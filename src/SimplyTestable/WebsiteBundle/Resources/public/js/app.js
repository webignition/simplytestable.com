$(document).ready(function() {  
    
    $('body.homepage .carousel').carousel('pause');
    
    $('body.roadmap .timeline').each(function () {
        var futureEvents = [];
        var pastEvents = [];
        var currentEvents = [];
        var now = new Date();        
        
        var isToday = function (eventTime) {
            if (eventTime.getDate() != now.getDate()) {
                return false;
            }
            
            if (eventTime.getDay() != now.getDay()) {
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
        
        $('.event', this).each(function () {
            var event = $(this);
            var eventTime = new Date($('time', event).attr('datetime'));
            
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
            
            time.after('<span class="indicator"><i class="icon-star highlighted"></i><i class="icon-star-empty"></i></div>');
        });        
        
        $('.past', this).each(function () {
            var event = $(this);
            var time = $('time', event);
            
            time.after('<span class="indicator"><i class="icon-ok highlighted"></i></div>');
        });        
        
        $('.future', this).each(function () {
            var event = $(this);
            var time = $('time', event);
            
            time.after('<span class="indicator"><i class="icon-off highlighted"></i></div>');
        });        
    }); 
    
    getTwitters('tweet', { 
        id: 'simplytestable', 
        count: 1, 
        enableLinks: true, 
        ignoreReplies: true, 
        clearContents: true,
        template: '%text% <a class="time" href="http://twitter.com/%user_screen_name%/statuses/%id_str%/">%time%</a>',
        callback: function () {
            $('#tweet').html(
                $('#tweet ul li').html()
            );
            
            $('#tweet').animate({
                'opacity':1
            });
        }
    });    
});