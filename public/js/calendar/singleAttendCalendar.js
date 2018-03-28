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
            selectable: true,
            events: '/admin/manage/attendance/getSingleData/'+golbalEmployeeId,
            // events: [
            //     {
            //         'start': '2018-03-28',
            //         'title': 'Attendance',
            //         'color': 'rgb(11, 186, 139)',
            //         'rendering':'background',
            //     },
            //     {
            //         'start': '2018-03-28 08:00:00',
            //         'end': '2018-03-28 16:00:00',
            //         'title': 'Attendance',
            //         'color': 'rgb(186, 11, 149)',
            //     },
            //     {
            //         'start': '2018-03-29 08:00:00',
            //         'end': '2018-03-29 16:00:00',
            //         'title': 'Attendance',
            //         'color': 'rgb(186, 11, 149)',
            //     },
            //     {
            //         'start': '2018-03-29 11:30:00',
            //         'end': '2018-03-29 12:00:00',
            //         'title': 'hello',
            //         'color': 'rgb(251, 251, 251)',
            //     }
            // ],
            // eventRender: function(event, element) {
            //     var bgEventTitle = document.createElement('div');
            //     bgEventTitle.style.position = 'absolute';
            //     bgEventTitle.style.bottom = '0';
            //     bgEventTitle.classList.add('fc-event');
            //     bgEventTitle.classList.add('holiday-calendar-title-div');
            //     var approval_status_string = '<p style="margin-bottom: 0;font-size: 11px;color:#ffffff;">(Approved)</p>';
            //     if (event.approval == 0) {
            //         approval_status_string = '<p style="margin-bottom: 0;font-size: 11px;color:#000000;">(Pending)</p>';;
            //     }
            //     if (event.status == 1) {
            //         var minutes = event.total_work%60;
            //         var hours = (event.total_work - minutes)/60;
            //         var string_working = "";
            //         if (hours == 0) {
            //             string_working = '<p style="margin-bottom: 0;">'+minutes+' minutes </p>';
            //         } else if(minutes == 0) {
            //             string_working = '<p style="margin-bottom: 0;">'+hours+' hours </p>';
            //         } else {
            //             string_working = '<p style="margin-bottom: 0;">'+hours+' hours </p><p style="margin-bottom: 0;">'+minutes+' minutes </p>';
            //         }
            //         bgEventTitle.innerHTML = '<h3 class="fc-title holiday-calendar-custom-h3">'+string_working+approval_status_string+'</h3>' ;
            //     } else if (event.status == 0) {
            //         bgEventTitle.innerHTML = '<h3 class="fc-title holiday-calendar-custom-h3">Absence'+approval_status_string+'</h3>' ;
            //     } else if (event.status == 2) {
            //         bgEventTitle.innerHTML = '<h3 class="fc-title holiday-calendar-custom-h3">Business Trip'+approval_status_string+'</h3>' ;
            //     } else if (event.status == 3) {
            //         bgEventTitle.innerHTML = '<h3 class="fc-title holiday-calendar-custom-h3">Vacation'+approval_status_string+'</h3>' ;
            //     } else if (event.status == 4) {
            //         bgEventTitle.innerHTML = '<h3 class="fc-title holiday-calendar-custom-h3">Sickness'+approval_status_string+'</h3>' ;
            //     }
            //     element.css('position', 'relative').html(bgEventTitle);
            // },
            select: function(start, end, jsEvent, view) {
                var eventDate = start.format('YYYY-MM-DD');
                var dataFormat = start.format('MM/DD/YYYY');
                var dateString = end.format(); // date string
                var actualDate = new Date(dateString); // convert to actual date
                var newDate = new Date(actualDate.getFullYear(), actualDate.getMonth(), actualDate.getDate()-1);
                var month = '' + (newDate.getMonth() + 1),
                    day = '' + newDate.getDate(),
                    year = newDate.getFullYear();
                var final_end_date = [month, day, year].join('/');
                var getData = '/admin/manage/attendance/checkSingleData/'+golbalEmployeeId+'/'+eventDate;
                $.ajax({
                    url: getData,
                    type: 'get',
                    success: function(result){
                        console.log(result);
                        if (result == "nodata") {
                            var form = $('#m-admin-new_attendance-form')[0];
                            form.reset();
                            $(form).find('#attend_date_from').val(dataFormat);
                            $(form).find('#attend_date_to').attr('value',final_end_date);
                            $(form).find('#attend_date_from').attr('readonly', true);
                            $(form).find('#attendance_type').selectpicker('destroy');
                            $(form).find('#attendance_type').selectpicker();
                            var input_boxs = $('#hidden_attendance_input_box_container').html();
                            $(form).find('.attendance_status_input_container').html(input_boxs);
                            $(form).find('button.add-smoke-time-btn').css({'display':'block'});
                            $('#m-admin-new_attendance-modal').modal('show');
                            $(form).find('#attend_date_to').datepicker('destroy');
                            setJsplugin();
                            $(form).find('#attend_date_from').datepicker('destroy');
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
                            $('#m-admin-edit_attendance-modal').modal('show');

                        }
                    },
                    error: function(result){
                        console.log(result);
                    }
                });
            },

            // dayClick: function(date, jsEvent, view) {
            //     var eventDate = date.format('YYYY-MM-DD');
            //     var dataFormat = date.format('MM/DD/YYYY');
            //     var getData = '/admin/manage/attendance/checkSingleData/'+golbalEmployeeId+'/'+eventDate;
            //     $.ajax({
            //         url: getData,
            //         type: 'get',
            //         success: function(result){
            //             console.log(result);
            //             if (result == "nodata") {
            //                 var form = $('#m-admin-new_attendance-form')[0];
            //                 form.reset();
            //                 $(form).find('#attend_date_from').val(dataFormat);
            //                 $(form).find('#attend_date_to').attr('value',dataFormat);
            //                 $(form).find('#attend_date_from').attr('readonly', true);
            //                 $(form).find('#attendance_type').selectpicker('destroy');
            //                 $(form).find('#attendance_type').selectpicker();
            //                 var input_boxs = $('#hidden_attendance_input_box_container').html();
            //                 $(form).find('.attendance_status_input_container').html(input_boxs);
            //                 $(form).find('button.add-smoke-time-btn').css({'display':'block'});
            //                 $('#m-admin-new_attendance-modal').modal('show');
            //                 $(form).find('#attend_date_to').datepicker('destroy');
            //                 setJsplugin();
            //                 $(form).find('#attend_date_from').datepicker('destroy');
            //             } else {
            //                 var form = $('#m-admin-edit_attendance-form')[0];
            //                 form.reset();
            //                 $(form).find('#attendance_id').val(result.id);
            //                 $(form).find('#_attend_date').val(dataFormat);
            //                 $(form).find('#_attend_date').attr('readonly', true);
            //                 $(form).find('#_attendance_type').val(result.type);
            //                 $(form).find('#_attendance_type').selectpicker('destroy');
            //                 $(form).find('#_attendance_type').selectpicker();
            //                 if (result.type == 1) {
            //                     var input_boxs = $('#hidden_attendance_input_box_container').html();
            //                     $(form).find('.attendance_status_input_container').html(input_boxs);
            //                     $(form).find('input[name=attend_arrive_time]').attr('value', result.arrival_time);
            //                     $(form).find('input[name=attend_departure_time]').attr('value', result.departure_time);
            //                     $(form).find('input[name=break_start_1]').attr('value', result.break1_start_time);
            //                     $(form).find('input[name=break_end_1]').attr('value', result.break1_end_time);
            //                     $(form).find('input[name=break_start_2]').attr('value', result.break2_start_time);
            //                     $(form).find('input[name=break_end_2]').attr('value', result.break2_end_time);
            //                     $(form).find('button.add-smoke-time-btn').css({'display':'block'});
            //                     if (result.smokings) {
            //                         var somking_container = $(form).find('.smoke-time-container');
            //                         somking_container.html("");
            //                         result.smokings.forEach(function(smoke){
            //                             var new_smoking = '<div class="input-group m-input-group m-input-group--air">'+
            //                                                 '<a class="current_smoking_time_delete_btn" title="delete smoke time"><i class="la la-close"></i></a>'+
            //                                                 '<div class="row">'+
            //                                                     '<div class="col-sm-6">'+
            //                                                         '<div class="m-form__content"></div>'+
            //                                                         '<div class="form-group m-form__group">'+
            //                                                             '<label for="exampleInputEmail1">Start:</label>'+
            //                                                             '<div class="input-group m-input-group m-input-group--air">'+
            //                                                                 '<span class="input-group-addon"><i class="la la-clock-o"></i></span>'+
            //                                                                 '<input type="text" class="form-control m-input input-smoke-timepicker" name="attend_smoking_start[]" value="'+smoke.sm_start+'" placeholder="Enter time" required>'+
            //                                                             '</div>'+
            //                                                         '</div>'+
            //                                                         '<div class="m-form__content"></div>'+
            //                                                     '</div>'+
            //                                                     '<div class="col-sm-6">'+
            //                                                         '<div class="m-form__content"></div>'+
            //                                                         '<div class="form-group m-form__group">'+
            //                                                             '<label for="exampleInputEmail1">End:</label>'+
            //                                                             '<div class="input-group m-input-group m-input-group--air">'+
            //                                                                 '<span class="input-group-addon"><i class="la la-clock-o"></i></span>'+
            //                                                                 '<input type="text" class="form-control m-input input-smoke-timepicker" name="attend_smoking_end[]" value="'+smoke.sm_end+'" placeholder="Enter time" required>'+
            //                                                             '</div>'+
            //                                                         '</div>'+
            //                                                         '<div class="m-form__content"></div>'+
            //                                                     '</div>'+
            //                                                 '</div>'+
            //                                             '</div>';
            //                             somking_container.append(new_smoking);
            //                             somking_container.parents('.smoke-time-container-form').css({'display': 'block'});
            //                         });
            //                     }
            //                 } else {
            //                     $(form).find('.attendance_status_input_container').html("");
            //                     $(form).find('button.add-smoke-time-btn').css({'display':'none'});
            //                 }
            //                 setJsplugin();
            //                 $('#m-admin-edit_attendance-modal').modal('show');
            //
            //             }
            //         },
            //         error: function(result){
            //             console.log(result);
            //         }
            //     });
            // }
        });
        }
    };
}();

jQuery(document).ready(function() {
    CalendardBasic.init();
});
