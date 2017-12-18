const ScrollTo = require('./scroll-to');

class FeaturesNavBarItem {
    /**
     * @param {HTMLElement} element
     * @param {number} scrollOffset
     */
    constructor (element, scrollOffset) {
        this.element = element;
        this.scrollOffset = scrollOffset;

        let anchor = this.element.getElementsByTagName('a')[0];
        let href = anchor.getAttribute('href');

        this.targetId = href.replace('#', '');

        this.element.addEventListener('click', this.handleClick.bind(this));
    };

    handleClick (event) {
        event.stopPropagation();
        event.preventDefault();

        let eventTargetValue = event.target.dataset.target;
        let target = this.getTarget();

        if (eventTargetValue) {
            target = document.getElementById(eventTargetValue.replace('#', ''));
        }

        ScrollTo.scrollTo(target, this.scrollOffset);
    }

    getTarget () {
        return document.getElementById(this.targetId);
    }

    isForTarget (targetId) {
        return this.targetId === targetId;
    }

    setActive () {
        this.element.classList.add('active');
    }

    setInactive () {
        this.element.classList.remove('active');
    }

    setScrollOffset (scrollOffset) {
        this.scrollOffset = scrollOffset;
    }
}

module.exports = FeaturesNavBarItem;
