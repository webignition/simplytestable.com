$(document).ready(function() {       
    if ($('body.homepage').length) {
        var updateRecentTests = function (data) {
            var isRemoving = false;

            var container = $('#recent-site-tests-list');
            var sourceTestList = $('.site', container);
            var updatedTestList = $('.site', data);
            
            var updatedTestListContains = function (testId) {                
                var contains = false;
                
                updatedTestList.each(function () {                    
                    if ($(this).attr('data-test-id') === testId) {
                        contains = true;
                    }
                });
                
                return contains;
            };
            
            var sourceTestListContains = function (testId) {
                var contains = false;
                
                sourceTestList.each(function () {                    
                    if ($(this).attr('data-test-id') === testId) {
                        contains = true;
                    }
                });
                
                return contains;                
            };
            
            var removeSite = function (site) {
                isRemoving = true;
                
                site.animate({
                    'opacity':0
                }, function () {
                    site.remove();
                    isRemoving = false;
                });
            }; 
            
            var addSite = function (site) {
                if (isRemoving === true) {
                    window.setTimeout(function () {
                        addSite(site);
                    }, 100);
                    return;
                }
                
                site.css({
                    'opacity':0
                });
                
                container.append(site);                
                
                site.css({
                    'margin-left':0
                });
                
                site.remove();
                
                container.prepend(site);
                site.animate({
                    'opacity':'1'
                });
            };
            
            var replaceInProgressSiteWithFinishedSite = function (inProgressSite, finishedSite) {
                finishedSite.css('opacity', 0);
                inProgressSite.animate({
                    'opacity':0
                }, function () {
                    inProgressSite.replaceWith(finishedSite);
                    finishedSite.animate({
                        'opacity':1
                    });
                });                 
            };
            
            var updateInProgressSite = function (inDocSite, site) {
                var completionPercent = $('.progress', site).attr('data-completion-percent');
                
                $('.queued', inDocSite).text($('.queued', site).text());
                $('.in-progress', inDocSite).text($('.in-progress', site).text());
                $('.finished', inDocSite).text($('.finished', site).text());
                
                $('.progress .progress-bar').css({
                    'width':completionPercent + '%'
                });
            };
            
            sourceTestList.each(function () {
                var site = $(this);                
                if (!updatedTestListContains(site.attr('data-test-id'))) {
                    removeSite(site);
                }
            });
            
            $('.site', data).each(function () {
                var site = $(this);
                
                if (!sourceTestListContains(site.attr('data-test-id'))) {
                    addSite(site);
                } else {
                    var inDocSite = $('[data-test-id='+site.attr('data-test-id')+']', container);
                    
                    var inDocSiteInProgress = $('.job-in-progress', inDocSite).length === 1;
                    var siteInProgress = $('.job-in-progress', site).length === 1;
                    var inDocSiteFinished = $('.job-finished', inDocSite).length === 1;
                    var siteFinished = $('.job-finished', site).length === 1;
                    
                    if (inDocSiteInProgress && siteFinished) {
                       replaceInProgressSiteWithFinishedSite(inDocSite, site);
                    }
                    
                    if (inDocSiteInProgress && siteInProgress) {
                        updateInProgressSite(inDocSite, site);
                    }
                }
            });
        };
        
        var requestRecentTestData = function () {
            var url = window.location.href + 'recent-test-list/';            
            $.get(url, function(data) {                
                window.setTimeout(function () {
                    requestRecentTestData();
                }, 3000);
                
                updateRecentTests(data);
            }, "html");               
        };
        
        requestRecentTestData();
        
        var a = document.body, e = document.documentElement;

        $(window).unbind("scroll").scroll(function () {                        
            var offset = (Math.max(e.scrollTop, a.scrollTop)) / 4;
            var updated = offset * -1;

            
            $('#landing-strip').css({
                'background-position-y':updated + 'px'
            });
        });        
    }   
    
    
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
            
            time.after('<span class="indicator"><i class="fa fa-star highlighted"></i><i class="fa fa-star-o"></i></span>');
        });        
        
        $('.past', this).each(function () {
            var event = $(this);
            var time = $('time', event);
            
            time.after('<span class="indicator"><i class="fa fa-check highlighted"></i></span>');
        });        
        
        $('.future', this).each(function () {
            var event = $(this);
            var time = $('time', event);
            
            time.after('<span class="indicator"><i class="fa fa-circle-o highlighted"></i></span>');
        });
        
        $('.past.next', this).each(function () {
            var event = $(this);
            var time = $('time', event);
            
            $('.indicator', event).remove();
            time.after('<span class="indicator"><i class="fa fa-star highlighted"></i><i class="fa fa-star-o"></i></span>');
        });
        
        
    });
});