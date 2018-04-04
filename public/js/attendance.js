//== Class definition
var datatable;

var DatatableAutoColumnHideDemo = function() {
  //== Private functions

  // basic demo
  var demo = function() {
    datatable = $('#m_attendance_datatable').mDatatable({
      // datasource definition
      data: {
        type: 'remote',
        source: {
			read: {
				url: '/admin/manage/attendance/getEmployee',
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
          field: 'username',
          title: 'UnserName',
          width: 150,
          template: function (row) {
              return '\
              <a class="employee-manage-unsername-select" href="/admin/manage/attendance/'+row.unique_id+'/view" target="_blank" title="'+row.username+'">\
              <img src="'+row.avatar+'">\
              <div style="padding-left:10px;"><p class="username-text">'+row.first_name+' '+row.last_name+' ('+row.client_id+')</p></div>\
              </a>\
              ';
          }
        }, {
          field: 'first_name',
          title: 'Full Name',
          width: 150,
          responsive: {visible: 'lg'},
        }, {
          field: 'last_name',
          title: 'SurName',
          width: 150,
          responsive: {visible: 'lg'},
        },{
          field: 'birth',
          title: 'Birthday',
          width: 150,
          responsive: {visible: 'lg'},
        }, {
            field: "Actions",
            width: 80,
            title: "Actions",
            sortable: false,
            overflow: 'visible',
            template: function (row, index, datatable) {
                var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';

                return '\
                <a href="/admin/manage/attendance/'+row.unique_id+'/view/'+'" target="_blank" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="View ">\
                <i class="la la-edit"></i>\
                </a>\
                ';
            }
        }],
    });
  };

  return {
    // public functions
    init: function() {
      demo();
    },
  };
}();

jQuery(document).ready(function() {
  DatatableAutoColumnHideDemo.init();
});
