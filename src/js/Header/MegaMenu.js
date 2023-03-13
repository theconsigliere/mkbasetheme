import EventEmitter from '../Classes/EventEmitter'

export default class MegaMenu extends EventEmitter {
  constructor({ version, type, scrollWrapper, body, mobileMenu, parent }) {
    super()
    this.header = parent
    this.version = version
    this.body = body
    this.DOM = { el: type }
    this.mobile = mobileMenu
    this.scrollWrapper = scrollWrapper
    this.DOM.MasterTab = this.DOM.el.parentNode.querySelector('.js-master-tab')
    this.DOM.toggle = this.DOM.el.querySelector('.js-toggle')
    this.DOM.mobileMenu = this.DOM.el.querySelector('.js-mobile-menu')
    this.DOM.dropdowns = [...this.DOM.el.querySelectorAll('.js-dropdown')]
    this.DOM.tabs = [...this.DOM.el.parentNode.querySelectorAll('.js-tab')]

    this.init()
  }

  setMasterPosition() {
    this.DOM.MasterTab.style.top = `${this.DOM.el.offsetHeight}px`
  }

  init() {
    this.setMasterPosition()
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
    this.DOM.MasterTab.classList.remove('js-open')

    if (this.DOM.tabs) {
      this.DOM.tabs.forEach((tab) => {
        tab.classList.remove('js-open')
      })
    }

    if (this.DOM.dropdowns) {
      this.DOM.dropdowns.forEach((dropdowns) => {
        dropdowns.classList.remove('js-open')
      })
    }

    // remove page pushdown
    this.scrollWrapper.classList.remove('js-open')
    this.scrollWrapper.style.transform = 'translateY(0px)'
  }

  // closes all dropdowns comes from HeaderManager headerOnScroll function
  closeAll() {
    this.closeDropdowns()
  }

  toggleDropdown(e) {
    e.preventDefault()
    const currentLink = e.currentTarget.parentElement.dataset.menu
    const open = []

    // show correct tab before animating down
    this.DOM.tabs.forEach((tab, index) => {
      if (tab.dataset.menu === currentLink) {
        if (tab.classList.contains('js-open')) {
          // close tab
          tab.classList.remove('js-open')
          open.push('no')
        } else {
          // open tab
          tab.classList.add('js-open')
          open.push('js-open')
        }
        return
      }
      tab.classList.remove('js-open')
      open.push('no')
    })

    // Check if a tab is active if not hide Master header
    // If js-open does not exisit in array close master header

    open.includes('js-open')
      ? this.DOM.MasterTab.classList.add('js-open')
      : this.DOM.MasterTab.classList.remove('js-open')

    // select current SVG
    this.DOM.dropdowns.forEach((toggle) => {
      if (toggle === e.currentTarget) {
        toggle.classList.contains('js-open')
          ? toggle.classList.remove('js-open')
          : toggle.classList.add('js-open')
        return
      }
      toggle.classList.remove('js-open')
    })

    // animate page down
    if (!this.DOM.MasterTab.classList.contains('js-open')) {
      // close
      this.scrollWrapper.classList.remove('js-open')
      this.scrollWrapper.style.transform = 'translateY(0px)'

      // re run and check if section we are intersecting has a specila state
      this.emit('checkHeaderState', 'yes')
    } else {
      //open
      this.scrollWrapper.style.transform = `translateY(${this.DOM.MasterTab.offsetHeight}px)`
      this.scrollWrapper.classList.add('js-open')

      //
      if (this.header.getAttribute('data-state') !== 'revert') {
        this.header.setAttribute('data-state', 'revert')
      }
    }
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
    this.dropdownEvent = this.toggleDropdown.bind(this)

    this.DOM.toggle.addEventListener('click', this.toggleEvent)

    if (this.DOM.dropdowns) {
      this.DOM.dropdowns.forEach((dropdown) => {
        dropdown.addEventListener('click', this.dropdownEvent)
      })
    }
  }
}
