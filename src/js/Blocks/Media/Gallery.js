import { gsap } from 'gsap/all'

export default class Gallery {
  constructor({ id, modalParent }) {
    this.modalParent = modalParent
    this.DOM = { el: document.getElementById(id) }
    this.DOM.galleryInner = this.DOM.el.querySelector('.js-gallery')
    this.DOM.images = [...this.DOM.el.querySelectorAll('.js-image')]
    this.DOM.modal = this.DOM.el.querySelector('.js-modal')
    this.DOM.buttonGroup = this.DOM.el.querySelector('.js-button-group')
    this.DOM.closeButton = this.DOM.el.querySelector('.js-close')
    this.DOM.prevButton = this.DOM.el.querySelector('.js-prev')
    this.DOM.nextButton = this.DOM.el.querySelector('.js-next')
    this.DOM.modalImg = this.DOM.modal.querySelector('.js-modal-image')
    this.DOM.modalTitle = this.DOM.modal.querySelector('.js-modal-title')
    this.DOM.modalP = this.DOM.modal.querySelector('.js-modal-desc')
    this.currentImage
  }

  showImage(element) {
    const el = element.currentTarget || element
    const image = el.querySelector('img')

    if (!el) {
      console.info('no image to show')
      return
    }

    this.DOM.modalImg.src = image.src
    this.DOM.modalTitle.textContent = image.title
    this.DOM.modalP.textContent = image.dataset.description
    this.currentImage = el
    this.openModal()
  }

  reparentModal() {
    // Pin Teamviewer / MINIMAP to page
    this.modalParent.append(...this.DOM.modal.childNodes)

    // add classes to modal
    this.DOM.modal.classList.forEach((classes) => {
      this.modalParent.classList.add(classes)
    })

    this.DOM.modalImg = this.modalParent.querySelector('.js-modal-image')
    this.DOM.modalTitle = this.modalParent.querySelector('.js-modal-title')
    this.DOM.modalP = this.modalParent.querySelector('.js-modal-desc')
  }

  openModal() {
    // console.info('Opening Modal...');
    // First check if the modal is already open
    if (this.modalParent.classList.contains('js-open')) {
      //  console.info('Modal already open');
      return // stop the function from running
    }

    // animate in buttons
    gsap.to(this.DOM.buttonGroup, {
      yPercent: 0,
      ease: 'expo.in',
      duration: 0.25,
      onComplete: () => {
        this.modalParent.classList.add('js-open')
      }
    })

    // Event listeners to be bound when we open the modal:
    window.addEventListener('keyup', this.handleKeyUp.bind(this))
    this.DOM.nextButton.addEventListener('click', this.clickNext)
    this.DOM.prevButton.addEventListener('click', this.clickPrev)
  }

  closeModal() {
    // animate in buttons
    gsap.to(this.DOM.buttonGroup, {
      yPercent: 100,
      ease: 'expo.out',
      duration: 0.6,
      onComplete: () => {
        this.modalParent.classList.remove('js-open')
      }
    })

    // TODO: add event listeners for clicks and keyboard..
    window.removeEventListener('keyup', this.handleKeyUp)
    this.DOM.nextButton.removeEventListener('click', this.clickNext)
    this.DOM.prevButton.removeEventListener('click', this.clickPrev)
  }

  handleClickOutside(e) {
    if (e.target === e.currentTarget) {
      this.closeModal()
    }
  }

  handleKeyUp(event) {
    if (event.key === 'Escape') return this.closeModal()
    if (event.key === 'ArrowRight') return this.showNextImage()
    if (event.key === 'ArrowLeft') return this.showPrevImage()
  }

  showNextImage() {
    this.showImage(
      this.currentImage.nextElementSibling ||
        this.DOM.galleryInner.firstElementChild
    )
  }
  showPrevImage() {
    this.showImage(
      this.currentImage.previousElementSibling ||
        this.DOM.galleryInner.lastElementChild
    )
  }

  addEventListeners() {
    this.handleClickEvent = this.handleClickOutside.bind(this)
    this.closeEvent = this.closeModal.bind(this)
    this.clickNext = this.showNextImage.bind(this)
    this.clickPrev = this.showPrevImage.bind(this)

    this.DOM.images.forEach((image) => {
      image.addEventListener('click', this.showImage.bind(this))

      image.addEventListener('keyup', (event) => {
        if (event.key === 'Enter') {
          this.showImage.bind(this)
        }
      })
    })

    this.DOM.closeButton.addEventListener('click', this.closeEvent)
    this.modalParent.addEventListener('click', this.handleClickEvent)
  }

  // REQUIRED for all Blocks | Activated by blockManager.js
  init() {
    gsap.set(this.DOM.buttonGroup, { yPercent: 100 })

    
    this.reparentModal()
    this.addEventListeners()
  }

  // OPTIONAL for all Blocks | Enables JS in Gutenberg Editor
  // gutenberg() {}
}
