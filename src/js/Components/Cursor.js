import { lerp, getMousePos } from '../Utils'
import gsap from 'gsap'

export default class Cursor {
    constructor({ mouse }) {
     //  console.log('hello')
        this.mouse = mouse
        this.DOM = {el: document.querySelector('.cursor')};
        this.DOM.el.style.opacity = 0;
        
        this.bounds = this.DOM.el.getBoundingClientRect();
        
        this.renderedStyles = {
            tx: {previous: 0, current: 0, amt: 0.2},
            ty: {previous: 0, current: 0, amt: 0.2},
            scale: {previous: 1, current: 1, amt: 0.15},
            //opacity: {previous: 1, current: 1, amt: 0.1}
        };

        this.addEventListeners()

        this.onMouseMoveEv = () => {
         //   console.log(this.mouse)
            this.renderedStyles.tx.previous = this.renderedStyles.tx.current = this.mouse.x - this.bounds.width/2;
            this.renderedStyles.ty.previous = this.renderedStyles.ty.previous = this.mouse.y - this.bounds.height/2;
            gsap.to(this.DOM.el, {duration: 0.9, ease: 'Power3.easeOut', opacity: 1});
            requestAnimationFrame(() => this.render());
            window.removeEventListener('mousemove', this.onMouseMoveEv);
        }
        window.addEventListener('mousemove', this.onMouseMoveEv);
    }

    enter() {
        this.renderedStyles['scale'].current = 2.5;
        //this.renderedStyles['opacity'].current = 0.5;
    }
    leave() {
        this.renderedStyles['scale'].current = 1;
        //this.renderedStyles['opacity'].current = 1;
    }
    render() {
        this.renderedStyles['tx'].current = this.mouse.x - this.bounds.width/2;
        this.renderedStyles['ty'].current = this.mouse.y - this.bounds.height/2;

        for (const key in this.renderedStyles ) {
            this.renderedStyles[key].previous = lerp(this.renderedStyles[key].previous, this.renderedStyles[key].current, this.renderedStyles[key].amt);
        }
                    
        this.DOM.el.style.transform = `translateX(${(this.renderedStyles['tx'].previous)}px) translateY(${this.renderedStyles['ty'].previous}px) scale(${this.renderedStyles['scale'].previous})`;
        //this.DOM.el.style.opacity = this.renderedStyles['opacity'].previous;

        requestAnimationFrame(() => this.render());
    }

    addEventListeners() {
      //  window.addEventListener('mousemove', this.onMouseMoveEv.bind(this));
        window.addEventListener('mousemove', ev => this.mouse = getMousePos(ev));

    }
}

