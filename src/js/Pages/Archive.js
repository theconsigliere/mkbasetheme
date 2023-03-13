import { postItem } from '../Components/PostItem'
// import { gsap, ScrollTrigger } from 'gsap/all'
// gsap.registerPlugin(ScrollTrigger)

export default class Archive {
  constructor({ body, scroll, header, cursor }) {
    this.scroll = scroll
    this.header = header
    this.cursor = cursor
    this.DOM = { el: body }
    this.DOM.holder = this.DOM.el.querySelector('.js-holder')
    this.DOM.cover = this.DOM.el.querySelector('.js-archive-cover')
    this.DOM.masterHolder = this.DOM.el.querySelector('.js-master-holder')
    this.DOM.filterLinks = [
      ...this.DOM.el.querySelectorAll('.js-filter-select')
    ]
    
    
    // don't run if wp filter is hidden
    if (!this.DOM.filterLinks.length) {
      this.DOM.cover.classList.add('js-fade-out')
      return
    } 
    
    // Posts
    this.categories = []
    this.allPosts = []
    this.filteredPosts = []
    this.offset = 0
    // how many post to show at anyone time
    this.postsPerPage = parseInt(this.DOM.masterHolder.dataset.showposts)
    this.defaultFilter = this.DOM.masterHolder.dataset.slug
    this.DOM.prevButton = this.DOM.el.querySelector('.js-previous-posts')
    this.DOM.nextButton = this.DOM.el.querySelector('.js-next-posts')
    // hide buttons till buttons available
    this.DOM.prevButton.disabled = true
    this.DOM.nextButton.disabled = true

    this.addEventListeners()
    this.init()
  }

  init() {
    // fade out archive
    setTimeout(() => {
      this.DOM.cover.classList.add('js-fade-out')
    }, 500)

    // Grab posts for when we need them
    this.fetchPosts()
  }

  // Runs on page load if terms are set
  wpFilterOnPageLoad() {
    //  console.log('wp filter page load')

    // if a custom filter is selected, display it on initial page load
    this.DOM.filterLinks.forEach((link) => {
      link.classList.remove('js-active')
      if (this.defaultFilter === link.dataset.slug) {
        link.classList.add('js-active')
      }
    })

    // Work out if pagination needs to be set
    let slicedArray
    // grab all filtered posts
    this.filteredPosts = []

    this.allPosts.forEach((post) => {
      if (post.categories.indexOf(this.defaultFilter) > -1) {
        //In the array!
        this.filteredPosts.push(post)
      }
    })

    // Slide up array
    slicedArray = this.filteredPosts.slice(0, this.postsPerPage)

    //check to show pagination buttons or not
    this.checkToShowButtons(this.filteredPosts, slicedArray)
  }

  truncate(str, no_words) {
    return str.split(' ').splice(0, no_words).join(' ')
  }

  // Pagination
  // 3. render these to the DOM

