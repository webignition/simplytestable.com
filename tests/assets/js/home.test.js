const test = require('tape');
const jsdom = require('jsdom');
const { JSDOM } = jsdom;
const home = require('../../../assets/js/home');

const landingStripFixture = `<!DOCTYPE html>
                <html>
                    <head></head>
                    <body>
                        <div id="landing-strip"></div>
                    </body>
                </html>`;

const callHomeFunction = function (scrollTop) {
    var dom = new JSDOM(landingStripFixture);

    var document = dom.window.document;
    var landingStrip = document.getElementById('landing-strip');

    document.documentElement.scrollTop = scrollTop;

    home(document, 'click');

    var event = document.createEvent('MouseEvent');
    event.initMouseEvent('click');
    document.dispatchEvent(event);

    return landingStrip.style.backgroundPositionY;
};

test('landing strip background image placement test', function (assert) {
    const dataProvider = [
        {
            'scrollTop': -100,
            'expectedBackgroundPositionY': '-310px'
        },
        {
            'scrollTop': 0,
            'expectedBackgroundPositionY': '-310px'
        },
        {
            'scrollTop': 100,
            'expectedBackgroundPositionY': '-335px'
        }
    ];

    dataProvider.forEach(function (fixture) {
        const landingStripeBackgroundPositionY = callHomeFunction(fixture.scrollTop);

        assert.equals(
            landingStripeBackgroundPositionY,
            fixture.expectedBackgroundPositionY,
            '#landing-strip backgroundPositionY is -360px'
        );
    });

    assert.end();
});