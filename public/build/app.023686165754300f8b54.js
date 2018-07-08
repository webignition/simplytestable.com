/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/build/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./assets/js/app.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./assets/css/app.scss":
/*!*****************************!*\
  !*** ./assets/css/app.scss ***!
  \*****************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./assets/images/browser-icons/128-chrome.png":
/*!****************************************************!*\
  !*** ./assets/images/browser-icons/128-chrome.png ***!
  \****************************************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports) {

module.exports = "/build/images/128-chrome.8399c2df.png";

/***/ }),

/***/ "./assets/images/browser-icons/128-firefox.png":
/*!*****************************************************!*\
  !*** ./assets/images/browser-icons/128-firefox.png ***!
  \*****************************************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports) {

module.exports = "/build/images/128-firefox.ecd17d1f.png";

/***/ }),

/***/ "./assets/images/browser-icons/128-ie.png":
/*!************************************************!*\
  !*** ./assets/images/browser-icons/128-ie.png ***!
  \************************************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports) {

module.exports = "/build/images/128-ie.d36bf675.png";

/***/ }),

/***/ "./assets/images/browser-icons/128-opera.png":
/*!***************************************************!*\
  !*** ./assets/images/browser-icons/128-opera.png ***!
  \***************************************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports) {

module.exports = "/build/images/128-opera.e86ae7a2.png";

/***/ }),

/***/ "./assets/images/browser-icons/128-safari.png":
/*!****************************************************!*\
  !*** ./assets/images/browser-icons/128-safari.png ***!
  \****************************************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports) {

module.exports = "/build/images/128-safari.8e977f6c.png";

/***/ }),

/***/ "./assets/images/browser-icons/256-ie.png":
/*!************************************************!*\
  !*** ./assets/images/browser-icons/256-ie.png ***!
  \************************************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports) {

module.exports = "/build/images/256-ie.af2d08d3.png";

/***/ }),

/***/ "./assets/js/app.js":
/*!**************************!*\
  !*** ./assets/js/app.js ***!
  \**************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! ../css/app.scss */ "./assets/css/app.scss");

__webpack_require__(/*! ../images/browser-icons/128-chrome.png */ "./assets/images/browser-icons/128-chrome.png");
__webpack_require__(/*! ../images/browser-icons/128-firefox.png */ "./assets/images/browser-icons/128-firefox.png");
__webpack_require__(/*! ../images/browser-icons/128-ie.png */ "./assets/images/browser-icons/128-ie.png");
__webpack_require__(/*! ../images/browser-icons/128-opera.png */ "./assets/images/browser-icons/128-opera.png");
__webpack_require__(/*! ../images/browser-icons/128-safari.png */ "./assets/images/browser-icons/128-safari.png");
__webpack_require__(/*! ../images/browser-icons/256-ie.png */ "./assets/images/browser-icons/256-ie.png");

__webpack_require__(/*! classlist-polyfill */ "./node_modules/classlist-polyfill/src/index.js");
var home = __webpack_require__(/*! ./home */ "./assets/js/home.js");
var Features = __webpack_require__(/*! ./features */ "./assets/js/features.js");
var DisplaySize = __webpack_require__(/*! ./display-size */ "./assets/js/display-size.js");

var onDomContentLoaded = function onDomContentLoaded() {
    if (document.body.classList.contains('home-index')) {
        home(document, 'scroll');
    }

    if (document.body.classList.contains('page-features')) {
        var displaySize = new DisplaySize(window);

        displaySize.set(displaySize.derive());

        var scrollOffsets = {
            'lg': 240,
            'md': 240,
            'sm': 160
        };

        var affixOffsets = {
            'lg': 60,
            'md': 60,
            'sm': 60
        };

        var scrollSpyOffset = 240;
        var features = new Features(document.getElementById('upper-nav'), document.getElementById('landing-strip'), scrollSpyOffset, scrollOffsets[displaySize.get()], affixOffsets[displaySize.get()]);

        window.addEventListener('resize', function () {
            displaySize.set(displaySize.derive());
            features.setScrollOffset(scrollOffsets[displaySize.get()]);
            features.setAffixOffset(affixOffsets[displaySize.get()]);
        }, true);
    }
};

document.addEventListener('DOMContentLoaded', onDomContentLoaded);

/***/ }),

/***/ "./assets/js/breakpoints.js":
/*!**********************************!*\
  !*** ./assets/js/breakpoints.js ***!
  \**********************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports) {

module.exports = {
    'xs': '(max-width: 768px)',
    'sm': '(min-width: 768px) and (max-width: 992px)',
    'md': '(min-width: 992px) and (max-width: 1200px)',
    'lg': '(min-width: 1200px)'
};

/***/ }),

/***/ "./assets/js/display-size.js":
/*!***********************************!*\
  !*** ./assets/js/display-size.js ***!
  \***********************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports, __webpack_require__) {

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

__webpack_require__(/*! matchmedia-polyfill */ "./node_modules/matchmedia-polyfill/matchMedia.js");
var breakpoints = __webpack_require__(/*! ./breakpoints */ "./assets/js/breakpoints.js");

var DisplaySize = function () {
    function DisplaySize(window) {
        _classCallCheck(this, DisplaySize);

        this.window = window;
    }

    _createClass(DisplaySize, [{
        key: 'derive',
        value: function derive() {
            var displaySizeName = 'xs';

            Object.keys(breakpoints).forEach(function (key) {
                var mediaQuery = breakpoints[key];

                if (window.matchMedia(mediaQuery).matches) {
                    displaySizeName = key;
                }
            });

            return displaySizeName;
        }
    }, {
        key: 'set',
        value: function set(sizeName) {
            this.window.document.body.dataset.displaySizeName = sizeName;
        }
    }, {
        key: 'get',
        value: function get() {
            return this.window.document.body.dataset.displaySizeName;
        }
    }]);

    return DisplaySize;
}();

module.exports = DisplaySize;

/***/ }),

/***/ "./assets/js/features-navbar-item.js":
/*!*******************************************!*\
  !*** ./assets/js/features-navbar-item.js ***!
  \*******************************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports, __webpack_require__) {

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var ScrollTo = __webpack_require__(/*! ./scroll-to */ "./assets/js/scroll-to.js");

var FeaturesNavBarItem = function () {
    /**
     * @param {HTMLElement} element
     * @param {number} scrollOffset
     */
    function FeaturesNavBarItem(element, scrollOffset) {
        _classCallCheck(this, FeaturesNavBarItem);

        this.element = element;
        this.scrollOffset = scrollOffset;

        var anchor = this.element.getElementsByTagName('a')[0];
        var href = anchor.getAttribute('href');

        this.targetId = href.replace('#', '');

        this.element.addEventListener('click', this.handleClick.bind(this));
    }

    _createClass(FeaturesNavBarItem, [{
        key: 'handleClick',
        value: function handleClick(event) {
            event.stopPropagation();
            event.preventDefault();

            var eventTargetValue = event.target.dataset.target;
            var target = this.getTarget();

            if (eventTargetValue) {
                target = document.getElementById(eventTargetValue.replace('#', ''));
            }

            ScrollTo.scrollTo(target, this.scrollOffset);
        }
    }, {
        key: 'getTarget',
        value: function getTarget() {
            return document.getElementById(this.targetId);
        }
    }, {
        key: 'isForTarget',
        value: function isForTarget(targetId) {
            return this.targetId === targetId;
        }
    }, {
        key: 'setActive',
        value: function setActive() {
            this.element.classList.add('active');
        }
    }, {
        key: 'setInactive',
        value: function setInactive() {
            this.element.classList.remove('active');
        }
    }, {
        key: 'setScrollOffset',
        value: function setScrollOffset(scrollOffset) {
            this.scrollOffset = scrollOffset;
        }
    }]);

    return FeaturesNavBarItem;
}();

module.exports = FeaturesNavBarItem;

/***/ }),

/***/ "./assets/js/features-navbar.js":
/*!**************************************!*\
  !*** ./assets/js/features-navbar.js ***!
  \**************************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports, __webpack_require__) {

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var NavBarItem = __webpack_require__(/*! ./features-navbar-item */ "./assets/js/features-navbar-item.js");

var FeaturesNavBar = function () {
    /**
     * @param {HTMLElement} navBarElement
     * @param {HTMLElement} landingStripElement
     * @param {number} scrollOffset
     * @param {number} affixOffset
     */
    function FeaturesNavBar(navBarElement, landingStripElement, scrollOffset, affixOffset) {
        _classCallCheck(this, FeaturesNavBar);

        this.navBarElement = navBarElement;
        this.landingStripElement = landingStripElement;
        this.affixOffset = affixOffset;
        this.navBarItems = [];

        var liElements = this.navBarElement.getElementsByTagName('li');

        for (var i = 0; i < liElements.length; i++) {
            this.navBarItems.push(new NavBarItem(liElements[i], scrollOffset));
        }

        window.addEventListener('scroll', this.affix.bind(this), true);
    }

    _createClass(FeaturesNavBar, [{
        key: 'affix',
        value: function affix() {
            var navBarBoundingRect = this.navBarElement.getBoundingClientRect();
            var navBarTop = navBarBoundingRect.top;
            var navBarBottom = navBarBoundingRect.bottom;

            if (navBarTop < this.affixOffset) {
                this.navBarElement.classList.add('affix');
            }

            var landingStripBoundingRect = this.landingStripElement.getBoundingClientRect();
            var landingStripBottom = landingStripBoundingRect.bottom;

            if (landingStripBottom > navBarBottom) {
                this.navBarElement.classList.remove('affix');
            }
        }
    }, {
        key: 'getLinkTargets',
        value: function getLinkTargets() {
            var linkTargets = [];

            for (var i = 0; i < this.navBarItems.length; i++) {
                linkTargets.push(this.navBarItems[i].getTarget());
            }

            return linkTargets;
        }
    }, {
        key: 'setActive',
        value: function setActive(linkTargetId) {
            for (var i = 0; i < this.navBarItems.length; i++) {
                var navBarItem = this.navBarItems[i];

                if (navBarItem.isForTarget(linkTargetId)) {
                    navBarItem.setActive();
                } else {
                    navBarItem.setInactive();
                }
            }
        }
    }, {
        key: 'setScrollOffset',
        value: function setScrollOffset(scrollOffset) {
            for (var i = 0; i < this.navBarItems.length; i++) {
                /** @type {FeaturesNavBarItem} */
                var navBarItem = this.navBarItems[i];

                navBarItem.setScrollOffset(scrollOffset);
            }
        }
    }, {
        key: 'setAffixOffset',
        value: function setAffixOffset(affixOffset) {
            this.affixOffset = affixOffset;
        }
    }]);

    return FeaturesNavBar;
}();

module.exports = FeaturesNavBar;

/***/ }),

/***/ "./assets/js/features-scrollspy.js":
/*!*****************************************!*\
  !*** ./assets/js/features-scrollspy.js ***!
  \*****************************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports) {

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var FeaturesScrollSpy = function () {
    /**
     * @param {FeaturesNavBar} navbar
     * @param {number} offset
     */
    function FeaturesScrollSpy(navbar, offset) {
        _classCallCheck(this, FeaturesScrollSpy);

        this.navbar = navbar;
        this.offset = offset;
    }

    _createClass(FeaturesScrollSpy, [{
        key: 'scrollEventListener',
        value: function scrollEventListener() {
            var activeLinkTarget = null;
            var linkTargets = this.navbar.getLinkTargets();
            var offset = this.offset;

            linkTargets.forEach(function (linkTarget, index) {
                if (!activeLinkTarget) {
                    var bottom = linkTarget.getBoundingClientRect().bottom;

                    if (bottom > offset || index === linkTargets.length - 1) {
                        activeLinkTarget = linkTarget;
                    }
                }
            });

            this.navbar.setActive(activeLinkTarget.getAttribute('id'));
        }
    }, {
        key: 'spy',
        value: function spy() {
            window.addEventListener('scroll', this.scrollEventListener.bind(this), true);
        }
    }]);

    return FeaturesScrollSpy;
}();

module.exports = FeaturesScrollSpy;

/***/ }),

/***/ "./assets/js/features.js":
/*!*******************************!*\
  !*** ./assets/js/features.js ***!
  \*******************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports, __webpack_require__) {

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var FeaturesNavBar = __webpack_require__(/*! ./features-navbar */ "./assets/js/features-navbar.js");
var FeaturesScrollSpy = __webpack_require__(/*! ./features-scrollspy */ "./assets/js/features-scrollspy.js");
var ScrollTo = __webpack_require__(/*! ./scroll-to */ "./assets/js/scroll-to.js");

var Features = function () {
    function Features(navBarElement, landingStripElement, scrollSpyOffset, scrollOffset, affixOffset) {
        _classCallCheck(this, Features);

        this.navbar = new FeaturesNavBar(navBarElement, landingStripElement, scrollOffset, affixOffset);
        this.scrollspy = new FeaturesScrollSpy(this.navbar, scrollSpyOffset);
        this.navbar.affix();
        this.scrollspy.spy();

        if (window.location.hash) {
            var target = document.getElementById(window.location.hash.replace('#', ''));

            if (target) {
                ScrollTo.scrollTo(target, scrollOffset);
            }
        }
    }

    _createClass(Features, [{
        key: 'setScrollOffset',
        value: function setScrollOffset(scrollOffset) {
            this.navbar.setScrollOffset(scrollOffset);
        }
    }, {
        key: 'setAffixOffset',
        value: function setAffixOffset(affixOffset) {
            this.navbar.setAffixOffset(affixOffset);
        }
    }]);

    return Features;
}();

module.exports = Features;

/***/ }),

/***/ "./assets/js/home.js":
/*!***************************!*\
  !*** ./assets/js/home.js ***!
  \***************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports) {

module.exports = function (document, eventName) {
    var initialOffset = 310;
    var landingStrip = document.getElementById('landing-strip');

    document.addEventListener(eventName, function () {
        var offset = Math.max(document.documentElement.scrollTop, document.body.scrollTop) / 4;
        var updated = offset * -1 - initialOffset;

        landingStrip.style.backgroundPositionY = updated + 'px';
    });
};

/***/ }),

/***/ "./assets/js/scroll-to.js":
/*!********************************!*\
  !*** ./assets/js/scroll-to.js ***!
  \********************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports, __webpack_require__) {

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var SmoothScroll = __webpack_require__(/*! smooth-scroll */ "./node_modules/smooth-scroll/dist/js/smooth-scroll.min.js");

var ScrollTo = function () {
    function ScrollTo() {
        _classCallCheck(this, ScrollTo);
    }

    _createClass(ScrollTo, null, [{
        key: 'scrollTo',
        value: function scrollTo(target, offset) {
            var scroll = new SmoothScroll();

            scroll.animateScroll(target.offsetTop + offset);

            if (window.history.pushState) {
                window.history.pushState(null, null, '#' + target.getAttribute('id'));
            }
        }
    }]);

    return ScrollTo;
}();

module.exports = ScrollTo;

/***/ }),

/***/ "./node_modules/classlist-polyfill/src/index.js":
/*!******************************************************!*\
  !*** ./node_modules/classlist-polyfill/src/index.js ***!
  \******************************************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports) {

/*
 * classList.js: Cross-browser full element.classList implementation.
 * 1.1.20170427
 *
 * By Eli Grey, http://eligrey.com
 * License: Dedicated to the public domain.
 *   See https://github.com/eligrey/classList.js/blob/master/LICENSE.md
 */

