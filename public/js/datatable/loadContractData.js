//== Class definition

var DatatableAutoColumnHideDemo = function() {
  //== Private functions

  // basic demo
  var demo = function() {
    var datatable = $('.m_contract_datatable').mDatatable({
      // datasource definition
      data: {
        type: 'remote',
        source: {
			read: {
				url: '/admin/manage/contract/getdatas',
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
          field: 'title',
          title: 'Contract Title',
          width: 150,
        },{
          field: 'working_time',
          title: 'Work Time',
          width: 150,
          responsive: {visible: 'sm'},
          template: function (row, index, datatable) {
              var minutes = row.working_time%60;
              var hours = (row.working_time - minutes)/60;
              var string_working = "";
              if (hours == 0) {
                  string_working = '<p style="margin-bottom: 0;">'+minutes+' minutes </p>';
              } else if(minutes == 0) {
                  string_working = '<p style="margin-bottom: 0;">'+hours+' hours </p>';
              } else {
                  string_working = '<p style="margin-bottom: 0;">'+hours+' hours </p><p style="margin-bottom: 0;">'+minutes+' minutes </p>';
              }

              return string_working;
          }
        }, {
          field: 'description',
          title: 'Description',
          width: 400,
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
                <a href="javascript:;" data-contract_id="'+row.id+'" class="m-contract-type-edit_btn m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="View ">\
                <i class="la la-edit"></i>\
                </a>\
                <a href="javascript:;" data-contract_id="'+row.id+'" class="m-contract-type-delete_btn m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="View ">\
                <i class="la la-trash"></i>\
                </a>\
                ';
            }
        }],
    });

    $('#m-admin-new_contract-type-form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this)[0];
        var possible_submit = false;
        var hour_box = $(form).find('#contract_time_hour').val();
        var minute_box = $(form).find('#contract_time_min').val();
        if (hour_box != "" || minute_box != "") {
            possible_submit = true;
        } else {
            swal({
               "title": "Alert",
               "text": "input working time.",
               "type": "warning",
               "confirmButtonClass": "btn btn-outline-accent m-btn m-btn--custom m-btn--air"
           });
           return false;
        }
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
                $('#m-admin-new_contract-type-modal').modal('hide');
            },
            processData: false,
            contentType: false,
            error: function(data)
           {
               console.log(data);
           }
        });
    });

    $('#m-admin-edit_contract-type-form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this)[0];
        var possible_submit = false;
        var hour_box = $(form).find('#_contract_time_hour').val();
        var minute_box = $(form).find('#_contract_time_min').val();
        if (hour_box != "" || minute_box != "") {
            possible_submit = true;
        } else {
            swal({
               "title": "Alert",
               "text": "input working time.",
               "type": "warning",
               "confirmButtonClass": "btn btn-outline-accent m-btn m-btn--custom m-btn--air"
           });
           return false;
        }
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
                $('#m-admin-edit_contract-type-modal').modal('hide');
            },
            processData: false,
            contentType: false,
            error: function(data)
           {
               console.log(data);
           }
        });
    });

    $(document).on('click', '.m-contract-type-edit_btn', function(){
        var $this = $(this);
        var contract_id = $this.data('contract_id');
        $.ajax({
            url: '/admin/manage/contract/getsingle_data/'+contract_id,
            type: 'get',
            success: function(result){
                if (result != "fail") {
                    var minutes = result.working_time%60;
                    var hours = (result.working_time - minutes)/60;
                    $('#m-admin-edit_contract-type-form #contract_id_for_edit').val(result.id);
                    $('#m-admin-edit_contract-type-form #_contract_title').val(result.title);
                    $('#m-admin-edit_contract-type-form #_contract_time_hour').val(hours);
                    $('#m-admin-edit_contract-type-form #_contract_time_min').val(minutes);
                    $('#m-admin-edit_contract-type-form #_contract_description').val(result.description);
                    $('#m-admin-edit_contract-type-modal').modal('show');
                }
            },
            error: function(error){
                console.log(error);
            }
        });
    });

    $(document).on('click', '.m-contract-type-delete_btn', function(){
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
