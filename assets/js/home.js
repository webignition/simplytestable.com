module.exports = function (document, eventName) {
    const initialOffset = 310;
    const landingStrip = document.getElementById('landing-strip');

    document.addEventListener(eventName, function () {
        let offset = (Math.max(document.documentElement.scrollTop, document.body.scrollTop)) / 4;
        let updated = offset * -1 - initialOffset;

        landingStrip.style.backgroundPositionY = updated + 'px';
    });
};
