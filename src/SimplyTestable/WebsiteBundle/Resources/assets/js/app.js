$(document).ready(function() {
    if ($('body.home-index').length) {
        var a = document.body, e = document.documentElement;

        $(window).unbind("scroll").scroll(function () {
            var offset = (Math.max(e.scrollTop, a.scrollTop)) / 4;
            var updated = offset * -1;


            $('#landing-strip').css({
                'background-position-y':updated + 'px'
            });
        });
    }
});