/*global self, document, DOMException */

/*! @source http://purl.eligrey.com/github/classList.js/blob/master/classList.js */

if ("document" in window.self) {

// Full polyfill for browsers with no classList support
// Including IE < Edge missing SVGElement.classList
if (!("classList" in document.createElement("_")) 
	|| document.createElementNS && !("classList" in document.createElementNS("http://www.w3.org/2000/svg","g"))) {

(function (view) {

"use strict";

if (!('Element' in view)) return;

var
	  classListProp = "classList"
	, protoProp = "prototype"
	, elemCtrProto = view.Element[protoProp]
	, objCtr = Object
	, strTrim = String[protoProp].trim || function () {
		return this.replace(/^\s+|\s+$/g, "");
	}
	, arrIndexOf = Array[protoProp].indexOf || function (item) {
		var
			  i = 0
			, len = this.length
		;
		for (; i < len; i++) {
			if (i in this && this[i] === item) {
				return i;
			}
		}
		return -1;
	}
	// Vendors: please allow content code to instantiate DOMExceptions
	, DOMEx = function (type, message) {
		this.name = type;
		this.code = DOMException[type];
		this.message = message;
	}
	, checkTokenAndGetIndex = function (classList, token) {
		if (token === "") {
			throw new DOMEx(
				  "SYNTAX_ERR"
				, "An invalid or illegal string was specified"
			);
		}
		if (/\s/.test(token)) {
			throw new DOMEx(
				  "INVALID_CHARACTER_ERR"
				, "String contains an invalid character"
			);
		}
		return arrIndexOf.call(classList, token);
	}
	, ClassList = function (elem) {
		var
			  trimmedClasses = strTrim.call(elem.getAttribute("class") || "")
			, classes = trimmedClasses ? trimmedClasses.split(/\s+/) : []
			, i = 0
			, len = classes.length
		;
		for (; i < len; i++) {
			this.push(classes[i]);
		}
		this._updateClassName = function () {
			elem.setAttribute("class", this.toString());
		};
	}
	, classListProto = ClassList[protoProp] = []
	, classListGetter = function () {
		return new ClassList(this);
	}
;
// Most DOMException implementations don't allow calling DOMException's toString()
// on non-DOMExceptions. Error's toString() is sufficient here.
DOMEx[protoProp] = Error[protoProp];
classListProto.item = function (i) {
	return this[i] || null;
};
classListProto.contains = function (token) {
	token += "";
	return checkTokenAndGetIndex(this, token) !== -1;
};
classListProto.add = function () {
	var
		  tokens = arguments
		, i = 0
		, l = tokens.length
		, token
		, updated = false
	;
	do {
		token = tokens[i] + "";
		if (checkTokenAndGetIndex(this, token) === -1) {
			this.push(token);
			updated = true;
		}
	}
	while (++i < l);

	if (updated) {
		this._updateClassName();
	}
};
classListProto.remove = function () {
	var
		  tokens = arguments
		, i = 0
		, l = tokens.length
		, token
		, updated = false
		, index
	;
	do {
		token = tokens[i] + "";
		index = checkTokenAndGetIndex(this, token);
		while (index !== -1) {
			this.splice(index, 1);
			updated = true;
			index = checkTokenAndGetIndex(this, token);
		}
	}
	while (++i < l);

	if (updated) {
		this._updateClassName();
	}
};
classListProto.toggle = function (token, force) {
	token += "";

	var
		  result = this.contains(token)
		, method = result ?
			force !== true && "remove"
		:
			force !== false && "add"
	;

	if (method) {
		this[method](token);
	}

	if (force === true || force === false) {
		return force;
	} else {
		return !result;
	}
};
classListProto.toString = function () {
	return this.join(" ");
};

if (objCtr.defineProperty) {
	var classListPropDesc = {
		  get: classListGetter
		, enumerable: true
		, configurable: true
	};
	try {
		objCtr.defineProperty(elemCtrProto, classListProp, classListPropDesc);
	} catch (ex) { // IE 8 doesn't support enumerable:true
		// adding undefined to fight this issue https://github.com/eligrey/classList.js/issues/36
		// modernie IE8-MSW7 machine has IE8 8.0.6001.18702 and is affected
		if (ex.number === undefined || ex.number === -0x7FF5EC54) {
			classListPropDesc.enumerable = false;
			objCtr.defineProperty(elemCtrProto, classListProp, classListPropDesc);
		}
	}
} else if (objCtr[protoProp].__defineGetter__) {
	elemCtrProto.__defineGetter__(classListProp, classListGetter);
}

}(window.self));

}

// There is full or partial native classList support, so just check if we need
// to normalize the add/remove and toggle APIs.

(function () {
	"use strict";

	var testElement = document.createElement("_");

	testElement.classList.add("c1", "c2");

	// Polyfill for IE 10/11 and Firefox <26, where classList.add and
	// classList.remove exist but support only one argument at a time.
	if (!testElement.classList.contains("c2")) {
		var createMethod = function(method) {
			var original = DOMTokenList.prototype[method];

			DOMTokenList.prototype[method] = function(token) {
				var i, len = arguments.length;

				for (i = 0; i < len; i++) {
					token = arguments[i];
					original.call(this, token);
				}
			};
		};
		createMethod('add');
		createMethod('remove');
	}

	testElement.classList.toggle("c3", false);

	// Polyfill for IE 10 and Firefox <24, where classList.toggle does not
	// support the second argument.
	if (testElement.classList.contains("c3")) {
		var _toggle = DOMTokenList.prototype.toggle;

		DOMTokenList.prototype.toggle = function(token, force) {
			if (1 in arguments && !this.contains(token) === !force) {
				return force;
			} else {
				return _toggle.call(this, token);
			}
		};

	}

	testElement = null;
}());

}


/***/ }),

/***/ "./node_modules/matchmedia-polyfill/matchMedia.js":
/*!********************************************************!*\
  !*** ./node_modules/matchmedia-polyfill/matchMedia.js ***!
  \********************************************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports) {

/*! matchMedia() polyfill - Test a CSS media type/query in JS. Authors & copyright (c) 2012: Scott Jehl, Paul Irish, Nicholas Zakas, David Knight. Dual MIT/BSD license */

window.matchMedia || (window.matchMedia = function() {
    "use strict";

    // For browsers that support matchMedium api such as IE 9 and webkit
    var styleMedia = (window.styleMedia || window.media);

    // For those that don't support matchMedium
    if (!styleMedia) {
        var style       = document.createElement('style'),
            script      = document.getElementsByTagName('script')[0],
            info        = null;

        style.type  = 'text/css';
        style.id    = 'matchmediajs-test';

        script.parentNode.insertBefore(style, script);

        // 'style.currentStyle' is used by IE <= 8 and 'window.getComputedStyle' for all other browsers
        info = ('getComputedStyle' in window) && window.getComputedStyle(style, null) || style.currentStyle;

        styleMedia = {
            matchMedium: function(media) {
                var text = '@media ' + media + '{ #matchmediajs-test { width: 1px; } }';

                // 'style.styleSheet' is used by IE <= 8 and 'style.textContent' for all other browsers
                if (style.styleSheet) {
                    style.styleSheet.cssText = text;
                } else {
                    style.textContent = text;
                }

                // Test if media query is true or false
                return info.width === '1px';
            }
        };
    }

    return function(media) {
        return {
            matches: styleMedia.matchMedium(media || 'all'),
            media: media || 'all'
        };
    };
}());


/***/ }),

/***/ "./node_modules/smooth-scroll/dist/js/smooth-scroll.min.js":
/*!*****************************************************************!*\
  !*** ./node_modules/smooth-scroll/dist/js/smooth-scroll.min.js ***!
  \*****************************************************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global) {var __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*! smooth-scroll v12.1.5 | (c) 2017 Chris Ferdinandi | MIT License | http://github.com/cferdinandi/smooth-scroll */
!(function(e,t){ true?!(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_RESULT__ = (function(){return t(e)}).apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__)):"object"==typeof exports?module.exports=t(e):e.SmoothScroll=t(e)})("undefined"!=typeof global?global:"undefined"!=typeof window?window:this,(function(e){"use strict";var t="querySelector"in document&&"addEventListener"in e&&"requestAnimationFrame"in e&&"closest"in e.Element.prototype,n={ignore:"[data-scroll-ignore]",header:null,speed:500,offset:0,easing:"easeInOutCubic",customEasing:null,before:function(){},after:function(){}},o=function(){for(var e={},t=0,n=arguments.length;t<n;t++){var o=arguments[t];!(function(t){for(var n in t)t.hasOwnProperty(n)&&(e[n]=t[n])})(o)}return e},a=function(t){return parseInt(e.getComputedStyle(t).height,10)},r=function(e){"#"===e.charAt(0)&&(e=e.substr(1));for(var t,n=String(e),o=n.length,a=-1,r="",i=n.charCodeAt(0);++a<o;){if(0===(t=n.charCodeAt(a)))throw new InvalidCharacterError("Invalid character: the input contains U+0000.");t>=1&&t<=31||127==t||0===a&&t>=48&&t<=57||1===a&&t>=48&&t<=57&&45===i?r+="\\"+t.toString(16)+" ":r+=t>=128||45===t||95===t||t>=48&&t<=57||t>=65&&t<=90||t>=97&&t<=122?n.charAt(a):"\\"+n.charAt(a)}return"#"+r},i=function(e,t){var n;return"easeInQuad"===e.easing&&(n=t*t),"easeOutQuad"===e.easing&&(n=t*(2-t)),"easeInOutQuad"===e.easing&&(n=t<.5?2*t*t:(4-2*t)*t-1),"easeInCubic"===e.easing&&(n=t*t*t),"easeOutCubic"===e.easing&&(n=--t*t*t+1),"easeInOutCubic"===e.easing&&(n=t<.5?4*t*t*t:(t-1)*(2*t-2)*(2*t-2)+1),"easeInQuart"===e.easing&&(n=t*t*t*t),"easeOutQuart"===e.easing&&(n=1- --t*t*t*t),"easeInOutQuart"===e.easing&&(n=t<.5?8*t*t*t*t:1-8*--t*t*t*t),"easeInQuint"===e.easing&&(n=t*t*t*t*t),"easeOutQuint"===e.easing&&(n=1+--t*t*t*t*t),"easeInOutQuint"===e.easing&&(n=t<.5?16*t*t*t*t*t:1+16*--t*t*t*t*t),e.customEasing&&(n=e.customEasing(t)),n||t},u=function(){return Math.max(document.body.scrollHeight,document.documentElement.scrollHeight,document.body.offsetHeight,document.documentElement.offsetHeight,document.body.clientHeight,document.documentElement.clientHeight)},c=function(e,t,n){var o=0;if(e.offsetParent)do{o+=e.offsetTop,e=e.offsetParent}while(e);return o=Math.max(o-t-n,0)},s=function(e){return e?a(e)+e.offsetTop:0},l=function(t,n,o){o||(t.focus(),document.activeElement.id!==t.id&&(t.setAttribute("tabindex","-1"),t.focus(),t.style.outline="none"),e.scrollTo(0,n))},f=function(t){return!!("matchMedia"in e&&e.matchMedia("(prefers-reduced-motion)").matches)};return function(a,d){var m,h,g,p,v,b,y,S={};S.cancelScroll=function(){cancelAnimationFrame(y)},S.animateScroll=function(t,a,r){var f=o(m||n,r||{}),d="[object Number]"===Object.prototype.toString.call(t),h=d||!t.tagName?null:t;if(d||h){var g=e.pageYOffset;f.header&&!p&&(p=document.querySelector(f.header)),v||(v=s(p));var b,y,E,I=d?t:c(h,v,parseInt("function"==typeof f.offset?f.offset():f.offset,10)),O=I-g,A=u(),C=0,w=function(n,o){var r=e.pageYOffset;if(n==o||r==o||(g<o&&e.innerHeight+r)>=A)return S.cancelScroll(),l(t,o,d),f.after(t,a),b=null,!0},Q=function(t){b||(b=t),C+=t-b,y=C/parseInt(f.speed,10),y=y>1?1:y,E=g+O*i(f,y),e.scrollTo(0,Math.floor(E)),w(E,I)||(e.requestAnimationFrame(Q),b=t)};0===e.pageYOffset&&e.scrollTo(0,0),f.before(t,a),S.cancelScroll(),e.requestAnimationFrame(Q)}};var E=function(e){h&&(h.id=h.getAttribute("data-scroll-id"),S.animateScroll(h,g),h=null,g=null)},I=function(t){if(!f()&&0===t.button&&!t.metaKey&&!t.ctrlKey&&(g=t.target.closest(a))&&"a"===g.tagName.toLowerCase()&&!t.target.closest(m.ignore)&&g.hostname===e.location.hostname&&g.pathname===e.location.pathname&&/#/.test(g.href)){var n;try{n=r(decodeURIComponent(g.hash))}catch(e){n=r(g.hash)}if("#"===n){t.preventDefault(),h=document.body;var o=h.id?h.id:"smooth-scroll-top";return h.setAttribute("data-scroll-id",o),h.id="",void(e.location.hash.substring(1)===o?E():e.location.hash=o)}h=document.querySelector(n),h&&(h.setAttribute("data-scroll-id",h.id),h.id="",g.hash===e.location.hash&&(t.preventDefault(),E()))}},O=function(e){b||(b=setTimeout((function(){b=null,v=s(p)}),66))};return S.destroy=function(){m&&(document.removeEventListener("click",I,!1),e.removeEventListener("resize",O,!1),S.cancelScroll(),m=null,h=null,g=null,p=null,v=null,b=null,y=null)},S.init=function(a){t&&(S.destroy(),m=o(n,a||{}),p=m.header?document.querySelector(m.header):null,v=s(p),document.addEventListener("click",I,!1),e.addEventListener("hashchange",E,!1),p&&e.addEventListener("resize",O,!1))},S.init(d),S}}));
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(/*! ./../../../webpack/buildin/global.js */ "./node_modules/webpack/buildin/global.js")))

/***/ }),

/***/ "./node_modules/webpack/buildin/global.js":
/*!***********************************!*\
  !*** (webpack)/buildin/global.js ***!
  \***********************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports) {

var g;

// This works in non-strict mode
g = (function() {
	return this;
})();

try {
	// This works if eval is allowed (see CSP)
	g = g || Function("return this")() || (1,eval)("this");
} catch(e) {
	// This works if the window reference is available
	if(typeof window === "object")
		g = window;
}

// g can still be undefined, but nothing to do about it...
// We return undefined, instead of nothing here, so it's
// easier to handle this case. if(!global) { ...}

module.exports = g;


/***/ })

