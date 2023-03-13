// HELPER STUFF

    // get viewport height
    export const getVh = () => {
        const vh = Math.max(document.documentElement.clientHeight || 0, window.innerHeight || 0);
        return vh;
    }
  
    // about half height
   export const halfHeight = (item) => {
        const height = (item.clientHeight / 2 ) - item.clientHeight * 0.2
        return height  
   }

    // Linear interpolation
    export const lerp = (a, b, n) => (1 - n) * a + n * b;
    
    // Gets the mouse position
    export const getMousePos = e => {
        return { 
            x : e.clientX, 
            y : e.clientY 
        };
    };

    export const calcWinsize = () => {
        return {width: window.innerWidth, height: window.innerHeight};
    };

    export const getRandomInteger = (min, max) => Math.floor(Math.random() * (max - min + 1) + min);


    // need to have imagesLoaded npm package
    export const preloadImages = (selector = 'img') => {
        return new Promise((resolve) => {
            imagesLoaded(document.querySelectorAll(selector), {background: true}, resolve);
        });
    };

    // Preload fonts
    export const preloadFonts = (id) => {
        return new Promise((resolve) => {
            WebFont.load({
                typekit: {
                    id: id
                },
                active: resolve
            });
        });
    };

    export const asyncQuerySelector = async (node, query) => {
        try {
          return await (query ? node.querySelector(query) : node)
        } catch (error) {
          console.error(`Cannot find ${query ? `${query} in`: ''} ${node}.`, error);
          return null;
        }
      };
    
    
      export const isInViewport = (elem) => {
        var distance = elem.getBoundingClientRect();
        return (
            distance.top >= 0 &&
            distance.left >= 0 &&
            distance.bottom <=
            (window.innerHeight || document.documentElement.clientHeight) &&
            distance.right <=
            (window.innerWidth || document.documentElement.clientWidth)
        );
    };