// To work with Scrollsmoother in directing the page when we use anchor links in url's
import { gsap, ScrollSmoother } from 'gsap/all'
gsap.registerPlugin(ScrollSmoother)

export default class LinkManager {
  constructor() {}
  // ON PAGE LOAD: Take you down the page to the chosen section
  onPageLoad(menu, background) {
    // check page has section first
    if (window.location.hash) {
      const section = document.querySelector(window.location.hash)

      // to hide the mobile menu
      if (menu && background) {
        menu.classList.remove('mobile-menu-appear')
        background.classList.remove('page-cover-opacity')
      }

      // then take you down the page
      if (section) return ScrollSmoother.get().scrollTo(section, true)
    }
  }

  // ON HOMEPAGE: take you down the page to the choosen section
  scrollDownPage(menu) {
    if (menu.href.includes('#')) {
      menu.addEventListener('click', (event) => {
        // if we are on homepage dont reload the page
        if (event.target.hash != null) {
          // If link is the same page we are on
          if (window.location.href.includes(event.target.href)) {
            event.preventDefault()
          }

          //scroll to section
          const section = document.querySelector(event.target.hash)

          // then take you down the page
          if (section) {
            ScrollSmoother.get().scrollTo(section, true)
            // Update window location
            window.history.pushState({}, '', event.target.hash)
          }
        }
      })
    }
  }
}
