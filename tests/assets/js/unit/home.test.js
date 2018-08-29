const test = require('tape');
const jsdom = require('jsdom');
const { JSDOM } = jsdom;
const Home = require('../../../../assets/js/page/home');
const dataProvider = require('../fixtures/home.dataprovider');
const landingStripFixture = require('../fixtures/landing-strip.html');

const callHomeFunction = function (scrollTop) {
    const dom = new JSDOM(landingStripFixture);
    const document = dom.window.document;
    const landingStrip = document.getElementById('landing-strip');

    document.documentElement.scrollTop = scrollTop;
    const home = new Home(document, 'click');
    home.init();

    const event = document.createEvent('MouseEvent');
    event.initMouseEvent('click');
    document.dispatchEvent(event);

    return landingStrip.style.backgroundPositionY;
};

test('home landing strip background image placement test', function (assert) {
    dataProvider.forEach(function (fixture) {
        const landingStripeBackgroundPositionY = callHomeFunction(fixture.scrollTop);

        assert.equals(
            landingStripeBackgroundPositionY,
            fixture.expectedBackgroundPositionY,
            '#landing-strip backgroundPositionY is ' + fixture.expectedBackgroundPositionY
        );
    });

    assert.end();
});
