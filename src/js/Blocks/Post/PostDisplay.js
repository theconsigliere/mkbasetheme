import { postItem } from '../../Components/PostItem'
import { gsap, ScrollTrigger } from 'gsap/all'
gsap.registerPlugin(ScrollTrigger)

// we are using the WP REST API to grab the posts for our WP FILTER
export default class PostDisplay {
  constructor(id) {
    this.DOM = { el: document.getElementById(id) }
    this.DOM.holder = this.DOM.el.querySelector('.js-holder')
    this.DOM.cover = this.DOM.el.querySelector('.js-archive-cover')
    this.DOM.masterHolder = this.DOM.el.querySelector('.js-master-holder')
    this.DOM.filterLinks = [
      ...this.DOM.el.querySelectorAll('.js-filter-select')
    ]

    // Posts
    this.categories = []
    this.allPosts = []
    this.filteredPosts = []
    // how many post to show at anyone time
    this.postsPerPage = parseInt(this.DOM.masterHolder.dataset.showposts)
    this.defaultFilter = this.DOM.masterHolder.dataset.slug

    this.addEventListeners()
  }

  init() {
    // fade out archive
    setTimeout(() => {
      this.DOM.cover.classList.add('js-fade-out')
    }, 500)

    if (this.defaultFilter) {
      // if a custom filter is selected, display it on initial page load
      this.DOM.filterLinks.forEach((link) => {
        link.classList.remove('js-active')
        if (this.defaultFilter === link.dataset.slug) {
          link.classList.add('js-active')
        }
      })
    }

    // Grab posts for when we need them
    this.fetchPosts()
  }

  truncate(str, no_words) {
    return str.split(' ').splice(0, no_words).join(' ')
  }

  // Pagination
  // 3. render these to the DOM

  async fetchPosts() {
    // grabs posts

    const response = await fetch(
      '/wp-json/wp/v2/posts?per_page=100&acf_format=standard'
    )
    const data = await response.json()

    // get acf data for each post
    data.forEach((item) => {
      const cat = []

      item.categories.forEach((category) => {
        const catname = category.category_name.toLowerCase()
        cat.push(catname)
      })

      const obj = {
        image: item.acf.article_hero.image.url,
        title: item.title.rendered,
        date: item.formatted_date,
        readTime: item.acf.article_intro.article_read_time,
        quote: `${this.truncate(item.acf.article_intro.intro_text, 55)}`,
        permalink: item.link,
        categories: cat
      }

      this.allPosts.push(obj)
    })
  }

  showPosts(post) {
    const postHTML = postItem(post)
    const newPost = new DOMParser().parseFromString(postHTML, 'text/html').body
      .firstChild
    this.DOM.holder.appendChild(newPost)
  }

  // show specific posts for pagination
  getNumberOfPosts() {
    // Get relevant posts
    let slicedArray
    let currentArray

    this.filteredPosts.length
      ? (currentArray = this.filteredPosts)
      : (currentArray = this.allPosts)

    slicedArray = currentArray.slice(0, this.postsPerPage)

    // empty divs
    this.DOM.holder.innerHTML = ''

    // show new posts
    slicedArray.forEach((post) => {
      this.showPosts(post)
    })

    // show archive
    setTimeout(() => {
      this.DOM.cover.classList.add('js-fade-out')
    }, 250)
  }

  //OPTIONAL if scroll event needed
  // Comes from index.js onScroll
  onScroll() {}

  filter(event) {
    // fade out
    this.DOM.cover.classList.remove('js-fade-out')

    // empty filtered posts
    this.filteredPosts = []
    event.target.classList.add('disable')
    this.DOM.holder.innerHTML = ''

    // remove active for all buttons
    this.DOM.filterLinks.forEach((link) => {
      link.classList.remove('js-active')
    })
    // add active for selected filter
    event.target.classList.add('js-active')

    // grab data attribute
    this.currentCategory = event.target.getAttribute('data-slug')
    // match currentcategory with posts and create array of posts
    this.allPosts.forEach((post) => {
      if (post.categories.indexOf(this.currentCategory) > -1) {
        //In the array!
        this.filteredPosts.push(post)
      }
    })

    // add loading then hide it after 2 secs
    setTimeout(() => {
      event.target.classList.remove('disable')
    }, 3000)

    this.getNumberOfPosts()
  }

  addEventListeners() {
    this.DOM.filterLinks.forEach((item) => {
      item.addEventListener('click', this.filter.bind(this))
    })
  }

  // Required!
  resize() {}

  getHeight() {
    // set cover
    this.DOM.holder.style.minHeight = `${
      this.DOM.holder.getBoundingClientRect().height
    }px`
  }
}
