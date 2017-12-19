const test = require('tape');
const jsdom = require('jsdom');
const { JSDOM } = jsdom;
const home = require('../../../assets/js/home');
const dataProvider = require('./home.dataprovider');

const landingStripFixture = `<!DOCTYPE html>
                <html>
                    <head></head>
                    <body>
                        <div id="landing-strip"></div>
                    </body>
                </html>`;

const callHomeFunction = function (scrollTop) {
    const dom = new JSDOM(landingStripFixture);
    const document = dom.window.document;
    const landingStrip = document.getElementById('landing-strip');

    document.documentElement.scrollTop = scrollTop;

    home(document, 'click');

    const event = document.createEvent('MouseEvent');
    event.initMouseEvent('click');
    document.dispatchEvent(event);

    return landingStrip.style.backgroundPositionY;
};

test('landing strip background image placement test', function (assert) {
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
