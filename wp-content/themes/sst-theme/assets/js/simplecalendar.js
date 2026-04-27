var calendar = {

    init: function (ajax) {

        if (ajax) {

            // ajax call to print json
            jQuery.ajax({
                url: sstAPI.home + '/wp-json/wp/v2/events-api',
                type: 'GET',
            })
                .done(function (data) {
                    var events = data;
                    for (var i = 0; i < events.length; i++) {
                        var eventDates = events[i].event_date[0];
                        var d = new Date(eventDates * 1000);

                        var day = d.getDate();
                        var month = d.getMonth() + 1;
                        var year = d.getFullYear();

                        var dateFormat = month + '/' + day + '/' + year;

                        var title = events[i].title.rendered;
                        var description = events[i].excerpt.rendered;
                        jQuery('.event-calendar-list').append('<div class="day-event" date-day="' + day + '" date-month="' + month + '" date-year="' + year + '" data-number="' + i + '">' +
                            '<a href="#" class="close"></a>' +
                            '<div class="date"><p class="eventDate">&#128197;' + dateFormat + '</p>' +
                            '<h2 class="title">' + title + '</h2>' +
                            '<p>' + description + '</p>' +
                            '</div></div>');
                    }
                    // start calendar
                    calendar.startCalendar();
                })
                .fail(function (data) {
                    console.log(data);
                });
        } else {

            // if not using ajax start calendar
            calendar.startCalendar();
        }

    },

    startCalendar: function () {
        var mon = 'Mon';
        var tue = 'Tue';
        var wed = 'Wed';
        var thur = 'Thur';
        var fri = 'Fri';
        var sat = 'Sat';
        var sund = 'Sun';

        /**
         * Get current date
         */
        var d = new Date();
        var strDate = yearNumber + "/" + (d.getMonth() + 1) + "/" + d.getDate();
        var yearNumber = (new Date).getFullYear();
        /**
         * Get current month and set as '.current-month' in title
         */
        var monthNumber = d.getMonth() + 1;

        function GetMonthName(monthNumber) {
            var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            return months[monthNumber - 1];
        }

        setMonth(monthNumber, mon, tue, wed, thur, fri, sat, sund);

        function setMonth(monthNumber, mon, tue, wed, thur, fri, sat, sund) {
            jQuery('.month').text(GetMonthName(monthNumber) + ' ' + yearNumber);
            jQuery('.month').attr('data-month', monthNumber);
            printDateNumber(monthNumber, mon, tue, wed, thur, fri, sat, sund);
        }

        jQuery('.btn-next').on('click', function (e) {
            var monthNumber = jQuery('.month').attr('data-month');
            if (monthNumber > 11) {
                jQuery('.month').attr('data-month', '0');
                var monthNumber = jQuery('.month').attr('data-month');
                yearNumber = yearNumber + 1;
                setMonth(parseInt(monthNumber) + 1, mon, tue, wed, thur, fri, sat, sund);
            } else {
                setMonth(parseInt(monthNumber) + 1, mon, tue, wed, thur, fri, sat, sund);
            }
            return false;
        });

        jQuery('.btn-prev').on('click', function (e) {
            var monthNumber = jQuery('.month').attr('data-month');
            if (monthNumber < 2) {
                jQuery('.month').attr('data-month', '13');
                var monthNumber = jQuery('.month').attr('data-month');
                yearNumber = yearNumber - 1;
                setMonth(parseInt(monthNumber) - 1, mon, tue, wed, thur, fri, sat, sund);
            } else {
                setMonth(parseInt(monthNumber) - 1, mon, tue, wed, thur, fri, sat, sund);
            }
            return false;
        });

        /**
         * Get all dates for current month
         */

        function printDateNumber(monthNumber, mon, tue, wed, thur, fri, sat, sund) {

            jQuery(jQuery('tbody.event-calendar tr')).each(function (index) {
                jQuery(this).empty();
            });

            jQuery(jQuery('thead.event-days tr')).each(function (index) {
                jQuery(this).empty();
            });

            function getDaysInMonth(month, year) {
                // Since no month has fewer than 28 days
                var date = new Date(year, month, 1);
                var days = [];
                while (date.getMonth() === month) {
                    days.push(new Date(date));
                    date.setDate(date.getDate() + 1);
                }
                return days;
            }

            i = 0;

            setDaysInOrder(mon, tue, wed, thur, fri, sat, sund);

            function setDaysInOrder(mon, tue, wed, thur, fri, sat, sund) {
                var monthDay = getDaysInMonth(monthNumber - 1, yearNumber)[0].toString().substring(0, 3);
                if (monthDay === 'Mon') {
                    jQuery('thead.event-days tr').append('<td>' + mon + '</td><td>' + tue + '</td><td>' + wed + '</td><td>' + thur + '</td><td>' + fri + '</td><td>' + sat + '</td><td>' + sund + '</td>');
                } else if (monthDay === 'Tue') {
                    jQuery('thead.event-days tr').append('<td>' + tue + '</td><td>' + wed + '</td><td>' + thur + '</td><td>' + fri + '</td><td>' + sat + '</td><td>' + sund + '</td><td>' + mon + '</td>');
                } else if (monthDay === 'Wed') {
                    jQuery('thead.event-days tr').append('<td>' + wed + '</td><td>' + thur + '</td><td>' + fri + '</td><td>' + sat + '</td><td>' + sund + '</td><td>' + mon + '</td><td>' + tue + '</td>');
                } else if (monthDay === 'Thu') {
                    jQuery('thead.event-days tr').append('<td>' + thur + '</td><td>' + fri + '</td><td>' + sat + '</td><td>' + sund + '</td><td>' + mon + '</td><td>' + tue + '</td><td>' + wed + '</td>');
                } else if (monthDay === 'Fri') {
                    jQuery('thead.event-days tr').append('<td>' + fri + '</td><td>' + sat + '</td><td>' + sund + '</td><td>' + mon + '</td><td>' + tue + '</td><td>' + wed + '</td><td>' + thur + '</td>');
                } else if (monthDay === 'Sat') {
                    jQuery('thead.event-days tr').append('<td>' + sat + '</td><td>' + sund + '</td><td>' + mon + '</td><td>' + tue + '</td><td>' + wed + '</td><td>' + thur + '</td><td>' + fri + '</td>');
                } else if (monthDay === 'Sun') {
                    jQuery('thead.event-days tr').append('<td>' + sund + '</td><td>' + mon + '</td><td>' + tue + '</td><td>' + wed + '</td><td>' + thur + '</td><td>' + fri + '</td><td>' + sat + '</td>');
                }
            };
            jQuery(getDaysInMonth(monthNumber - 1, yearNumber)).each(function (index) {
                var index = index + 1;
                if (index < 8) {
                    jQuery('tbody.event-calendar tr.1').append('<td date-month="' + monthNumber + '" date-day="' + index + '" date-year="' + yearNumber + '">' + index + '</td>');
                } else if (index < 15) {
                    jQuery('tbody.event-calendar tr.2').append('<td date-month="' + monthNumber + '" date-day="' + index + '" date-year="' + yearNumber + '">' + index + '</td>');
                } else if (index < 22) {
                    jQuery('tbody.event-calendar tr.3').append('<td date-month="' + monthNumber + '" date-day="' + index + '" date-year="' + yearNumber + '">' + index + '</td>');
                } else if (index < 29) {
                    jQuery('tbody.event-calendar tr.4').append('<td date-month="' + monthNumber + '" date-day="' + index + '" date-year="' + yearNumber + '">' + index + '</td>');
                } else if (index < 32) {
                    jQuery('tbody.event-calendar tr.5').append('<td date-month="' + monthNumber + '" date-day="' + index + '" date-year="' + yearNumber + '">' + index + '</td>');
                }
                i++;
            });
            var date = new Date();
            var month = date.getMonth() + 1;
            var thisyear = new Date().getFullYear();
            setCurrentDay(month, thisyear);
            setEvent();
            displayEvent();
        }

        /**
         * Get current day and set as '.current-day'
         */
        function setCurrentDay(month, year) {
            var viewMonth = jQuery('.month').attr('data-month');
            var eventYear = jQuery('.event-days').attr('date-year');
            if (parseInt(year) === yearNumber) {
                if (parseInt(month) === parseInt(viewMonth)) {
                    jQuery('tbody.event-calendar td[date-day="' + d.getDate() + '"]').addClass('current-day');
                }
            }
        };

        /**
         * Add class '.active' on calendar date
         */
        jQuery('tbody.event-calendar td').on('click', function (e) {
            if (jQuery(this).hasClass('event')) {
                jQuery('tbody.event-calendar td').removeClass('active');
                jQuery(this).addClass('active');
            } else {
                jQuery('tbody.event-calendar td').removeClass('active');
            }
            ;
        });

        /**
         * Add '.event' class to all days that has an event
         */
        function setEvent() {
            jQuery('.day-event').each(function (i) {
                var eventMonth = jQuery(this).attr('date-month');
                var eventDay = jQuery(this).attr('date-day');
                var eventYear = jQuery(this).attr('date-year');
                var eventClass = jQuery(this).attr('event-class');
                if (eventClass === undefined) eventClass = 'event';
                else eventClass = 'event ' + eventClass;

                if (parseInt(eventYear) === yearNumber) {
                    jQuery('tbody.event-calendar tr td[date-month="' + eventMonth + '"][date-day="' + eventDay + '"]').addClass(eventClass);
                }
            });
        };

        /**
         * Get current day on click in calendar
         * and find day-event to display
         */
        function displayEvent() {
            jQuery('tbody.event-calendar td').on('click', function (e) {
                jQuery('.day-event').slideUp('fast');
                var monthEvent = jQuery(this).attr('date-month');
                var dayEvent = jQuery(this).text();
                jQuery('.day-event[date-month="' + monthEvent + '"][date-day="' + dayEvent + '"]').slideDown('fast');
            });
        };

        /**
         * Close day-event
         */
        jQuery('.close').on('click', function (e) {
            jQuery(this).parent().slideUp('fast');
        });

    },

};

jQuery(document).ready(function () {
    calendar.init('ajax');
});
