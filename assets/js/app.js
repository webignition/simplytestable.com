require('../css/app.scss');

require('../images/browser-icons/128-chrome.png');
require('../images/browser-icons/128-firefox.png');
require('../images/browser-icons/128-ie.png');
require('../images/browser-icons/128-opera.png');
require('../images/browser-icons/128-safari.png');
require('../images/browser-icons/256-ie.png');

require('classlist-polyfill');
let Home = require('./page/home');
let Features = require('./page/features');
let DisplaySize = require('./display-size');
let formButtonSpinner = require('./form-button-spinner');
let formFieldFocuser = require('./form-field-focuser');
let AlertFactory = require('./services/alert-factory');

const onDomContentLoaded = function () {
    let focusedField = document.querySelector('[data-focused]');

    if (focusedField) {
        formFieldFocuser(focusedField);
    }

    [].forEach.call(document.querySelectorAll('.js-form-button-spinner'), function (formElement) {
        formButtonSpinner(formElement);
    });

    if (document.body.classList.contains('home')) {
        let home = new Home(document, 'scroll');
        home.init();
    }

    if (document.body.classList.contains('features')) {
        let displaySize = new DisplaySize(window);

        displaySize.set(displaySize.derive());

        const scrollOffsets = {
            'lg': 240,
            'md': 240,
            'sm': 160
        };

        const affixOffsets = {
            'lg': 60,
            'md': 60,
            'sm': 60
        };

        const scrollSpyOffset = 240;
        const features = new Features(
            document.getElementById('upper-nav'),
            document.getElementById('landing-strip'),
            scrollSpyOffset,
            scrollOffsets[displaySize.get()],
            affixOffsets[displaySize.get()]
        );

        window.addEventListener('resize', function () {
            displaySize.set(displaySize.derive());
            features.setScrollOffset(scrollOffsets[displaySize.get()]);
            features.setAffixOffset(affixOffsets[displaySize.get()]);
        }, true);
    }

    [].forEach.call(document.querySelectorAll('.alert'), function (alertElement) {
        AlertFactory.createFromElement(alertElement);
    });
};

document.addEventListener('DOMContentLoaded', onDomContentLoaded);
