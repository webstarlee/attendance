var attendanceCalendar;
function vac_circle_calc() {
    $.ajax({
        url: '/admin/manage/attendance/getPercentVacation/'+golbalEmployeeId,
        type: 'get',
        success: function(result){
            if (result.result != "fail") {
                $('#employee-attend-dashboard-detail').html(result.html);
                var percent = result.percent;
                var point_percent = percent/100;
                $('#vac_circle_chart').circleProgress({
                    startAngle: -Math.PI / 4 * 2,
                    value: point_percent,
                    fill: {color: '#30e226'},
                    size: 170,
                 }).on('circle-animation-progress', function(event, progress) {
                   $(this).find('strong').html(Math.round(percent * progress) + '<i>%</i>');
                 });
            }
        },
        error: function(error){
            console.log(error);
        }
    });
}
var CalendardBasic = function() {

    return {
        //main function to initiate the module
        init: function() {
            vac_circle_calc();
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
                selectable: true,
                events: '/admin/manage/attendance/getSingleData/'+golbalEmployeeId,

                select: function(start, end, jsEvent, view) {
                    var eventDate = start.format('YYYY-MM-DD');
                    var dataFormat = start.format('MM/DD/YYYY');
                    var dateString = end.format('YYYY-MM-DD'); // date string
                    var actualDate = new Date(dateString); // convert to actual date
                    var newDate = new Date(actualDate.getFullYear(), actualDate.getMonth(), actualDate.getDate()-1);
                    var month = '' + (newDate.getMonth() + 1),
                        day = '' + newDate.getDate(),
                        year = newDate.getFullYear();
                    var final_end_date = [month, day, year].join('/');

                    var form = $('#m-admin-new_attendance-form')[0];
                    form.reset();
                    $(form).find('#attend_date_from').val(dataFormat);
                    $(form).find('#attend_date_to').attr('value', final_end_date);
                    $(form).find('#attendance_type').selectpicker('destroy');
                    $(form).find('#attendance_type').selectpicker();
                    var input_boxs = $('#hidden_attendance_input_box_container').html();
                    $(form).find('.attendance_status_input_container').html(input_boxs);
                    $(form).find('button.add-smoke-time-btn').css({'display':'block'});
                    $('#m-admin-new_attendance-modal').modal('show');
                    $(form).find('#attend_date_to').datepicker('destroy');
                    $(form).find('#attend_date_from').datepicker('destroy');
                    setJsplugin();

                },

                eventClick: function(calEvent, jsEvent, view) {
                    var attend_id = calEvent.event_id;

                    var getData = '/admin/manage/attendance/getSingleAttend/'+attend_id;

                    $.ajax({
                        url: getData,
                        type: 'get',
                        success: function(result){

                            var form = $('#m-admin-edit_attendance-form')[0];
                            form.reset();
                            $(form).find('#attendance_id').val(result.id);
                            $(form).find('#_attend_date_from').val(result.attend_date);
                            $(form).find('#_attend_date_from').attr('readonly', true);
                            $(form).find('#_attend_start_time').val(result.start_time);
                            $(form).find('#_attend_date_to').val(result.attend_date);
                            $(form).find('#_attend_date_to').attr('readonly', true);
                            $(form).find('#_attend_end_time').val(result.end_time);
                            $(form).find('#_attendance_type').val(result.attend_type);
                            $(form).find('#_attendance_type').selectpicker('destroy');
                            $(form).find('#_attendance_type').selectpicker();
                            if (result.attend_type == 1) {
                                var input_boxs = $('#hidden_attendance_input_box_container').html();
                                $(form).find('.attendance_status_input_container').html(input_boxs);
                                if (result.smokes) {
                                    var somking_container = $(form).find('.smoke-time-container');
                                    somking_container.html("");
                                    result.smokes.forEach(function(smoke){
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
                                if (result.breaks) {
                                    var break_container = $(form).find('.break-time-container');
                                    break_container.html("");
                                    result.breaks.forEach(function(breaking){
                                        var new_break = '<div class="input-group m-input-group m-input-group--air">'+
                                                            '<a class="current_smoking_time_delete_btn" title="delete smoke time"><i class="la la-close"></i></a>'+
                                                            '<div class="row">'+
                                                                '<div class="col-sm-6">'+
                                                                    '<div class="m-form__content"></div>'+
                                                                    '<div class="form-group m-form__group">'+
                                                                        '<label for="exampleInputEmail1">Start:</label>'+
                                                                        '<div class="input-group m-input-group m-input-group--air">'+
                                                                            '<span class="input-group-addon"><i class="la la-clock-o"></i></span>'+
                                                                            '<input type="text" class="form-control m-input input-smoke-timepicker" name="attend_break_start[]" value="'+breaking.br_start+'" placeholder="Enter time" required>'+
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
                                                                            '<input type="text" class="form-control m-input input-smoke-timepicker" name="attend_break_end[]" value="'+breaking.br_end+'" placeholder="Enter time" required>'+
                                                                        '</div>'+
                                                                    '</div>'+
                                                                    '<div class="m-form__content"></div>'+
                                                                '</div>'+
                                                            '</div>'+
                                                        '</div>';
                                        break_container.append(new_break);
                                        break_container.parents('.break-time-container-form').css({'display': 'block'});
                                    });
                                }
                            } else {
                                $(form).find('.attendance_status_input_container').html("");
                            }
                            setJsplugin();
                            $(form).find('#_attend_date_from').datepicker('destroy');
                            $(form).find('#_attend_date_to').datepicker('destroy');
                            $('#m-admin-edit_attendance-modal').modal('show');
                        },
                        error: function(result){
                            console.log(result);
                        }
                    });
                },

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
