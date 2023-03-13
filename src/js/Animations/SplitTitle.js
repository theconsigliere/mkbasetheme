import { gsap, SplitText } from 'gsap/all'
gsap.registerPlugin(SplitText)

// This Variable splits a title into lines and fades it up

export const SplitTitle = (title) => {
  const newTitle = new SplitText(title, {
    type: 'lines',
    linesClass: 'lineChild'
  })
  const innerTitle = new SplitText(title, {
    type: 'lines',
    linesClass: 'lineParent'
  })
  gsap.set(newTitle.lines, { yPercent: 100 })

  return newTitle.lines
}
