export default class HeaderDefault {
  constructor({ version, type, mobileMenu, body, parent }) {
    this.header = parent
    this.version = version
    this.body = body
    this.DOM = { el: type }
    this.mobile = mobileMenu
    this.DOM.toggle = this.DOM.el.querySelector('.js-toggle')
    this.DOM.mobileMenu = this.DOM.el.querySelector('.js-mobile-menu')

    this.init()
  }

  init() {
    this.addEventListeners()
    this.mobileMenu = new this.mobile({
      menu: this.DOM.mobileMenu,
      icon: this.DOM.toggle,
      body: this.body
    })
  }

  openToggle() {
    this.mobileMenu.toggle()
  }

  headerChangeState(value) {
    this.header.setAttribute('data-state', value)
  }

  headerRevertState() {
    this.header.setAttribute('data-state', 'revert')
  }

  addEventListeners() {
    this.toggleEvent = this.openToggle.bind(this)
    this.DOM.toggle.addEventListener('click', this.toggleEvent)
  }

  onResize() {}
}
