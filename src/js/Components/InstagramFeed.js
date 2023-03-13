import Instafeed from 'instafeed.js'

// To get your instagram access first you need
// 1. Fb Login
// 2. Instagram Login
// 3. Follow this video: https://www.youtube.com/watch?v=E9OftnOmcIY

export default class InstagramPosts {
  constructor(id) {
    this.id = id
    this.init()
  }

  init() {
   
    const feed = new Instafeed({
      accessToken: process.env.INSTAGRAM_TOKEN,
      limit: 8,
      target: this.id,
      template:
        '<a href="{{link}}" target="new"><img title="{{caption}}" src="{{image}}" /></a>'
    })

    feed.run()
  }
}
