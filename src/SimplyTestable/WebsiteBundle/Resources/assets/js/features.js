$(function() {
    var displayClasses = ['lg', 'md', 'sm', 'xs'];

    var deriveDisplaySizeClass = function () {
        for (var classIndex = 0; classIndex < displayClasses.length; classIndex++) {
            var current = $('#' + displayClasses[classIndex]);
            if (current.css('display') !== 'none') {
                return displayClasses[classIndex];
            }
        }
    };

    $('body').addClass('display-' + deriveDisplaySizeClass()).attr('data-display-class', deriveDisplaySizeClass().replace('display-', ''));

    $(window).on('resize', function () {
        var body = $('body');

        for (var classIndex = 0; classIndex < displayClasses.length; classIndex++) {
            body.removeClass('display-' + displayClasses[classIndex]).addClass('display-' + deriveDisplaySizeClass());
        }

        body.attr('data-display-class', deriveDisplaySizeClass().replace('display-', ''));
    });

    var getDisplayClass = function () {
        return $('body').attr('data-display-class');
    };

    var getScrollOffset = function () {
        var offsets = {
            'upper-nav-affix': {
                'lg': 300,
                'md': 300,
                'sm': 200,
                'xs': 300
            },
            'default': {
                'lg': 298,
                'md': 298,
                'sm': 198,
                'xs': 298
            }
        };

        var offsetGroup = $('body').is('.upper-nav-affix') ? offsets['upper-nav-affix'] : offsets['default'];
        var offset =  offsetGroup[getDisplayClass()];

//        var offset = 12;
//
//        console.log(offset);
//
//
//
//        //offset = offset - 100;

        return offset;
    };

    var getAffixOffset = function () {
        var offsets = {
            'lg': 278,
            'md': 278,
            'sm': 238,
            'xs': 278
        };

        return offsets[getDisplayClass()];
    };


    $('a[href*=#]:not([href=#])').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');

            var hashValue = this.hash.slice(1);

            if (target.length) {
                var offset = getScrollOffset();

                $('html,body').animate({
                    scrollTop: (target.offset().top) - offset
                }, 400, function () {
                    if($('body').is('.IE8')) {

                    } else {
                        window.location.hash = hashValue;
                    }
                });

                return false;
            }
        }
    });

    if ($(window.location.hash).length) {
        var target = $(window.location.hash);

        if (target.length) {
            $('html,body').animate({
                scrollTop: (target.offset().top) - getScrollOffset()
            }, 400);
        }
    }

    var mostRecentlyClicked = null;

    $('#upper-nav').on('affix.bs.affix', function (event) {
        $('body').addClass('upper-nav-affix').removeClass('upper-nav-affix-top');
    }).on('affix-top.bs.affix', function (event) {
        $('body').removeClass('upper-nav-affix').addClass('upper-nav-affix-top');
    }).on('activate.bs.scrollspy', function (event) {
        if (mostRecentlyClicked == null) {
            return false;
        }

        var target = $(event.target);

        if (target.attr('id') === mostRecentlyClicked.attr('id')) {
            mostRecentlyClicked = null;
        } else {
            target.removeClass('active');
        }

        return true;
    });


    $('#upper-nav a').click(function (event) {
        var targetListItem = $(this).closest('li');
        if (targetListItem.is('.active')) {
            return false;
        }

        $('#upper-nav li').removeClass('active');
        mostRecentlyClicked = targetListItem;

        return false;
    });


    $('#upper-nav-fundamental-testing em').click(function () {
        var hashValue = $(this).attr('data-target');
        var target = $(hashValue);

        if (target.length) {
            $(this).closest('li').addClass('selected');

            var offset = $('body').is('.upper-nav-affix') ? 300 : 298;

            $('html,body').animate({
                scrollTop: (target.offset().top) - offset
            }, 400, function () {
                window.location.hash = hashValue.slice(1);
            });

            return false;
        }
    });

    $('#upper-nav').affix({
        offset: {
            top: getAffixOffset()
        }
    });

    $('body').scrollspy({
        target: '#upper-nav',
        offset: 340
    })
});