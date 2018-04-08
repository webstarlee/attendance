var attendanceTable;
var DatatableBasic = function() {

    return {
        //main function to initiate the module
        init: function() {

            attendanceTable = $('#m_project_table').mDatatable({
              // datasource definition
              data: {
                type: 'remote',
                source: {
        			read: {
        				url: '/project/getData/',
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
                  field: 'pro_name',
                  title: i18n.language.title,
                  width: 100,
                }, {
                  field: 'pro_id',
                  title: i18n.language.project.project_id,
                  width: 100,
                  responsive: {visible: 'lg'},
                }, {
                  field: 'pro_leader',
                  title: i18n.language.leader,
                  width: 100,
                  responsive: {visible: 'lg'},
                  template: function (row) {
                      return '\
                      <a href="/admin/profile/employee/'+row.leader_unique+'" target="_blank" title="'+row.leader_name+'" style="display:inline-block;">\
                        <img src="'+row.leader_photo+'" style="width:35px;height:35px;border-radius:50%;">\
                      </a>\
                      ';
                  }
                },{
                  field: 'members',
                  title: i18n.language.member,
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
                  field: 'pro_end_date',
                  title: i18n.language.deadline,
                  width: 100,
                  responsive: {visible: 'lg'},
                }, {
                  field: 'pro_priority',
                  title: i18n.language.priority,
                  width: 100,
                  responsive: {visible: 'lg'},
                  template: function (row) {
                    var status = {
                        0: {'title': 'High', 'class': 'm-badge--danger'},
                        1: {'title': 'Medium', 'class': ' m-badge--accent'},
                        2: {'title': 'Low', 'class': ' m-badge--primary'},
                    };
                     return '<span class="m-badge ' + status[row.pro_priority].class + ' m-badge--wide" style="width:70px;">' + status[row.pro_priority].title + '</span>';
                  }
                }, {
                  field: 'pro_status',
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
                            <span class="m-badge m-badge--' + status[row.pro_status].state + ' m-badge--dot"></span>\
                            &nbsp;<span class="m--font-bold m--font-' + status[row.pro_status].state + '"> \
                                '+status[row.pro_status].title+' </span>\
                            </a>\
						</div>\
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
