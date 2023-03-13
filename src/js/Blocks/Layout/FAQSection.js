import { gsap, ScrollTrigger } from 'gsap/all'
gsap.registerPlugin(ScrollTrigger)

export default class FAQSection {
  constructor(id) {
    this.DOM = { el: document.getElementById(id) }
    this.DOM.menu = this.DOM.el.querySelector('.js-nav-group')
    this.DOM.answer = this.DOM.el.querySelector('.js-question-section')
    this.DOM.innerBar = this.DOM.el.querySelector('.js-nav')
    this.DOM.questions = [...this.DOM.el.querySelectorAll('.js-item')]
    this.DOM.topLevels = [...this.DOM.el.querySelectorAll('.js-detail')]
    this.DOM.stages = [...this.DOM.el.querySelectorAll('.js-section-item')]
  }

  linkTo() {
    this.DOM.stages.forEach((stage) => {
      // when we click on a link scroll to that section
      this.DOM.questions.forEach((link) => {
        const target = link.getAttribute('href')
        link.addEventListener('click', (e) => {
          e.preventDefault()

          // console.log(target, link, stage)
          document.querySelector(target).scrollIntoView({ block: 'center' })
          //  this.scroll.scroll.scrollTo(target, {offset: -halfHeight(stage)})
        })
      })
    })
  }

  collapse() {
    // close all tabs when opening a new tab
    // Add the onclick listeners.
    this.DOM.topLevels.forEach((targetDetail) => {
      targetDetail.addEventListener('click', () => {
        // Close all the details that are not targetDetail.
        this.DOM.topLevels.forEach((detail) => {
          if (detail !== targetDetail) {
            detail.removeAttribute('open')
          }
        })
      })
    })
  }

  fixInPlace() {
    ScrollTrigger.matchMedia({
      // Desktop
      '(min-width: 992px)': () => {
        ScrollTrigger.create({
          endTrigger: this.DOM.el,
          trigger: this.DOM.menu,
          start: `top-=20% top`,
          end: `bottom top+=25%`,
          pinReparent: true,
          pin: true
          // markers: true
        })
      },
      // Mobile
      '(max-width: 991px)': () => {
        //  gsap.set([this.DOM.button], { xPercent: 150 })
      }
    })
  }

  // REQUIRED for all Blocks | Activated by blockManager.js
  init() {
    this.fixInPlace()
    this.collapse()
    this.linkTo()
  }

  // OPTIONAL for all Blocks | Enables JS in Gutenberg Editor
  //  gutenberg() {}
}
