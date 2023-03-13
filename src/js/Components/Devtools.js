export default class Devtools {
  constructor({ id, preloader, modal }) {
    this.DOM = { el: id }
    this.preloader = preloader
    this.modal = modal

    this.DOM.gridSelector = this.DOM.el.querySelector('.js-grid-selector')
    this.DOM.grid = document.querySelector('.js-grid')
    this.DOM.preloaderSelector = this.DOM.el.querySelector(
      '.js-preloader-selector'
    )
    this.DOM.modalSelector = this.DOM.el.querySelector('.js-modal-selector')

    this.addEventListeners()
  }

  addEventListeners() {
    this.DOM.gridSelector.addEventListener('change', (event) => {
      event.currentTarget.checked
        ? this.DOM.grid.classList.add('js-on')
        : this.DOM.grid.classList.remove('js-on')
    })

    if (this.DOM.preloaderSelector) {
      this.DOM.preloaderSelector.addEventListener('change', () => {
        this.DOM.preloaderSelector.checked
          ? this.preloader.loop()
          : this.preloader.hide()
      })
    }

    if (this.DOM.modalSelector) {
      this.DOM.modalSelector.addEventListener('change', () => {
        this.DOM.modalSelector.checked
          ? this.modal.showModal()
          : this.modal.hideModal()
      })
    }
  }
}
