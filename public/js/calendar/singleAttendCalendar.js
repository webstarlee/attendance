var attendanceCalendar;
var CalendardBasic = function() {

    return {
        //main function to initiate the module
        init: function() {
            var todayDate = moment().startOf('day');
            var YM = todayDate.format('YYYY-MM');
            var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
            var TODAY = todayDate.format('YYYY-MM-DD');
            var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');

            attendanceCalendar = $('#m_attendance_calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listWeek'
            },
            editable: false,
            eventLimit: true, // allow "more" link when too many events
            navLinks: true,
            events: '/admin/manage/attendance/getSingleData/'+golbalEmployeeId,

            eventRender: function(event, element) {
                var bgEventTitle = document.createElement('div');
                bgEventTitle.style.position = 'absolute';
                bgEventTitle.style.bottom = '0';
                bgEventTitle.classList.add('fc-event');
                bgEventTitle.classList.add('holiday-calendar-title-div');
                if (event.status == 1) {
                    var minutes = event.total_work%60;
                    var hours = (event.total_work - minutes)/60;
                    var string_working = "";
                    if (hours == 0) {
                        string_working = '<p style="margin-bottom: 0;">'+minutes+' minutes </p>';
                    } else if(minutes == 0) {
                        string_working = '<p style="margin-bottom: 0;">'+hours+' hours </p>';
                    } else {
                        string_working = '<p style="margin-bottom: 0;">'+hours+' hours </p><p style="margin-bottom: 0;">'+minutes+' minutes </p>';
                    }
                    bgEventTitle.innerHTML = '<h3 class="fc-title holiday-calendar-custom-h3">' + string_working + '</h3>' ;
                } else if (event.status == 0) {
                    bgEventTitle.innerHTML = '<h3 class="fc-title holiday-calendar-custom-h3">Absence</h3>' ;
                } else if (event.status == 2) {
                    bgEventTitle.innerHTML = '<h3 class="fc-title holiday-calendar-custom-h3">Business Trip</h3>' ;
                } else if (event.status == 3) {
                    bgEventTitle.innerHTML = '<h3 class="fc-title holiday-calendar-custom-h3">Vacation</h3>' ;
                } else if (event.status == 4) {
                    bgEventTitle.innerHTML = '<h3 class="fc-title holiday-calendar-custom-h3">Sickness</h3>' ;
                }
                element.css('position', 'relative').html(bgEventTitle);
            },

            dayClick: function(date, jsEvent, view) {
                var eventDate = date.format('YYYY-MM-DD');
                var dataFormat = date.format('MM/DD/YYYY');
                var getData = '/admin/manage/attendance/checkSingleData/'+golbalEmployeeId+'/'+eventDate;
                $.ajax({
                    url: getData,
                    type: 'get',
                    success: function(result){
                        console.log(result);
                        if (result == "nodata") {
                            var form = $('#m-admin-new_attendance-form')[0];
                            form.reset();
                            $(form).find('#attend_date').val(dataFormat);
                            $(form).find('#attend_date').attr('readonly', true);
                            $(form).find('#attendance_type').selectpicker('destroy');
                            $(form).find('#attendance_type').selectpicker();
                            var input_boxs = $('#hidden_attendance_input_box_container').html();
                            $(form).find('.attendance_status_input_container').html(input_boxs);
                            $(form).find('button.add-smoke-time-btn').css({'display':'block'});
                            $('#m-admin-new_attendance-modal').modal('show');
                            setJsplugin();
                            $(form).find('#attend_date').datepicker('destroy');
                        } else {
                            var form = $('#m-admin-edit_attendance-form')[0];
                            form.reset();
                            $(form).find('#attendance_id').val(result.id);
                            $(form).find('#_attend_date').val(dataFormat);
                            $(form).find('#_attend_date').attr('readonly', true);
                            $(form).find('#_attendance_type').val(result.type);
                            $(form).find('#_attendance_type').selectpicker('destroy');
                            $(form).find('#_attendance_type').selectpicker();
                            if (result.type == 1) {
                                var input_boxs = $('#hidden_attendance_input_box_container').html();
                                $(form).find('.attendance_status_input_container').html(input_boxs);
                                $(form).find('input[name=attend_arrive_time]').attr('value', result.arrival_time);
                                $(form).find('input[name=attend_departure_time]').attr('value', result.departure_time);
                                $(form).find('input[name=break_start_1]').attr('value', result.break1_start_time);
                                $(form).find('input[name=break_end_1]').attr('value', result.break1_end_time);
                                $(form).find('input[name=break_start_2]').attr('value', result.break2_start_time);
                                $(form).find('input[name=break_end_2]').attr('value', result.break2_end_time);
                                $(form).find('button.add-smoke-time-btn').css({'display':'block'});
                                if (result.smokings) {
                                    var somking_container = $(form).find('.smoke-time-container');
                                    somking_container.html("");
                                    result.smokings.forEach(function(smoke){
                                        var new_smoking = '<div class="input-group m-input-group m-input-group--air">'+
                                                            '<a class="current_smoking_time_delete_btn" title="delete smoke time"><i class="la la-close"></i></a>'+
                                                            '<div class="row">'+
                                                                '<div class="col-sm-6">'+
                                                                    '<div class="m-form__content"></div>'+
                                                                    '<div class="form-group m-form__group">'+
                                                                        '<label for="exampleInputEmail1">Start:</label>'+
                                                                        '<div class="input-group m-input-group m-input-group--air">'+
                                                                            '<span class="input-group-addon"><i class="la la-clock-o"></i></span>'+
                                                                            '<input type="text" class="form-control m-input input-smoke-timepicker" name="attend_smoking_start[]" value="'+smoke.sm_start+'" placeholder="Enter time" required>'+
                                                                        '</div>'+
                                                                    '</div>'+
                                                                    '<div class="m-form__content"></div>'+
                                                                '</div>'+
                                                                '<div class="col-sm-6">'+
                                                                    '<div class="m-form__content"></div>'+
                                                                    '<div class="form-group m-form__group">'+
                                                                        '<label for="exampleInputEmail1">End:</label>'+
                                                                        '<div class="input-group m-input-group m-input-group--air">'+
                                                                            '<span class="input-group-addon"><i class="la la-clock-o"></i></span>'+
                                                                            '<input type="text" class="form-control m-input input-smoke-timepicker" name="attend_smoking_end[]" value="'+smoke.sm_end+'" placeholder="Enter time" required>'+
                                                                        '</div>'+
                                                                    '</div>'+
                                                                    '<div class="m-form__content"></div>'+
                                                                '</div>'+
                                                            '</div>'+
                                                        '</div>';
                                        somking_container.append(new_smoking);
                                        somking_container.parents('.smoke-time-container-form').css({'display': 'block'});
                                    });
                                }
                            } else {
                                $(form).find('.attendance_status_input_container').html("");
                                $(form).find('button.add-smoke-time-btn').css({'display':'none'});
                            }
                            setJsplugin();
                            $(form).find('#attend_date').datepicker('destroy');
                            $('#m-admin-edit_attendance-modal').modal('show');

                        }
                    },
                    error: function(result){
                        console.log(result);
                    }
                });
            }
        });
        }
    };
}();

jQuery(document).ready(function() {
    CalendardBasic.init();
});
