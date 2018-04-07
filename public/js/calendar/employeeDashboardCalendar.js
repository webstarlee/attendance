var CalendardBasic = function() {

    return {
        //main function to initiate the module
        init: function() {
            var todayDate = moment().startOf('day');
            var YM = todayDate.format('YYYY-MM');
            var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
            var TODAY = todayDate.format('YYYY-MM-DD');
            var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');

            var dashCalendar = $('#m_dash_event_calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay,listWeek'
                },
                editable: false,
                eventLimit: true, // allow "more" link when too many events
                navLinks: true,
                selectable: true,
                events: '/dashboard/calendarEvent',

                eventRender: function(event, element) {
                    if (element.hasClass('fc-day-grid-event')) {
                        element.find('.fc-content').html('<span class="fc-title">' + event.title + '</span>');
                    }

                    if (event.title == "holiday") {
                        var holiday_html = '<div style="width:100%;height:100%;display:flex;flex-direction:column;justify-content:center;text-align:center;"><span style="color:#fff;">Holiday</span><span style="color:#fff;font-size:11px;">( '+event.description+' )</span></div>'
                        element.html(holiday_html);
                    }
                }
            });
        }
    };
}();

jQuery(document).ready(function() {
    CalendardBasic.init();
});
