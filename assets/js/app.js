require('../css/app.scss');

require('../images/browser-icons/128-chrome.png');
require('../images/browser-icons/128-firefox.png');
require('../images/browser-icons/128-ie.png');
require('../images/browser-icons/128-opera.png');
require('../images/browser-icons/128-safari.png');
require('../images/browser-icons/256-ie.png');

require('classlist-polyfill');
let home = require('./home');

function ready (fn) {
    if (document.attachEvent ? document.readyState === 'complete' : document.readyState !== 'loading') {
        fn();
    } else {
        document.addEventListener('DOMContentLoaded', fn);
    }
}

ready(function () {
    if (document.body.classList.contains('home-index')) {
        home(document, 'scroll');
    }
});
