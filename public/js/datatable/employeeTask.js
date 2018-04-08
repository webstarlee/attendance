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

    var datatable = $('#m_task_datatable').mDatatable({
      // datasource definition
      data: {
        type: 'remote',
        source: {
			read: {
				url: '/task/getData',
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
          field: 'task_name',
          title: i18n.language.project.task,
          width: 100,
        }, {
          field: 'pro_name',
          title: i18n.language.project.project_name,
          width: 150,
          responsive: {visible: 'sm'},
        }, {
          field: 'members',
          title: i18n.language.assigned,
          width: 150,
          responsive: {visible: 'lg'},
          template: function (row, index, datatable) {
              var $final_members = "";
              var member_count = 0;
              row.members.forEach(function(member) {
                  member_count ++;
                  if (member_count < 4) {
                      $final_members += '<a href="/admin/profile/employee/'+member.member_unique+'" target="_blank" title="'+member.member_username+'" style="display:inline-block;">'+
                                        '<img src="'+member.member_avatar+'" style="width:35px;height:35px;border-radius:50%;"></a>';
                  }
              });
              if (member_count > 3) {
                  var left_member = member_count - 3;
                  $final_members += '<a href="#" style="display:flex;width:35px;height:35px;background-color:#ddd;border-radius:50%;text-align:center;justify-content:center;flex-direction:column;">+'+left_member+'</a>';
              }
              return '<div style="display: flex;">'+$final_members+'</div>';
          }
        }, {
          field: 'task_status',
          title: i18n.language.status,
          width: 100,
          overflow: 'visible',
          responsive: {visible: 'lg'},
          template: function (row, index, datatable) {
              var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';
              var status = {
                0: {'title': 'Inactive', 'state': 'danger'},
                1: {'title': 'Active', 'state': 'primary'},
                2: {'title': 'Complete', 'state': 'accent'},
              };

              return '\
						<div class="dropdown ' + dropup + '">\
							<a href="#" class="btn">\
                            <span class="m-badge m-badge--' + status[row.task_status].state + ' m-badge--dot"></span>\
                            &nbsp;<span class="m--font-bold m--font-' + status[row.task_status].state + '"> \
                                '+status[row.task_status].title+' </span>\
                            </a>\
						</div>\
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
