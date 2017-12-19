const FeaturesNavBar = require('./features-navbar');
const FeaturesScrollSpy = require('./features-scrollspy');
const ScrollTo = require('./scroll-to');

class Features {
    constructor (navBarElement, landingStripElement, scrollSpyOffset, scrollOffset, affixOffset) {
        this.navbar = new FeaturesNavBar(navBarElement, landingStripElement, scrollOffset, affixOffset);
        this.scrollspy = new FeaturesScrollSpy(this.navbar, scrollSpyOffset);
        this.navbar.affix();
        this.scrollspy.spy();

        if (window.location.hash) {
            const target = document.getElementById(window.location.hash.replace('#', ''));

            if (target) {
                ScrollTo.scrollTo(target, scrollOffset);
            }
        }
    }

    setScrollOffset (scrollOffset) {
        this.navbar.setScrollOffset(scrollOffset);
    }

    setAffixOffset (affixOffset) {
        this.navbar.setAffixOffset(affixOffset);
    }
}

module.exports = Features;
