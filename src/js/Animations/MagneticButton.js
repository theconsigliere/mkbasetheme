/*!
 * Magnetic Button Component
 *
 *  Button: Use this for mutiple buttons or just one
 *  movement: How far you want the button to move
 *  Scale: Scale on hover
 *  label: Can be used to label button or or include text in the button you want to animate
 *
 * Use it like this:
 *
 *  const magneticButtons = new MagneticButton({
 *       button: this.DOM.symbols,
 *       label: 'symbols',
 *       movement: 0.75,
 *       scale: 1.4
 *     })
 */

import { gsap } from 'gsap/all'

export default class MagneticButton {
  constructor(options) {
    this.options = {
      button: options.button,
      label: options.label ? options.label : '',
      movement: options.movement ? options.movement : 0.5,
      scale: options.scale ? options.scale : 1.25
    }

    this.addEventListeners()
  }

  magneticEnter(event) {
    const btn = event.currentTarget
    const boundingRect = btn.getBoundingClientRect()
    let relX = event.pageX - (boundingRect.left + boundingRect.width / 2)
    let relY = event.pageY - (boundingRect.top + boundingRect.height / 2)

    gsap.to(btn, {
      x: relX * this.options.movement,
      y: relY * this.options.movement,
      ease: 'power1',
      scale: this.options.scale,
      duration: 0.6
    })
  }

  magneticLeave(event) {
    const btn = event.currentTarget

    gsap.to(btn, {
      scale: 1,
      x: 0,
      y: 0,
      ease: 'power3',
      duration: 0.6
    })
  }

  addEventListeners() {
    this.mouseMoveEvent = this.magneticEnter.bind(this)
    this.mouseLeaveEvent = this.magneticLeave.bind(this)

    // check if an array or not
    if (Array.isArray(this.options.button)) {
      // array
      this.options.button.forEach((button) => {
        button.addEventListener('mousemove', this.mouseMoveEvent)
        button.addEventListener('mouseleave', this.mouseLeaveEvent)
      })
    } else {
      // not array
      this.options.button.addEventListener('mousemove', this.mouseMoveEvent)
      this.options.button.addEventListener('mouseleave', this.mouseLeaveEvent)
    }
  }
}
