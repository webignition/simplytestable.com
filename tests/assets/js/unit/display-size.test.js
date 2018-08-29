const test = require('tape');
const jsdom = require('jsdom');
const { JSDOM } = jsdom;
const breakpoints = require('../../../../assets/js/breakpoints');
const deriveDataProvider = require('../fixtures/display-size.derive.dataprovider');
const setGetDataProvider = require('../fixtures/display-size.setget.dataprovider');
const htmlFixture = require('../fixtures/empty-document-with-empty-script.html');

const createMatchMediaMock = function (matchesData) {
    let mediaQueryMatches = {};

    Object.keys(matchesData).forEach(function (key) {
        let matches = matchesData[key];
        let mediaQuery = breakpoints[key];

        mediaQueryMatches[mediaQuery] = matches;
    });

    return function (mediaQuery) {
        return {
            'matches': mediaQueryMatches[mediaQuery]
        };
    };
};

test('DisplaySize.derive()', function (assert) {
    let dom = new JSDOM(htmlFixture);

    global.window = dom.window;
    global.document = window.document;

    let DisplaySize = require('../../../../assets/js/display-size');

    Object.keys(deriveDataProvider).forEach(function (key) {
        let fixtureData = deriveDataProvider[key];

        window.matchMedia = createMatchMediaMock(fixtureData.matchMediaMatches);

        let displaySize = new DisplaySize(global.window);
        let displaySizeName = displaySize.derive();

        assert.equals(
            displaySizeName,
            fixtureData.expectedDisplaySizeName,
            'displaySizeName is ' + fixtureData.expectedDisplaySizeName
        );
    });

    assert.end();
});

test('DisplaySize.set(), DisplaySize.get()', function (assert) {
    let dom = new JSDOM(htmlFixture);

    global.window = dom.window;
    global.document = window.document;

    let DisplaySize = require('../../../../assets/js/display-size');

    Object.keys(setGetDataProvider).forEach(function (key) {
        let fixtureData = setGetDataProvider[key];

        let displaySize = new DisplaySize(global.window);
        displaySize.set(fixtureData.set);

        assert.equals(
            displaySize.get(),
            fixtureData.expectedDisplaySizeName,
            'displaySizeName is ' + fixtureData.expectedDisplaySizeName
        );
    });

    assert.end();
});