/******/ });
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAgZDczYjEwZDVlMTBlMGQ5Yjk4NGMiLCJ3ZWJwYWNrOi8vLy4vYXNzZXRzL2Nzcy9hcHAuc2Nzcz80ZmIwIiwid2VicGFjazovLy8uL2Fzc2V0cy9pbWFnZXMvYnJvd3Nlci1pY29ucy8xMjgtY2hyb21lLnBuZyIsIndlYnBhY2s6Ly8vLi9hc3NldHMvaW1hZ2VzL2Jyb3dzZXItaWNvbnMvMTI4LWZpcmVmb3gucG5nIiwid2VicGFjazovLy8uL2Fzc2V0cy9pbWFnZXMvYnJvd3Nlci1pY29ucy8xMjgtaWUucG5nIiwid2VicGFjazovLy8uL2Fzc2V0cy9pbWFnZXMvYnJvd3Nlci1pY29ucy8xMjgtb3BlcmEucG5nIiwid2VicGFjazovLy8uL2Fzc2V0cy9pbWFnZXMvYnJvd3Nlci1pY29ucy8xMjgtc2FmYXJpLnBuZyIsIndlYnBhY2s6Ly8vLi9hc3NldHMvaW1hZ2VzL2Jyb3dzZXItaWNvbnMvMjU2LWllLnBuZyIsIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvYXBwLmpzIiwid2VicGFjazovLy8uL2Fzc2V0cy9qcy9icmVha3BvaW50cy5qcyIsIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvZGlzcGxheS1zaXplLmpzIiwid2VicGFjazovLy8uL2Fzc2V0cy9qcy9mZWF0dXJlcy1uYXZiYXItaXRlbS5qcyIsIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvZmVhdHVyZXMtbmF2YmFyLmpzIiwid2VicGFjazovLy8uL2Fzc2V0cy9qcy9mZWF0dXJlcy1zY3JvbGxzcHkuanMiLCJ3ZWJwYWNrOi8vLy4vYXNzZXRzL2pzL2ZlYXR1cmVzLmpzIiwid2VicGFjazovLy8uL2Fzc2V0cy9qcy9ob21lLmpzIiwid2VicGFjazovLy8uL2Fzc2V0cy9qcy9zY3JvbGwtdG8uanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2NsYXNzbGlzdC1wb2x5ZmlsbC9zcmMvaW5kZXguanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL21hdGNobWVkaWEtcG9seWZpbGwvbWF0Y2hNZWRpYS5qcyIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvc21vb3RoLXNjcm9sbC9kaXN0L2pzL3Ntb290aC1zY3JvbGwubWluLmpzIiwid2VicGFjazovLy8od2VicGFjaykvYnVpbGRpbi9nbG9iYWwuanMiXSwibmFtZXMiOlsicmVxdWlyZSIsImhvbWUiLCJGZWF0dXJlcyIsIkRpc3BsYXlTaXplIiwib25Eb21Db250ZW50TG9hZGVkIiwiZG9jdW1lbnQiLCJib2R5IiwiY2xhc3NMaXN0IiwiY29udGFpbnMiLCJkaXNwbGF5U2l6ZSIsIndpbmRvdyIsInNldCIsImRlcml2ZSIsInNjcm9sbE9mZnNldHMiLCJhZmZpeE9mZnNldHMiLCJzY3JvbGxTcHlPZmZzZXQiLCJmZWF0dXJlcyIsImdldEVsZW1lbnRCeUlkIiwiZ2V0IiwiYWRkRXZlbnRMaXN0ZW5lciIsInNldFNjcm9sbE9mZnNldCIsInNldEFmZml4T2Zmc2V0IiwibW9kdWxlIiwiZXhwb3J0cyIsImJyZWFrcG9pbnRzIiwiZGlzcGxheVNpemVOYW1lIiwiT2JqZWN0Iiwia2V5cyIsImZvckVhY2giLCJrZXkiLCJtZWRpYVF1ZXJ5IiwibWF0Y2hNZWRpYSIsIm1hdGNoZXMiLCJzaXplTmFtZSIsImRhdGFzZXQiLCJTY3JvbGxUbyIsIkZlYXR1cmVzTmF2QmFySXRlbSIsImVsZW1lbnQiLCJzY3JvbGxPZmZzZXQiLCJhbmNob3IiLCJnZXRFbGVtZW50c0J5VGFnTmFtZSIsImhyZWYiLCJnZXRBdHRyaWJ1dGUiLCJ0YXJnZXRJZCIsInJlcGxhY2UiLCJoYW5kbGVDbGljayIsImJpbmQiLCJldmVudCIsInN0b3BQcm9wYWdhdGlvbiIsInByZXZlbnREZWZhdWx0IiwiZXZlbnRUYXJnZXRWYWx1ZSIsInRhcmdldCIsImdldFRhcmdldCIsInNjcm9sbFRvIiwiYWRkIiwicmVtb3ZlIiwiTmF2QmFySXRlbSIsIkZlYXR1cmVzTmF2QmFyIiwibmF2QmFyRWxlbWVudCIsImxhbmRpbmdTdHJpcEVsZW1lbnQiLCJhZmZpeE9mZnNldCIsIm5hdkJhckl0ZW1zIiwibGlFbGVtZW50cyIsImkiLCJsZW5ndGgiLCJwdXNoIiwiYWZmaXgiLCJuYXZCYXJCb3VuZGluZ1JlY3QiLCJnZXRCb3VuZGluZ0NsaWVudFJlY3QiLCJuYXZCYXJUb3AiLCJ0b3AiLCJuYXZCYXJCb3R0b20iLCJib3R0b20iLCJsYW5kaW5nU3RyaXBCb3VuZGluZ1JlY3QiLCJsYW5kaW5nU3RyaXBCb3R0b20iLCJsaW5rVGFyZ2V0cyIsImxpbmtUYXJnZXRJZCIsIm5hdkJhckl0ZW0iLCJpc0ZvclRhcmdldCIsInNldEFjdGl2ZSIsInNldEluYWN0aXZlIiwiRmVhdHVyZXNTY3JvbGxTcHkiLCJuYXZiYXIiLCJvZmZzZXQiLCJhY3RpdmVMaW5rVGFyZ2V0IiwiZ2V0TGlua1RhcmdldHMiLCJsaW5rVGFyZ2V0IiwiaW5kZXgiLCJzY3JvbGxFdmVudExpc3RlbmVyIiwic2Nyb2xsc3B5Iiwic3B5IiwibG9jYXRpb24iLCJoYXNoIiwiZXZlbnROYW1lIiwiaW5pdGlhbE9mZnNldCIsImxhbmRpbmdTdHJpcCIsIk1hdGgiLCJtYXgiLCJkb2N1bWVudEVsZW1lbnQiLCJzY3JvbGxUb3AiLCJ1cGRhdGVkIiwic3R5bGUiLCJiYWNrZ3JvdW5kUG9zaXRpb25ZIiwiU21vb3RoU2Nyb2xsIiwic2Nyb2xsIiwiYW5pbWF0ZVNjcm9sbCIsIm9mZnNldFRvcCIsImhpc3RvcnkiLCJwdXNoU3RhdGUiXSwibWFwcGluZ3MiOiI7QUFBQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7O0FBR0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsYUFBSztBQUNMO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0EsbUNBQTJCLDBCQUEwQixFQUFFO0FBQ3ZELHlD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QWUsaURBQWlELGVBQWUsbUNBQW1DLDZEQUE2RCxNQUFNLEVBQUUsNEdBQTRHLG1NQUFtTSxZQUFZLGlCQUFpQixNQUFNLDJtQkFBMm1CLGNBQWMsb05BQW9OLG1CQUFtQixRQUFRLHFCQUFxQixnQ0FBZ0MsU0FBUywyQkFBMkIsZUFBZSw0QkFBNEIsbUJBQW1CLG9JQUFvSSxlQUFlLDhFQUE4RSxxQkFBcUIsdUJBQXVCLDBCQUEwQix3QkFBd0IsaUNBQWlDLGtCQUFrQixpRkFBaUYsU0FBUyxvQkFBb0IsK0RBQStELG9IQUFvSCxvQkFBb0IsaUdBQWlHLGVBQWUsc0lBQXNJLCtGQUErRixrQkFBa0IsOEVBQThFLGVBQWUsME5BQTBOLE1BQU0sSUFBSSxnQ0FBZ0MsU0FBUyxZQUFZLFlBQVksbUNBQW1DLG9DQUFvQywrR0FBK0csbUlBQW1JLGVBQWUsNkJBQTZCLGNBQWMsUUFBUSw0QkFBNEIsdUpBQXVKLG9CQUFvQiwyQkFBMkIsOEtBQThLLGNBQWMsRzs7Ozs7Ozs7Ozs7OztBQ0RwMUk7O0FBRUE7QUFDQTtBQUNBO0FBQ0EsQ0FBQzs7QUFFRDtBQUNBO0FBQ0E7QUFDQSxDQUFDO0FBQ0Q7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBLDRDQUE0Qzs7QUFFNUMiLCJmaWxlIjoiYXBwLjAyMzY4NjE2NTc1NDMwMGY4YjU0LmpzIiwic291cmNlc0NvbnRlbnQiOlsiIFx0Ly8gVGhlIG1vZHVsZSBjYWNoZVxuIFx0dmFyIGluc3RhbGxlZE1vZHVsZXMgPSB7fTtcblxuIFx0Ly8gVGhlIHJlcXVpcmUgZnVuY3Rpb25cbiBcdGZ1bmN0aW9uIF9fd2VicGFja19yZXF1aXJlX18obW9kdWxlSWQpIHtcblxuIFx0XHQvLyBDaGVjayBpZiBtb2R1bGUgaXMgaW4gY2FjaGVcbiBcdFx0aWYoaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0pIHtcbiBcdFx0XHRyZXR1cm4gaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0uZXhwb3J0cztcbiBcdFx0fVxuIFx0XHQvLyBDcmVhdGUgYSBuZXcgbW9kdWxlIChhbmQgcHV0IGl0IGludG8gdGhlIGNhY2hlKVxuIFx0XHR2YXIgbW9kdWxlID0gaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0gPSB7XG4gXHRcdFx0aTogbW9kdWxlSWQsXG4gXHRcdFx0bDogZmFsc2UsXG4gXHRcdFx0ZXhwb3J0czoge31cbiBcdFx0fTtcblxuIFx0XHQvLyBFeGVjdXRlIHRoZSBtb2R1bGUgZnVuY3Rpb25cbiBcdFx0bW9kdWxlc1ttb2R1bGVJZF0uY2FsbChtb2R1bGUuZXhwb3J0cywgbW9kdWxlLCBtb2R1bGUuZXhwb3J0cywgX193ZWJwYWNrX3JlcXVpcmVfXyk7XG5cbiBcdFx0Ly8gRmxhZyB0aGUgbW9kdWxlIGFzIGxvYWRlZFxuIFx0XHRtb2R1bGUubCA9IHRydWU7XG5cbiBcdFx0Ly8gUmV0dXJuIHRoZSBleHBvcnRzIG9mIHRoZSBtb2R1bGVcbiBcdFx0cmV0dXJuIG1vZHVsZS5leHBvcnRzO1xuIFx0fVxuXG5cbiBcdC8vIGV4cG9zZSB0aGUgbW9kdWxlcyBvYmplY3QgKF9fd2VicGFja19tb2R1bGVzX18pXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm0gPSBtb2R1bGVzO1xuXG4gXHQvLyBleHBvc2UgdGhlIG1vZHVsZSBjYWNoZVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5jID0gaW5zdGFsbGVkTW9kdWxlcztcblxuIFx0Ly8gZGVmaW5lIGdldHRlciBmdW5jdGlvbiBmb3IgaGFybW9ueSBleHBvcnRzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLmQgPSBmdW5jdGlvbihleHBvcnRzLCBuYW1lLCBnZXR0ZXIpIHtcbiBcdFx0aWYoIV9fd2VicGFja19yZXF1aXJlX18ubyhleHBvcnRzLCBuYW1lKSkge1xuIFx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBuYW1lLCB7XG4gXHRcdFx0XHRjb25maWd1cmFibGU6IGZhbHNlLFxuIFx0XHRcdFx0ZW51bWVyYWJsZTogdHJ1ZSxcbiBcdFx0XHRcdGdldDogZ2V0dGVyXG4gXHRcdFx0fSk7XG4gXHRcdH1cbiBcdH07XG5cbiBcdC8vIGdldERlZmF1bHRFeHBvcnQgZnVuY3Rpb24gZm9yIGNvbXBhdGliaWxpdHkgd2l0aCBub24taGFybW9ueSBtb2R1bGVzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm4gPSBmdW5jdGlvbihtb2R1bGUpIHtcbiBcdFx0dmFyIGdldHRlciA9IG1vZHVsZSAmJiBtb2R1bGUuX19lc01vZHVsZSA/XG4gXHRcdFx0ZnVuY3Rpb24gZ2V0RGVmYXVsdCgpIHsgcmV0dXJuIG1vZHVsZVsnZGVmYXVsdCddOyB9IDpcbiBcdFx0XHRmdW5jdGlvbiBnZXRNb2R1bGVFeHBvcnRzKCkgeyByZXR1cm4gbW9kdWxlOyB9O1xuIFx0XHRfX3dlYnBhY2tfcmVxdWlyZV9fLmQoZ2V0dGVyLCAnYScsIGdldHRlcik7XG4gXHRcdHJldHVybiBnZXR0ZXI7XG4gXHR9O1xuXG4gXHQvLyBPYmplY3QucHJvdG90eXBlLmhhc093blByb3BlcnR5LmNhbGxcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubyA9IGZ1bmN0aW9uKG9iamVjdCwgcHJvcGVydHkpIHsgcmV0dXJuIE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbChvYmplY3QsIHByb3BlcnR5KTsgfTtcblxuIFx0Ly8gX193ZWJwYWNrX3B1YmxpY19wYXRoX19cbiBcdF9fd2VicGFja19yZXF1aXJlX18ucCA9IFwiL2J1aWxkL1wiO1xuXG4gXHQvLyBMb2FkIGVudHJ5IG1vZHVsZSBhbmQgcmV0dXJuIGV4cG9ydHNcbiBcdHJldHVybiBfX3dlYnBhY2tfcmVxdWlyZV9fKF9fd2VicGFja19yZXF1aXJlX18ucyA9IFwiLi9hc3NldHMvanMvYXBwLmpzXCIpO1xuXG5cblxuLy8gV0VCUEFDSyBGT09URVIgLy9cbi8vIHdlYnBhY2svYm9vdHN0cmFwIGQ3M2IxMGQ1ZTEwZTBkOWI5ODRjIiwiLy8gcmVtb3ZlZCBieSBleHRyYWN0LXRleHQtd2VicGFjay1wbHVnaW5cblxuXG4vLy8vLy8vLy8vLy8vLy8vLy9cbi8vIFdFQlBBQ0sgRk9PVEVSXG4vLyAuL2Fzc2V0cy9jc3MvYXBwLnNjc3Ncbi8vIG1vZHVsZSBpZCA9IC4vYXNzZXRzL2Nzcy9hcHAuc2Nzc1xuLy8gbW9kdWxlIGNodW5rcyA9IDAiLCJtb2R1bGUuZXhwb3J0cyA9IFwiL2J1aWxkL2ltYWdlcy8xMjgtY2hyb21lLjgzOTljMmRmLnBuZ1wiO1xuXG5cbi8vLy8vLy8vLy8vLy8vLy8vL1xuLy8gV0VCUEFDSyBGT09URVJcbi8vIC4vYXNzZXRzL2ltYWdlcy9icm93c2VyLWljb25zLzEyOC1jaHJvbWUucG5nXG4vLyBtb2R1bGUgaWQgPSAuL2Fzc2V0cy9pbWFnZXMvYnJvd3Nlci1pY29ucy8xMjgtY2hyb21lLnBuZ1xuLy8gbW9kdWxlIGNodW5rcyA9IDAiLCJtb2R1bGUuZXhwb3J0cyA9IFwiL2J1aWxkL2ltYWdlcy8xMjgtZmlyZWZveC5lY2QxN2QxZi5wbmdcIjtcblxuXG4vLy8vLy8vLy8vLy8vLy8vLy9cbi8vIFdFQlBBQ0sgRk9PVEVSXG4vLyAuL2Fzc2V0cy9pbWFnZXMvYnJvd3Nlci1pY29ucy8xMjgtZmlyZWZveC5wbmdcbi8vIG1vZHVsZSBpZCA9IC4vYXNzZXRzL2ltYWdlcy9icm93c2VyLWljb25zLzEyOC1maXJlZm94LnBuZ1xuLy8gbW9kdWxlIGNodW5rcyA9IDAiLCJtb2R1bGUuZXhwb3J0cyA9IFwiL2J1aWxkL2ltYWdlcy8xMjgtaWUuZDM2YmY2NzUucG5nXCI7XG5cblxuLy8vLy8vLy8vLy8vLy8vLy8vXG4vLyBXRUJQQUNLIEZPT1RFUlxuLy8gLi9hc3NldHMvaW1hZ2VzL2Jyb3dzZXItaWNvbnMvMTI4LWllLnBuZ1xuLy8gbW9kdWxlIGlkID0gLi9hc3NldHMvaW1hZ2VzL2Jyb3dzZXItaWNvbnMvMTI4LWllLnBuZ1xuLy8gbW9kdWxlIGNodW5rcyA9IDAiLCJtb2R1bGUuZXhwb3J0cyA9IFwiL2J1aWxkL2ltYWdlcy8xMjgtb3BlcmEuZTg2YWU3YTIucG5nXCI7XG5cblxuLy8vLy8vLy8vLy8vLy8vLy8vXG4vLyBXRUJQQUNLIEZPT1RFUlxuLy8gLi9hc3NldHMvaW1hZ2VzL2Jyb3dzZXItaWNvbnMvMTI4LW9wZXJhLnBuZ1xuLy8gbW9kdWxlIGlkID0gLi9hc3NldHMvaW1hZ2VzL2Jyb3dzZXItaWNvbnMvMTI4LW9wZXJhLnBuZ1xuLy8gbW9kdWxlIGNodW5rcyA9IDAiLCJtb2R1bGUuZXhwb3J0cyA9IFwiL2J1aWxkL2ltYWdlcy8xMjgtc2FmYXJpLjhlOTc3ZjZjLnBuZ1wiO1xuXG5cbi8vLy8vLy8vLy8vLy8vLy8vL1xuLy8gV0VCUEFDSyBGT09URVJcbi8vIC4vYXNzZXRzL2ltYWdlcy9icm93c2VyLWljb25zLzEyOC1zYWZhcmkucG5nXG4vLyBtb2R1bGUgaWQgPSAuL2Fzc2V0cy9pbWFnZXMvYnJvd3Nlci1pY29ucy8xMjgtc2FmYXJpLnBuZ1xuLy8gbW9kdWxlIGNodW5rcyA9IDAiLCJtb2R1bGUuZXhwb3J0cyA9IFwiL2J1aWxkL2ltYWdlcy8yNTYtaWUuYWYyZDA4ZDMucG5nXCI7XG5cblxuLy8vLy8vLy8vLy8vLy8vLy8vXG4vLyBXRUJQQUNLIEZPT1RFUlxuLy8gLi9hc3NldHMvaW1hZ2VzL2Jyb3dzZXItaWNvbnMvMjU2LWllLnBuZ1xuLy8gbW9kdWxlIGlkID0gLi9hc3NldHMvaW1hZ2VzL2Jyb3dzZXItaWNvbnMvMjU2LWllLnBuZ1xuLy8gbW9kdWxlIGNodW5rcyA9IDAiLCJyZXF1aXJlKCcuLi9jc3MvYXBwLnNjc3MnKTtcblxucmVxdWlyZSgnLi4vaW1hZ2VzL2Jyb3dzZXItaWNvbnMvMTI4LWNocm9tZS5wbmcnKTtcbnJlcXVpcmUoJy4uL2ltYWdlcy9icm93c2VyLWljb25zLzEyOC1maXJlZm94LnBuZycpO1xucmVxdWlyZSgnLi4vaW1hZ2VzL2Jyb3dzZXItaWNvbnMvMTI4LWllLnBuZycpO1xucmVxdWlyZSgnLi4vaW1hZ2VzL2Jyb3dzZXItaWNvbnMvMTI4LW9wZXJhLnBuZycpO1xucmVxdWlyZSgnLi4vaW1hZ2VzL2Jyb3dzZXItaWNvbnMvMTI4LXNhZmFyaS5wbmcnKTtcbnJlcXVpcmUoJy4uL2ltYWdlcy9icm93c2VyLWljb25zLzI1Ni1pZS5wbmcnKTtcblxucmVxdWlyZSgnY2xhc3NsaXN0LXBvbHlmaWxsJyk7XG5sZXQgaG9tZSA9IHJlcXVpcmUoJy4vaG9tZScpO1xubGV0IEZlYXR1cmVzID0gcmVxdWlyZSgnLi9mZWF0dXJlcycpO1xubGV0IERpc3BsYXlTaXplID0gcmVxdWlyZSgnLi9kaXNwbGF5LXNpemUnKTtcblxuY29uc3Qgb25Eb21Db250ZW50TG9hZGVkID0gZnVuY3Rpb24gKCkge1xuICAgIGlmIChkb2N1bWVudC5ib2R5LmNsYXNzTGlzdC5jb250YWlucygnaG9tZS1pbmRleCcpKSB7XG4gICAgICAgIGhvbWUoZG9jdW1lbnQsICdzY3JvbGwnKTtcbiAgICB9XG5cbiAgICBpZiAoZG9jdW1lbnQuYm9keS5jbGFzc0xpc3QuY29udGFpbnMoJ3BhZ2UtZmVhdHVyZXMnKSkge1xuICAgICAgICBsZXQgZGlzcGxheVNpemUgPSBuZXcgRGlzcGxheVNpemUod2luZG93KTtcblxuICAgICAgICBkaXNwbGF5U2l6ZS5zZXQoZGlzcGxheVNpemUuZGVyaXZlKCkpO1xuXG4gICAgICAgIGNvbnN0IHNjcm9sbE9mZnNldHMgPSB7XG4gICAgICAgICAgICAnbGcnOiAyNDAsXG4gICAgICAgICAgICAnbWQnOiAyNDAsXG4gICAgICAgICAgICAnc20nOiAxNjBcbiAgICAgICAgfTtcblxuICAgICAgICBjb25zdCBhZmZpeE9mZnNldHMgPSB7XG4gICAgICAgICAgICAnbGcnOiA2MCxcbiAgICAgICAgICAgICdtZCc6IDYwLFxuICAgICAgICAgICAgJ3NtJzogNjBcbiAgICAgICAgfTtcblxuICAgICAgICBjb25zdCBzY3JvbGxTcHlPZmZzZXQgPSAyNDA7XG4gICAgICAgIGNvbnN0IGZlYXR1cmVzID0gbmV3IEZlYXR1cmVzKFxuICAgICAgICAgICAgZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ3VwcGVyLW5hdicpLFxuICAgICAgICAgICAgZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2xhbmRpbmctc3RyaXAnKSxcbiAgICAgICAgICAgIHNjcm9sbFNweU9mZnNldCxcbiAgICAgICAgICAgIHNjcm9sbE9mZnNldHNbZGlzcGxheVNpemUuZ2V0KCldLFxuICAgICAgICAgICAgYWZmaXhPZmZzZXRzW2Rpc3BsYXlTaXplLmdldCgpXVxuICAgICAgICApO1xuXG4gICAgICAgIHdpbmRvdy5hZGRFdmVudExpc3RlbmVyKCdyZXNpemUnLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICBkaXNwbGF5U2l6ZS5zZXQoZGlzcGxheVNpemUuZGVyaXZlKCkpO1xuICAgICAgICAgICAgZmVhdHVyZXMuc2V0U2Nyb2xsT2Zmc2V0KHNjcm9sbE9mZnNldHNbZGlzcGxheVNpemUuZ2V0KCldKTtcbiAgICAgICAgICAgIGZlYXR1cmVzLnNldEFmZml4T2Zmc2V0KGFmZml4T2Zmc2V0c1tkaXNwbGF5U2l6ZS5nZXQoKV0pO1xuICAgICAgICB9LCB0cnVlKTtcbiAgICB9XG59O1xuXG5kb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCdET01Db250ZW50TG9hZGVkJywgb25Eb21Db250ZW50TG9hZGVkKTtcblxuXG5cbi8vIFdFQlBBQ0sgRk9PVEVSIC8vXG4vLyAuL2Fzc2V0cy9qcy9hcHAuanMiLCJtb2R1bGUuZXhwb3J0cyA9IHtcbiAgICAneHMnOiAnKG1heC13aWR0aDogNzY4cHgpJyxcbiAgICAnc20nOiAnKG1pbi13aWR0aDogNzY4cHgpIGFuZCAobWF4LXdpZHRoOiA5OTJweCknLFxuICAgICdtZCc6ICcobWluLXdpZHRoOiA5OTJweCkgYW5kIChtYXgtd2lkdGg6IDEyMDBweCknLFxuICAgICdsZyc6ICcobWluLXdpZHRoOiAxMjAwcHgpJ1xufTtcblxuXG5cbi8vIFdFQlBBQ0sgRk9PVEVSIC8vXG4vLyAuL2Fzc2V0cy9qcy9icmVha3BvaW50cy5qcyIsInJlcXVpcmUoJ21hdGNobWVkaWEtcG9seWZpbGwnKTtcbmNvbnN0IGJyZWFrcG9pbnRzID0gcmVxdWlyZSgnLi9icmVha3BvaW50cycpO1xuXG5jbGFzcyBEaXNwbGF5U2l6ZSB7XG4gICAgY29uc3RydWN0b3IgKHdpbmRvdykge1xuICAgICAgICB0aGlzLndpbmRvdyA9IHdpbmRvdztcbiAgICB9XG5cbiAgICBkZXJpdmUgKCkge1xuICAgICAgICBsZXQgZGlzcGxheVNpemVOYW1lID0gJ3hzJztcblxuICAgICAgICBPYmplY3Qua2V5cyhicmVha3BvaW50cykuZm9yRWFjaChmdW5jdGlvbiAoa2V5KSB7XG4gICAgICAgICAgICBsZXQgbWVkaWFRdWVyeSA9IGJyZWFrcG9pbnRzW2tleV07XG5cbiAgICAgICAgICAgIGlmICh3aW5kb3cubWF0Y2hNZWRpYShtZWRpYVF1ZXJ5KS5tYXRjaGVzKSB7XG4gICAgICAgICAgICAgICAgZGlzcGxheVNpemVOYW1lID0ga2V5O1xuICAgICAgICAgICAgfVxuICAgICAgICB9KTtcblxuICAgICAgICByZXR1cm4gZGlzcGxheVNpemVOYW1lO1xuICAgIH1cblxuICAgIHNldCAoc2l6ZU5hbWUpIHtcbiAgICAgICAgdGhpcy53aW5kb3cuZG9jdW1lbnQuYm9keS5kYXRhc2V0LmRpc3BsYXlTaXplTmFtZSA9IHNpemVOYW1lO1xuICAgIH1cblxuICAgIGdldCAoKSB7XG4gICAgICAgIHJldHVybiB0aGlzLndpbmRvdy5kb2N1bWVudC5ib2R5LmRhdGFzZXQuZGlzcGxheVNpemVOYW1lO1xuICAgIH1cbn1cblxubW9kdWxlLmV4cG9ydHMgPSBEaXNwbGF5U2l6ZTtcblxuXG5cbi8vIFdFQlBBQ0sgRk9PVEVSIC8vXG4vLyAuL2Fzc2V0cy9qcy9kaXNwbGF5LXNpemUuanMiLCJjb25zdCBTY3JvbGxUbyA9IHJlcXVpcmUoJy4vc2Nyb2xsLXRvJyk7XG5cbmNsYXNzIEZlYXR1cmVzTmF2QmFySXRlbSB7XG4gICAgLyoqXG4gICAgICogQHBhcmFtIHtIVE1MRWxlbWVudH0gZWxlbWVudFxuICAgICAqIEBwYXJhbSB7bnVtYmVyfSBzY3JvbGxPZmZzZXRcbiAgICAgKi9cbiAgICBjb25zdHJ1Y3RvciAoZWxlbWVudCwgc2Nyb2xsT2Zmc2V0KSB7XG4gICAgICAgIHRoaXMuZWxlbWVudCA9IGVsZW1lbnQ7XG4gICAgICAgIHRoaXMuc2Nyb2xsT2Zmc2V0ID0gc2Nyb2xsT2Zmc2V0O1xuXG4gICAgICAgIGxldCBhbmNob3IgPSB0aGlzLmVsZW1lbnQuZ2V0RWxlbWVudHNCeVRhZ05hbWUoJ2EnKVswXTtcbiAgICAgICAgbGV0IGhyZWYgPSBhbmNob3IuZ2V0QXR0cmlidXRlKCdocmVmJyk7XG5cbiAgICAgICAgdGhpcy50YXJnZXRJZCA9IGhyZWYucmVwbGFjZSgnIycsICcnKTtcblxuICAgICAgICB0aGlzLmVsZW1lbnQuYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCB0aGlzLmhhbmRsZUNsaWNrLmJpbmQodGhpcykpO1xuICAgIH07XG5cbiAgICBoYW5kbGVDbGljayAoZXZlbnQpIHtcbiAgICAgICAgZXZlbnQuc3RvcFByb3BhZ2F0aW9uKCk7XG4gICAgICAgIGV2ZW50LnByZXZlbnREZWZhdWx0KCk7XG5cbiAgICAgICAgbGV0IGV2ZW50VGFyZ2V0VmFsdWUgPSBldmVudC50YXJnZXQuZGF0YXNldC50YXJnZXQ7XG4gICAgICAgIGxldCB0YXJnZXQgPSB0aGlzLmdldFRhcmdldCgpO1xuXG4gICAgICAgIGlmIChldmVudFRhcmdldFZhbHVlKSB7XG4gICAgICAgICAgICB0YXJnZXQgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZChldmVudFRhcmdldFZhbHVlLnJlcGxhY2UoJyMnLCAnJykpO1xuICAgICAgICB9XG5cbiAgICAgICAgU2Nyb2xsVG8uc2Nyb2xsVG8odGFyZ2V0LCB0aGlzLnNjcm9sbE9mZnNldCk7XG4gICAgfVxuXG4gICAgZ2V0VGFyZ2V0ICgpIHtcbiAgICAgICAgcmV0dXJuIGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKHRoaXMudGFyZ2V0SWQpO1xuICAgIH1cblxuICAgIGlzRm9yVGFyZ2V0ICh0YXJnZXRJZCkge1xuICAgICAgICByZXR1cm4gdGhpcy50YXJnZXRJZCA9PT0gdGFyZ2V0SWQ7XG4gICAgfVxuXG4gICAgc2V0QWN0aXZlICgpIHtcbiAgICAgICAgdGhpcy5lbGVtZW50LmNsYXNzTGlzdC5hZGQoJ2FjdGl2ZScpO1xuICAgIH1cblxuICAgIHNldEluYWN0aXZlICgpIHtcbiAgICAgICAgdGhpcy5lbGVtZW50LmNsYXNzTGlzdC5yZW1vdmUoJ2FjdGl2ZScpO1xuICAgIH1cblxuICAgIHNldFNjcm9sbE9mZnNldCAoc2Nyb2xsT2Zmc2V0KSB7XG4gICAgICAgIHRoaXMuc2Nyb2xsT2Zmc2V0ID0gc2Nyb2xsT2Zmc2V0O1xuICAgIH1cbn1cblxubW9kdWxlLmV4cG9ydHMgPSBGZWF0dXJlc05hdkJhckl0ZW07XG5cblxuXG4vLyBXRUJQQUNLIEZPT1RFUiAvL1xuLy8gLi9hc3NldHMvanMvZmVhdHVyZXMtbmF2YmFyLWl0ZW0uanMiLCJjb25zdCBOYXZCYXJJdGVtID0gcmVxdWlyZSgnLi9mZWF0dXJlcy1uYXZiYXItaXRlbScpO1xuXG5jbGFzcyBGZWF0dXJlc05hdkJhciB7XG4gICAgLyoqXG4gICAgICogQHBhcmFtIHtIVE1MRWxlbWVudH0gbmF2QmFyRWxlbWVudFxuICAgICAqIEBwYXJhbSB7SFRNTEVsZW1lbnR9IGxhbmRpbmdTdHJpcEVsZW1lbnRcbiAgICAgKiBAcGFyYW0ge251bWJlcn0gc2Nyb2xsT2Zmc2V0XG4gICAgICogQHBhcmFtIHtudW1iZXJ9IGFmZml4T2Zmc2V0XG4gICAgICovXG4gICAgY29uc3RydWN0b3IgKG5hdkJhckVsZW1lbnQsIGxhbmRpbmdTdHJpcEVsZW1lbnQsIHNjcm9sbE9mZnNldCwgYWZmaXhPZmZzZXQpIHtcbiAgICAgICAgdGhpcy5uYXZCYXJFbGVtZW50ID0gbmF2QmFyRWxlbWVudDtcbiAgICAgICAgdGhpcy5sYW5kaW5nU3RyaXBFbGVtZW50ID0gbGFuZGluZ1N0cmlwRWxlbWVudDtcbiAgICAgICAgdGhpcy5hZmZpeE9mZnNldCA9IGFmZml4T2Zmc2V0O1xuICAgICAgICB0aGlzLm5hdkJhckl0ZW1zID0gW107XG5cbiAgICAgICAgbGV0IGxpRWxlbWVudHMgPSB0aGlzLm5hdkJhckVsZW1lbnQuZ2V0RWxlbWVudHNCeVRhZ05hbWUoJ2xpJyk7XG5cbiAgICAgICAgZm9yIChsZXQgaSA9IDA7IGkgPCBsaUVsZW1lbnRzLmxlbmd0aDsgaSsrKSB7XG4gICAgICAgICAgICB0aGlzLm5hdkJhckl0ZW1zLnB1c2gobmV3IE5hdkJhckl0ZW0obGlFbGVtZW50c1tpXSwgc2Nyb2xsT2Zmc2V0KSk7XG4gICAgICAgIH1cblxuICAgICAgICB3aW5kb3cuYWRkRXZlbnRMaXN0ZW5lcignc2Nyb2xsJywgdGhpcy5hZmZpeC5iaW5kKHRoaXMpLCB0cnVlKTtcbiAgICB9O1xuXG4gICAgYWZmaXggKCkge1xuICAgICAgICBjb25zdCBuYXZCYXJCb3VuZGluZ1JlY3QgPSB0aGlzLm5hdkJhckVsZW1lbnQuZ2V0Qm91bmRpbmdDbGllbnRSZWN0KCk7XG4gICAgICAgIGNvbnN0IG5hdkJhclRvcCA9IG5hdkJhckJvdW5kaW5nUmVjdC50b3A7XG4gICAgICAgIGNvbnN0IG5hdkJhckJvdHRvbSA9IG5hdkJhckJvdW5kaW5nUmVjdC5ib3R0b207XG5cbiAgICAgICAgaWYgKG5hdkJhclRvcCA8IHRoaXMuYWZmaXhPZmZzZXQpIHtcbiAgICAgICAgICAgIHRoaXMubmF2QmFyRWxlbWVudC5jbGFzc0xpc3QuYWRkKCdhZmZpeCcpO1xuICAgICAgICB9XG5cbiAgICAgICAgY29uc3QgbGFuZGluZ1N0cmlwQm91bmRpbmdSZWN0ID0gdGhpcy5sYW5kaW5nU3RyaXBFbGVtZW50LmdldEJvdW5kaW5nQ2xpZW50UmVjdCgpO1xuICAgICAgICBjb25zdCBsYW5kaW5nU3RyaXBCb3R0b20gPSBsYW5kaW5nU3RyaXBCb3VuZGluZ1JlY3QuYm90dG9tO1xuXG4gICAgICAgIGlmIChsYW5kaW5nU3RyaXBCb3R0b20gPiBuYXZCYXJCb3R0b20pIHtcbiAgICAgICAgICAgIHRoaXMubmF2QmFyRWxlbWVudC5jbGFzc0xpc3QucmVtb3ZlKCdhZmZpeCcpO1xuICAgICAgICB9XG4gICAgfTtcblxuICAgIGdldExpbmtUYXJnZXRzICgpIHtcbiAgICAgICAgbGV0IGxpbmtUYXJnZXRzID0gW107XG5cbiAgICAgICAgZm9yIChsZXQgaSA9IDA7IGkgPCB0aGlzLm5hdkJhckl0ZW1zLmxlbmd0aDsgaSsrKSB7XG4gICAgICAgICAgICBsaW5rVGFyZ2V0cy5wdXNoKHRoaXMubmF2QmFySXRlbXNbaV0uZ2V0VGFyZ2V0KCkpO1xuICAgICAgICB9XG5cbiAgICAgICAgcmV0dXJuIGxpbmtUYXJnZXRzO1xuICAgIH1cblxuICAgIHNldEFjdGl2ZSAobGlua1RhcmdldElkKSB7XG4gICAgICAgIGZvciAobGV0IGkgPSAwOyBpIDwgdGhpcy5uYXZCYXJJdGVtcy5sZW5ndGg7IGkrKykge1xuICAgICAgICAgICAgbGV0IG5hdkJhckl0ZW0gPSB0aGlzLm5hdkJhckl0ZW1zW2ldO1xuXG4gICAgICAgICAgICBpZiAobmF2QmFySXRlbS5pc0ZvclRhcmdldChsaW5rVGFyZ2V0SWQpKSB7XG4gICAgICAgICAgICAgICAgbmF2QmFySXRlbS5zZXRBY3RpdmUoKTtcbiAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgbmF2QmFySXRlbS5zZXRJbmFjdGl2ZSgpO1xuICAgICAgICAgICAgfVxuICAgICAgICB9XG4gICAgfVxuXG4gICAgc2V0U2Nyb2xsT2Zmc2V0IChzY3JvbGxPZmZzZXQpIHtcbiAgICAgICAgZm9yIChsZXQgaSA9IDA7IGkgPCB0aGlzLm5hdkJhckl0ZW1zLmxlbmd0aDsgaSsrKSB7XG4gICAgICAgICAgICAvKiogQHR5cGUge0ZlYXR1cmVzTmF2QmFySXRlbX0gKi9cbiAgICAgICAgICAgIGxldCBuYXZCYXJJdGVtID0gdGhpcy5uYXZCYXJJdGVtc1tpXTtcblxuICAgICAgICAgICAgbmF2QmFySXRlbS5zZXRTY3JvbGxPZmZzZXQoc2Nyb2xsT2Zmc2V0KTtcbiAgICAgICAgfVxuICAgIH1cblxuICAgIHNldEFmZml4T2Zmc2V0IChhZmZpeE9mZnNldCkge1xuICAgICAgICB0aGlzLmFmZml4T2Zmc2V0ID0gYWZmaXhPZmZzZXQ7XG4gICAgfVxufVxuXG5tb2R1bGUuZXhwb3J0cyA9IEZlYXR1cmVzTmF2QmFyO1xuXG5cblxuLy8gV0VCUEFDSyBGT09URVIgLy9cbi8vIC4vYXNzZXRzL2pzL2ZlYXR1cmVzLW5hdmJhci5qcyIsImNsYXNzIEZlYXR1cmVzU2Nyb2xsU3B5IHtcbiAgICAvKipcbiAgICAgKiBAcGFyYW0ge0ZlYXR1cmVzTmF2QmFyfSBuYXZiYXJcbiAgICAgKiBAcGFyYW0ge251bWJlcn0gb2Zmc2V0XG4gICAgICovXG4gICAgY29uc3RydWN0b3IgKG5hdmJhciwgb2Zmc2V0KSB7XG4gICAgICAgIHRoaXMubmF2YmFyID0gbmF2YmFyO1xuICAgICAgICB0aGlzLm9mZnNldCA9IG9mZnNldDtcbiAgICB9XG5cbiAgICBzY3JvbGxFdmVudExpc3RlbmVyICgpIHtcbiAgICAgICAgbGV0IGFjdGl2ZUxpbmtUYXJnZXQgPSBudWxsO1xuICAgICAgICBsZXQgbGlua1RhcmdldHMgPSB0aGlzLm5hdmJhci5nZXRMaW5rVGFyZ2V0cygpO1xuICAgICAgICBsZXQgb2Zmc2V0ID0gdGhpcy5vZmZzZXQ7XG5cbiAgICAgICAgbGlua1RhcmdldHMuZm9yRWFjaChmdW5jdGlvbiAobGlua1RhcmdldCwgaW5kZXgpIHtcbiAgICAgICAgICAgIGlmICghYWN0aXZlTGlua1RhcmdldCkge1xuICAgICAgICAgICAgICAgIGxldCBib3R0b20gPSBsaW5rVGFyZ2V0LmdldEJvdW5kaW5nQ2xpZW50UmVjdCgpLmJvdHRvbTtcblxuICAgICAgICAgICAgICAgIGlmIChib3R0b20gPiBvZmZzZXQgfHwgaW5kZXggPT09IGxpbmtUYXJnZXRzLmxlbmd0aCAtIDEpIHtcbiAgICAgICAgICAgICAgICAgICAgYWN0aXZlTGlua1RhcmdldCA9IGxpbmtUYXJnZXQ7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfVxuICAgICAgICB9KTtcblxuICAgICAgICB0aGlzLm5hdmJhci5zZXRBY3RpdmUoYWN0aXZlTGlua1RhcmdldC5nZXRBdHRyaWJ1dGUoJ2lkJykpO1xuICAgIH1cblxuICAgIHNweSAoKSB7XG4gICAgICAgIHdpbmRvdy5hZGRFdmVudExpc3RlbmVyKFxuICAgICAgICAgICAgJ3Njcm9sbCcsXG4gICAgICAgICAgICB0aGlzLnNjcm9sbEV2ZW50TGlzdGVuZXIuYmluZCh0aGlzKSxcbiAgICAgICAgICAgIHRydWVcbiAgICAgICAgKTtcbiAgICB9XG59XG5cbm1vZHVsZS5leHBvcnRzID0gRmVhdHVyZXNTY3JvbGxTcHk7XG5cblxuXG4vLyBXRUJQQUNLIEZPT1RFUiAvL1xuLy8gLi9hc3NldHMvanMvZmVhdHVyZXMtc2Nyb2xsc3B5LmpzIiwiY29uc3QgRmVhdHVyZXNOYXZCYXIgPSByZXF1aXJlKCcuL2ZlYXR1cmVzLW5hdmJhcicpO1xuY29uc3QgRmVhdHVyZXNTY3JvbGxTcHkgPSByZXF1aXJlKCcuL2ZlYXR1cmVzLXNjcm9sbHNweScpO1xuY29uc3QgU2Nyb2xsVG8gPSByZXF1aXJlKCcuL3Njcm9sbC10bycpO1xuXG5jbGFzcyBGZWF0dXJlcyB7XG4gICAgY29uc3RydWN0b3IgKG5hdkJhckVsZW1lbnQsIGxhbmRpbmdTdHJpcEVsZW1lbnQsIHNjcm9sbFNweU9mZnNldCwgc2Nyb2xsT2Zmc2V0LCBhZmZpeE9mZnNldCkge1xuICAgICAgICB0aGlzLm5hdmJhciA9IG5ldyBGZWF0dXJlc05hdkJhcihuYXZCYXJFbGVtZW50LCBsYW5kaW5nU3RyaXBFbGVtZW50LCBzY3JvbGxPZmZzZXQsIGFmZml4T2Zmc2V0KTtcbiAgICAgICAgdGhpcy5zY3JvbGxzcHkgPSBuZXcgRmVhdHVyZXNTY3JvbGxTcHkodGhpcy5uYXZiYXIsIHNjcm9sbFNweU9mZnNldCk7XG4gICAgICAgIHRoaXMubmF2YmFyLmFmZml4KCk7XG4gICAgICAgIHRoaXMuc2Nyb2xsc3B5LnNweSgpO1xuXG4gICAgICAgIGlmICh3aW5kb3cubG9jYXRpb24uaGFzaCkge1xuICAgICAgICAgICAgY29uc3QgdGFyZ2V0ID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQod2luZG93LmxvY2F0aW9uLmhhc2gucmVwbGFjZSgnIycsICcnKSk7XG5cbiAgICAgICAgICAgIGlmICh0YXJnZXQpIHtcbiAgICAgICAgICAgICAgICBTY3JvbGxUby5zY3JvbGxUbyh0YXJnZXQsIHNjcm9sbE9mZnNldCk7XG4gICAgICAgICAgICB9XG4gICAgICAgIH1cbiAgICB9XG5cbiAgICBzZXRTY3JvbGxPZmZzZXQgKHNjcm9sbE9mZnNldCkge1xuICAgICAgICB0aGlzLm5hdmJhci5zZXRTY3JvbGxPZmZzZXQoc2Nyb2xsT2Zmc2V0KTtcbiAgICB9XG5cbiAgICBzZXRBZmZpeE9mZnNldCAoYWZmaXhPZmZzZXQpIHtcbiAgICAgICAgdGhpcy5uYXZiYXIuc2V0QWZmaXhPZmZzZXQoYWZmaXhPZmZzZXQpO1xuICAgIH1cbn1cblxubW9kdWxlLmV4cG9ydHMgPSBGZWF0dXJlcztcblxuXG5cbi8vIFdFQlBBQ0sgRk9PVEVSIC8vXG4vLyAuL2Fzc2V0cy9qcy9mZWF0dXJlcy5qcyIsIm1vZHVsZS5leHBvcnRzID0gZnVuY3Rpb24gKGRvY3VtZW50LCBldmVudE5hbWUpIHtcbiAgICBjb25zdCBpbml0aWFsT2Zmc2V0ID0gMzEwO1xuICAgIGNvbnN0IGxhbmRpbmdTdHJpcCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdsYW5kaW5nLXN0cmlwJyk7XG5cbiAgICBkb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKGV2ZW50TmFtZSwgZnVuY3Rpb24gKCkge1xuICAgICAgICBsZXQgb2Zmc2V0ID0gKE1hdGgubWF4KGRvY3VtZW50LmRvY3VtZW50RWxlbWVudC5zY3JvbGxUb3AsIGRvY3VtZW50LmJvZHkuc2Nyb2xsVG9wKSkgLyA0O1xuICAgICAgICBsZXQgdXBkYXRlZCA9IG9mZnNldCAqIC0xIC0gaW5pdGlhbE9mZnNldDtcblxuICAgICAgICBsYW5kaW5nU3RyaXAuc3R5bGUuYmFja2dyb3VuZFBvc2l0aW9uWSA9IHVwZGF0ZWQgKyAncHgnO1xuICAgIH0pO1xufTtcblxuXG5cbi8vIFdFQlBBQ0sgRk9PVEVSIC8vXG4vLyAuL2Fzc2V0cy9qcy9ob21lLmpzIiwiY29uc3QgU21vb3RoU2Nyb2xsID0gcmVxdWlyZSgnc21vb3RoLXNjcm9sbCcpO1xuXG5jbGFzcyBTY3JvbGxUbyB7XG4gICAgc3RhdGljIHNjcm9sbFRvICh0YXJnZXQsIG9mZnNldCkge1xuICAgICAgICBjb25zdCBzY3JvbGwgPSBuZXcgU21vb3RoU2Nyb2xsKCk7XG5cbiAgICAgICAgc2Nyb2xsLmFuaW1hdGVTY3JvbGwodGFyZ2V0Lm9mZnNldFRvcCArIG9mZnNldCk7XG5cbiAgICAgICAgaWYgKHdpbmRvdy5oaXN0b3J5LnB1c2hTdGF0ZSkge1xuICAgICAgICAgICAgd2luZG93Lmhpc3RvcnkucHVzaFN0YXRlKG51bGwsIG51bGwsICcjJyArIHRhcmdldC5nZXRBdHRyaWJ1dGUoJ2lkJykpO1xuICAgICAgICB9XG4gICAgfVxufVxuXG5tb2R1bGUuZXhwb3J0cyA9IFNjcm9sbFRvO1xuXG5cblxuLy8gV0VCUEFDSyBGT09URVIgLy9cbi8vIC4vYXNzZXRzL2pzL3Njcm9sbC10by5qcyIsIi8qXG4gKiBjbGFzc0xpc3QuanM6IENyb3NzLWJyb3dzZXIgZnVsbCBlbGVtZW50LmNsYXNzTGlzdCBpbXBsZW1lbnRhdGlvbi5cbiAqIDEuMS4yMDE3MDQyN1xuICpcbiAqIEJ5IEVsaSBHcmV5LCBodHRwOi8vZWxpZ3JleS5jb21cbiAqIExpY2Vuc2U6IERlZGljYXRlZCB0byB0aGUgcHVibGljIGRvbWFpbi5cbiAqICAgU2VlIGh0dHBzOi8vZ2l0aHViLmNvbS9lbGlncmV5L2NsYXNzTGlzdC5qcy9ibG9iL21hc3Rlci9MSUNFTlNFLm1kXG4gKi9cblxuLypnbG9iYWwgc2VsZiwgZG9jdW1lbnQsIERPTUV4Y2VwdGlvbiAqL1xuXG4vKiEgQHNvdXJjZSBodHRwOi8vcHVybC5lbGlncmV5LmNvbS9naXRodWIvY2xhc3NMaXN0LmpzL2Jsb2IvbWFzdGVyL2NsYXNzTGlzdC5qcyAqL1xuXG5pZiAoXCJkb2N1bWVudFwiIGluIHdpbmRvdy5zZWxmKSB7XG5cbi8vIEZ1bGwgcG9seWZpbGwgZm9yIGJyb3dzZXJzIHdpdGggbm8gY2xhc3NMaXN0IHN1cHBvcnRcbi8vIEluY2x1ZGluZyBJRSA8IEVkZ2UgbWlzc2luZyBTVkdFbGVtZW50LmNsYXNzTGlzdFxuaWYgKCEoXCJjbGFzc0xpc3RcIiBpbiBkb2N1bWVudC5jcmVhdGVFbGVtZW50KFwiX1wiKSkgXG5cdHx8IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnROUyAmJiAhKFwiY2xhc3NMaXN0XCIgaW4gZG9jdW1lbnQuY3JlYXRlRWxlbWVudE5TKFwiaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmdcIixcImdcIikpKSB7XG5cbihmdW5jdGlvbiAodmlldykge1xuXG5cInVzZSBzdHJpY3RcIjtcblxuaWYgKCEoJ0VsZW1lbnQnIGluIHZpZXcpKSByZXR1cm47XG5cbnZhclxuXHQgIGNsYXNzTGlzdFByb3AgPSBcImNsYXNzTGlzdFwiXG5cdCwgcHJvdG9Qcm9wID0gXCJwcm90b3R5cGVcIlxuXHQsIGVsZW1DdHJQcm90byA9IHZpZXcuRWxlbWVudFtwcm90b1Byb3BdXG5cdCwgb2JqQ3RyID0gT2JqZWN0XG5cdCwgc3RyVHJpbSA9IFN0cmluZ1twcm90b1Byb3BdLnRyaW0gfHwgZnVuY3Rpb24gKCkge1xuXHRcdHJldHVybiB0aGlzLnJlcGxhY2UoL15cXHMrfFxccyskL2csIFwiXCIpO1xuXHR9XG5cdCwgYXJySW5kZXhPZiA9IEFycmF5W3Byb3RvUHJvcF0uaW5kZXhPZiB8fCBmdW5jdGlvbiAoaXRlbSkge1xuXHRcdHZhclxuXHRcdFx0ICBpID0gMFxuXHRcdFx0LCBsZW4gPSB0aGlzLmxlbmd0aFxuXHRcdDtcblx0XHRmb3IgKDsgaSA8IGxlbjsgaSsrKSB7XG5cdFx0XHRpZiAoaSBpbiB0aGlzICYmIHRoaXNbaV0gPT09IGl0ZW0pIHtcblx0XHRcdFx0cmV0dXJuIGk7XG5cdFx0XHR9XG5cdFx0fVxuXHRcdHJldHVybiAtMTtcblx0fVxuXHQvLyBWZW5kb3JzOiBwbGVhc2UgYWxsb3cgY29udGVudCBjb2RlIHRvIGluc3RhbnRpYXRlIERPTUV4Y2VwdGlvbnNcblx0LCBET01FeCA9IGZ1bmN0aW9uICh0eXBlLCBtZXNzYWdlKSB7XG5cdFx0dGhpcy5uYW1lID0gdHlwZTtcblx0XHR0aGlzLmNvZGUgPSBET01FeGNlcHRpb25bdHlwZV07XG5cdFx0dGhpcy5tZXNzYWdlID0gbWVzc2FnZTtcblx0fVxuXHQsIGNoZWNrVG9rZW5BbmRHZXRJbmRleCA9IGZ1bmN0aW9uIChjbGFzc0xpc3QsIHRva2VuKSB7XG5cdFx0aWYgKHRva2VuID09PSBcIlwiKSB7XG5cdFx0XHR0aHJvdyBuZXcgRE9NRXgoXG5cdFx0XHRcdCAgXCJTWU5UQVhfRVJSXCJcblx0XHRcdFx0LCBcIkFuIGludmFsaWQgb3IgaWxsZWdhbCBzdHJpbmcgd2FzIHNwZWNpZmllZFwiXG5cdFx0XHQpO1xuXHRcdH1cblx0XHRpZiAoL1xccy8udGVzdCh0b2tlbikpIHtcblx0XHRcdHRocm93IG5ldyBET01FeChcblx0XHRcdFx0ICBcIklOVkFMSURfQ0hBUkFDVEVSX0VSUlwiXG5cdFx0XHRcdCwgXCJTdHJpbmcgY29udGFpbnMgYW4gaW52YWxpZCBjaGFyYWN0ZXJcIlxuXHRcdFx0KTtcblx0XHR9XG5cdFx0cmV0dXJuIGFyckluZGV4T2YuY2FsbChjbGFzc0xpc3QsIHRva2VuKTtcblx0fVxuXHQsIENsYXNzTGlzdCA9IGZ1bmN0aW9uIChlbGVtKSB7XG5cdFx0dmFyXG5cdFx0XHQgIHRyaW1tZWRDbGFzc2VzID0gc3RyVHJpbS5jYWxsKGVsZW0uZ2V0QXR0cmlidXRlKFwiY2xhc3NcIikgfHwgXCJcIilcblx0XHRcdCwgY2xhc3NlcyA9IHRyaW1tZWRDbGFzc2VzID8gdHJpbW1lZENsYXNzZXMuc3BsaXQoL1xccysvKSA6IFtdXG5cdFx0XHQsIGkgPSAwXG5cdFx0XHQsIGxlbiA9IGNsYXNzZXMubGVuZ3RoXG5cdFx0O1xuXHRcdGZvciAoOyBpIDwgbGVuOyBpKyspIHtcblx0XHRcdHRoaXMucHVzaChjbGFzc2VzW2ldKTtcblx0XHR9XG5cdFx0dGhpcy5fdXBkYXRlQ2xhc3NOYW1lID0gZnVuY3Rpb24gKCkge1xuXHRcdFx0ZWxlbS5zZXRBdHRyaWJ1dGUoXCJjbGFzc1wiLCB0aGlzLnRvU3RyaW5nKCkpO1xuXHRcdH07XG5cdH1cblx0LCBjbGFzc0xpc3RQcm90byA9IENsYXNzTGlzdFtwcm90b1Byb3BdID0gW11cblx0LCBjbGFzc0xpc3RHZXR0ZXIgPSBmdW5jdGlvbiAoKSB7XG5cdFx0cmV0dXJuIG5ldyBDbGFzc0xpc3QodGhpcyk7XG5cdH1cbjtcbi8vIE1vc3QgRE9NRXhjZXB0aW9uIGltcGxlbWVudGF0aW9ucyBkb24ndCBhbGxvdyBjYWxsaW5nIERPTUV4Y2VwdGlvbidzIHRvU3RyaW5nKClcbi8vIG9uIG5vbi1ET01FeGNlcHRpb25zLiBFcnJvcidzIHRvU3RyaW5nKCkgaXMgc3VmZmljaWVudCBoZXJlLlxuRE9NRXhbcHJvdG9Qcm9wXSA9IEVycm9yW3Byb3RvUHJvcF07XG5jbGFzc0xpc3RQcm90by5pdGVtID0gZnVuY3Rpb24gKGkpIHtcblx0cmV0dXJuIHRoaXNbaV0gfHwgbnVsbDtcbn07XG5jbGFzc0xpc3RQcm90by5jb250YWlucyA9IGZ1bmN0aW9uICh0b2tlbikge1xuXHR0b2tlbiArPSBcIlwiO1xuXHRyZXR1cm4gY2hlY2tUb2tlbkFuZEdldEluZGV4KHRoaXMsIHRva2VuKSAhPT0gLTE7XG59O1xuY2xhc3NMaXN0UHJvdG8uYWRkID0gZnVuY3Rpb24gKCkge1xuXHR2YXJcblx0XHQgIHRva2VucyA9IGFyZ3VtZW50c1xuXHRcdCwgaSA9IDBcblx0XHQsIGwgPSB0b2tlbnMubGVuZ3RoXG5cdFx0LCB0b2tlblxuXHRcdCwgdXBkYXRlZCA9IGZhbHNlXG5cdDtcblx0ZG8ge1xuXHRcdHRva2VuID0gdG9rZW5zW2ldICsgXCJcIjtcblx0XHRpZiAoY2hlY2tUb2tlbkFuZEdldEluZGV4KHRoaXMsIHRva2VuKSA9PT0gLTEpIHtcblx0XHRcdHRoaXMucHVzaCh0b2tlbik7XG5cdFx0XHR1cGRhdGVkID0gdHJ1ZTtcblx0XHR9XG5cdH1cblx0d2hpbGUgKCsraSA8IGwpO1xuXG5cdGlmICh1cGRhdGVkKSB7XG5cdFx0dGhpcy5fdXBkYXRlQ2xhc3NOYW1lKCk7XG5cdH1cbn07XG5jbGFzc0xpc3RQcm90by5yZW1vdmUgPSBmdW5jdGlvbiAoKSB7XG5cdHZhclxuXHRcdCAgdG9rZW5zID0gYXJndW1lbnRzXG5cdFx0LCBpID0gMFxuXHRcdCwgbCA9IHRva2Vucy5sZW5ndGhcblx0XHQsIHRva2VuXG5cdFx0LCB1cGRhdGVkID0gZmFsc2Vcblx0XHQsIGluZGV4XG5cdDtcblx0ZG8ge1xuXHRcdHRva2VuID0gdG9rZW5zW2ldICsgXCJcIjtcblx0XHRpbmRleCA9IGNoZWNrVG9rZW5BbmRHZXRJbmRleCh0aGlzLCB0b2tlbik7XG5cdFx0d2hpbGUgKGluZGV4ICE9PSAtMSkge1xuXHRcdFx0dGhpcy5zcGxpY2UoaW5kZXgsIDEpO1xuXHRcdFx0dXBkYXRlZCA9IHRydWU7XG5cdFx0XHRpbmRleCA9IGNoZWNrVG9rZW5BbmRHZXRJbmRleCh0aGlzLCB0b2tlbik7XG5cdFx0fVxuXHR9XG5cdHdoaWxlICgrK2kgPCBsKTtcblxuXHRpZiAodXBkYXRlZCkge1xuXHRcdHRoaXMuX3VwZGF0ZUNsYXNzTmFtZSgpO1xuXHR9XG59O1xuY2xhc3NMaXN0UHJvdG8udG9nZ2xlID0gZnVuY3Rpb24gKHRva2VuLCBmb3JjZSkge1xuXHR0b2tlbiArPSBcIlwiO1xuXG5cdHZhclxuXHRcdCAgcmVzdWx0ID0gdGhpcy5jb250YWlucyh0b2tlbilcblx0XHQsIG1ldGhvZCA9IHJlc3VsdCA/XG5cdFx0XHRmb3JjZSAhPT0gdHJ1ZSAmJiBcInJlbW92ZVwiXG5cdFx0OlxuXHRcdFx0Zm9yY2UgIT09IGZhbHNlICYmIFwiYWRkXCJcblx0O1xuXG5cdGlmIChtZXRob2QpIHtcblx0XHR0aGlzW21ldGhvZF0odG9rZW4pO1xuXHR9XG5cblx0aWYgKGZvcmNlID09PSB0cnVlIHx8IGZvcmNlID09PSBmYWxzZSkge1xuXHRcdHJldHVybiBmb3JjZTtcblx0fSBlbHNlIHtcblx0XHRyZXR1cm4gIXJlc3VsdDtcblx0fVxufTtcbmNsYXNzTGlzdFByb3RvLnRvU3RyaW5nID0gZnVuY3Rpb24gKCkge1xuXHRyZXR1cm4gdGhpcy5qb2luKFwiIFwiKTtcbn07XG5cbmlmIChvYmpDdHIuZGVmaW5lUHJvcGVydHkpIHtcblx0dmFyIGNsYXNzTGlzdFByb3BEZXNjID0ge1xuXHRcdCAgZ2V0OiBjbGFzc0xpc3RHZXR0ZXJcblx0XHQsIGVudW1lcmFibGU6IHRydWVcblx0XHQsIGNvbmZpZ3VyYWJsZTogdHJ1ZVxuXHR9O1xuXHR0cnkge1xuXHRcdG9iakN0ci5kZWZpbmVQcm9wZXJ0eShlbGVtQ3RyUHJvdG8sIGNsYXNzTGlzdFByb3AsIGNsYXNzTGlzdFByb3BEZXNjKTtcblx0fSBjYXRjaCAoZXgpIHsgLy8gSUUgOCBkb2Vzbid0IHN1cHBvcnQgZW51bWVyYWJsZTp0cnVlXG5cdFx0Ly8gYWRkaW5nIHVuZGVmaW5lZCB0byBmaWdodCB0aGlzIGlzc3VlIGh0dHBzOi8vZ2l0aHViLmNvbS9lbGlncmV5L2NsYXNzTGlzdC5qcy9pc3N1ZXMvMzZcblx0XHQvLyBtb2Rlcm5pZSBJRTgtTVNXNyBtYWNoaW5lIGhhcyBJRTggOC4wLjYwMDEuMTg3MDIgYW5kIGlzIGFmZmVjdGVkXG5cdFx0aWYgKGV4Lm51bWJlciA9PT0gdW5kZWZpbmVkIHx8IGV4Lm51bWJlciA9PT0gLTB4N0ZGNUVDNTQpIHtcblx0XHRcdGNsYXNzTGlzdFByb3BEZXNjLmVudW1lcmFibGUgPSBmYWxzZTtcblx0XHRcdG9iakN0ci5kZWZpbmVQcm9wZXJ0eShlbGVtQ3RyUHJvdG8sIGNsYXNzTGlzdFByb3AsIGNsYXNzTGlzdFByb3BEZXNjKTtcblx0XHR9XG5cdH1cbn0gZWxzZSBpZiAob2JqQ3RyW3Byb3RvUHJvcF0uX19kZWZpbmVHZXR0ZXJfXykge1xuXHRlbGVtQ3RyUHJvdG8uX19kZWZpbmVHZXR0ZXJfXyhjbGFzc0xpc3RQcm9wLCBjbGFzc0xpc3RHZXR0ZXIpO1xufVxuXG59KHdpbmRvdy5zZWxmKSk7XG5cbn1cblxuLy8gVGhlcmUgaXMgZnVsbCBvciBwYXJ0aWFsIG5hdGl2ZSBjbGFzc0xpc3Qgc3VwcG9ydCwgc28ganVzdCBjaGVjayBpZiB3ZSBuZWVkXG4vLyB0byBub3JtYWxpemUgdGhlIGFkZC9yZW1vdmUgYW5kIHRvZ2dsZSBBUElzLlxuXG4oZnVuY3Rpb24gKCkge1xuXHRcInVzZSBzdHJpY3RcIjtcblxuXHR2YXIgdGVzdEVsZW1lbnQgPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KFwiX1wiKTtcblxuXHR0ZXN0RWxlbWVudC5jbGFzc0xpc3QuYWRkKFwiYzFcIiwgXCJjMlwiKTtcblxuXHQvLyBQb2x5ZmlsbCBmb3IgSUUgMTAvMTEgYW5kIEZpcmVmb3ggPDI2LCB3aGVyZSBjbGFzc0xpc3QuYWRkIGFuZFxuXHQvLyBjbGFzc0xpc3QucmVtb3ZlIGV4aXN0IGJ1dCBzdXBwb3J0IG9ubHkgb25lIGFyZ3VtZW50IGF0IGEgdGltZS5cblx0aWYgKCF0ZXN0RWxlbWVudC5jbGFzc0xpc3QuY29udGFpbnMoXCJjMlwiKSkge1xuXHRcdHZhciBjcmVhdGVNZXRob2QgPSBmdW5jdGlvbihtZXRob2QpIHtcblx0XHRcdHZhciBvcmlnaW5hbCA9IERPTVRva2VuTGlzdC5wcm90b3R5cGVbbWV0aG9kXTtcblxuXHRcdFx0RE9NVG9rZW5MaXN0LnByb3RvdHlwZVttZXRob2RdID0gZnVuY3Rpb24odG9rZW4pIHtcblx0XHRcdFx0dmFyIGksIGxlbiA9IGFyZ3VtZW50cy5sZW5ndGg7XG5cblx0XHRcdFx0Zm9yIChpID0gMDsgaSA8IGxlbjsgaSsrKSB7XG5cdFx0XHRcdFx0dG9rZW4gPSBhcmd1bWVudHNbaV07XG5cdFx0XHRcdFx0b3JpZ2luYWwuY2FsbCh0aGlzLCB0b2tlbik7XG5cdFx0XHRcdH1cblx0XHRcdH07XG5cdFx0fTtcblx0XHRjcmVhdGVNZXRob2QoJ2FkZCcpO1xuXHRcdGNyZWF0ZU1ldGhvZCgncmVtb3ZlJyk7XG5cdH1cblxuXHR0ZXN0RWxlbWVudC5jbGFzc0xpc3QudG9nZ2xlKFwiYzNcIiwgZmFsc2UpO1xuXG5cdC8vIFBvbHlmaWxsIGZvciBJRSAxMCBhbmQgRmlyZWZveCA8MjQsIHdoZXJlIGNsYXNzTGlzdC50b2dnbGUgZG9lcyBub3Rcblx0Ly8gc3VwcG9ydCB0aGUgc2Vjb25kIGFyZ3VtZW50LlxuXHRpZiAodGVzdEVsZW1lbnQuY2xhc3NMaXN0LmNvbnRhaW5zKFwiYzNcIikpIHtcblx0XHR2YXIgX3RvZ2dsZSA9IERPTVRva2VuTGlzdC5wcm90b3R5cGUudG9nZ2xlO1xuXG5cdFx0RE9NVG9rZW5MaXN0LnByb3RvdHlwZS50b2dnbGUgPSBmdW5jdGlvbih0b2tlbiwgZm9yY2UpIHtcblx0XHRcdGlmICgxIGluIGFyZ3VtZW50cyAmJiAhdGhpcy5jb250YWlucyh0b2tlbikgPT09ICFmb3JjZSkge1xuXHRcdFx0XHRyZXR1cm4gZm9yY2U7XG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRyZXR1cm4gX3RvZ2dsZS5jYWxsKHRoaXMsIHRva2VuKTtcblx0XHRcdH1cblx0XHR9O1xuXG5cdH1cblxuXHR0ZXN0RWxlbWVudCA9IG51bGw7XG59KCkpO1xuXG59XG5cblxuXG4vLy8vLy8vLy8vLy8vLy8vLy9cbi8vIFdFQlBBQ0sgRk9PVEVSXG4vLyAuL25vZGVfbW9kdWxlcy9jbGFzc2xpc3QtcG9seWZpbGwvc3JjL2luZGV4LmpzXG4vLyBtb2R1bGUgaWQgPSAuL25vZGVfbW9kdWxlcy9jbGFzc2xpc3QtcG9seWZpbGwvc3JjL2luZGV4LmpzXG4vLyBtb2R1bGUgY2h1bmtzID0gMCIsIi8qISBtYXRjaE1lZGlhKCkgcG9seWZpbGwgLSBUZXN0IGEgQ1NTIG1lZGlhIHR5cGUvcXVlcnkgaW4gSlMuIEF1dGhvcnMgJiBjb3B5cmlnaHQgKGMpIDIwMTI6IFNjb3R0IEplaGwsIFBhdWwgSXJpc2gsIE5pY2hvbGFzIFpha2FzLCBEYXZpZCBLbmlnaHQuIER1YWwgTUlUL0JTRCBsaWNlbnNlICovXG5cbndpbmRvdy5tYXRjaE1lZGlhIHx8ICh3aW5kb3cubWF0Y2hNZWRpYSA9IGZ1bmN0aW9uKCkge1xuICAgIFwidXNlIHN0cmljdFwiO1xuXG4gICAgLy8gRm9yIGJyb3dzZXJzIHRoYXQgc3VwcG9ydCBtYXRjaE1lZGl1bSBhcGkgc3VjaCBhcyBJRSA5IGFuZCB3ZWJraXRcbiAgICB2YXIgc3R5bGVNZWRpYSA9ICh3aW5kb3cuc3R5bGVNZWRpYSB8fCB3aW5kb3cubWVkaWEpO1xuXG4gICAgLy8gRm9yIHRob3NlIHRoYXQgZG9uJ3Qgc3VwcG9ydCBtYXRjaE1lZGl1bVxuICAgIGlmICghc3R5bGVNZWRpYSkge1xuICAgICAgICB2YXIgc3R5bGUgICAgICAgPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KCdzdHlsZScpLFxuICAgICAgICAgICAgc2NyaXB0ICAgICAgPSBkb2N1bWVudC5nZXRFbGVtZW50c0J5VGFnTmFtZSgnc2NyaXB0JylbMF0sXG4gICAgICAgICAgICBpbmZvICAgICAgICA9IG51bGw7XG5cbiAgICAgICAgc3R5bGUudHlwZSAgPSAndGV4dC9jc3MnO1xuICAgICAgICBzdHlsZS5pZCAgICA9ICdtYXRjaG1lZGlhanMtdGVzdCc7XG5cbiAgICAgICAgc2NyaXB0LnBhcmVudE5vZGUuaW5zZXJ0QmVmb3JlKHN0eWxlLCBzY3JpcHQpO1xuXG4gICAgICAgIC8vICdzdHlsZS5jdXJyZW50U3R5bGUnIGlzIHVzZWQgYnkgSUUgPD0gOCBhbmQgJ3dpbmRvdy5nZXRDb21wdXRlZFN0eWxlJyBmb3IgYWxsIG90aGVyIGJyb3dzZXJzXG4gICAgICAgIGluZm8gPSAoJ2dldENvbXB1dGVkU3R5bGUnIGluIHdpbmRvdykgJiYgd2luZG93LmdldENvbXB1dGVkU3R5bGUoc3R5bGUsIG51bGwpIHx8IHN0eWxlLmN1cnJlbnRTdHlsZTtcblxuICAgICAgICBzdHlsZU1lZGlhID0ge1xuICAgICAgICAgICAgbWF0Y2hNZWRpdW06IGZ1bmN0aW9uKG1lZGlhKSB7XG4gICAgICAgICAgICAgICAgdmFyIHRleHQgPSAnQG1lZGlhICcgKyBtZWRpYSArICd7ICNtYXRjaG1lZGlhanMtdGVzdCB7IHdpZHRoOiAxcHg7IH0gfSc7XG5cbiAgICAgICAgICAgICAgICAvLyAnc3R5bGUuc3R5bGVTaGVldCcgaXMgdXNlZCBieSBJRSA8PSA4IGFuZCAnc3R5bGUudGV4dENvbnRlbnQnIGZvciBhbGwgb3RoZXIgYnJvd3NlcnNcbiAgICAgICAgICAgICAgICBpZiAoc3R5bGUuc3R5bGVTaGVldCkge1xuICAgICAgICAgICAgICAgICAgICBzdHlsZS5zdHlsZVNoZWV0LmNzc1RleHQgPSB0ZXh0O1xuICAgICAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgICAgIHN0eWxlLnRleHRDb250ZW50ID0gdGV4dDtcbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICAvLyBUZXN0IGlmIG1lZGlhIHF1ZXJ5IGlzIHRydWUgb3IgZmFsc2VcbiAgICAgICAgICAgICAgICByZXR1cm4gaW5mby53aWR0aCA9PT0gJzFweCc7XG4gICAgICAgICAgICB9XG4gICAgICAgIH07XG4gICAgfVxuXG4gICAgcmV0dXJuIGZ1bmN0aW9uKG1lZGlhKSB7XG4gICAgICAgIHJldHVybiB7XG4gICAgICAgICAgICBtYXRjaGVzOiBzdHlsZU1lZGlhLm1hdGNoTWVkaXVtKG1lZGlhIHx8ICdhbGwnKSxcbiAgICAgICAgICAgIG1lZGlhOiBtZWRpYSB8fCAnYWxsJ1xuICAgICAgICB9O1xuICAgIH07XG59KCkpO1xuXG5cblxuLy8vLy8vLy8vLy8vLy8vLy8vXG4vLyBXRUJQQUNLIEZPT1RFUlxuLy8gLi9ub2RlX21vZHVsZXMvbWF0Y2htZWRpYS1wb2x5ZmlsbC9tYXRjaE1lZGlhLmpzXG4vLyBtb2R1bGUgaWQgPSAuL25vZGVfbW9kdWxlcy9tYXRjaG1lZGlhLXBvbHlmaWxsL21hdGNoTWVkaWEuanNcbi8vIG1vZHVsZSBjaHVua3MgPSAwIiwiLyohIHNtb290aC1zY3JvbGwgdjEyLjEuNSB8IChjKSAyMDE3IENocmlzIEZlcmRpbmFuZGkgfCBNSVQgTGljZW5zZSB8IGh0dHA6Ly9naXRodWIuY29tL2NmZXJkaW5hbmRpL3Ntb290aC1zY3JvbGwgKi9cbiEoZnVuY3Rpb24oZSx0KXtcImZ1bmN0aW9uXCI9PXR5cGVvZiBkZWZpbmUmJmRlZmluZS5hbWQ/ZGVmaW5lKFtdLChmdW5jdGlvbigpe3JldHVybiB0KGUpfSkpOlwib2JqZWN0XCI9PXR5cGVvZiBleHBvcnRzP21vZHVsZS5leHBvcnRzPXQoZSk6ZS5TbW9vdGhTY3JvbGw9dChlKX0pKFwidW5kZWZpbmVkXCIhPXR5cGVvZiBnbG9iYWw/Z2xvYmFsOlwidW5kZWZpbmVkXCIhPXR5cGVvZiB3aW5kb3c/d2luZG93OnRoaXMsKGZ1bmN0aW9uKGUpe1widXNlIHN0cmljdFwiO3ZhciB0PVwicXVlcnlTZWxlY3RvclwiaW4gZG9jdW1lbnQmJlwiYWRkRXZlbnRMaXN0ZW5lclwiaW4gZSYmXCJyZXF1ZXN0QW5pbWF0aW9uRnJhbWVcImluIGUmJlwiY2xvc2VzdFwiaW4gZS5FbGVtZW50LnByb3RvdHlwZSxuPXtpZ25vcmU6XCJbZGF0YS1zY3JvbGwtaWdub3JlXVwiLGhlYWRlcjpudWxsLHNwZWVkOjUwMCxvZmZzZXQ6MCxlYXNpbmc6XCJlYXNlSW5PdXRDdWJpY1wiLGN1c3RvbUVhc2luZzpudWxsLGJlZm9yZTpmdW5jdGlvbigpe30sYWZ0ZXI6ZnVuY3Rpb24oKXt9fSxvPWZ1bmN0aW9uKCl7Zm9yKHZhciBlPXt9LHQ9MCxuPWFyZ3VtZW50cy5sZW5ndGg7dDxuO3QrKyl7dmFyIG89YXJndW1lbnRzW3RdOyEoZnVuY3Rpb24odCl7Zm9yKHZhciBuIGluIHQpdC5oYXNPd25Qcm9wZXJ0eShuKSYmKGVbbl09dFtuXSl9KShvKX1yZXR1cm4gZX0sYT1mdW5jdGlvbih0KXtyZXR1cm4gcGFyc2VJbnQoZS5nZXRDb21wdXRlZFN0eWxlKHQpLmhlaWdodCwxMCl9LHI9ZnVuY3Rpb24oZSl7XCIjXCI9PT1lLmNoYXJBdCgwKSYmKGU9ZS5zdWJzdHIoMSkpO2Zvcih2YXIgdCxuPVN0cmluZyhlKSxvPW4ubGVuZ3RoLGE9LTEscj1cIlwiLGk9bi5jaGFyQ29kZUF0KDApOysrYTxvOyl7aWYoMD09PSh0PW4uY2hhckNvZGVBdChhKSkpdGhyb3cgbmV3IEludmFsaWRDaGFyYWN0ZXJFcnJvcihcIkludmFsaWQgY2hhcmFjdGVyOiB0aGUgaW5wdXQgY29udGFpbnMgVSswMDAwLlwiKTt0Pj0xJiZ0PD0zMXx8MTI3PT10fHwwPT09YSYmdD49NDgmJnQ8PTU3fHwxPT09YSYmdD49NDgmJnQ8PTU3JiY0NT09PWk/cis9XCJcXFxcXCIrdC50b1N0cmluZygxNikrXCIgXCI6cis9dD49MTI4fHw0NT09PXR8fDk1PT09dHx8dD49NDgmJnQ8PTU3fHx0Pj02NSYmdDw9OTB8fHQ+PTk3JiZ0PD0xMjI/bi5jaGFyQXQoYSk6XCJcXFxcXCIrbi5jaGFyQXQoYSl9cmV0dXJuXCIjXCIrcn0saT1mdW5jdGlvbihlLHQpe3ZhciBuO3JldHVyblwiZWFzZUluUXVhZFwiPT09ZS5lYXNpbmcmJihuPXQqdCksXCJlYXNlT3V0UXVhZFwiPT09ZS5lYXNpbmcmJihuPXQqKDItdCkpLFwiZWFzZUluT3V0UXVhZFwiPT09ZS5lYXNpbmcmJihuPXQ8LjU/Mip0KnQ6KDQtMip0KSp0LTEpLFwiZWFzZUluQ3ViaWNcIj09PWUuZWFzaW5nJiYobj10KnQqdCksXCJlYXNlT3V0Q3ViaWNcIj09PWUuZWFzaW5nJiYobj0tLXQqdCp0KzEpLFwiZWFzZUluT3V0Q3ViaWNcIj09PWUuZWFzaW5nJiYobj10PC41PzQqdCp0KnQ6KHQtMSkqKDIqdC0yKSooMip0LTIpKzEpLFwiZWFzZUluUXVhcnRcIj09PWUuZWFzaW5nJiYobj10KnQqdCp0KSxcImVhc2VPdXRRdWFydFwiPT09ZS5lYXNpbmcmJihuPTEtIC0tdCp0KnQqdCksXCJlYXNlSW5PdXRRdWFydFwiPT09ZS5lYXNpbmcmJihuPXQ8LjU/OCp0KnQqdCp0OjEtOCotLXQqdCp0KnQpLFwiZWFzZUluUXVpbnRcIj09PWUuZWFzaW5nJiYobj10KnQqdCp0KnQpLFwiZWFzZU91dFF1aW50XCI9PT1lLmVhc2luZyYmKG49MSstLXQqdCp0KnQqdCksXCJlYXNlSW5PdXRRdWludFwiPT09ZS5lYXNpbmcmJihuPXQ8LjU/MTYqdCp0KnQqdCp0OjErMTYqLS10KnQqdCp0KnQpLGUuY3VzdG9tRWFzaW5nJiYobj1lLmN1c3RvbUVhc2luZyh0KSksbnx8dH0sdT1mdW5jdGlvbigpe3JldHVybiBNYXRoLm1heChkb2N1bWVudC5ib2R5LnNjcm9sbEhlaWdodCxkb2N1bWVudC5kb2N1bWVudEVsZW1lbnQuc2Nyb2xsSGVpZ2h0LGRvY3VtZW50LmJvZHkub2Zmc2V0SGVpZ2h0LGRvY3VtZW50LmRvY3VtZW50RWxlbWVudC5vZmZzZXRIZWlnaHQsZG9jdW1lbnQuYm9keS5jbGllbnRIZWlnaHQsZG9jdW1lbnQuZG9jdW1lbnRFbGVtZW50LmNsaWVudEhlaWdodCl9LGM9ZnVuY3Rpb24oZSx0LG4pe3ZhciBvPTA7aWYoZS5vZmZzZXRQYXJlbnQpZG97bys9ZS5vZmZzZXRUb3AsZT1lLm9mZnNldFBhcmVudH13aGlsZShlKTtyZXR1cm4gbz1NYXRoLm1heChvLXQtbiwwKX0scz1mdW5jdGlvbihlKXtyZXR1cm4gZT9hKGUpK2Uub2Zmc2V0VG9wOjB9LGw9ZnVuY3Rpb24odCxuLG8pe298fCh0LmZvY3VzKCksZG9jdW1lbnQuYWN0aXZlRWxlbWVudC5pZCE9PXQuaWQmJih0LnNldEF0dHJpYnV0ZShcInRhYmluZGV4XCIsXCItMVwiKSx0LmZvY3VzKCksdC5zdHlsZS5vdXRsaW5lPVwibm9uZVwiKSxlLnNjcm9sbFRvKDAsbikpfSxmPWZ1bmN0aW9uKHQpe3JldHVybiEhKFwibWF0Y2hNZWRpYVwiaW4gZSYmZS5tYXRjaE1lZGlhKFwiKHByZWZlcnMtcmVkdWNlZC1tb3Rpb24pXCIpLm1hdGNoZXMpfTtyZXR1cm4gZnVuY3Rpb24oYSxkKXt2YXIgbSxoLGcscCx2LGIseSxTPXt9O1MuY2FuY2VsU2Nyb2xsPWZ1bmN0aW9uKCl7Y2FuY2VsQW5pbWF0aW9uRnJhbWUoeSl9LFMuYW5pbWF0ZVNjcm9sbD1mdW5jdGlvbih0LGEscil7dmFyIGY9byhtfHxuLHJ8fHt9KSxkPVwiW29iamVjdCBOdW1iZXJdXCI9PT1PYmplY3QucHJvdG90eXBlLnRvU3RyaW5nLmNhbGwodCksaD1kfHwhdC50YWdOYW1lP251bGw6dDtpZihkfHxoKXt2YXIgZz1lLnBhZ2VZT2Zmc2V0O2YuaGVhZGVyJiYhcCYmKHA9ZG9jdW1lbnQucXVlcnlTZWxlY3RvcihmLmhlYWRlcikpLHZ8fCh2PXMocCkpO3ZhciBiLHksRSxJPWQ/dDpjKGgsdixwYXJzZUludChcImZ1bmN0aW9uXCI9PXR5cGVvZiBmLm9mZnNldD9mLm9mZnNldCgpOmYub2Zmc2V0LDEwKSksTz1JLWcsQT11KCksQz0wLHc9ZnVuY3Rpb24obixvKXt2YXIgcj1lLnBhZ2VZT2Zmc2V0O2lmKG49PW98fHI9PW98fChnPG8mJmUuaW5uZXJIZWlnaHQrcik+PUEpcmV0dXJuIFMuY2FuY2VsU2Nyb2xsKCksbCh0LG8sZCksZi5hZnRlcih0LGEpLGI9bnVsbCwhMH0sUT1mdW5jdGlvbih0KXtifHwoYj10KSxDKz10LWIseT1DL3BhcnNlSW50KGYuc3BlZWQsMTApLHk9eT4xPzE6eSxFPWcrTyppKGYseSksZS5zY3JvbGxUbygwLE1hdGguZmxvb3IoRSkpLHcoRSxJKXx8KGUucmVxdWVzdEFuaW1hdGlvbkZyYW1lKFEpLGI9dCl9OzA9PT1lLnBhZ2VZT2Zmc2V0JiZlLnNjcm9sbFRvKDAsMCksZi5iZWZvcmUodCxhKSxTLmNhbmNlbFNjcm9sbCgpLGUucmVxdWVzdEFuaW1hdGlvbkZyYW1lKFEpfX07dmFyIEU9ZnVuY3Rpb24oZSl7aCYmKGguaWQ9aC5nZXRBdHRyaWJ1dGUoXCJkYXRhLXNjcm9sbC1pZFwiKSxTLmFuaW1hdGVTY3JvbGwoaCxnKSxoPW51bGwsZz1udWxsKX0sST1mdW5jdGlvbih0KXtpZighZigpJiYwPT09dC5idXR0b24mJiF0Lm1ldGFLZXkmJiF0LmN0cmxLZXkmJihnPXQudGFyZ2V0LmNsb3Nlc3QoYSkpJiZcImFcIj09PWcudGFnTmFtZS50b0xvd2VyQ2FzZSgpJiYhdC50YXJnZXQuY2xvc2VzdChtLmlnbm9yZSkmJmcuaG9zdG5hbWU9PT1lLmxvY2F0aW9uLmhvc3RuYW1lJiZnLnBhdGhuYW1lPT09ZS5sb2NhdGlvbi5wYXRobmFtZSYmLyMvLnRlc3QoZy5ocmVmKSl7dmFyIG47dHJ5e249cihkZWNvZGVVUklDb21wb25lbnQoZy5oYXNoKSl9Y2F0Y2goZSl7bj1yKGcuaGFzaCl9aWYoXCIjXCI9PT1uKXt0LnByZXZlbnREZWZhdWx0KCksaD1kb2N1bWVudC5ib2R5O3ZhciBvPWguaWQ/aC5pZDpcInNtb290aC1zY3JvbGwtdG9wXCI7cmV0dXJuIGguc2V0QXR0cmlidXRlKFwiZGF0YS1zY3JvbGwtaWRcIixvKSxoLmlkPVwiXCIsdm9pZChlLmxvY2F0aW9uLmhhc2guc3Vic3RyaW5nKDEpPT09bz9FKCk6ZS5sb2NhdGlvbi5oYXNoPW8pfWg9ZG9jdW1lbnQucXVlcnlTZWxlY3RvcihuKSxoJiYoaC5zZXRBdHRyaWJ1dGUoXCJkYXRhLXNjcm9sbC1pZFwiLGguaWQpLGguaWQ9XCJcIixnLmhhc2g9PT1lLmxvY2F0aW9uLmhhc2gmJih0LnByZXZlbnREZWZhdWx0KCksRSgpKSl9fSxPPWZ1bmN0aW9uKGUpe2J8fChiPXNldFRpbWVvdXQoKGZ1bmN0aW9uKCl7Yj1udWxsLHY9cyhwKX0pLDY2KSl9O3JldHVybiBTLmRlc3Ryb3k9ZnVuY3Rpb24oKXttJiYoZG9jdW1lbnQucmVtb3ZlRXZlbnRMaXN0ZW5lcihcImNsaWNrXCIsSSwhMSksZS5yZW1vdmVFdmVudExpc3RlbmVyKFwicmVzaXplXCIsTywhMSksUy5jYW5jZWxTY3JvbGwoKSxtPW51bGwsaD1udWxsLGc9bnVsbCxwPW51bGwsdj1udWxsLGI9bnVsbCx5PW51bGwpfSxTLmluaXQ9ZnVuY3Rpb24oYSl7dCYmKFMuZGVzdHJveSgpLG09byhuLGF8fHt9KSxwPW0uaGVhZGVyP2RvY3VtZW50LnF1ZXJ5U2VsZWN0b3IobS5oZWFkZXIpOm51bGwsdj1zKHApLGRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoXCJjbGlja1wiLEksITEpLGUuYWRkRXZlbnRMaXN0ZW5lcihcImhhc2hjaGFuZ2VcIixFLCExKSxwJiZlLmFkZEV2ZW50TGlzdGVuZXIoXCJyZXNpemVcIixPLCExKSl9LFMuaW5pdChkKSxTfX0pKTtcblxuXG4vLy8vLy8vLy8vLy8vLy8vLy9cbi8vIFdFQlBBQ0sgRk9PVEVSXG4vLyAuL25vZGVfbW9kdWxlcy9zbW9vdGgtc2Nyb2xsL2Rpc3QvanMvc21vb3RoLXNjcm9sbC5taW4uanNcbi8vIG1vZHVsZSBpZCA9IC4vbm9kZV9tb2R1bGVzL3Ntb290aC1zY3JvbGwvZGlzdC9qcy9zbW9vdGgtc2Nyb2xsLm1pbi5qc1xuLy8gbW9kdWxlIGNodW5rcyA9IDAiLCJ2YXIgZztcclxuXHJcbi8vIFRoaXMgd29ya3MgaW4gbm9uLXN0cmljdCBtb2RlXHJcbmcgPSAoZnVuY3Rpb24oKSB7XHJcblx0cmV0dXJuIHRoaXM7XHJcbn0pKCk7XHJcblxyXG50cnkge1xyXG5cdC8vIFRoaXMgd29ya3MgaWYgZXZhbCBpcyBhbGxvd2VkIChzZWUgQ1NQKVxyXG5cdGcgPSBnIHx8IEZ1bmN0aW9uKFwicmV0dXJuIHRoaXNcIikoKSB8fCAoMSxldmFsKShcInRoaXNcIik7XHJcbn0gY2F0Y2goZSkge1xyXG5cdC8vIFRoaXMgd29ya3MgaWYgdGhlIHdpbmRvdyByZWZlcmVuY2UgaXMgYXZhaWxhYmxlXHJcblx0aWYodHlwZW9mIHdpbmRvdyA9PT0gXCJvYmplY3RcIilcclxuXHRcdGcgPSB3aW5kb3c7XHJcbn1cclxuXHJcbi8vIGcgY2FuIHN0aWxsIGJlIHVuZGVmaW5lZCwgYnV0IG5vdGhpbmcgdG8gZG8gYWJvdXQgaXQuLi5cclxuLy8gV2UgcmV0dXJuIHVuZGVmaW5lZCwgaW5zdGVhZCBvZiBub3RoaW5nIGhlcmUsIHNvIGl0J3NcclxuLy8gZWFzaWVyIHRvIGhhbmRsZSB0aGlzIGNhc2UuIGlmKCFnbG9iYWwpIHsgLi4ufVxyXG5cclxubW9kdWxlLmV4cG9ydHMgPSBnO1xyXG5cblxuXG4vLy8vLy8vLy8vLy8vLy8vLy9cbi8vIFdFQlBBQ0sgRk9PVEVSXG4vLyAod2VicGFjaykvYnVpbGRpbi9nbG9iYWwuanNcbi8vIG1vZHVsZSBpZCA9IC4vbm9kZV9tb2R1bGVzL3dlYnBhY2svYnVpbGRpbi9nbG9iYWwuanNcbi8vIG1vZHVsZSBjaHVua3MgPSAwIl0sInNvdXJjZVJvb3QiOiIifQ==