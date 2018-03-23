var attendanceTable;
var DatatableBasic = function() {

    return {
        //main function to initiate the module
        init: function() {

            attendanceTable = $('#m_attendance_table').mDatatable({
              // datasource definition
              data: {
                type: 'remote',
                source: {
        			read: {
        				url: '/admin/manage/attendance/getSingleData/'+golbalEmployeeId,
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
                  title: 'Date',
                  width: 100,
                }, {
                  field: 'total_work',
                  title: 'Working Time',
                  width: 150,
                  template: function(row, index, datatable) {
                      var string_working = "";
                      if (row.status == 1) {
                          var minutes = row.total_work%60;
                          var hours = (row.total_work - minutes)/60;
                          if (hours == 0) {
                              string_working = '<p style="margin-bottom: 0;">'+minutes+' minutes </p>';
                          } else if(minutes == 0) {
                              string_working = '<p style="margin-bottom: 0;">'+hours+' hours </p>';
                          } else {
                              string_working = '<p style="margin-bottom: 0;">'+hours+' hours </p><p style="margin-bottom: 0;">'+minutes+' minutes </p>';
                          }
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

        }
    };
}();

jQuery(document).ready(function() {
    DatatableBasic.init();
});
