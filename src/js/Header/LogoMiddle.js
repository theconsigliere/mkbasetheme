import { gsap } from 'gsap/all'

export default class LogoLeft {
  constructor({ version, type, body, parent }) {
    this.header = parent
    this.version = version
    this.DOM = { el: type }
    this.body = body
    console.log('fuck')
    // fullscreen
    this.DOM.fullScreen =
      this.DOM.el.parentNode.querySelector('.fullscreen-nav-js')
    this.DOM.items = [
      ...this.DOM.el.parentNode.querySelectorAll('.js-menu-item')
    ]
    this.DOM.dropdowns = [
      ...this.DOM.el.parentNode.querySelectorAll('.js-dropdown svg')
    ]
    this.DOM.subMenus = [
      ...this.DOM.el.parentNode.querySelectorAll('.js-submenu')
    ]
    this.DOM.subLinks = [
      ...this.DOM.el.parentNode.querySelectorAll('.js-sub-link')
    ]
    this.DOM.toggle = this.DOM.el.querySelector('.js-toggle')

    this.init()
  }

  init() {
    //hide menu items
    gsap.set([this.DOM.items], { yPercent: 100 })
    if (this.DOM.dropdowns) gsap.set([this.DOM.dropdowns], { yPercent: 100 })
    gsap.set(this.DOM.subLinks, { yPercent: 10, autoAlpha: 0 })
    this.addEventListeners()
  }

  // comes from headerManager.js
  onResize() {
    if (this.DOM.dropdowns) {
      this.DOM.dropdowns.forEach((dropdown) => {
        dropdown.classList.remove('js-open')
      })
    }

    if (this.DOM.subMenus) {
      this.DOM.subMenus.forEach((submenu) => {
        submenu.classList.remove('js-appear')
        submenu.style.height = '0px'
      })

      gsap.set(this.DOM.subLinks, { yPercent: 10, autoAlpha: 0 })
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
      target.parentElement.parentElement.parentElement.querySelector(
        '.js-submenu'
      )
    // find selected toggle in array position
    currentMenu = this.DOM.subMenus.indexOf(targetSubMenu)

    this.DOM.subMenus.forEach((submenu, index) => {
      // find current target in loop

      if (index == currentMenu) {
        // if current target isn't open, open it then close everything else
        if (submenu.offsetHeight <= 0) {
          const inner = submenu.querySelector('.js-inner')
          const subLinks = [...inner.querySelectorAll('.js-sub-link')]
          gsap.to(subLinks, {
            autoAlpha: 1,
            yPercent: 0,
            duration: 0.2,
            ease: 'expo.out',
            stagger: 0.12
          })

          submenu.style.height = `${inner.getBoundingClientRect().height}px`

          return
        }
      }
      // TODO: Need to grab the rest of the sub items and hide

      // this is just getting selected array
      const itemsWithoutCurrent = this.DOM.subLinks.filter((x) => {
        return x !== currentMenu
      })
      gsap.set(itemsWithoutCurrent, { autoAlpha: 0, yPercent: 10 })
      submenu.style.height = '0px'
    })
  }

  openMenu() {
    this.body.style.overflow = 'hidden'
    this.DOM.fullScreen.classList.add('js-open')
    this.DOM.el.classList.add('js-open')
    this.DOM.toggle.classList.add('js-open')
    this.DOM.toggle.disabled = true

    this.openAnim = gsap.timeline({
      defaults: {
        ease: 'sine.out',
        duration: 0.25
      },
      onComplete: () => {
        this.DOM.toggle.disabled = false
      }
    })

    this.openAnim
      .to([this.DOM.items], {
        yPercent: 0,
        stagger: '0.1'
      })
      .to(
        [this.DOM.dropdowns],
        {
          yPercent: 0,
          stagger: '0.1'
        },
        0
      )
  }

  closeMenu() {
    this.body.style.overflow = 'visible'
    this.DOM.fullScreen.classList.remove('js-open')
    this.DOM.el.classList.remove('js-open')
    this.DOM.toggle.classList.remove('js-open')
    this.DOM.toggle.disabled = true

    this.closeAnim = gsap.timeline({
      defaults: {
        ease: 'expo.out',
        duration: 0.4
      },
      onComplete: () => {
        this.DOM.toggle.disabled = false
      }
    })

    this.closeAnim
      .to([this.DOM.items], {
        yPercent: 100,
        stagger: '0.2'
      })
      .to([this.DOM.dropdowns], {
        yPercent: 100,
        stagger: '0.2'
      })

    // turn off dropdowns
    this.onResize()
  }

  chooseMenu(e) {
    if (e.currentTarget.classList.contains('js-open')) {
      // close mennu
      this.closeMenu()
    } else {
      //open menu
      this.openMenu()
    }
  }

  headerChangeState(value) {
    this.header.setAttribute('data-state', value)
  }

  headerRevertState() {
    this.header.setAttribute('data-state', 'revert')
  }

  addEventListeners() {
    this.chooseEvent = this.chooseMenu.bind(this)
    this.dropdownEvent = this.toggleDropdown.bind(this)

    this.DOM.toggle.addEventListener('click', this.chooseEvent)

    if (this.DOM.dropdowns) {
      this.DOM.dropdowns.forEach((dropdown) => {
        dropdown.addEventListener('click', this.dropdownEvent)
      })
    }
  }
}
