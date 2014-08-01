$(function() {
    $('a[href*=#]:not([href=#])').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');

            var hashValue = this.hash.slice(1);

            if (target.length) {
                var offset = $('body').is('.upper-nav-affix') ? 300 : 298;

                $('html,body').animate({
                    scrollTop: (target.offset().top) - offset
                }, 400, function () {
                    window.location.hash = hashValue;
                });

                return false;
            }
        }
    });

    if ($(window.location.hash).length) {
        var target = $(window.location.hash);

        if (target.length) {
            $('html,body').animate({
                scrollTop: (target.offset().top) - 300
            }, 400);
        }
    }

    $('#upper-nav').on('affix.bs.affix', function (event) {
        $('body').addClass('upper-nav-affix').removeClass('upper-nav-affix-top');
    }).on('affix-top.bs.affix', function (event) {
        $('body').removeClass('upper-nav-affix').addClass('upper-nav-affix-top');
    });


    $('#upper-nav-fundamental-testing em').click(function () {
        var hashValue = $(this).attr('data-target');
        var target = $(hashValue);

        if (target.length) {
            var offset = $('body').is('.upper-nav-affix') ? 300 : 298;

            $('html,body').animate({
                scrollTop: (target.offset().top) - offset
            }, 400, function () {
                window.location.hash = hashValue.slice(1);
            });

            return false;
        }
    });
});