class Home {
    /**
     * @param {Document} document
     * @param {string} eventName
     */
    constructor (document, eventName) {
        this.document = document;
        this.eventName = eventName;
        this.initialOffset = 310;
        this.landingStrip = document.getElementById('landing-strip');
    }

    init () {
        this.document.addEventListener(this.eventName, () => {
            let offset = (Math.max(this.document.documentElement.scrollTop, this.document.body.scrollTop)) / 4;
            let updated = offset * -1 - this.initialOffset;

            this.landingStrip.style.backgroundPositionY = updated + 'px';
        });
    };
}

module.exports = Home;
