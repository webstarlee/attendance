var AttendBasic = function() {

    return {
        //main function to initiate the module
        init: function() {

            $('#add-new-attendance-btn').on('click', function(e) {
                e.preventDefault();
                var form = $('#m-admin-new_attendance-form')[0];
                form.reset();
                $(form).find('#attend_date').attr('readonly', false);
                $(form).find('#attendance_type').selectpicker('destroy');
                $(form).find('#attendance_type').selectpicker();
                var input_boxs = $('#hidden_attendance_input_box_container').html();
                $(form).find('.attendance_status_input_container').html(input_boxs);
                $(form).find('button.add-smoke-time-btn').css({'display':'block'});
                $('#m-admin-new_attendance-modal').modal('show');
                setJsplugin();
            });

            $('#m-admin-new_attendance-form select[name=attendance_type]').on('change', function(e) {
                e.preventDefault();
                var form = $('#m-admin-new_attendance-form');
                var select_box = $(this);
                var current_status = select_box.val();
                var attendance_input_container = form.find('.attendance_status_input_container')[0];
                var smoking_add_btn = form.find('button.add-smoke-time-btn');
                if (current_status == 1) {
                    if(attendance_input_container.childNodes.length == 0) {
                        var input_boxs = $('#hidden_attendance_input_box_container').html();
                        $(attendance_input_container).html(input_boxs);
                        smoking_add_btn.css({'display': 'block'});
                        setJsplugin();
                    }
                } else {
                    $(attendance_input_container).html("");
                    smoking_add_btn.css({'display': 'none'});
                }
            });

            $('#m-admin-edit_attendance-form select[name=_attendance_type]').on('change', function(e) {
                e.preventDefault();
                var form = $('#m-admin-edit_attendance-form');
                var select_box = $(this);
                var current_status = select_box.val();
                var attendance_input_container = form.find('.attendance_status_input_container')[0];
                var smoking_add_btn = form.find('button.add-smoke-time-btn');
                if (current_status == 1) {
                    if(attendance_input_container.childNodes.length == 0) {
                        var input_boxs;
                        if (random_string_id == null) {
                                input_boxs = $('#hidden_attendance_input_box_container').html();
                        } else {
                            input_boxs = $('#'+random_string_id).html();
                        }
                        $(attendance_input_container).html(input_boxs);
                        smoking_add_btn.css({'display': 'block'});
                        setJsplugin();
                    }

                    if (random_string_id != null) {
                        $('#'+random_string_id).remove();
                    }
                    random_string_id = null;
                } else {
                    if(attendance_input_container.childNodes.length != 0) {
                        if (random_string_id == null) {
                            random_string_id = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
                            var new_random_div = '<div id="'+random_string_id+'" style="display: none;"></div>';
                            $('body .m-content').append(new_random_div);
                        }
                        $('#'+random_string_id).html($(attendance_input_container).html());
                        $(attendance_input_container).html("");
                    }
                    smoking_add_btn.css({'display': 'none'});
                }
            });

            $(document).on('click', '.add-smoke-time-btn', function(e) {
                e.preventDefault();
                var form = $(this).parents('form')[0];
                var smoke_container = $(form).find('.smoke-time-container');
                var new_smoking = '<div class="input-group m-input-group m-input-group--air">'+
                                    '<a class="current_smoking_time_delete_btn" title="delete smoke time"><i class="la la-close"></i></a>'+
                                    '<div class="row">'+
                                        '<div class="col-sm-6">'+
                                            '<div class="m-form__content"></div>'+
                                            '<div class="form-group m-form__group">'+
                                                '<label for="exampleInputEmail1">Start:</label>'+
                                                '<div class="input-group m-input-group m-input-group--air">'+
                                                    '<span class="input-group-addon"><i class="la la-clock-o"></i></span>'+
                                                    '<input type="text" class="form-control m-input input-smoke-timepicker" name="attend_smoking_start[]" value="" placeholder="Enter time" required>'+
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
                                                    '<input type="text" class="form-control m-input input-smoke-timepicker" name="attend_smoking_end[]" value="" placeholder="Enter time" required>'+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="m-form__content"></div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>';
                smoke_container.append(new_smoking);
                smoke_container.parents('.smoke-time-container-form').css({'display': 'block'});
                setJsplugin();
            });

            $(document).on('click', '.add-break-time-btn', function(e) {
                e.preventDefault();
                var form = $(this).parents('form')[0];
                var smoke_container = $(form).find('.break-time-container');
                var new_smoking = '<div class="input-group m-input-group m-input-group--air">'+
                                    '<a class="current_smoking_time_delete_btn" title="delete break time"><i class="la la-close"></i></a>'+
                                    '<div class="row">'+
                                        '<div class="col-sm-6">'+
                                            '<div class="m-form__content"></div>'+
                                            '<div class="form-group m-form__group">'+
                                                '<label for="exampleInputEmail1">Start:</label>'+
                                                '<div class="input-group m-input-group m-input-group--air">'+
                                                    '<span class="input-group-addon"><i class="la la-clock-o"></i></span>'+
                                                    '<input type="text" class="form-control m-input input-smoke-timepicker" name="attend_break_start[]" value="" placeholder="Enter time" required>'+
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
                                                    '<input type="text" class="form-control m-input input-smoke-timepicker" name="attend_break_end[]" value="" placeholder="Enter time" required>'+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="m-form__content"></div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>';
                smoke_container.append(new_smoking);
                smoke_container.parents('.break-time-container-form').css({'display': 'block'});
                setJsplugin();
            });

            $(document).on('click', '.current_smoking_time_delete_btn', function(e){
                e.preventDefault();
                var smoking_time_form = $(this).parent();
                var top_container = smoking_time_form.parent();
                smoking_time_form.remove();
                if (top_container[0].childNodes.length == 0) {
                    top_container.parent().css({'display': 'none'});
                }
            });

            $('#m-admin-new_attendance-form').on('submit', function(e) {
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
                        console.log(data);
                        submit_btn.removeClass('m-loader m-loader--success m-loader--right').attr('disabled', false);
                        if (data == "fail_3") {
                            swal({
                                title: 'Failed?',
                                text: "Inserted to outside of person employment",
                                type: 'error',
                                showCancelButton: false,
                                confirmButtonText: "Ok!",
                                confirmButtonClass: "btn m-btn--air btn-outline-accent",
                            });
                        } else if (data == "fail_vac_limit") {
                            if (typeof attendanceCalendar !== 'undefined') {
                                attendanceCalendar.fullCalendar('refetchEvents');
                            }
                            swal({
                                title: 'Failed?',
                                text: "There is not available vacation",
                                type: 'error',
                                showCancelButton: false,
                                confirmButtonText: "Ok!",
                                confirmButtonClass: "btn m-btn--air btn-outline-accent",
                            });
                        } else {
                            if (typeof attendanceCalendar !== 'undefined') {
                                attendanceCalendar.fullCalendar('refetchEvents');
                            }
                            vac_circle_calc();
                            $('#m-admin-new_attendance-modal').modal('hide');
                        }
                    },
                    processData: false,
                    contentType: false,
                    error: function(data)
                   {
                       console.log(data);
                   }
                });
            });

            $('#m-admin-edit_attendance-form').on('submit', function(e) {
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
                        submit_btn.removeClass('m-loader m-loader--success m-loader--right').attr('disabled', false);
                        if (data == "fail_3") {
                            swal({
                                title: 'Failed?',
                                text: "Inserted to outside of person employment",
                                type: 'error',
                                showCancelButton: false,
                                confirmButtonText: "Ok!",
                                confirmButtonClass: "btn m-btn--air btn-outline-accent",
                            });
                        } else if (data == "fail_vac_limit") {
                            if (typeof attendanceCalendar !== 'undefined') {
                                attendanceCalendar.fullCalendar('refetchEvents');
                            }
                            swal({
                                title: 'Failed?',
                                text: "There is not available vacation",
                                type: 'error',
                                showCancelButton: false,
                                confirmButtonText: "Ok!",
                                confirmButtonClass: "btn m-btn--air btn-outline-accent",
                            });
                        } else {
                            if (typeof attendanceCalendar !== 'undefined') {
                                attendanceCalendar.fullCalendar('refetchEvents');
                            }
                            vac_circle_calc();
                            $('#m-admin-edit_attendance-modal').modal('hide');
                        }
                    },
                    processData: false,
                    contentType: false,
                    error: function(data)
                   {
                       console.log(data);
                   }
                });
            });

            $('#attendance_delete_btn').on('click', function(e) {
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
                    if (result.value) {
                        var form = $this.parents('#m-admin-edit_attendance-form');
                        var attendanceId = form.find('#attendance_id').val();
                        $.ajax({
                            url: '/admin/manage/attendance/destroy/'+attendanceId,
                            type: 'get',
                            success: function(result){
                                $('#m-admin-edit_attendance-modal').modal('hide');
                                swal({
                                    "title": "Success",
                                    "text": "Holiday Deleted !.",
                                    "type": "success",
                                    "confirmButtonClass": "btn m-btn--air btn-outline-accent"
                                });
                                if (typeof attendanceCalendar !== 'undefined') {
                                    attendanceCalendar.fullCalendar('refetchEvents');
                                }
                                if (typeof attendanceTable !== 'undefined') {
                                    attendanceTable.reload();
                                }
                            },
                            error: function(error){
                                console.log(error);
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.m-attendance-delete-btn', function(e) {
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
                    if (result.value) {
                        var attendanceId = $this.data('attendance_id');
                        $.ajax({
                            url: '/admin/manage/attendance/destroy/'+attendanceId,
                            type: 'get',
                            success: function(result){
                                swal({
                                    "title": "Success",
                                    "text": "Attendance Deleted !.",
                                    "type": "success",
                                    "confirmButtonClass": "btn m-btn--air btn-outline-accent"
                                });
                                if (typeof attendanceCalendar !== 'undefined') {
                                    attendanceCalendar.fullCalendar('refetchEvents');
                                }
                                if (typeof attendanceTable !== 'undefined') {
                                    attendanceTable.reload();
                                }
                            },
                            error: function(error){
                                console.log(error);
                            }
                        });
                    }
                });
            });

        }
    };
}();

jQuery(document).ready(function() {
    AttendBasic.init();
});