  async fetchPosts() {
    // grabs all posts NOT THE FIRST 4
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

      // after posts returned enable pagination
      this.DOM.nextButton.disabled = false
    })

    // if we have a hash, hash takes precendance over what was set as acf term
    if (window.location.hash) {
      let typeLink, type
      // check hash against our filterlinks
      const hash = window.location.hash.substring(1)
      for (let i = 0; i < this.DOM.filterLinks.length; i++) {
        type = this.DOM.filterLinks[i].dataset.slug
        if (type === window.location.hash.substring(1)) {
          typeLink = true
          break
        }
        typeLink = false
      }

      // console.log(typeLink)
      // console.log(this.defaultFilter)

      if (typeLink) {
        this.filterByHash(type)
      } else if (this.defaultFilter) {
        this.wpFilterOnPageLoad()
      } else {
      }
    } else if (this.defaultFilter) {
      this.wpFilterOnPageLoad()
    } else {
    }
  }

  filterByHash(term) {
    // empty filtered posts
    this.filteredPosts = []

    // 1. Select Correct filter link to activate
    this.DOM.filterLinks.forEach((link) => {
      link.classList.remove('js-active')
      if (term === link.dataset.slug) {
        link.classList.add('js-active')
      }
    })

    // update currentcategory
    this.currentCategory = term

    this.allPosts.forEach((post) => {
      if (post.categories.indexOf(this.currentCategory) > -1) {
        //In the array!
        this.filteredPosts.push(post)
      }
    })

    this.getNumberOfPosts(0)
  }

  showPosts(post) {
    const postHTML = postItem(post)
    const newPost = new DOMParser().parseFromString(postHTML, 'text/html').body
      .firstChild
    this.DOM.holder.appendChild(newPost)
  }

  // show specific posts for pagination
  getNumberOfPosts(offset) {
    // console.log('get number of posts')
    // get relevant posts
    //  console.log(this.allPosts.length, offset, this.showposts)
    let slicedArray
    let currentArray

    // selected filtered posts if available
    this.filteredPosts.length
      ? (currentArray = this.filteredPosts)
      : (currentArray = this.allPosts)

    // slide up array
    slicedArray = currentArray.slice(offset, this.postsPerPage + offset)

    console.log(currentArray, slicedArray)

    // scroll to top of archive
    // this.scroll.Scroll.scrollTo(this.DOM.holder, true, 'top 50%')

    this.DOM.el.scrollIntoView({
      behavior: 'smooth',
      block: 'start',
      inline: 'start'
    })

    // empty divs
    this.DOM.holder.innerHTML = ''

    slicedArray.forEach((post) => {
      this.showPosts(post)
    })

    // show archive
    setTimeout(() => {
      this.DOM.cover.classList.add('js-fade-out')
    }, 250)
    //check to show pagination buttons or not
    this.checkToShowButtons(currentArray, slicedArray)
  }

  // this is a click event
  prevPosts(event) {
    this.DOM.cover.classList.remove('js-fade-out')

    this.getHeight()
    let currentPosts = []

    this.offset -= this.postsPerPage
    this.getNumberOfPosts(this.offset)

    if (!this.filteredPosts.length) {
      // empty or does not exist
      currentPosts = this.allPosts
    } else {
      currentPosts = this.filteredPosts
    }

    // Hide button if no more pages after this one
    if (this.offset - this.postsPerPage <= 0) {
      this.DOM.prevButton.disabled = true
    }

    // show next button if now available
    if (this.offset + this.postsPerPage <= currentPosts.length) {
      this.DOM.nextButton.disabled = false
    }
  }

  checkToShowButtons(currentArray, slicedArray) {
    // check wether to show or hide next button
    //  console.log(this.offset, this.postsPerPage, currentArray, slicedArray)
    this.DOM.nextButton.disabled = false
    this.DOM.prevButton.disabled = false

    // console.log(currentArray, slicedArray)

    // Hide button if no more pages after this one
    if (this.offset - this.postsPerPage <= 0) {
      this.DOM.prevButton.disabled = true
    }

    // console.log(this.offset + this.postsPerPage, currentArray.length)

    // show next button if now available
    if (this.offset + this.postsPerPage >= currentArray.length) {
      this.DOM.nextButton.disabled = true
    }
  }

  // this is a click event
  nextPosts(event) {
    this.DOM.cover.classList.remove('js-fade-out')

    this.getHeight()
    this.offset += this.postsPerPage
    let currentPosts = []

    // console.log(event.target)
    this.getNumberOfPosts(this.offset)

    if (!this.filteredPosts.length) {
      // empty or does not exist
      currentPosts = this.allPosts
    } else {
      currentPosts = this.filteredPosts
    }

    // Hide button if no more pages after this one
    if (this.offset + this.postsPerPage >= currentPosts.length) {
      this.DOM.nextButton.disabled = true
    }

    // shwo prev butotn if available
    if (this.offset - this.postsPerPage >= 0) {
      this.DOM.prevButton.disabled = false
    }
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

    // Reset offset after new filter has been clicked
    this.offset = 0

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

    this.getNumberOfPosts(this.offset)
  }

  addEventListeners() {
    this.prevPostsEvent = this.prevPosts.bind(this)
    this.nextPostsEvent = this.nextPosts.bind(this)

    this.DOM.prevButton.addEventListener('click', this.prevPostsEvent)
    this.DOM.nextButton.addEventListener('click', this.nextPostsEvent)

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
