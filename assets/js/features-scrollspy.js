class FeaturesScrollSpy {
    /**
     * @param {FeaturesNavBar} navbar
     * @param {number} offset
     */
    constructor (navbar, offset) {
        this.navbar = navbar;
        this.offset = offset;
    }

    scrollEventListener () {
        let activeLinkTarget = null;
        let linkTargets = this.navbar.getLinkTargets();
        let offset = this.offset;

        linkTargets.forEach(function (linkTarget, index) {
            if (!activeLinkTarget) {
                let bottom = linkTarget.getBoundingClientRect().bottom;

                if (bottom > offset || index === linkTargets.length - 1) {
                    activeLinkTarget = linkTarget;
                }
            }
        });

        this.navbar.setActive(activeLinkTarget.getAttribute('id'));
    }

    spy () {
        window.addEventListener(
            'scroll',
            this.scrollEventListener.bind(this),
            true
        );
    }
}

module.exports = FeaturesScrollSpy;
