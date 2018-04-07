var attendanceRequestTable;
var DatatableBasic = function() {

    return {
        //main function to initiate the module
        init: function() {

            attendanceRequestTable = $('#m_attendance_request_table').mDatatable({
              // datasource definition
              data: {
                type: 'remote',
                source: {
        			read: {
        				url: '/attendance/getAttendanceRequest/',
                        method: 'GET',
        			},
        		},
                pageSize: 10,
              },

              // column sorting
              sortable: true,

              pagination: true,

              toolbar: {
                // toolbar items
                items: {
                  // pagination
                  pagination: {
                    // page size select
                    pageSizeSelect: [10, 20, 30, 50, 100],
                  },
                },
              },

              search: {
                input: $('#generalSearch'),
              },

              // columns definition
              columns: [
                 {
                  field: "id",
                  title: "#",
                  width: 20,
                  sortable: false,
                  textAlign: 'center',
                  selector: {
                      class: 'm-checkbox--solid m-checkbox--brand',
                      name:'request_ids[]'
                  }
                }, {
                  field: 'color',
                  title: 'Type',
                  width: 100,
                  template: function (row, index, datatable) {
                      var new_color_div = '<span class="m-badge m-badge--wide" style="background-color: '+row.color+';color:#fff;">'+row.title+'</span>';
                      return new_color_div;
                  }
                }, {
                  field: 'date_from',
                  title: 'Date From',
                  width: 100,
                }, {
                  field: 'date_to',
                  title: 'Date To',
                  width: 100,
                }, {
                  field: 'total_work',
                  title: 'Working Time',
                  width: 150,
                  template: function (row, index, datatable) {
                      return row.start_time+'-'+row.end_time;
                  },
                  responsive: {visible: 'lg'},
                },{
                    field: "Actions",
                    width: 80,
                    title: "Actions",
                    sortable: false,
                    overflow: 'visible',
                    template: function (row, index, datatable) {
                        var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';

                        return '\
                        <a href="javascript:;" data-request_id="'+row.request_id+'" class="m-request-edit-btn m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="View ">\
                        <i class="la la-edit"></i>\
                        </a>\
                        <a href="javascript:;" data-request_id="'+row.request_id+'" class="m-request-delete-btn m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="View ">\
                        <i class="la la-trash"></i>\
                        </a>\
                        ';
                    }
                }],
            });

            $('#add-new-request-btn').on('click', function(e) {
                e.preventDefault();
                var form = $('#m-admin-new_request-form')[0];
                form.reset();
                $(form).find('#attendance_type').selectpicker('destroy');
                $(form).find('#attendance_type').selectpicker();
                var input_boxs = $('#hidden_attendance_input_box_container').html();
                $(form).find('.attendance_status_input_container').html(input_boxs);
                $(form).find('button.add-smoke-time-btn').css({'display':'block'});
                $('#m-admin-new_request-modal').modal('show');
                setJsplugin();
            });

            $('#m-admin-new_request-form select[name=attendance_type]').on('change', function(e) {
                e.preventDefault();
                var form = $('#m-admin-new_request-form');
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

            $('#m-admin-new_request-form').on('submit', function(e) {
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
                            if (typeof attendanceRequestTable !== 'undefined') {
                                attendanceRequestTable.reload();
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
                            if (typeof attendanceRequestTable !== 'undefined') {
                                attendanceRequestTable.reload();
                            }
                            $('#m-admin-new_request-modal').modal('hide');
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
                            if (typeof attendanceRequestTable !== 'undefined') {
                                attendanceRequestTable.reload();
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
                            if (typeof attendanceRequestTable !== 'undefined') {
                                attendanceRequestTable.reload();
                            }
                            $('#m-admin-new_request-modal').modal('hide');
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

            $(document).on('click', '.m-request-edit-btn', function(e) {
                e.preventDefault();
                var $this = $(this);
                var requestId = $this.data('request_id');
                var getData_url = '/attendance/getSingleAttendanceRequest/'+requestId;
                $.ajax({
                    url: getData_url,
                    type: 'get',
                    success: function(result){
                        var form = $('#m-admin-edit_attendance-form')[0];
                        form.reset();
                        $(form).find('#attendance_request_id').val(result.id);
                        $(form).find('#_attend_date_from').val(result.attend_date_from);
                        $(form).find('#_attend_date_from').datepicker('destroy');
                        $(form).find('#_attend_start_time').val(result.start_time);
                        $(form).find('#_attend_date_to').val(result.attend_date_to);
                        $(form).find('#_attend_date_to').datepicker('destroy');
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
                        $('#m-admin-edit_attendance-modal').modal('show');
                    },
                    error: function(result){
                        console.log(result);
                    }
                });
            })

            $(document).on('click', '.m-request-delete-btn', function(e) {
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
                        var requestId = $this.data('request_id');
                        $.ajax({
                            url: '/attendance/request/destroy/'+requestId,
                            type: 'get',
                            success: function(result){
                                swal({
                                    "title": "Success",
                                    "text": "Attendance Deleted !.",
                                    "type": "success",
                                    "confirmButtonClass": "btn m-btn--air btn-outline-accent"
                                });
                                if (typeof attendanceRequestTable !== 'undefined') {
                                    attendanceRequestTable.reload();
                                }
                                if (typeof attendanceRequestTable !== 'undefined') {
                                    attendanceRequestTable.reload();
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
    DatatableBasic.init();
});
