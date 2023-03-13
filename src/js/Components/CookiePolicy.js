import gsap from 'gsap/all'

export default class CookiePolicy {
  constructor(id) {
    this.DOM = { el: id }
    this.DOM.button = this.DOM.el.querySelector('.js-button')
    this.DOM.days = this.DOM.el.dataset.duration
    gsap.set(this.DOM.el, { autoAlpha: 0, yPercent: 100 })
    this.init()
  }

  init() {
    this.showCookiePolicy()
    // after preloader wait 1 secs then show cookie policy box
  }

  addEventListeners() {
    this.closeEvent = this.close.bind(this)
    this.DOM.button.addEventListener('click', this.closeEvent, false)
  }

  close() {
    return gsap.to(this.DOM.el, {
      autoAlpha: 0,
      yPercent: 100,
      duration: 1.2,
      ease: 'expo.out',
      onComplete: () => {
        if (this.DOM.el.parentNode !== null) {
          this.DOM.el.parentNode.removeChild(this.DOM.el)
        }
      }
    })
  }

  show(element) {
    setTimeout(() => {
      gsap.to(element, {
        autoAlpha: 1,
        yPercent: 0,
        duration: 0.8,
        ease: 'expo.in'
      })
    }, 1000) //Show the div

    this.addEventListeners()
  }

  showCookiePolicy() {
    // grab how many days the modal should be shown again after
    const days = parseInt(this.DOM.days)

    // SHOW POP UP AGAIN AFTER SO MANY

    // if days set to 1 show pop up everytime
    if (days === 1) {
      localStorage.last = Date.now()
      this.show(this.DOM.el) //Show the div because you haven't ever shown it before.
    } else {
      if (localStorage.last) {
        if (
          (localStorage.last - Date.now()) / (1000 * 60 * 60 * 24 * days) >=
          1
        ) {
          //Date.now() is in milliseconds, so convert it all to days, and if it's more than 1 day, show the div
          this.show(this.DOM.el) //Show the div
          localStorage.last = Date.now() //Reset your timer
        }
      } else {
        localStorage.last = Date.now()
        this.show(this.DOM.el) //Show the div because you haven't ever shown it before.
      }
    }
  }
}
