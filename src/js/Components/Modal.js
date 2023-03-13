import gsap from 'gsap'

export default class Modal {
  constructor({ id, body }) {
    this.body = body
    // el is the outer wrapper of the modal
    this.DOM = { el: id }
    this.DOM.modal = this.DOM.el.querySelector('.js-modal')
    this.DOM.time = this.DOM.el.dataset.duration
    this.DOM.close = this.DOM.el.querySelector('.js-close')
    gsap.set(this.DOM.modal, { yPercent: 20, autoAlpha: 0 })

    this.activate()
    this.addEventListeners()
  }

  activate() {
    // grab how many days the modal should be shown again after
    const days = parseInt(this.DOM.time)
    this.body.style.overflow = 'hidden'

    // SHOW POP UP AGAIN AFTER SO MANY

    // if days set to 1 show pop up everytime
    if (days === 1) {
      localStorage.last = Date.now()

      //Show the div because you haven't ever shown it before.
      this.showModal()
    } else {
      if (localStorage.last) {
        if (
          (localStorage.last - Date.now()) / (1000 * 60 * 60 * 24 * days) >=
          1
        ) {
          //Date.now() is in milliseconds, so convert it all to days, and if it's more than 1 day, show the div
          this.showModal() //Show the div
          localStorage.last = Date.now() //Reset your timer
        }
      } else {
        localStorage.last = Date.now()
        this.showModal() //Show the div because you haven't ever shown it before.
      }
    }
  }

  showModal() {
    gsap.to(this.DOM.modal, {
      yPercent: 0,
      ease: 'expo.out',
      duration: 0.8,
      delay: 1,
      autoAlpha: 1,
      onEnter: () => {
        this.DOM.el.classList.remove('js-hide')
      },
      onComplete: () => {
        this.body.style.overflow = 'hidden'
      }
    })
  }

  hideModal() {
    gsap.to(this.DOM.modal, {
      yPercent: 20,
      ease: 'expo.in',
      duration: 0.4,
      autoAlpha: 0,
      onComplete: () => {
        this.DOM.el.classList.add('js-hide')
        this.body.style.overflow = 'visible'
      }
    })
  }

  closeModal() {
    this.hideModal()
    // setTimeout(() => {
    //   this.DOM.el.parentNode.removeChild(this.DOM.el)
    // }, 2000)
  }

  addEventListeners() {
    this.closeEvent = this.closeModal.bind(this)

    this.DOM.close.addEventListener('click', this.closeEvent)
  }
}
