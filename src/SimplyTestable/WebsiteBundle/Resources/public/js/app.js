$(document).ready(function() {       
    if ($('body.homepage').length) {
        var taskFinishedStates = [
            'cancelled',
            'completed',
            'failed-no-retry-available',
            'failed-retry-available',
            'failed-retry-limit-reached',
            'skipped',
            'no-sitemap'
        ]; 

        var queuedStates = [
            'queued-for-assignment',
            'queued'            
        ];
        
        var getOutputDomainFromWebsiteUrl = function (websiteUrl) {
            var outputDomain = websiteUrl.replace('http://', '').replace('https://', '')
            
            if (outputDomain.charAt(outputDomain.length - 1) == '/') {
                outputDomain = outputDomain.substr(0, outputDomain.length - 1);
            }
            
            return outputDomain;
        };
        
        var isFinishedState = function (stateName) {
            for (var stateIndex = 0; stateIndex < taskFinishedStates.length; stateIndex++) {
                if (stateName == taskFinishedStates[stateIndex]) {
                    return true;
                }
            }
            
            return false;
        };
        
        var getFinishedTaskCount = function(taskCountByState) {
            var finishedTaskCount = 0;
            
            for (var stateName in taskCountByState) {
                if (taskCountByState.hasOwnProperty(stateName)) {
                    if (isFinishedState(stateName)) {
                        finishedTaskCount += taskCountByState[stateName];
                    }
                }
            }
            
            return finishedTaskCount;
        };
     
        var getQueuedTaskCount = function (taskCountByState) {            
            var queuedTaskCount = 0;
            
            for (var stateIndex = 0; stateIndex < queuedStates.length; stateIndex++) {
                if (taskCountByState[queuedStates[stateIndex]] != undefined) {
                    queuedTaskCount += taskCountByState[queuedStates[stateIndex]];
                }
            }
            
            return queuedTaskCount;
        };   
        
        var getCompletionPercent = function (remoteTestSummary) {
            if (isFinishedState(remoteTestSummary.state)) {
                return 100;
            }

            if (remoteTestSummary.task_count === 0) {
                return 0;
            }
            
            var finishedCount = getFinishedTaskCount(remoteTestSummary.task_count_by_state);
            
            if (finishedCount == remoteTestSummary.task_count) {
                return 100;
            }
            
            var requiredPrecision = Math.floor(Math.log(remoteTestSummary.task_count) / Math.log(10)) - 1;
            
            if (requiredPrecision == 0) {
                return Math.floor((finishedCount / remoteTestSummary.task_count) * 100);
            }
            
            if (requiredPrecision > 2) {
                requiredPrecision = 2;
            }
            
            if (requiredPrecision < 1) {
                requiredPrecision = 1;
            }

            return ((finishedCount / remoteTestSummary.task_count) * 100).toPrecision(requiredPrecision + 1);
        };
        
        var getStateIcon = function (state) {
            if (state == 'new') {
                return 'icon-off';
            }
            
            if (state == 'queued') {
                return 'icon-off';
            }
            
            if (state == 'preparing') {
                return 'icon-cog';
            }
            
            if (state == 'in-progress') {
                return 'icon-play-circle';
            }

            if (state == 'completed') {                
                return 'icon-bar-chart';
            }
            
            if (state == 'cancelled') {
                return 'icon-bar-chart';
            }
        };
        
        var getStateLabelClass = function (state) {
            if (state == 'new') {
                return '';
            }
            
            if (state == 'queued') {
                return 'info';
            }
            
            if (state == 'preparing') {
                return 'warning';
            }
            
            if (state == 'in-progress') {
                return 'warning';
            }

            if (state == 'completed') {                
                return 'success';
            }
            
            if (state == 'cancelled') {
                return 'success';
            }
        };        
        
        var updateRecentTests = function (data) {
           var recentSiteTestsList = $('#recent-site-tests-list');
           recentSiteTestsList.html('');
            
            $(data).each(function () { 
                var maximumStandardDigitLength = 4;
                var standardDigitSize = 40;
                var taskCount = this.task_count;

                var taskCountElement = $('<span class="test-count">'+taskCount+'</span>');
                var taskCountDigitLength = taskCount.length;
                
                if (taskCountDigitLength > maximumStandardDigitLength) {
                    var fontSize = (standardDigitSize - ((taskCountDigitLength - maximumStandardDigitLength) * 5)) + 'px';
                    taskCountElement.css({
                        'font-size':fontSize
                    });
                }
                
                var siteListItem = $('<div class="site span4" />').append(
                    $('<div class="wrapper" />').append(
                        '<a class="url" href="'+this.website+'">'+getOutputDomainFromWebsiteUrl(this.website)+'</a>'
                    ).append(
                        $('<div class="results" />').append(
                            $('<a href="http://gears.simplytestable.com/'+this.website+'/'+this.id+'/results/" />').append(
                                $('<span class="badge badge-'+getStateLabelClass(this.state)+'"> <i class="icon state-icon '+getStateIcon(this.state)+'"></i> #'+this.id+' <i class="icon action-icon icon-caret-right"></i> </span>')
                            )
                        )
                    ).append(
                        $('<div class="row-fluid meta">').append(
                            $(' <div class="span4 total">').append(
                                taskCountElement
                            ).append(
                                '<span class="subtext">tests overall</span>'
                            )
                        ).append(
                            $(' <div class="span4 total">').append(
                                '<span class="test-count">'+getCompletionPercent(this)+'<span class="percent">%</span></span><span class="subtext">finished</span>'
                            )
                        ).append(
                            $('<div class="span4 detail">').append(
                                '<div><span class="queued-count figure">'+getQueuedTaskCount(this.task_count_by_state)+'</span> <span class="caption">queued</span></div>'
                            ).append(
                                '<div><span class="in-progress-count figure">'+this.task_count_by_state['in-progress']+'</span> <span class="caption">in progress</span></div>'
                            ).append(
                                '<div><span class="finished-count figure">'+getFinishedTaskCount(this.task_count_by_state)+'</span> <span class="caption">finished</span></div>'
                            )
                        )
                    )
                );

                recentSiteTestsList.append(siteListItem);
            });            
        };
        
        var requestRecentTestData = function () {
            $.get('/core-application-proxy/?url=http://app.simplytestable.com/jobs/list/3/', function(data) {
                updateRecentTests(data);
            }, "json");               
        };


//        $.get('/core-application-proxy/?url=http://app.simplytestable.com/tasks/HTML%20validation/completed/count/', function(data) {
//            $('#html-validation-completed-count').text(data);
//        }, "json");
        
        requestRecentTestData();

        window.setInterval(function () {
            requestRecentTestData();
        }, 1000);
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
            
            time.after('<span class="indicator"><i class="icon-star highlighted"></i><i class="icon-star-empty"></i></span>');
        });        
        
        $('.past', this).each(function () {
            var event = $(this);
            var time = $('time', event);
            
            time.after('<span class="indicator"><i class="icon-ok highlighted"></i></span>');
        });        
        
        $('.future', this).each(function () {
            var event = $(this);
            var time = $('time', event);
            
            time.after('<span class="indicator"><i class="icon-off highlighted"></i></span>');
        });        
    });
        
    getTwitters('footer-tweet', { 
        id: 'simplytestable', 
        count: 1, 
        enableLinks: true, 
        ignoreReplies: true, 
        clearContents: true,
        template: '%text% <a class="time" href="http://twitter.com/%user_screen_name%/statuses/%id_str%/">%time%</a>',
        callback: function () {                       
            $('.tweet-container .tweet').html($('#footer-tweet').html()).animate({
                'opacity':1
            });
        }
    });
});