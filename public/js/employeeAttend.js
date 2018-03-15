var CalendarBasic = function() {

    return {
        //main function to initiate the module
        init: function() {
            var todayDate = moment().startOf('day');
            var YM = todayDate.format('YYYY-MM');
            var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
            var TODAY = todayDate.format('YYYY-MM-DD');
            var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');
            var golbalEmployeeId = $('#golobal_employee_id').val();

            var attendanceCalendar = $('#m_attendance_calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay,listWeek'
                },
                editable: false,
                eventLimit: true, // allow "more" link when too many events
                navLinks: true,
                events: '/attendance/getAttendance/',

                eventRender: function(event, element) {

                },

                dayClick: function(date, jsEvent, view) {
                    var eventDate = date.format();
                    var dataFormat = date.format('MM/DD/YYYY');
                    var getData = '/attendance/checkSingleData/'+eventDate;
                    $.ajax({
                        url: getData,
                        type: 'get',
                        success: function(result){
                            console.log(result);
                            if (result == "nodata") {
                                $('#m-employee-new_attendance-form #attend_date').val(dataFormat);
                                $('#m-employee-new_attendance-form #attend_date').attr('readonly', true);
                                $('#m-employee-new_attendance-modal').modal('show');
                                $('#attend_date').datepicker('destroy');
                            }
                        },
                        error: function(result){
                            console.log(result);
                        }
                    });
                },

                eventClick: function(event) {
                    var eventDate = event.start.format('MM/DD/YYYY');
                    var getData_url = '/attendance/getSingleAttendance/'+event.id;
                    $.ajax({
                        url: getData_url,
                        type: 'get',
                        success: function(result){
                            if (result != "nodata") {
                                $('#m-employee-edit_attendance-form #attendance_id').val(event.id);
                                $('#m-employee-edit_attendance-form #_attend_date').val(eventDate);
                                $('#m-employee-edit_attendance-form #_attend_date').attr('readonly', true);
                                $('#m-employee-edit_attendance-form #_contract_type').val(result.contract_id);
                                $('#m-employee-edit_attendance-form #_contract_type').selectpicker('destroy');
                                $('#m-employee-edit_attendance-form #_contract_type').selectpicker();
                                $('#m-employee-edit_attendance-modal').modal('show');
                            }
                        },
                        error: function(result){
                            console.log(result);
                        }
                    });
                }
            });

            var attendanceTable = $('#m_attendance_table').mDatatable({
              // datasource definition
              data: {
                type: 'remote',
                source: {
        			read: {
        				url: '/attendance/getAttendance/',
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
                  selector: {class: 'm-checkbox--solid m-checkbox--brand'}
                },
                {
                  field: 'start',
                  title: 'Date',
                  width: 150,
                }, {
                  field: 'title',
                  title: 'Contract Type',
                  width: 150,
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
                        <a href="javascript:;" data-attendance_id="'+row.id+'" class="m-attendance-edit-btn m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="View ">\
                        <i class="la la-edit"></i>\
                        </a>\
                        <a href="javascript:;" data-attendance_id="'+row.id+'" class="m-attendance-delete-btn m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="View ">\
                        <i class="la la-trash"></i>\
                        </a>\
                        ';
                    }
                }],
            });

            $('#add-new-attendance-btn').on('click', function(e) {
                e.preventDefault();
                var form = $('#m-employee-new_attendance-form')[0];
                form.reset();
                $(form).find('#attend_date').attr('readonly', false);
                $('#m-employee-new_attendance-modal').modal('show');
                setJsplugin();
            })

            $('#m-employee-new_attendance-form').on('submit', function(e) {
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
                        if (data == "fail") {
                            swal({
                                title: 'Failed?',
                                text: "Already Exist attendance",
                                type: 'error',
                                showCancelButton: false,
                                confirmButtonText: "Ok!",
                                confirmButtonClass: "btn m-btn--air btn-outline-accent",
                            });
                        } else {
                            attendanceCalendar.fullCalendar('refetchEvents');
                            attendanceTable.reload();
                        }
                        submit_btn.removeClass('m-loader m-loader--success m-loader--right').attr('disabled', false);
                        $('#m-employee-new_attendance-modal').modal('hide');
                    },
                    processData: false,
                    contentType: false,
                    error: function(data)
                   {
                       console.log(data);
                   }
                });
            });

            $('#m-employee-edit_attendance-form').on('submit', function(e) {
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
                        attendanceCalendar.fullCalendar('refetchEvents');
                        attendanceTable.reload();
                        $('#m-employee-edit_attendance-modal').modal('hide');
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
                        var form = $this.parents('#m-employee-edit_attendance-form');
                        var attendanceId = form.find('#attendance_id').val();
                        $.ajax({
                            url: '/attendance/destroy/'+attendanceId,
                            type: 'get',
                            success: function(result){
                                $('#m-employee-edit_attendance-modal').modal('hide');
                                swal({
                                    "title": "Success",
                                    "text": "Holiday Deleted !.",
                                    "type": "success",
                                    "confirmButtonClass": "btn m-btn--air btn-outline-accent"
                                });
                                attendanceCalendar.fullCalendar('refetchEvents');
                                attendanceTable.reload();
                            },
                            error: function(error){
                                console.log(error);
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.m-attendance-edit-btn', function(e) {
                e.preventDefault();
                var $this = $(this);
                var attendanceId = $this.data('attendance_id');
                var getData_url = '/attendance/getSingleAttendance/'+attendanceId;
                $.ajax({
                    url: getData_url,
                    type: 'get',
                    success: function(result){
                        if (result != "nodata") {
                            var from = result.attendance_date.split("-");
                            var dateYear = from[0];
                            var dateMonth = from[1];
                            var dateDay = from[2];
                            var dataFormat = dateMonth+"/"+dateDay+"/"+dateYear;

                            $('#m-employee-edit_attendance-form #attendance_id').val(attendanceId);
                            $('#m-employee-edit_attendance-form #_attend_date').val(dataFormat);
                            $('#m-employee-edit_attendance-form #_attend_date').attr('readonly', true);
                            $('#m-employee-edit_attendance-form #_contract_type').val(result.contract_id);
                            $('#m-employee-edit_attendance-form #_contract_type').selectpicker('destroy');
                            $('#m-employee-edit_attendance-form #_contract_type').selectpicker();
                            $('#m-employee-edit_attendance-modal').modal('show');
                        }
                    },
                    error: function(result){
                        console.log(result);
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
                            url: '/attendance/destroy/'+attendanceId,
                            type: 'get',
                            success: function(result){
                                swal({
                                    "title": "Success",
                                    "text": "Attendance Deleted !.",
                                    "type": "success",
                                    "confirmButtonClass": "btn m-btn--air btn-outline-accent"
                                });
                                attendanceCalendar.fullCalendar('refetchEvents');
                                attendanceTable.reload();
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
    CalendarBasic.init();
});
