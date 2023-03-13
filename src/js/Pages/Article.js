import { gsap, ScrollTrigger } from 'gsap/all'
gsap.registerPlugin(ScrollTrigger)

export default class Article {
  constructor({ body, scroll, header }) {
    this.scroll = scroll
    this.header = header
    this.DOM = { el: body }
    this.DOM.hero = this.DOM.el.querySelector('.js-hero')
    this.DOM.social = this.DOM.el.querySelector('.js-article-socials')
    this.DOM.button = this.DOM.el.querySelector('.js-article-button')
    this.DOM.container = this.DOM.el.querySelector('.js-article-container')

    if (this.DOM.social) gsap.set([this.DOM.social], { xPercent: 150 })

    ScrollTrigger.matchMedia({
      // Desktop
      '(min-width: 992px)': () => {
        gsap.set([this.DOM.button], { xPercent: -200 })
      },
      // Mobile
      '(max-width: 991px)': () => {
        gsap.set([this.DOM.button], { xPercent: 150 })
      }
    })

    this.addEventListeners()
    this.appearOnScroll()
  }

  //OPTIONAL if scroll event needed
  // Comes from index.js onScroll
  onScroll() {}

  appearOnScroll() {
    // show button, socials on scroll
    this.anim = gsap.timeline({
      scrollTrigger: {
        trigger: this.DOM.hero,
        start: 'bottom center',
        end: 'bottom+=20% center',
        //  markers: true,
        scrub: true
      }
    })

    this.anim.to(
      [this.DOM.social, this.DOM.button],
      {
        autoAlpha: 1,
        xPercent: 0,
        stagger: 0.2
      },
      0
    )
  }

  resize() {}

  scrollToTop() {
    // smoothscroll
    // this.scroll.Scroll.scrollTo(0, true)

    document.body.scrollTop = 0 // For Safari
    document.documentElement.scrollTop = 0 // For Chrome, Firefox, IE and Opera
  }

  addEventListeners() {
    this.scrollTopEvent = this.scrollToTop.bind(this)

    this.DOM.button.addEventListener('click', this.scrollTopEvent)
  }
}
