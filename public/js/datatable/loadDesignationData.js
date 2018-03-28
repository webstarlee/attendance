//== Class definition

var DatatableAutoColumnHideDemo = function() {
  //== Private functions

  // basic demo
  var demo = function() {
      $('.m_selectpicker').selectpicker();
    var datatable = $('#m_designation_datatable').mDatatable({
      // datasource definition
      data: {
        type: 'remote',
        source: {
    		read: {
    			url: '/admin/manage/designation/get_table_date',
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
          field: 'design_title',
          title: i18n.language.title,
          width: 200,
        },{
          field: 'depart_title',
          title: i18n.language.department.department,
          width: 200,
        }, {
          field: 'design_note',
          title: i18n.language.note,
          width: 300,
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
                <a href="javascript:;" data-designation_id="'+row.id+'" class="m-designation-edit_btn m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="View ">\
                <i class="la la-edit"></i>\
                </a>\
                <a href="javascript:;" data-designation_id="'+row.id+'" class="m-designation-delete_btn m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="View ">\
                <i class="la la-trash"></i>\
                </a>\
                ';
            }
        }],
    });

    $('#m-admin-new_designation-form').on('submit', function(e) {
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
                $('#m-admin-new_designation-modal').modal('hide');
            },
            processData: false,
            contentType: false,
            error: function(data)
           {
               console.log(data);
           }
        });
    });

    $('#m-admin-edit_designation-form').on('submit', function(e) {
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
                $('#m-admin-edit_designation-modal').modal('hide');
            },
            processData: false,
            contentType: false,
            error: function(data)
           {
               console.log(data);
           }
        });
    });

    $(document).on('click', '.m-designation-edit_btn', function(){
        var $this = $(this);
        var designation_id = $this.data('designation_id');
        $.ajax({
            url: '/admin/manage/designation/get_specify_designation/'+designation_id,
            type: 'get',
            success: function(result){
                if (result != "fail") {
                    $('#m-admin-edit_designation-form #designation_id_for_edit').val(result.id);
                    $('#m-admin-edit_designation-form #_designation_title').val(result.design_title);
                    $('#m-admin-edit_designation-form #_department_id').val(result.depart_id);
                    $('#m-admin-edit_designation-form #_designation_note').val(result.design_note);
                    $('#m-admin-edit_designation-modal').modal('show');
                }
            },
            error: function(error){
                console.log(error);
            }
        });
    });

    $(document).on('click', '.m-designation-delete_btn', function(){
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
