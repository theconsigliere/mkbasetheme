// Hero
import HeroSlideshow from '../Blocks/hero/HeroSlideshow'
import HeroFullWidth from '../Blocks/hero/HeroFullWidth'
import HeroImagesideTextside from '../Blocks/Hero/HeroImagesideTextside'

export default class HeroManager {
  constructor({ hero, header, screenSize, preloader }) {
    this.hero = hero
    this.header = header
    this.screenSize = screenSize
    this.preloader = preloader

    if (this.hero) {
      this.init()
    } else {
      //If hero not available doing something, this.header.headerBackground()
    }
  }

  init() {
    this.heroCheck(this.hero)
  }

  heroCheck(hero) {
    const className = hero.className
    const id = hero.id

    // split classnames into an array
    let key = className.split(' ')
    key = key.filter((cl) => cl !== 'alignfull' || !cl.includes('wp-block'))
    // flatten array
    key = key[0]

    switch (key) {
      case 'HeroFullWidth':
        this.theHero = new HeroFullWidth(id)
        break
      case 'HeroSlideshow':
        this.theHero = new HeroSlideshow(id)
        break
      case 'HeroImagesideTextside':
        this.theHero = new HeroImagesideTextside(id)
        break
      default:
        return
    }

    // if gutenberg
    if (typeof wp != 'undefined' && wp.blockEditor) {
      if (this.theHero.gutenberg) {
        this.theHero.gutenberg()
      }
    } else {
      // if not gutenberg
      this.theHero.init()
    }
  }

  deleteHero() {
    if (this.theHero) {
      delete this.theHero
    }
  }

  // barba enter
  enterPageTransition() {
    this.currentHero = document.querySelector('[data-hero]')
    if (this.currentHero) {
      this.heroCheck(this.currentHero)
    }
  }

  // does block need to enable gutenberg  back end editing
  gutenberg() {
    if (this.theHero.gutenberg) {
      this.theHero.gutenberg()
    }
  }

  onResize(screenSize) {
    this.screenSize = screenSize

    // console.log(this)
    //  console.log('heros resize')
  }
}
