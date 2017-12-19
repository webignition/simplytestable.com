const NavBarItem = require('./features-navbar-item');

class FeaturesNavBar {
    /**
     * @param {HTMLElement} navBarElement
     * @param {HTMLElement} landingStripElement
     * @param {number} scrollOffset
     * @param {number} affixOffset
     */
    constructor (navBarElement, landingStripElement, scrollOffset, affixOffset) {
        this.navBarElement = navBarElement;
        this.landingStripElement = landingStripElement;
        this.affixOffset = affixOffset;
        this.navBarItems = [];

        let liElements = this.navBarElement.getElementsByTagName('li');

        for (let i = 0; i < liElements.length; i++) {
            this.navBarItems.push(new NavBarItem(liElements[i], scrollOffset));
        }

        window.addEventListener('scroll', this.affix.bind(this), true);
    };

    affix () {
        const navBarBoundingRect = this.navBarElement.getBoundingClientRect();
        const navBarTop = navBarBoundingRect.top;
        const navBarBottom = navBarBoundingRect.bottom;

        if (navBarTop < this.affixOffset) {
            this.navBarElement.classList.add('affix');
        }

        const landingStripBoundingRect = this.landingStripElement.getBoundingClientRect();
        const landingStripBottom = landingStripBoundingRect.bottom;

        if (landingStripBottom > navBarBottom) {
            this.navBarElement.classList.remove('affix');
        }
    };

    getLinkTargets () {
        let linkTargets = [];

        for (let i = 0; i < this.navBarItems.length; i++) {
            linkTargets.push(this.navBarItems[i].getTarget());
        }

        return linkTargets;
    }

    setActive (linkTargetId) {
        for (let i = 0; i < this.navBarItems.length; i++) {
            let navBarItem = this.navBarItems[i];

            if (navBarItem.isForTarget(linkTargetId)) {
                navBarItem.setActive();
            } else {
                navBarItem.setInactive();
            }
        }
    }

    setScrollOffset (scrollOffset) {
        for (let i = 0; i < this.navBarItems.length; i++) {
            /** @type {FeaturesNavBarItem} */
            let navBarItem = this.navBarItems[i];

            navBarItem.setScrollOffset(scrollOffset);
        }
    }

    setAffixOffset (affixOffset) {
        this.affixOffset = affixOffset;
    }
}

module.exports = FeaturesNavBar;
