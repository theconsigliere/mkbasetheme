import { gsap, ScrollTrigger } from 'gsap/all'
gsap.registerPlugin(ScrollTrigger)

export default class Accordion {
  constructor({ scroll, container, id }) {
    this.DOM = { el: document.getElementById(id) }
    this.scroll = scroll
    this.container = container
    this.DOM.items = [...this.DOM.el.querySelectorAll('.js-accordion-item')]
    // this.init()
  }

  showList(event) {
    const item = event.currentTarget
    const desc = item.querySelector('.js-desc')
    const icon = item.querySelector('.js-icon')

    //get a perfect slide down
    if (desc.offsetHeight > 0) {
      // console.log('scrollUp')
      desc.style.height = `0px`
      // toggle between down arrow and straight bullet point
      // left
      icon.children[0].classList.remove('js-active')
      // right
      icon.children[1].classList.remove('js-active')
    } else {
      // console.log('scrollDown')
      desc.style.height = `${desc.scrollHeight}px`
      // toggle between down arrow and straight bullet point
      // left
      icon.children[0].classList.add('js-active')
      //right
      icon.children[1].classList.add('js-active')
    }
  }
  onResize() {}

  addEventListeners() {
    this.showEvent = this.showList.bind(this)
    this.DOM.items.forEach((item) => {
      item.addEventListener('click', this.showEvent)
    })
  }

  // OPTIONAL for all Blocks | Enables JS in Gutenberg Editor
  gutenberg() {
    if (window.acf) {
      this.init()
    }
  }

  // REQUIRED for all Blocks | Activated by blockManager.js
  init() {
    this.addEventListeners()
    this.onResize()
  }
}
