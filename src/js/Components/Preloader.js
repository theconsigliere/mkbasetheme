import imagesLoaded from 'imagesloaded'
import EventEmitter from '../Classes/EventEmitter'

import { gsap, GSDevTools, DrawSVGPlugin } from 'gsap/all'
gsap.registerPlugin(GSDevTools, DrawSVGPlugin)

export default class Preloader extends EventEmitter {
  constructor() {
    super()
    this.DOM = { el: document.querySelector('.js-preloader') }
    this.DOM.images = [...document.querySelectorAll('img')]
    this.DOM.progressCircle = this.DOM.el.querySelector('circle')
    this.DOM.numberText = this.DOM.el.querySelector('.js-text')
    this.length = 0
    gsap.set(this.DOM.progressCircle, { drawSVG: '0%' })
    this.imageLoader()
  }

  imageLoader() {
    const imgLoad = imagesLoaded(this.DOM.images)
    imgLoad.on('always', (instance, img) => {
      this.onImagesLoaded(instance, img)
    })
    imgLoad.on('fail', (instance, img) => {
      console.log(`broken images :(( ${img}`)
      // console.log(instance)
    })
  }

  onImagesLoaded(instance, img) {
    this.loaderTimeline = gsap.timeline({
      defaults: {
        ease: 'expo.out'
      },
      delay: 0.5,
      onComplete: () => {
        this.emit('completed', 'yes')
      }
    })

    this.loaderTimeline
      .to(this.DOM.numberText, {
        innerText: 100,
        duration: 3.5,
        snap: 'innerText'
      })
      .to(
        this.DOM.progressCircle,
        { drawSVG: '100%', ease: 'expo.out', duration: 3.5 },
        0
      )
  }

  destroy() {
    this.DOM.el.classList.add('js-hidden')
    setTimeout(() => {
      this.DOM.el.parentNode.removeChild(this.DOM.el)
    }, 2500)
  }

  loop() {
    this.DOM.el.classList.remove('js-hidden')
    this.loaderTimeline.restart()
  }

  hide() {
    this.loaderTimeline.pause()
    this.DOM.el.classList.add('js-hidden')
  }
}
