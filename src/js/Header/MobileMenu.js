export default class MobileMenu {
  constructor({ menu, icon, body }) {
    this.DOM = { el: menu }
    this.icon = icon
    this.body = body
    this.DOM.dropdowns = [
      ...this.DOM.el.querySelectorAll('.js-mobile-dropdown')
    ]
    this.DOM.subMenus = [...this.DOM.el.querySelectorAll('.js-mobile-submenu')]

    this.addEventListeners()
  }

  toggle() {
    this.icon.classList.toggle('js-open')
    this.DOM.el.classList.toggle('js-appear')

    // disable movement if open
    if (this.icon.classList.contains('js-open')) {
      this.body.style.overflow = 'hidden'
    } else {
      this.body.style.overflow = 'visible'
    }
  }

  // comes from logoLeft.js
  onResize() {
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

    let currentMenu
    let targetSubMenu

    // SORT OUT TOGGLES
    const target = e.currentTarget
    // find selected toggle in array position
    const currentTarget = this.DOM.dropdowns.indexOf(target)

    // remove all over open targets
    this.DOM.dropdowns.forEach((dropdown, index) => {
      // find current target in loop

      if (index == currentTarget) {
        // if current target isn't open, open it then close everything else
        if (!dropdown.classList.contains('js-open'))
          return dropdown.classList.add('js-open')
      }
      dropdown.classList.remove('js-open')
    })

    //SORT OUT SUBMENUS

    targetSubMenu =
      target.parentElement.parentElement.querySelector('.js-mobile-submenu')

    // find selected toggle in array position
    currentMenu = this.DOM.subMenus.indexOf(targetSubMenu)

    this.DOM.subMenus.forEach((submenu, index) => {
      // find current target in loop
      if (index == currentMenu) {
        // if current target isn't open, open it then close everything else
        if (submenu.offsetHeight <= 0) {
          const inner = submenu.querySelector('.js-mobile-inner')
          return (submenu.style.height = `${
            inner.getBoundingClientRect().height
          }px`)
        }
      }

      submenu.style.height = '0px'
    })
  }

  addEventListeners() {
    this.dropdownEvent = this.toggleDropdown.bind(this)

    if (this.DOM.dropdowns) {
      this.DOM.dropdowns.forEach((dropdown) => {
        dropdown.addEventListener('click', this.dropdownEvent)
      })
    }
  }
}
