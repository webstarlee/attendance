var CalendarBasic = function() {

    return {
        //main function to initiate the module
        init: function() {
            var todayDate = moment().startOf('day');
            var YM = todayDate.format('YYYY-MM');
            var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
            var TODAY = todayDate.format('YYYY-MM-DD');
            var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');

            var holidayCalendar = $('#m_holiday_calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay,listWeek'
                },
                editable: false,
                eventLimit: true, // allow "more" link when too many events
                navLinks: true,
                events: '/admin/manage/holiday/getAlldays/',

                eventRender: function(event, element) {
                    if (event.rendering == 'background') {
                        var bgEventTitle = document.createElement('div');
                        bgEventTitle.style.position = 'absolute';
                        bgEventTitle.style.bottom = '0';
                        bgEventTitle.classList.add('fc-event');
                        bgEventTitle.classList.add('holiday-calendar-title-div');
                        bgEventTitle.innerHTML = '<h3 class="fc-title holiday-calendar-custom-h3">' + event.title + '</h3>' ;
                        element.css('position', 'relative').html(bgEventTitle);
                    }
                },

                dayClick: function(date, jsEvent, view) {
                    var eventDate = date.format();
                    var dataFormat = date.format('MM/DD/YYYY');
                    var getData = '/admin/manage/holiday/checkDate/'+eventDate;
                    $.ajax({
                        url: getData,
                        type: 'get',
                        success: function(result){
                            if (result != "nodata" || jsEvent.target.classList.contains('fc-bgevent')) {
                                $('#m-admin-edit_holiday-form #holiday_id').val(result.id);
                                $('#m-admin-edit_holiday-form #_holi_date').val(dataFormat);
                                $('#m-admin-edit_holiday-form #_holi_date').attr('readonly', true);
                                $('#m-admin-edit_holiday-form #_holi_title').val(result.title);
                                $('#m-admin-edit_holiday-form #_holi_description').val(result.description);
                                $('#m-admin-edit_holiday-modal').modal('show');
                            } else{
                                $('#m-admin-new_holiday-form #holi_date').val(dataFormat);
                                $('#m-admin-new_holiday-form #holi_date').attr('readonly', true);
                                $('#m-admin-new_holiday-modal').modal('show');
                                $('#holi_date').datepicker('destroy');
                            }
                        },
                        error: function(result){
                            console.log(result);
                        }
                    });
                },
            });

            var holidayTable = $('#m_holiday_table').mDatatable({
              // datasource definition
              data: {
                type: 'remote',
                source: {
        			read: {
        				url: '/admin/manage/holiday/getAlldays/',
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
                  title: 'Title',
                  width: 150,
                  responsive: {visible: 'lg'},
                }, {
                  field: 'description',
                  title: 'Description',
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
                        <a href="javascript:;" data-holiday_date="'+row.start+'" class="m-holiday-edit-btn m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="View ">\
                        <i class="la la-edit"></i>\
                        </a>\
                        <a href="javascript:;" data-holiday_id="'+row.id+'" class="m-holiday-delete-btn m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="View ">\
                        <i class="la la-trash"></i>\
                        </a>\
                        ';
                    }
                }],
            });

            $('#add-new-holiday-btn').on('click', function(e) {
                e.preventDefault();
                var form = $('#m-admin-new_holiday-form')[0];
                form.reset();
                $(form).find('#holi_date').attr('readonly', false);
                $('#m-admin-new_holiday-modal').modal('show');
                setJsplugin();
            })

            $('#m-admin-new_holiday-form').on('submit', function(e) {
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
                submit_btn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        submit_btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                        holidayCalendar.fullCalendar('refetchEvents');
                        holidayTable.reload();
                        $('#m-admin-new_holiday-modal').modal('hide');
                    },
                    processData: false,
                    contentType: false,
                    error: function(data)
                   {
                       console.log(data);
                   }
                });
            })

            $('#m-admin-edit_holiday-form').on('submit', function(e) {
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
                        holidayCalendar.fullCalendar('refetchEvents');
                        holidayTable.reload();
                        $('#m-admin-edit_holiday-modal').modal('hide');
                    },
                    processData: false,
                    contentType: false,
                    error: function(data)
                   {
                       console.log(data);
                   }
                });
            })

            $('#holiday_delete_btn').on('click', function(e) {
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
                    var form = $this.parents('#m-admin-edit_holiday-form');
                    var holidayId = form.find('#holiday_id').val();
                    $.ajax({
                        url: '/admin/manage/holiday/destroy/'+holidayId,
                        type: 'get',
                        success: function(result){
                            $('#m-admin-edit_holiday-modal').modal('hide');
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
