//Pages
import Article from '../Pages/Article'
import Archive from '../Pages/Archive'
import Search from '../Pages/Search'

export default class PageManager {
  constructor({ body, scroll, header, cursor, preloader }) {
    this.body = body
    this.scroll = scroll
    this.header = header
    this.cursor = cursor
    this.preloader = preloader

    this.init()
  }

  init() {
    this.pageCheck()
  }

  pageCheck() {
    const type = this.body.dataset.type

    switch (type) {
      case 'single.php':
        this.page = new Article({
            body: this.body,
            scroll: this.scroll,
            header: this.header
          })
        break
      case 'archive.php':
        this.page = new Archive({
            body: this.body,
            scroll: this.scroll,
            header: this.header,
            cursor: this.cursor
          })
        break
      case 'search.php':
        this.page = new Search({
            body: this.body,
            scroll: this.scroll,
            header: this.header,
            cursor: this.cursor
        })
        break
      default:
        return
    }
  }
}
