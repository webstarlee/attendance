function setJsplugin() {
    $('.input-date-picker').datepicker({
        todayHighlight: true,
        autoclose: true,
        orientation: "bottom left",
        templates: {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }
    });

    $('.input-time-picker').timepicker()
}

var CalendarBasic = function() {

    return {
        //main function to initiate the module
        init: function() {
            setJsplugin();

            var todayDate = moment().startOf('day');
            var YM = todayDate.format('YYYY-MM');
            var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
            var TODAY = todayDate.format('YYYY-MM-DD');
            var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');

            var eventCalendar = $('#m_holiday_calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay,listWeek'
                },
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                navLinks: true,
                events: '/admin/manage/event/get_table_data/',

                dayClick: function(date, jsEvent, view) {
                    var eventDate = date.format();
                    var dataFormat = date.format('MM/DD/YYYY');
                    $('#m-admin-new_event-form #event_date').val(dataFormat);
                    $('#m-admin-new_event-form #event_date').attr('readonly', true);
                    $('#m-admin-new_event-modal').modal('show');
                    $('#event_date').datepicker('destroy');
                    setJsplugin();
                },

                eventClick: function(event, jsEvent, view) {
                    var event_date = event.start.format('MM/DD/YYYY');
                    var event_start = event.start.format('h:s a');
                    var event_end = event.end.format('h:s A');
                    var event_title = event.title;
                    var event_description = event.description;
                    $('#m-admin-edit_event-form #event_id_for_edit').val(event.id);
                    $('#m-admin-edit_event-form #_event_date').val(event_date);
                    $('#m-admin-edit_event-form #_event_start_time').attr('value',event_start);
                    $('#m-admin-edit_event-form #_event_end_time').attr('value',event_end);
                    $('#m-admin-edit_event-form #_event_title').val(event_title);
                    $('#m-admin-edit_event-form #_event_note').val(event_description);
                    $('.input-date-picker').datepicker('destroy');
                    // setJsplugin();
                    $('#m-admin-edit_event-modal').modal('show');
                },

                eventDrop: function(event, delta, revertFunc, jsEvent, ui, view) {
                    var event_id = event.id;
                    var new_date = event.start.format('YYYY-MM-DD');
                    var changeDateUrl = '/admin/manage/event/changeDate/'+event_id+'/'+new_date;
                    $.ajax({
                        url: changeDateUrl,
                        type: 'get',
                        success: function(result){
                            console.log(result);
                        },
                        error: function(result){
                            console.log(result);
                        }
                    });
                }
            });

            $('#add-new-holiday-btn').on('click', function(e) {
                e.preventDefault();
                var form = $('#m-admin-new_holiday-form')[0];
                form.reset();
                $(form).find('#holi_date').attr('readonly', false);
                $('#m-admin-new_holiday-modal').modal('show');
                setJsplugin();
            })

            $('#m-admin-new_event-form').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                    }
                });
                var url = $(form).attr( 'action' );

                var formData = new FormData($(form)[0]);
                var submit_btn = $(form).find('.form-submit-btn');
                submit_btn.addClass('m-loader m-loader--right m-loader--success').attr('disabled', true);
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        console.log(data);
                        if (data != "fail") {
                            eventCalendar.fullCalendar('refetchEvents');
                        }
                        submit_btn.removeClass('m-loader m-loader--right m-loader--success').attr('disabled', false);
                        $('#m-admin-new_event-modal').modal('hide');
                    },
                    processData: false,
                    contentType: false,
                    error: function(data)
                   {
                       console.log(data);
                   }
                });
            })

            $('#m-admin-edit_event-form').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                    }
                });
                var url = $(form).attr( 'action' );

                var formData = new FormData($(form)[0]);
                var submit_btn = $(form).find('.form-submit-btn');
                submit_btn.addClass('m-loader m-loader--success m-loader--right').attr('disabled', true);
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        submit_btn.removeClass('m-loader m-loader--success m-loader--light').attr('disabled', false);
                        eventCalendar.fullCalendar('refetchEvents');
                        $('#m-admin-edit_event-modal').modal('hide');
                    },
                    processData: false,
                    contentType: false,
                    error: function(data)
                   {
                       console.log(data);
                   }
                });
            })

            $('#event_delete_btn').on('click', function(e) {
                e.preventDefault();
                var $this = $(this);
                swal({
                    title: i18n.language.are_you_sure,
                    text: i18n.language.do_you_want_to_delete,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    confirmButtonClass: "btn m-btn--air btn-outline-accent",
                    cancelButtonClass: "btn m-btn--air btn-outline-primary",
                }).then(function(result) {
                    if (result.value) {
                        var form = $this.parents('#m-admin-edit_event-form');
                        var eventId = form.find('#event_id_for_edit').val();
                        $.ajax({
                            url: '/admin/manage/event/destroy/'+eventId,
                            type: 'get',
                            success: function(result){
                                $('#m-admin-edit_event-modal').modal('hide');
                                swal({
                                    "title": "Success",
                                    "text": "Holiday Deleted !.",
                                    "type": "success",
                                    "confirmButtonClass": "btn m-btn--air btn-outline-accent"
                                });
                                eventCalendar.fullCalendar('refetchEvents');
                            },
                            error: function(error){
                                console.log(error);
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.m-holiday-edit-btn', function(e) {
                e.preventDefault();
                var $this = $(this);
                var holidayDate = $this.data('holiday_date');
                var getData = '/admin/manage/holiday/checkDate/'+holidayDate;
                $.ajax({
                    url: getData,
                    type: 'get',
                    success: function(result){
                        if (result != "nodata") {
                            var from = holidayDate.split("-");
                            var dateYear = from[0];
                            var dateMonth = from[1];
                            var dateDay = from[2];
                            var dataFormat = dateMonth+"/"+dateDay+"/"+dateYear;
                            $('#m-admin-edit_holiday-form #holiday_id').val(result.id);
                            $('#m-admin-edit_holiday-form #_holi_date').val(dataFormat);
                            $('#m-admin-edit_holiday-form #_holi_date').attr('readonly', true);
                            $('#m-admin-edit_holiday-form #_holi_title').val(result.title);
                            $('#m-admin-edit_holiday-form #_holi_description').val(result.description);
                            $('#m-admin-edit_holiday-modal').modal('show');
                        }
                    },
                    error: function(result){
                        console.log(result);
                    }
                });
                console.log(holidayDate);
            })

            $(document).on('click', '.m-holiday-delete-btn', function(e) {
                e.preventDefault();
                var $this = $(this);
                swal({
                    title: 'Are you sure?',
                    text: "Do want to delete !",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    confirmButtonClass: "btn m-btn--air btn-outline-accent",
                    cancelButtonClass: "btn m-btn--air btn-outline-primary",
                }).then(function(result) {
                    var holidayId = $this.data('holiday_id');
                    $.ajax({
                        url: '/admin/manage/holiday/destroy/'+holidayId,
                        type: 'get',
                        success: function(result){
                            swal({
                                "title": "Success",
                                "text": "Holiday Deleted !.",
                                "type": "success",
                                "confirmButtonClass": "btn m-btn--air btn-outline-accent"
                            });
                            holidayCalendar.fullCalendar('refetchEvents');
                            holidayTable.reload();
                        },
                        error: function(error){
                            console.log(error);
                        }
                    });
                });
            })
        }
    };
}();

jQuery(document).ready(function() {
    CalendarBasic.init();
});
