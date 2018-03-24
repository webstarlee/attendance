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
        				url: '/admin/manage/attendance/request/getSingleData/'+golbalEmployeeId,
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
                }, {
                  field: 'color',
                  title: 'Status',
                  width: 50,
                  template: function (row, index, datatable) {
                      var new_color_div = '<div style="margin: 0 auto; width: 25px; height: 25px; background-color: '+row.color+'"></div>';
                      return new_color_div;
                  }
                }, {
                  field: 'start',
                  title: 'Date From',
                  width: 100,
                }, {
                  field: 'end',
                  title: 'Date To',
                  width: 100,
                }, {
                  field: 'total_work',
                  title: 'Working Time',
                  width: 150,
                  template: function(row, index, datatable) {
                      var string_working = "";
                      if (row.status == 1) {
                          string_working = '<p style="margin-bottom: 0;">Worked</p>';
                      } else if (row.status == 0) {
                          string_working = '<p style="margin-bottom: 0;">Absence</p>';
                      } else if (row.status == 2) {
                          string_working = '<p style="margin-bottom: 0;">Business Trip</p>';
                      } else if (row.status == 3) {
                          string_working = '<p style="margin-bottom: 0;">Vacation</p>';
                      } else if (row.status == 4) {
                          string_working = '<p style="margin-bottom: 0;">Sickness</p>';
                      }

                      return string_working;
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
                        <a href="javascript:;" data-attendance_request_id="'+row.id+'" class="m-attendance-request-view-btn m-portlet__nav-link btn m-btn m-btn--hover-primary m-btn--icon m-btn--icon-only m-btn--pill" title="View">\
                        <i class="la la-edit"></i>\
                        </a>\
                        <a href="javascript:;" data-attendance_request_id="'+row.id+'" class="m-attendance-request-approve-btn m-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill" title="Approve">\
                        <i class="la la-hand-rock-o"></i>\
                        </a>\
                        ';
                    }
                }],
            });

        }
    };
}();

jQuery(document).ready(function() {
    DatatableBasic.init();
});
