export default class Search {
  constructor({ body, scroll, header }) {
    this.scroll = scroll
    this.header = header
    this.DOM = { el: body }

    this.DOM.disclaimer = this.DOM.el.querySelector('.js-disclaimer')
    this.DOM.disclaimerSpan = this.DOM.el.querySelector('.js-disclaimer-span')
    this.DOM.form = this.DOM.el.querySelector('.js-search-form')
    this.DOM.input = this.DOM.form.querySelector('.js-search-field')
    this.DOM.loading = this.DOM.el.querySelector('.js-loader')
    this.DOM.resultsDiv = this.DOM.el.querySelector('.js-render-results')
    this.DOM.resultsTitle = this.DOM.el.querySelector('.js-results-title')
    this.DOM.submit = this.DOM.form.querySelector(".js-search-submit")

    // Events
    this.updateValue = new CustomEvent('updateSearchValue', {
      bubbles: true,
      detail: { searchTerm: () => this.DOM.input.value }
    })

    // events
    this.searchInputTerm = this.searchTerm.bind(this)

    this.searchResults = {}
    this.emptyResults()

    this.addEventListeners()

    /* Finds Search query from URL & runs search with it */
    const URL = window.location.href
    const domain = window.location.protocol + '//' + window.location.host + '/?s='
    const searchQuery = URL.replace(domain, '')
    // console.log('Search query:', searchQuery)
    if (searchQuery != '') {
      this.DOM.submit.click()
    }
  }

  emptyResults() {
    this.searchResults.Pages = []
    this.searchResults.Posts = []
  }

  // OPTIONAL if scroll event needed
  // Comes from index.js onScroll
  // onScroll() {}

  handleError(err) {
    console.log(err, 'sorry no pages or posts')
  }

  renderNoResults(term) {
    setTimeout(() => {
      this.DOM.loading.classList.remove('js-active')
      this.DOM.resultsTitle.classList.add('js-active')
      //Append to page

      // after loader has tranisitioned out
      setTimeout(() => {
        const title = document.createElement('h5')
        title.classList.add('js-render-no-results')
        title.innerHTML = `Sorry no pages or posts match your search ${term}, please try again`
        this.DOM.resultsDiv.appendChild(title)
      }, 400)
    }, 2000)
  }

  newPageCard(page) {
    let title

    if (page.subtype == 'page') {
      title = `<h4 class='SearchPage__results-item--title'>${page.title}</h4>`
    } else {
      title = `<h5 class='approach SearchPage__results-item--title'>${page.title}</h5>`
    }

    return `<a class="results-card" href="${page.url}">
            <div class="results-card__title-ssection">
                ${title}
            </div>
        </a>`
  }

  renderSearchResults(results, term) {
    const keys = Object.keys(results)
    const resultDivEntries = []

    // iterate over object
    keys.forEach((key, index) => {
      // create title
      if (results[key].length) {
        const pageSection = document.createElement('div')
        pageSection.classList.add('SearchPage__results-section')
        const title = document.createElement('h6')
        title.classList.add('SearchPage__results-title')
        title.innerHTML = `${key} that match '${term}'`
        pageSection.appendChild(title)

        // then interiate over each key
        results[key].forEach((value) => {
          const page = document.createElement('article')
          page.classList.add('SearchPage__result')
          page.innerHTML = this.newPageCard(value)
          pageSection.appendChild(page)
        })

        resultDivEntries.push(pageSection)
      }
    })

    // wait then allow results to be shown and hide loading state
    setTimeout(() => {
      this.DOM.loading.classList.remove('js-active')
      this.DOM.resultsTitle.classList.add('js-active')
      //Append to page

      // after loader has tranisitioned out
      setTimeout(() => {
        resultDivEntries.forEach((div) => {
          this.DOM.resultsDiv.appendChild(div)
        })
      }, 400)
    }, 2000)
  }

  async searchTerm(e) {
    // Prevents Page reload on form submit
    e.preventDefault()

    // grab current search term
    const term = this.updateValue.detail.searchTerm()

    // dont run if already searched term
    if (term === this.term) return

    // save term to compare next time
    this.term = term

    // add loading state
    this.DOM.resultsTitle.classList.remove('js-active')
    this.DOM.loading.classList.add('js-active')
    this.DOM.disclaimer.classList.add('js-hide')

    // grabs all search responses
    const response = await fetch(
      `/wp-json/wp/v2/search?per_page=99&search=${term}`
    ).catch(this.handleError)
    const data = await response.json()

    // Results Block Title
    this.DOM.resultsTitle.textContent = `Showing results for: "${term}"`

    // empty search results
    this.emptyResults()

    if (data.length > 0) {
      // get acf data for each post
      data.forEach((item) => {
        switch (item.subtype) {
          case 'page':
            let page = item
            this.searchResults.Pages.push(page)
            break
          case 'post':
            let post = item
            this.searchResults.Posts.push(post)
            break
        }
        return this.searchResults
      })

      this.renderSearchResults(this.searchResults, term)
    } else {
      this.renderNoResults(term)
    }
    
    window.history.replaceState(null, document.title, "/?s=" + term)
  }

  addEventListeners() {
    // The form element listens for the custom "updateSearchValue" event and then consoles the output of the passed text() method
    this.DOM.form.addEventListener('updateSearchValue', (e) => {
      // if we have a vlaue in input field add a space before text
      e.detail.searchTerm()
        ? (this.DOM.disclaimerSpan.textContent = ' ' + e.detail.searchTerm())
        : (this.DOM.disclaimerSpan.textContent = '')
    })

    // listen for text changes on input field, when 'input' dispatch custom event
    this.DOM.input.addEventListener('input', (e) => {
      // clear results
      this.DOM.resultsDiv.innerHTML = ''
      this.DOM.resultsTitle.classList.remove('js-active')
      this.DOM.resultsTitle.innerHTML = ''
      this.DOM.disclaimer.classList.remove('js-hide')
      // dispatch event
      e.target.dispatchEvent(this.updateValue)
    })

    this.DOM.form.addEventListener('submit', this.searchInputTerm)
  }
}
