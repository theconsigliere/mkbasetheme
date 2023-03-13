//MEDIA
import FullWidthImage from '../Blocks/Media/FullWidthImage'
import Gallery from '../Blocks/Media/Gallery'
import Slideshow from '../Blocks/Media/Slideshow'

// LAYOUT
import Accordion from '../Blocks/Layout/Accordion'
import FAQSection from '../Blocks/Layout/FAQSection'

// POST
import Testimonials from '../Blocks/Post/Testimonials'
import PostDisplay from '../Blocks/Post/PostDisplay'

// TEXT
import ContactSection from '../Blocks/Text/ContactSection'

export default class BlockManager {
  constructor({ blocks, scroll, wrapper, screenSize, modalParent }) {
    this.blocks = blocks
    this.scroll = scroll
    this.screenSize = screenSize
    this.scrollWrapper = wrapper
    this.modalParent = modalParent
    this.currentBlocks = []

    this.onFirstPageLoad()

    if (typeof wp != 'undefined' && wp.blockEditor) {
      this.gutenberg()
    } else {
      this.frontend()
    }
  }

  onFirstPageLoad() {
    this.blocks.forEach((block) => {
      this.blockCheck(block)
    })
  }

  blockCheck(block) {
    if (!this.currentBlocks) {
      this.currentBlocks = []
    }

    const className = block.className
    const id = block.id
    // split classnames into an array
    let keys = className.split(' ')
    // filter out any classes that match 'alignfull' or contain 'wp-block'
    keys = keys.filter((cl) => cl !== 'alignfull' || !cl.includes('wp-block'))
    // flatten array
    keys = keys[0]

    switch (keys) {
      case 'PostDisplay':
        const pd = new PostDisplay(id)
        this.currentBlocks.push(pd)
        break
      case 'Testimonials':
        const t = new Testimonials(id)
        this.currentBlocks.push(t)
        break
      case 'ContactSection':
        const cs = new ContactSection(id)
        this.currentBlocks.push(cs)
        break
      case 'Slideshow':
        const s = new Slideshow({
          scroll: this.scroll,
          container: this.scrollWrapper,
          id: id
        })
        this.currentBlocks.push(s)
        break
      case 'Accordion':
        const a = new Accordion({
          scroll: this.scroll,
          container: this.scrollWrapper,
          id: id
        })
        this.currentBlocks.push(a)
        break
      case 'FAQSection':
        const l = new FAQSection(id)
        this.currentBlocks.push(l)
        break
      case 'FullWidthImage':
        const fwi = new FullWidthImage({
          scroll: this.scroll,
          container: this.scrollWrapper,
          id: id
        })
        this.currentBlocks.push(fwi)
        break
      case 'Gallery':
        const g = new Gallery({
          id: id,
          modalParent: this.modalParent
        })
        this.currentBlocks.push(g)
        break
      default:
        return
    }
  }

  // Enable Gutenberg
  gutenberg() {
    this.currentBlocks.forEach((block) => {
      if (block.gutenberg) block.gutenberg()
    })
  }

  // ENbale frontend JS
  frontend() {
    this.currentBlocks.forEach((block) => {
      block.init()
    })
  }

  deleteBlocks() {
    if (this.currentBlocks) {
      delete this.currentBlocks
    }
  }

  enterPageTransition(next) {
    // init
    const blocksOnNewPage = [...document.querySelectorAll('[data-block]')]

    blocksOnNewPage.forEach((block) => {
      this.blockCheck(block)
    })
  }

  onResize(screenSize) {
    this.screenSize = screenSize

    this.currentBlocks.forEach((block) => {
      if (block.onResize) {
        block.onResize(this.screenSize)
      }
      // this.blocks[blocks].onResize(this.screenSize)
    })

    //  console.log('blocks resize')
  }
}
