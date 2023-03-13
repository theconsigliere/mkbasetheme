import { Parallax } from '../../Animations/Parallax'

export default class HeroImagesideTextside {
  constructor(id) {
    this.DOM = { el: document.getElementById(id) }
    this.DOM.image = this.DOM.el.querySelector('.js-parallax')
  }

  // REQUIRED for all Heros | Activated by heroManager.js
  init() {
    // split text
    this.onResize()
  }

  init() {
    Parallax(this.DOM.image)
  }

  onResize() {}

  // OPTIONAL for all Blocks | Enables JS in Gutenberg Editor
  // gutenberg() {}

  // Necessary to have, leave empty if not needed
  // Activated by index.js
  onLoad() {
    this.init()
  }
}
