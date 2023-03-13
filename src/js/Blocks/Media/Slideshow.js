// https://swiperjs.com/swiper-api
// core version + navigation, pagination modules:
import Swiper, { Scrollbar, Autoplay } from 'swiper'

// configure Swiper to use modules
Swiper.use([Scrollbar, Autoplay])

export default class Slideshow {
  constructor({ scroll, container, id }) {
    this.DOM = { el: document.getElementById(id) }
    this.scroll = scroll
    this.container = container
    this.DOM.speed = this.DOM.el.dataset.duration
    this.DOM.wrapper = this.DOM.el.querySelector('.js-wrapper')
    this.DOM.slider = this.DOM.el.querySelector('.js-slider')
    this.DOM.pagination = this.DOM.el.querySelector('.js-pagination')
    this.DOM.next = this.DOM.el.querySelector('.js-next')
    this.DOM.prev = this.DOM.el.querySelector('.js-prev')
  }

  // REQUIRED for all Blocks | Activated by blockManager.js
  init() {
    const speed = parseInt(this.DOM.speed)

    this.swiper = new Swiper(this.DOM.slider, {
      slidesPerView: 1,
      grabCursor: true,
      simulateTouch: true,
      loop: true,
      pagination: {
        el: this.DOM.pagination,
        type: 'fraction'
      },
      navigation: {
        nextEl: this.DOM.next,
        prevEl: this.DOM.prev
      },
      autoplay: {
        delay: speed,
        disableOnInteraction: false
      }
      // breakpoints: {
      //   // when window width is >= 0px
      //   0: {
      //     slidesPerView: 1,
      //     spaceBetween: 5
      //   },
      //   // when window width is >= 640px
      //   768: {
      //     slidesPerView: 2,
      //     spaceBetween: 20
      //   },
      //   // when window width is >= 640px
      //   1220: {
      //     slidesPerView: 2,
      //     spaceBetween: 30
      //   }
      // }
    })
  }
  // OPTIONAL for all Blocks | Enables JS in Gutenberg Editor
  gutenberg() {
    this.init()
  }
}
