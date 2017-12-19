require('matchmedia-polyfill');
const breakpoints = require('./breakpoints');

class DisplaySize {
    constructor (window) {
        this.window = window;
    }

    derive () {
        let displaySizeName = 'xs';

        Object.keys(breakpoints).forEach(function (key) {
            let mediaQuery = breakpoints[key];

            if (window.matchMedia(mediaQuery).matches) {
                displaySizeName = key;
            }
        });

        return displaySizeName;
    }

    set (sizeName) {
        this.window.document.body.dataset.displaySizeName = sizeName;
    }

    get () {
        return this.window.document.body.dataset.displaySizeName;
    }
}

module.exports = DisplaySize;
