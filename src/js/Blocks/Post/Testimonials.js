// core version + navigation, pagination modules:
import Swiper, { Navigation, Pagination, Autoplay, EffectFade } from 'swiper'
// configure Swiper to use modules
Swiper.use([Navigation, Pagination, Autoplay, EffectFade])

export default class Testimonials {
  constructor(id) {
    this.DOM = { el: document.getElementById(id) }
    this.DOM.slider = this.DOM.el.querySelector('.js-container')
    this.DOM.slides = [...this.DOM.el.querySelectorAll('.js-slide')]
    this.DOM.pagination = this.DOM.el.querySelector('.js-pagination')
    this.DOM.buttonNext = this.DOM.el.querySelector('.js-next')
    this.DOM.buttonPrev = this.DOM.el.querySelector('.js-prev')

    this.DOM.speed = this.DOM.el.dataset.duration
  }
  // REQUIRED for all Heros | Activated by heroManager.js
  init() {
    this.swiper()
  }
  swiper() {
    const speed = parseInt(this.DOM.speed)

    this.swiperSlider = new Swiper(this.DOM.slider, {
      spaceBetween: 30,
      effect: 'fade',
      simulateTouch: true,
      loop: true,
      pagination: {
        el: this.DOM.pagination,
        type: 'fraction',
        clickable: true
      },
      autoplay: {
        delay: speed,
        disableOnInteraction: false
      },
      navigation: {
        nextEl: this.DOM.buttonNext,
        prevEl: this.DOM.buttonPrev
      },
      on: {
        init: function () {
          console.log('Testimonial swiper initialized')
        }
      }
    })
  }

  onResize() {}

  onLoad() {
    this.swiper()
  }

  gutenberg() {
    this.swiper()
    //   window.acf.addAction('render_block_preview/type=hero-slideshow', this.swiper.bind(this))
  }
}
