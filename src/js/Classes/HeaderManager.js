import hotkeys from 'hotkeys-js';

// Headers
import LogoLeft from '../Header/LogoLeft'
import LogoMiddle from '../Header/LogoMiddle'
import MegaMenu from '../Header/MegaMenu'
import HeaderDefault from '../Header/HeaderDefault'
import MobileMenu from '../Header/MobileMenu'

export default class HeaderManager {
  constructor({ scroll, scrollWrapper, headerType, headerCore, body }) {
    this.scroll = scroll
    this.scrollWrapper = scrollWrapper
    this.headerType = headerType
    this.headerCore = headerCore
    this.body = body
    this.lastScroll
    this.headerStateSections = [
      ...document.querySelectorAll('[data-header-state]')
    ]
    this.searchBox = this.headerCore.querySelector('.js-search-box')
    this.searchInput = this.searchBox.querySelector('#js-search-input')
    this.searchClose = this.searchBox.querySelector('.js-search-close')

    this.init()
    this.initSearchComponent()
  }

  initSearchComponent() {

    // do not show on search.php page
    if(this.body.dataset.type != 'search.php') {
        hotkeys('cmd+k', (event, handler) => {
          event.preventDefault()
          console.log('You pressed cmd+k')
          this.searchBox.classList.toggle('js-active')
          this.searchInput.focus()
      })
    }

    this.searchClose.addEventListener('click', () => {
      this.searchBox.classList.remove('js-active')
    })
  }

  init() {
    this.headerCheck(this.headerType)
  }

  headerCheck(type) {
    // Select which header is available
    const version = type.dataset.header
    switch (version) {
      case 'LogoLeft':
        this.header = new LogoLeft({
          parent: this.headerCore,
          version: version,
          type: type,
          body: this.body,
          mobileMenu: MobileMenu
        })
        break
      case 'LogoMiddle':
        this.header = new LogoMiddle({
          parent: this.headerCore,
          version: version,
          type: type,
          body: this.body
        })
        break
      case 'MegaMenu':
        this.header = new MegaMenu({
          parent: this.headerCore,
          version: version,
          type: type,
          body: this.body,
          scrollWrapper: this.scrollWrapper,
          mobileMenu: MobileMenu
        })

        // When master header is closed emit this so we can check if section current intersecting has a data-state or not
        this.header.on(
          'checkHeaderState',
          this.checkSectionforHeader.bind(this)
        )

        break
      default:
        // headerDefault show mobile menu
        this.header = new HeaderDefault({
          parent: this.headerCore,
          version: version,
          type: type,
          body: this.body,
          mobileMenu: MobileMenu
        })
    }

    // check if we are scrollling over data-header='white' sections
    this.checkSectionforHeader()
  }

  // comes from index.js
  onResize(screenSize) {
    if (this.header) this.header.onResize()
    
    // Check current header state
    if (this.headerResults) this.checkHeaderResults()
  }
  
  // on resize we are able to keep header state
  checkHeaderResults() {
        // we have an array of all results of all divs are in view or not
      // if one of the results is true set the header, if all are false revert

      // checks whether an element is true
      const result = (element) => element === true

      if (this.headerResults.some(result)) {
        // if we are overwriting the header (page gift-card) return

        if (this.header.headerChangeState)
          this.header.headerChangeState(this.headerNameState, this.headerColourState)
      } else {
        if (this.header.headerRevertState) this.header.headerRevertState()
      }
  }

  checkSectionforHeader() {
    // use intersection observer to see if header is overlapping data-header sections
    // if so run headerWhite function
    // https://www.smashingmagazine.com/2021/07/dynamic-header-intersection-observer/
    // Only works on desktop

    // if No sections
    if (!this.headerStateSections.length) return

    // if Mega Menu is open revert header state
    if (this.headerType.className === 'MegaMenu') {
      if (this.header.DOM.MasterTab.classList.contains('js-open')) {
        if (this.header.headerRevertState) this.header.headerRevertState()
        return
      }
    }

    const options = {
      // root is the scrollwrapper so can be used with scrollsmoother or just default
      rootMargin: `-${this.header.DOM.el.offsetHeight}px 0px -${
        window.innerHeight - this.header.DOM.el.offsetHeight
      }px 0px`,
      threshold: 0
      // trackVisibility: true,
      // delay: 100
    }

    /* The callback that will fire on intersection */
    const onIntersect = (entries) => {
      // wipe each time
      this.headerResults = []
      this.headerNameState

      entries.forEach((entry) => {
        // return if section is not visible
        if (entry.isIntersecting) {
          this.headerNameState = entry.target.dataset.headerState
          this.headerResults.push(true)
        } else {
          this.headerResults.push(false)
        }
        return this.headerResults
      })

      // we have an array of all results of all divs are in view or not
      // if one of the results is true set the header, if all are false revert

      this.checkHeaderResults()
    }

    /* Create the observer */
    const observer = new IntersectionObserver(onIntersect, options)
    const that = this

    /* Set our observer to observe each section */
    this.headerStateSections.forEach((section) => {
      observer.observe(section)
    })
  }

  // comes from index.js
  headerOnScroll() {
    // check if we are scrollling over data-header='white' sections
   // this.checkSectionforHeader()

    // Header up + down
    if (this.headerCore.classList.contains('js-header-activate')) {
      let currentScroll = window.pageYOffset
      let currentWidth = window.innerWidth
      const scrollUp = 'js-scroll-up'
      const scrollDown = 'js-scroll-down'

      // remove reveal header on moible and tbalet screens
      if (currentWidth < 992) {
        return
      } else {
        if (currentScroll === 0) {
          this.headerCore.classList.remove(scrollUp)
          return
        }
        if (
          currentScroll > this.lastScroll + 5 &&
          !this.headerCore.classList.contains(scrollDown)
        ) {
          // DOWN
          // hides header from view
          this.headerCore.classList.remove(scrollUp)
          this.headerCore.classList.add(scrollDown)

          // for megaMenu and logoleft close dropdowns on scroll
          if (
            this.header.version === 'LogoLeft' ||
            this.header.version === 'MegaMenu'
          ) {
            this.header.closeAll()
          }
        } else if (
          currentScroll < this.lastScroll
          // && this.headerCore.classList.contains(scrollDown)
        ) {
          // UP
          // shows header
          this.headerCore.classList.remove(scrollDown)
          this.headerCore.classList.add(scrollUp)
        }
        this.lastScroll = currentScroll
      }
    }
  }
}
