//== Class definition

function init_plugins(){
    $('.m_selectpicker').selectpicker();

    $('.m-datepciker').datepicker({
        todayHighlight: true,
        autoclose: true,
        orientation: "bottom left",
        templates: {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }
    });

    $('.m-input-mask-int').inputmask({
        "mask": "9",
        "repeat": 9,
        "greedy": false
    });
}

var DatatableAutoColumnHideDemo = function() {
  //== Private functions

  // basic demo
  var demo = function() {

      init_plugins();

    var datatable = $('#m_sheet_datatable').mDatatable({
      // datasource definition
      data: {
        type: 'remote',
        source: {
			read: {
				url: '/timingsheet/getData',
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
          field: 'employee_name',
          title: i18n.language.assigned,
          width: 150,
          responsive: {visible: 'lg'},
          template: function (row, index, datatable) {
              return '\
              <a class="text-hover-decoration" href="/admin/profile/employee/'+row.employee_unique_id+'" target="_blank" title="'+row.employee_name+'">\
              <img src="'+row.employee_photo+'" style="width:35px;height:35px;border-radius:50%;">\
              <span style="padding-left:10px;">'+row.employee_name+'</span>\
              </a>\
              ';
          }
        }, {
          field: 'pro_name',
          title: i18n.language.project.project_name,
          width: 100,
        }, {
          field: 'sheet_date',
          title: i18n.language.date,
          width: 100,
        }, {
          field: 'sheet_time',
          title: i18n.language.time,
          width: 100,
          template: function (row, index, datatable) {
              return row.sheet_time+" hours";
          }
        }, {
          field: 'sheet_note',
          title: i18n.language.description,
          width: 100,
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
