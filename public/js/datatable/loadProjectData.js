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

    var datatable = $('#m_project_datatable').mDatatable({
      // datasource definition
      data: {
        type: 'remote',
        source: {
			read: {
				url: '/admin/manage/project/get_table_date',
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
          // template: function (row) {
          //     return '\
          //     <a href="/admin/manage/project/view_project/'+row.leader_unique+'" target="_blank" title="'+row.pro_name+'">\
          //       '+row.pro_name+'\
          //     </a>\
          //     ';
          // }

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
							<a href="#" class="btn m-btn--hover-metal" data-toggle="dropdown">\
                            <span class="m-badge m-badge--' + status[row.pro_status].state + ' m-badge--dot"></span>\
                            &nbsp;<span class="m--font-bold m--font-' + status[row.pro_status].state + '"> \
                                '+status[row.pro_status].title+' </span>\
                            </a>\
						  	<div class="dropdown-menu dropdown-menu-right">\
                                <a class="dropdown-item project-status-change-btn" data-project_id="'+row.id+'" data-project_status="0" href="javascript:;">\
                                    <span class="m-badge m-badge--' + status[0].state + ' m-badge--dot"></span>\
                                    &nbsp;<span class="m--font-bold m--font-' + status[0].state + '">'+status[0].title+'</span></a>\
                                <a class="dropdown-item project-status-change-btn" data-project_id="'+row.id+'" data-project_status="1" href="javascript:;">\
                                    <span class="m-badge m-badge--' + status[1].state + ' m-badge--dot"></span>\
                                    &nbsp;<span class="m--font-bold m--font-' + status[1].state + '">'+status[1].title+'</span></a>\
                                <a class="dropdown-item project-status-change-btn" data-project_id="'+row.id+'" data-project_status="2" href="javascript:;">\
                                    <span class="m-badge m-badge--' + status[2].state + ' m-badge--dot"></span>\
                                    &nbsp;<span class="m--font-bold m--font-' + status[2].state + '">'+status[2].title+'</span></a>\
						  	</div>\
						</div>\
                        ';
          }
        }, {
            field: "Actions",
            width: 80,
            title: "Actions",
            sortable: false,
            overflow: 'visible',
            template: function (row, index, datatable) {
                return '\
                <a href="javascript:;" data-project_id="'+row.id+'" class="m-project-edit_btn m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="View ">\
                <i class="la la-edit"></i>\
                </a>\
                <a href="javascript:;" data-project_id="'+row.id+'" class="m-project-delete_btn m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="View ">\
                <i class="la la-trash"></i>\
                </a>\
                ';
            }
        }],
    });

    $('#m-admin-new_project-form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this)[0];
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        var url = $(form).attr( 'action' );

        var formData = new FormData($(form)[0]);
        var submit_btn = $(form).find('.form-submit-btn');
        submit_btn.addClass('m-loader m-loader--right m-loader--success').attr('disabled', true);
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function (data) {
                submit_btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                datatable.reload();
                form.reset();
                $('.m_selectpicker').selectpicker('destroy');
                init_plugins();
                $('#m-admin-new_project-modal').modal('hide');
            },
            processData: false,
            contentType: false,
            error: function(data)
           {
               console.log(data);
           }
        });
    });

    $('#m-admin-edit_project-form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this)[0];
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        var url = $(form).attr( 'action' );

        var formData = new FormData($(form)[0]);
        var submit_btn = $(form).find('.form-submit-btn');
        submit_btn.addClass('m-loader m-loader--right m-loader--success').attr('disabled', true);
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function (data) {
                submit_btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                datatable.reload();
                form.reset();
                $('.m_selectpicker').selectpicker('destroy');
                init_plugins();
                $('#m-admin-edit_project-modal').modal('hide');
            },
            processData: false,
            contentType: false,
            error: function(data)
           {
               console.log(data);
           }
        });
    });

    $(document).on('click', '.m-project-edit_btn', function(){
        var $this = $(this);
        var project_id = $this.data('project_id');
        $.ajax({
            url: '/admin/manage/project/get_specify_project/'+project_id,
            type: 'get',
            success: function(result){
                console.log(result);
                if (result != "fail") {
                    $('#m-admin-edit_project-form #project_id_for_edit').val(result.id);
                    $('#m-admin-edit_project-form #_project_title').val(result.pro_name);
                    $('#m-admin-edit_project-form #_project_client').val(result.pro_client);
                    $('#m-admin-edit_project-form #_project_start_date').attr('value', result.pro_start_date);
                    $('#m-admin-edit_project-form #_project_end_date').attr('value', result.pro_end_date);
                    $('#m-admin-edit_project-form #_project_rate').val(result.pro_rate);
                    $('#m-admin-edit_project-form #_project_rate_type').val(result.pro_rate_type);
                    $('#m-admin-edit_project-form #_project_priority').val(result.pro_priority);
                    $('#m-admin-edit_project-form #_project_leader').val(result.pro_leader);
                    $('#m-admin-edit_project-form #_project_members').val(result.pro_members);
                    $('#m-admin-edit_project-form #_project_note').val(result.pro_note);
                    $('.m_selectpicker').selectpicker('destroy');
                    init_plugins();
                    $('#m-admin-edit_project-modal').modal('show');
                }
            },
            error: function(error){
                console.log(error);
            }
        });
    });

    $(document).on('click', '.project-status-change-btn', function(){
        var $this = $(this);
        var current_project_id = $this.data('project_id');
        var current_project_status = $this.data('project_status');
        $.ajax({
            url: '/admin/manage/project/set_status/'+current_project_id+'/'+current_project_status,
            type: 'get',
            success: function(result){
                console.log(result);
                if (result != "fail") {
                    datatable.reload();
                }
            },
            error: function(error){
                console.log(error);
            }
        });
    });

    $(document).on('click', '.m-depatment-delete_btn', function(){
        console.log("disabled currently");
        // var $this = $(this);
        // swal({
        //     title: 'Are you sure?',
        //     text: "Do want to delete !",
        //     type: 'warning',
        //     showCancelButton: true,
        //     confirmButtonText: 'Yes, delete it!'
        // }).then(function(result) {
        //     if (result.value) {
        //         var contract_id = $this.data('contract_id');
        //         $.ajax({
        //             url: '/admin/manage/contract/delete/'+contract_id,
        //             type: 'get',
        //             success: function(result){
        //                 if (result == "success") {
        //                     swal({
        //                         "title": "Success",
        //                         "text": "Admin Deleted !.",
        //                         "type": "success",
        //                         "confirmButtonClass": "btn btn-secondary m-btn m-btn--wide"
        //                     });
        //                     datatable.reload();
        //                 } else if (result == "fail") {
        //                     swal({
        //                         "title": "Faild",
        //                         "text": "Sent something Wrong !.",
        //                         "type": "error",
        //                         "confirmButtonClass": "btn btn-secondary m-btn m-btn--wide"
        //                     });
        //                 }
        //             },
        //             error: function(error){
        //                 console.log(error);
        //             }
        //         });
        //     }
        // });
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
