module.exports = function () {
    const initialOffset = 310;
    const landingStrip = document.getElementById('landing-strip');

    document.body.onscroll = function () {
        let offset = (Math.max(document.documentElement.scrollTop, document.body.scrollTop)) / 4;
        let updated = offset * -1 - initialOffset;

        landingStrip.style.backgroundPositionY = updated + 'px';
    };
};
