export default class ContactSection {
  constructor(id) {
    this.DOM = { el: document.getElementById(id) }
    this.DOM.form = this.DOM.el.querySelector('.wpcf7 > form')
  }

  // REQUIRED for all Blocks | Activated by blockManager.js
  init() {
    if (wpcf7.init) {
      // console.log(wpcf7)
      wpcf7.init(this.DOM.form)
    }

    this.DOM.form.addEventListener(
      'wpcf7submit',
      function (event) {
        //   window.open('/newspace-flipbook', '_blank').focus();
        console.log('send')
      },
      false
    )
  }
}
