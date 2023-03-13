import { gsap, ScrollTrigger, ScrollSmoother } from 'gsap/all'
gsap.registerPlugin(ScrollTrigger, ScrollSmoother)
// https://greensock.com/docs/v3/Plugins/ScrollSmoother

export default class Scroll {
  constructor({ scrollWrapper, scrollContent }) {
    this.scrollWrapper = scrollWrapper
    this.scrollContent = scrollContent

    this.Scroll = ScrollSmoother.create({
      wrapper: this.scrollWrapper,
      content: this.scrollContent,
      effects: true,
      normalizeScroll: true, // prevents address bar from showing/hiding on most devices, solves various other browser inconsistencies
      ignoreMobileResize: true,
      smoothTouch: false,
      smooth: 1
    })

    gsap.set('html, body', { scrollBehavior: 'auto' })
    this.init()
  }

  refresh() {
    // console.log(ScrollSmoother.get().scrollTrigger)
    ScrollSmoother.get().scrollTrigger.refresh()
  }

  isScrolling() {
    ScrollTrigger.update()
    //  console.log(this)
  }

  scrollTo(target, options) {
    return this.scroll.scrollTo(target, { options })
  }

  init() {}
}
