import { SplitTitle } from '../../Animations/SplitTitle'
import { gsap } from 'gsap/all'

export default class HeroFullWidth {
  constructor(id) {
    this.DOM = { el: document.getElementById(id) }
    this.DOM.subtitle = this.DOM.el.querySelector('.js-subtitle')
    this.DOM.title = this.DOM.el.querySelector('.js-title')
    this.DOM.desc = this.DOM.el.querySelector('.js-desc')
    this.DOM.image = this.DOM.el.querySelector('.js-image')
    this.DOM.button = this.DOM.el.querySelector('.js-btn')
  }

  // REQUIRED for all Heros | Activated by heroManager.js
  init() {
    this.title = SplitTitle(this.DOM.title)
    this.subtitle = SplitTitle(this.DOM.subtitle)
    gsap.set(this.DOM.image, { scale: 1.2 })
    gsap.set([this.DOM.desc, this.DOM.button], { autoAlpha: 0 })

    // split text
    this.onResize()
  }

  animate() {
    this.tlHero = gsap.timeline({
      defaults: {
        ease: 'expo.out',
        duration: 0.8
      }
    })

    this.tlHero
      .to([this.title, this.subtitle], {
        yPercent: 0,
        duration: 0.8,
        stagger: '0.2'
      })
      .to([this.DOM.desc, this.DOM.button], { autoAlpha: 1 })
      .to(this.DOM.image, { scale: 1, duration: 2, ease: 'power4.out' }, 0)
  }

  onResize() {}

  // OPTIONAL for all Blocks | Enables JS in Gutenberg Editor
  gutenberg() {}

  // Necessary to have, leave empty if not needed
  // Activated by index.js
  onLoad() {
    this.animate()
  }
}
