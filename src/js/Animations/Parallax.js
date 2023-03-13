import gsap from "gsap";
import ScrollTrigger from "gsap/ScrollTrigger"
gsap.registerPlugin(ScrollTrigger)

// Classic Parallax

export const Parallax = (image) => {
  return gsap.fromTo(image,{ 
      y: -(image.offsetHeight - image.parentElement.offsetHeight)
    }, {
      scrollTrigger: {
        trigger: image.parentElement,
        scrub: true,
        invalidateOnRefresh: true
      },
      y: 0,
      ease: "none"
    })
}
