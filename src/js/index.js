import Preloader from './Components/Preloader'
import Modal from './Components/Modal'
import Cursor from './Components/Cursor'
import CookiePolicy from './Components/CookiePolicy'
import Devtools from './Components/Devtools'

//Classes
import BlockManager from './Classes/BlockManager'
import HeroManager from './Classes/HeroManager'
import HeaderManager from './Classes/HeaderManager'
import PageManager from './Classes/PageManager'

// Page Transitions
import Fade from './Transitions/Fade'

// Smooth Scroll
// import Scroll from './Components/Scroll/Scroll'
// import Scroll from './Components/Scroll/LinkManager'

// Utils
// import { getMousePos } from 'Utils'

class App {
  constructor() {
    // Checking if we are viewing on backend or not
    if (typeof wp != "undefined") {
      if (wp.blockEditor) {
        // GUTENBERG
        window._wpLoadBlockEditor.then(this.runGutenberg.bind(this))
        return
      }

      // if backend don't run
      // you are on the frontend but wp object wiht emoji is still registering
      typeof wp.editor != "undefined" ? "" : this.initFrontend
    } else {
      // FRONTEND
      this.initFrontend()
    }
  }

  initFrontend() {
    this.consoleMessage()
    this.createScroll()
    this.createHeader()
    this.createHero()
    this.createSettings()
    this.createBlocks()
    this.addEventListeners()
    this.pageTransitions()
    this.onResize()
  }

  pageTransitions() {
    this.transitions = new Fade(this.headerFader)
  }

  consoleMessage() {
    console.groupCollapsed(
      '%cThis website was developed by Dirty Martini Marketing',
      'color:white, background:black'
    )
    console.log(
      'For all your website needs, please contact us | https://dirty-martini.com'
    )
    console.log(
      'Website theme built by Maxwell Kirwin https://maxwellkirwin.co.uk'
    )
    console.log(
      'With further support + development by Charles Farrelly https://uk.linkedin.com/in/charles-farrelly-08666b162'
    )
    console.groupEnd()
  }

  createSettings() {
    this.preloaderInView = document.querySelector('.js-preloader')
    this.modalInView = document.querySelector('.js-main-modal')
    this.cursorOnPage = document.querySelector('.cursor')
    this.devToolsInView = document.querySelector('.js-devtools')
    this.gdpr = document.querySelector('.js-cookie-policy')

    if (this.preloaderInView) {
      this.preloader = new Preloader()
      //   console.log(this.preloader._events)
      this.preloader.once('completed', this.onPreloaded.bind(this))
    } else {
      // check if there is a hero on the page
      if (this.HeroManager) {
        if (this.HeroManager.theHero) this.HeroManager.theHero.onLoad()
      }

      if (this.gdpr) this.cookiePolicy = new CookiePolicy(this.gdpr)

      if (this.modalInView) {
        this.modal = new Modal({
          id: this.modalInView,
          body: this.body
        })
      }

      if (this.devToolsInView) {
        this.devtools = new Devtools({
          id: this.devToolsInView,
          preloader: this.preloader,
          modal: this.modal
        })
      }
    
    }

    if (this.cursorOnPage) {
      // Initialize custom cursor
      this.mouse = { x: 0, y: 0 }
      this.cursor = new Cursor({ mouse: this.mouse })
    }
  }

  createScroll() {
    this.scrollWrapper = document.querySelector('#smooth-wrapper')
    this.scrollContent = document.querySelector('#smooth-content')

    // this.scroll = new Scroll({
    //   scrollWrapper: this.scrollWrapper,
    //   scrollContent: this.scrollContent
    // })
  }

  createHeader() {
    this.headerCore = document.querySelector('header')
    this.body = document.querySelector('body')
    this.headerType = this.headerCore.querySelector('[data-header]')
    this.headerFader = document.querySelector('.js-header-fader')
    this.modalParent = document.querySelector('.js-modal-parent')

    this.HeaderManager = new HeaderManager({
      scroll: this.scroll,
      scrollWrapper: this.scrollWrapper,
      headerType: this.headerType,
      headerCore: this.headerCore,
      body: this.body
    })
  }

  onPreloaded() {
    this.preloader.destroy()

    // run hero animations
    if (this.modalInView) {
      this.modal = new Modal({
        id: this.modalInView,
        body: this.body
      })

      if (this.devToolsInView) {
        this.devtools = new Devtools({
          id: this.devToolsInView,
          preloader: this.preloader,
          modal: this.modal
        })
      }
    }

    if (this.gdpr) this.cookiePolicy = new CookiePolicy(this.gdpr)

    // check if there is a hero on the page
    if (this.HeroManager.theHero) this.HeroManager.theHero.onLoad()
  }

  runGutenberg() {
    this.consoleMessage()
    console.log('This is the backend')
    // window._wpLoadBlockEditor.then(() => { })

    // check for Gutenberg to finish loading then run
    acf.addAction('load', () => {
      this.createHero()
      this.createBlocks()
    })
  }

  createHero() {
    this.currentHero = document.querySelector('[data-hero]')
    this.preloaderInView = document.querySelector('.js-preloader')

    // if no hero don't run
    if (!this.currentHero) return

    this.HeroManager = new HeroManager({
      hero: this.currentHero,
      header: this.headerCore,
      screenSize: this.screenSize,
      preloader: this.preloaderInView
    })
  }

  createBlocks() {
    this.blocks = [...document.querySelectorAll('[data-block]')]

    // if no blocks on the page, run createPages
    if (!this.blocks.length) return this.createPages()

    // Check this if you want to create a new JS Block
    this.BlockManager = new BlockManager({
      blocks: this.blocks,
      scroll: this.smoothScroll,
      wrapper: this.scrollWrapper,
      screenSize: this.screenSize,
      modalParent: this.modalParent
    })
  }

  createPages() {
    this.PageManager = new PageManager({
      body: this.body,
      scroll: this.scroll,
      header: this.header,
      cursor: this.cursor,
      preloader: this.preloader
    })
  }

  onResize() {
    if (this.HeroManager) this.HeroManager.theHero.onResize()

    // run on Resize for all blocks
    if (this.BlockManager) this.BlockManager.onResize(this.screenSize)

    // run on Resize for all blocks
    if (this.HeaderManager) this.HeaderManager.onResize(this.screenSize)

    if (this.scroll) this.scroll.refresh()
  }

  onScroll() {
    if (this.HeaderManager) this.HeaderManager.headerOnScroll()

    // on Selected page if they have scroll
    if (this.page) {
      if (this.page.onScroll) this.page.onScroll()
    }
  }

  addEventListeners() {
    this.events = {}
    this.events.resize = this.onResize.bind(this)
    this.events.scroll = this.onScroll.bind(this)

    // check for frontend
    if (this.cursorOnPage) {
      this.anchors = [...document.querySelectorAll('a')]
      // Mouse effects on all links and others
      this.anchors.forEach((link) => {
        link.addEventListener('mouseenter', () => this.cursor.enter())
        link.addEventListener('mouseleave', () => this.cursor.leave())
      })
    }

    window.addEventListener('resize', this.events.resize)
    window.addEventListener('scroll', this.events.scroll)
  }
}

const website = new App()
