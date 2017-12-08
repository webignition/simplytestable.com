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

    $('body.roadmap .timeline').each(function () {
        var futureEvents = [];
        var pastEvents = [];
        var currentEvents = [];
        var now = new Date();

        var isToday = function (eventTime) {
            if (eventTime.getDate() != now.getDate()) {
                return false;
            }

            if (eventTime.getMonth() != now.getMonth()) {
                return false;
            }

            if (eventTime.getFullYear() != now.getFullYear()) {
                return false;
            }

            return true;
        };

        var isFuture = function (eventTime) {
            return eventTime.getTime() > now.getTime();
        };

        var parseEventTimeParts = function (timeAttribute) {
            var monthPart = timeAttribute.substring(5, 7);
            if (monthPart.length == 2 && monthPart.substr(0, 1) == 0) {
                monthPart = monthPart.substr(1, 1);
            }

            var dayPart = timeAttribute.substring(8, 10);
            if (dayPart.length == 2 && dayPart.substr(0, 1) == 0) {
                dayPart = dayPart.substr(1, 1);
            }

            return {
                'year':parseInt(timeAttribute.substring(0, 4), 10),
                'month':parseInt(monthPart, 10) - 1,
                'day':parseInt(dayPart, 10)
            }
        };

        $('.event', this).each(function () {
            var event = $(this);
            var eventTimeParts = parseEventTimeParts($('time', event).attr('datetime'));
            var eventTime = new Date(eventTimeParts.year, eventTimeParts.month, eventTimeParts.day);

            if (isToday(eventTime)) {
                currentEvents.push(event);
                event.addClass('next');
            } else if (isFuture(eventTime)) {
                futureEvents.push(event);
                event.addClass('future');
            } else {
                pastEvents.push(event);
                event.addClass('past');
            }
        });

        if (currentEvents.length === 0) {
            if (futureEvents.length > 0) {
                futureEvents[futureEvents.length - 1].removeClass('future').addClass('next');
            } else if (pastEvents.length > 0) {
                pastEvents[0].removeClass('future').addClass('next');
            }
        }

        $('.next', this).each(function () {
            var event = $(this);
            var time = $('time', event);

            time.after('<span class="indicator hidden-xs"><i class="fa fa-star highlighted"></i><i class="fa fa-star-o"></i></span>');
        });

        $('.past', this).each(function () {
            var event = $(this);
            var time = $('time', event);

            time.after('<span class="indicator hidden-xs"><i class="fa fa-check highlighted"></i></span>');
        });

        $('.future', this).each(function () {
            var event = $(this);
            var time = $('time', event);

            time.after('<span class="indicator hidden-xs"><i class="fa fa-circle-o highlighted"></i></span>');
        });

        $('.past.next', this).each(function () {
            var event = $(this);
            var time = $('time', event);

            $('.indicator', event).remove();
            time.after('<span class="indicator hidden-xs"><i class="fa fa-star highlighted"></i><i class="fa fa-star-o"></i></span>');
        });


    });
});