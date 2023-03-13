export default class LogoLeft {
  constructor({ version, type, mobileMenu, body, parent }) {
    this.header = parent
    this.version = version
    this.body = body
    this.DOM = { el: type }
    this.mobile = mobileMenu
    this.DOM.dropdowns = [...this.DOM.el.querySelectorAll('.js-dropdown')]
    this.DOM.subMenus = [...this.DOM.el.querySelectorAll('.js-submenu')]
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

  // comes from headerManager.js
  onResize() {
    this.closeDropdowns()
    if (this.mobileMenu) this.mobileMenu.onResize()
  }

  closeDropdowns() {
    if (this.DOM.dropdowns) {
      this.DOM.dropdowns.forEach((dropdown) => {
        dropdown.classList.remove('js-open')
      })
    }

    if (this.DOM.subMenus) {
      this.DOM.subMenus.forEach((submenu) => {
        submenu.classList.remove('js-appear')
      })
    }
  }

  toggleDropdown(e) {
    e.preventDefault()
    // SORT OUT TOGGLES
    const target = e.currentTarget
    // find selected toggle in array position
    const currentTarget = this.DOM.dropdowns.indexOf(target)

    this.DOM.subMenus.forEach((menu) => menu.classList.remove('js-appear'))

    // remove all over open targets
    this.DOM.dropdowns.forEach((dropdown, index) => {
      // find current target in loop
      if (index == currentTarget) {
        // if current target isn't open, open it then close everything else
        if (!dropdown.classList.contains('js-open')) {
          const submenu =
            dropdown.parentNode.parentNode.querySelector('.js-submenu')
          submenu.classList.add('js-appear')
          dropdown.classList.add('js-open')
          return
        }
      }
      dropdown.classList.remove('js-open')
    })
  }

  openToggle() {
    this.mobileMenu.toggle()
  }

  // closes all dropdowns comes from HeaderManager headerOnScroll function
  closeAll() {
    this.closeDropdowns()
  }

  headerChangeState(value) {
    this.header.setAttribute('data-state', value)
  }

  headerRevertState() {
    this.header.setAttribute('data-state', 'revert')
  }

  addEventListeners() {
    this.toggleEvent = this.openToggle.bind(this)
    this.dropdownEvent = this.toggleDropdown.bind(this)

    this.DOM.toggle.addEventListener('click', this.toggleEvent)

    if (this.DOM.dropdowns) {
      this.DOM.dropdowns.forEach((dropdown) => {
        dropdown.addEventListener('click', this.dropdownEvent)
      })
    }
  }
}
