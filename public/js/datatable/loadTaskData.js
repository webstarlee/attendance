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
				url: '/admin/manage/project/task/get_table_date',
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
							<a href="#" class="btn m-btn--hover-metal" data-toggle="dropdown">\
                            <span class="m-badge m-badge--' + status[row.task_status].state + ' m-badge--dot"></span>\
                            &nbsp;<span class="m--font-bold m--font-' + status[row.task_status].state + '"> \
                                '+status[row.task_status].title+' </span>\
                            </a>\
						  	<div class="dropdown-menu dropdown-menu-right">\
                                <a class="dropdown-item task-status-change-btn" data-task_id="'+row.id+'" data-task_status="0" href="javascript:;">\
                                    <span class="m-badge m-badge--' + status[0].state + ' m-badge--dot"></span>\
                                    &nbsp;<span class="m--font-bold m--font-' + status[0].state + '">'+status[0].title+'</span></a>\
                                <a class="dropdown-item task-status-change-btn" data-task_id="'+row.id+'" data-task_status="1" href="javascript:;">\
                                    <span class="m-badge m-badge--' + status[1].state + ' m-badge--dot"></span>\
                                    &nbsp;<span class="m--font-bold m--font-' + status[1].state + '">'+status[1].title+'</span></a>\
                                <a class="dropdown-item task-status-change-btn" data-task_id="'+row.id+'" data-task_status="2" href="javascript:;">\
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
                <a href="javascript:;" data-task_id="'+row.id+'" class="m-task-edit_btn m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="View ">\
                <i class="la la-edit"></i>\
                </a>\
                <a href="javascript:;" data-task_id="'+row.id+'" class="m-task-edit_btn m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="View ">\
                <i class="la la-trash"></i>\
                </a>\
                ';
            }
        }],
    });

    $('#m-admin-new_task-form').on('submit', function(e) {
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
                $('#m-admin-new_task-modal').modal('hide');
            },
            processData: false,
            contentType: false,
            error: function(data)
           {
               console.log(data);
           }
        });
    });

    $('#m-admin-edit_task-form').on('submit', function(e) {
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
                $('#m-admin-edit_task-modal').modal('hide');
            },
            processData: false,
            contentType: false,
            error: function(data)
           {
               console.log(data);
           }
        });
    });

    $(document).on('click', '.m-task-edit_btn', function(){
        var $this = $(this);
        var task_id = $this.data('task_id');
        $.ajax({
            url: '/admin/manage/project/task/get_specify_project/'+task_id,
            type: 'get',
            success: function(result){
                console.log(result);
                if (result != "fail") {
                    $('#m-admin-edit_task-form #task_id_for_edit').val(result.id);
                    $('#m-admin-edit_task-form #_task_title').val(result.task_name);
                    $('#m-admin-edit_task-form #_task_project').val(result.pro_id);
                    $('#m-admin-edit_task-form #_task_members').val(result.members);
                    $('#m-admin-edit_task-form #_task_note').val(result.task_note);
                    $('.m_selectpicker').selectpicker('destroy');
                    init_plugins();
                    $('#m-admin-edit_task-modal').modal('show');
                }
            },
            error: function(error){
                console.log(error);
            }
        });
    });

    $(document).on('click', '.task-status-change-btn', function(){
        var $this = $(this);
        var current_task_id = $this.data('task_id');
        var current_task_status = $this.data('task_status');
        $.ajax({
            url: '/admin/manage/project/task/set_status/'+current_task_id+'/'+current_task_status,
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
