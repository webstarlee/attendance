$(document).on('click', '.m-admin-delete-btn', function(e) {
    e.preventDefault();
    var $this = $(this);
    swal({
        title: 'Are you sure?',
        text: "Do want to delete !",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
    }).then(function(result) {
        if (result.value) {
            var current_unique = $this.data('unique_id');
            $.ajax({
                url: '/admin/manage/delete/admin/'+current_unique,
                type: 'get',
                success: function(result){
                    if (result == "role_fail") {
                        swal({
                            "title": "Faild",
                            "text": "Permission denied !.",
                            "type": "error",
                            "confirmButtonClass": "btn btn-secondary m-btn m-btn--wide"
                        });
                    } else if (result == "find_fail") {
                        swal({
                            "title": "Faild",
                            "text": "Admin Can't find !.",
                            "type": "error",
                            "confirmButtonClass": "btn btn-secondary m-btn m-btn--wide"
                        });
                        datatable.reload();
                    } else if (result == "success") {
                        swal({
                            "title": "Success",
                            "text": "Admin Deleted !.",
                            "type": "success",
                            "confirmButtonClass": "btn btn-secondary m-btn m-btn--wide"
                        });
                        datatable.reload();
                    }
                },
                error: function(error){
                    console.log(error);
                }
            });
        }
    });
})

$(document).on('click', '.m-employee-delete-btn', function(e) {
    e.preventDefault();
    var $this = $(this);
    swal({
        title: 'Are you sure?',
        text: "Do want to delete !",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
    }).then(function(result) {
        if (result.value) {
            var current_unique = $this.data('unique_id');
            $.ajax({
                url: '/admin/manage/delete/employee/'+current_unique,
                type: 'get',
                success: function(result){
                    if (result == "find_fail") {
                        swal({
                            "title": "Faild",
                            "text": "Employee Can't find !.",
                            "type": "error",
                            "confirmButtonClass": "btn btn-secondary m-btn m-btn--wide"
                        });
                        datatable.reload();
                    } else if (result == "success") {
                        swal({
                            "title": "Success",
                            "text": "Employee Deleted !.",
                            "type": "success",
                            "confirmButtonClass": "btn btn-secondary m-btn m-btn--wide"
                        });
                        datatable.reload();
                    }
                },
                error: function(error){
                    console.log(error);
                }
            });
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
                $('#m-admin-edit_contract-type-form #contract_id_for_edit').val(result.id);
                $('#m-admin-edit_contract-type-form #_contract_title').val(result.title);
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
