import { Parallax } from '../../Animations/Parallax'

export default class FullWidthImage {
  constructor({ scroll, container, id }) {
    this.DOM = { el: document.getElementById(id) }
    this.scroll = scroll
    this.container = container
    this.DOM.image = this.DOM.el.querySelector('.js-parallax')
  }

  // REQUIRED for all Blocks | Activated by blockManager.js
  init() {
    Parallax(this.DOM.image)
  }

  onResize() {
    // re run parallax on page resize
    this.init()
  }

  // OPTIONAL for all Blocks | Enables JS in Gutenberg Editor
  // gutenberg() {}
}
