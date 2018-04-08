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

    var datatable = $('#m_ticket_datatable').mDatatable({
      // datasource definition
      data: {
        type: 'remote',
        source: {
			read: {
				url: '/ticket/getData',
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
          field: 'ticket_unique_id',
          title: i18n.language.ticket.ticket_id,
          width: 100,
        }, {
          field: 'ticket_subject',
          title: i18n.language.ticket.ticket+" "+i18n.language.ticket.subject,
          width: 200,
        }, {
          field: 'ticket_staff_name',
          title: i18n.language.ticket.assign_staff,
          width: 100,
          responsive: {visible: 'lg'},
          template: function (row) {
              return '\
              <a href="/admin/profile/employee/'+row.ticket_staff_id+'" target="_blank" title="'+row.ticket_staff_name+'" style="display:inline-block;">\
                <img src="'+row.ticket_staff_avatar+'" style="width:35px;height:35px;border-radius:50%;">\
              </a>\
              ';
          }
        },{
          field: 'ticket_followers',
          title: i18n.language.ticket.follower,
          width: 150,
          responsive: {visible: 'lg'},
          template: function (row, index, datatable) {
              var $final_members = "";
              var member_count = 0;
              if (row.ticket_followers != "" || row.ticket_followers != null) {
                  row.ticket_followers.forEach(function(member) {
                      member_count ++;
                      if (member_count < 4) {
                          $final_members += '<a href="/admin/profile/employee/'+member.follower_unique+'" target="_blank" title="'+member.follower_username+'" style="display:inline-block;">'+
                                            '<img src="'+member.follower_avatar+'" style="width:35px;height:35px;border-radius:50%;"></a>';
                      }
                  });
                  if (member_count > 3) {
                      var left_member = member_count - 3;
                      $final_members += '<a href="#" style="display:flex;width:35px;height:35px;background-color:#ddd;border-radius:50%;text-align:center;justify-content:center;flex-direction:column;">+'+left_member+'</a>';
                  }
              }
              return '<div style="display: flex;">'+$final_members+'</div>';
          }
        }, {
          field: 'ticket_create_date',
          title: i18n.language.ticket.created_date,
          width: 100,
          responsive: {visible: 'lg'},
        }, {
          field: 'ticket_priority',
          title: i18n.language.priority,
          width: 100,
          responsive: {visible: 'lg'},
          template: function (row) {
            var status = {
                0: {'title': 'High', 'class': 'm-badge--danger'},
                1: {'title': 'Medium', 'class': ' m-badge--accent'},
                2: {'title': 'Low', 'class': ' m-badge--primary'},
            };
             return '<span class="m-badge ' + status[row.ticket_priority].class + ' m-badge--wide" style="width:70px;">' + status[row.ticket_priority].title + '</span>';
          }
        }, {
          field: 'ticket_status',
          title: i18n.language.status,
          width: 100,
          overflow: 'visible',
          responsive: {visible: 'lg'},
          template: function (row, index, datatable) {
              var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';
              var status = {
                0: {'title': 'New', 'state': 'danger'},
                1: {'title': 'Open', 'state': 'primary'},
                2: {'title': 'Onhold', 'state': 'danger'},
                3: {'title': 'Closed', 'state': 'accent'},
                4: {'title': 'Inprogress', 'state': 'primary'},
                5: {'title': 'Cancelled', 'state': 'danger'},
              };

              return '\
						<div class="dropdown ' + dropup + '">\
							<a href="#" class="btn">\
                            <span class="m-badge m-badge--' + status[row.ticket_status].state + ' m-badge--dot"></span>\
                            &nbsp;<span class="m--font-bold m--font-' + status[row.ticket_status].state + '"> \
                                '+status[row.ticket_status].title+' </span>\
                            </a>\
						</div>\
                        ';
          }
        }],
    });

    $('#m-admin-new_ticket-form').on('submit', function(e) {
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
                $('#m-admin-new_ticket-modal').modal('hide');
            },
            processData: false,
            contentType: false,
            error: function(data)
           {
               console.log(data);
           }
        });
    });

    $('#m-admin-edit_ticket-form').on('submit', function(e) {
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
                $('#m-admin-edit_ticket-modal').modal('hide');
            },
            processData: false,
            contentType: false,
            error: function(data)
           {
               console.log(data);
           }
        });
    });

    $(document).on('click', '.m-ticket-edit_btn', function(){
        var $this = $(this);
        var ticket_id = $this.data('ticket_id');
        $.ajax({
            url: '/admin/manage/ticket/get_specify_ticket/'+ticket_id,
            type: 'get',
            success: function(result){
                console.log(result);
                if (result != "fail") {
                    $('#m-admin-edit_ticket-form #ticket_id_for_edit').val(result.id);
                    $('#m-admin-edit_ticket-form #_ticket_subject').val(result.ticket_subject);
                    $('#m-admin-edit_ticket-form #_ticket_client').val(result.ticket_client);
                    $('#m-admin-edit_ticket-form #_ticket_priority').val(result.ticket_priority);
                    $('#m-admin-edit_ticket-form #_ticket_staff').val(result.ticket_staff);
                    $('#m-admin-edit_ticket-form #_ticket_follower').val(result.ticket_followers);
                    $('#m-admin-edit_ticket-form #_ticket_note').val(result.ticket_note);
                    $('.m_selectpicker').selectpicker('destroy');
                    init_plugins();
                    $('#m-admin-edit_ticket-modal').modal('show');
                }
            },
            error: function(error){
                console.log(error);
            }
        });
    });

    $(document).on('click', '.ticket-status-change-btn', function(){
        var $this = $(this);
        var current_ticket_id = $this.data('ticket_id');
        var current_ticket_status = $this.data('ticket_status');
        $.ajax({
            url: '/admin/manage/ticket/set_status/'+current_ticket_id+'/'+current_ticket_status,
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
