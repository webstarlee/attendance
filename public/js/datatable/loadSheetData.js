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
				url: '/admin/manage/project/timing-sheet/get_table_date',
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
        }, {
            field: "Actions",
            width: 80,
            title: "Actions",
            sortable: false,
            overflow: 'visible',
            template: function (row, index, datatable) {
                return '\
                <a href="javascript:;" data-sheet_id="'+row.id+'" class="m-sheet-edit_btn m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="View ">\
                <i class="la la-edit"></i>\
                </a>\
                <a href="javascript:;" data-sheet_id="'+row.id+'" class="m-sheet-delete_btn m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="View ">\
                <i class="la la-trash"></i>\
                </a>\
                ';
            }
        }],
    });

    $('#m-admin-new_sheet-form').on('submit', function(e) {
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
                $('#m-admin-new_sheet-modal').modal('hide');
            },
            processData: false,
            contentType: false,
            error: function(data)
           {
               console.log(data);
           }
        });
    });

    $('#m-admin-edit_sheet-form').on('submit', function(e) {
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
                $('#m-admin-edit_sheet-modal').modal('hide');
            },
            processData: false,
            contentType: false,
            error: function(data)
           {
               console.log(data);
           }
        });
    });

    $(document).on('click', '.m-sheet-edit_btn', function(){
        var $this = $(this);
        var sheet_id = $this.data('sheet_id');
        $.ajax({
            url: '/admin/manage/project/timing-sheet/get_specify_project/'+sheet_id,
            type: 'get',
            success: function(result){
                console.log(result);
                if (result != "fail") {
                    $('#m-admin-edit_sheet-form #sheet_id_for_edit').val(result.id);
                    $('#m-admin-edit_sheet-form #_sheet_project').val(result.pro_id);
                    $('#m-admin-edit_sheet-form #_sheet_member').val(result.employee_id);
                    $('#m-admin-edit_sheet-form #_sheet_date').attr('value', result.sheet_date);
                    $('#m-admin-edit_sheet-form #_sheet_date').val(result.sheet_date);
                    $('#m-admin-edit_sheet-form #_sheet_time').val(result.sheet_time);
                    $('#m-admin-edit_sheet-form #_sheet_note').val(result.sheet_note);
                    $('.m_selectpicker').selectpicker('destroy');
                    $('.m-datepciker').datepicker('destroy');
                    init_plugins();
                    $('#m-admin-edit_sheet-modal').modal('show');
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
