$(function () {
    //to open submitbtn modal
    $('#school_modalbtn').on('click', function () {
        $('#schoolForm')[0].reset();
        $('#schoolForm').find('input[type="hidden"]').val('');
        $('#school_modalId').modal('show');
        $('#school_modalTitleId').html('Create School');
        $('#school_medium_table').empty();
        getBoards();
        $('.board_switchbox').each(function () {
            $(this).attr('data-state', 'create');   
        });
    });
    //create or update
    $('#school_sub_btn').on('click', function (e) {
        e.preventDefault(); // Prevent form submission

        var checkedValues = $('.board_switchbox:checked').map(function () {
            return $(this).val();
        }).get();
        var medium_switch_box = $('.medium_switchbox:checked').map(function () {
            return $(this).val();
        }).get();
        var standard_switch_box = $('.standard_switchbox:checked').map(function () {
            return $(this).val();
        }).get();
        // Create a FormData object to handle file uploads
        var formData = new FormData();
        formData.append('name', $('#school_name').val());
        formData.append('id', $('#school_id').val());
        formData.append('address', $('#school_address').val());

        // Append the logo file if selected
        var logoFile = $('#school_logo')[0].files[0];
        if (logoFile) {
            formData.append('logo', logoFile);
        }

        formData.append('board_array', checkedValues.length > 0 ? JSON.stringify(checkedValues) : "");
        formData.append('medium_array', medium_switch_box.length > 0 ? JSON.stringify(medium_switch_box) : "");
        formData.append('standard_array', standard_switch_box.length > 0 ? JSON.stringify(standard_switch_box) : "");
        // Set up AJAX request with FormData
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: 'school', // Correct URL for the 'store' method
            type: 'POST',
            data: formData,
            processData: false, // Prevent jQuery from automatically transforming the data into a query string
            contentType: false, // Prevent jQuery from setting the content type
            success: function (response) {
           
                success_error(type='success',msg=response.message); // Show success message
                $('#school_modalId').modal('hide');
                $('#schoolTable').DataTable().ajax.reload();
            },
            error: function (xhr) {
              
                success_error(type='error',msg=xhr.responseJSON.message);
               
            }
        });
    });
    
    // school page data table
    var table = $('#schoolTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: 'school', // Adjust if necessary
            type: 'GET'
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'school_name', name: 'school_name' },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ]
    });
    $(document).on('click', '.edit', function () {
        $('#schoolForm')[0].reset();
        $('#school_modalId').modal('show');
        $('#school_modalTitleId').html('Update School');
        
      
       
        var row = $(this).closest('tr');
        var data = table.row(row).data();
        $('#school_id').val(data.id);
        $('#school_name').val(data.school_name);
        $('#school_address').val(data.address);

        var boardIds = $(this).data('board');
        var mediumIds = $(this).data('medium');
        var stadardIds = $(this).data('standard');
        $('.board_switchbox').each(function () {
            $(this).attr('data-state', 'edit');
            $(this).attr('data-medium', mediumIds);
        });
       
        $('.board_switchbox').each(function () {
            if (boardIds.includes($(this).val())) {
                $(this).prop('checked', true);
              
            } else {
                $(this).prop('checked', false);
            }
        });
        $('.standard_switchbox').each(function () {
            if (stadardIds.includes($(this).val())) {
                $(this).prop('checked', true);

            } else {
                $(this).prop('checked', false);
            }
        });
        
        getmedium(mediumIds); 
      
      
             
    });

   
//to fetch the boards from board table
function getBoards(){
    
    $.ajax({
        url: 'school_board', // Correct URL for the 'school_medium' method
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            var table = $('#school_board_table');
            table.empty();
            response.data.forEach(function (item) {
                table.append(
                    `<tr>
                                
                                <td>
                                    <div class="form-check form-switch">
                                     <label class="form-check-label" for="flexSwitchCheck${item.id}">${item.name}</label>
                                        <input class="form-check-input board_switchbox" type="checkbox" value="${item.id}" id="board${item.id}" />  
                                    </div>
                                </td>
                            </tr>`
                );
            });

        },
        error: function (xhr) {
            alert('Error: ' + xhr.responseJSON.message); // Handle error
        }
    });
}
getBoards();  
    function getStandards() {

        $.ajax({
            url: 'school_standard', // Correct URL for the 'school_medium' method
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                var table = $('#school_standard_table');
                table.empty();
                response.data.forEach(function (item) {
                    table.append(
                        `<tr>
                                
                                <td>
                                    <div class="form-check form-switch">
                                     <label class="form-check-label" for="flexSwitchCheck${item.id}">${item.name}</label>
                                        <input class="form-check-input standard_switchbox" type="checkbox" value="${item.id}" id="standard${item.id}" />  
                                    </div>
                                </td>
                            </tr>`
                    );
                });

            },
            error: function (xhr) {
                alert('Error: ' + xhr.responseJSON.message); // Handle error
            }
        });
    }
    getStandards();  
 //to fetch medium based on board   
$(document).on('change', '.board_switchbox', function () {
    var state = $(this).attr('data-state');
    var medium=$(this).data('medium');
    if (state == "edit") { getmedium(medium); }
    else { getmedium(); }
    });
    function getmedium(mediumIds = []) {
        if (typeof mediumIds === 'number') {
           
            mediumIds= [mediumIds.toString()];
        } 
        var checkedValues = $('.board_switchbox:checked').map(function () {
            return $(this).val();
        }).get();

        $.ajax({
            url: 'school_medium', // Correct URL for the 'school_medium' method
            type: 'GET',
            dataType: 'json',
            data: {
                board: checkedValues // Send checkedValues as part of the request
            },
            success: function (response) {
                var table = $('#school_medium_table');
                table.empty(); // Clear previous data
                response.data.forEach(function (item) {
                    table.append(
                        `<tr>
                        <td>
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="flexSwitchCheck${item.id}">${item.name}</label>
                                <input class="form-check-input medium_switchbox" type="checkbox" value="${item.id}" id="medium${item.id}" />
                            </div>
                        </td>
                    </tr>`
                    );
                });
               
                    $('.medium_switchbox').each(function () {

                        if (mediumIds.includes($(this).val())) {
                            $(this).prop('checked', true);
                        } else {
                            $(this).prop('checked', false);
                        }
                    });
                
              
            },
            error: function (xhr) {
                alert('Error: ' + xhr.responseJSON.message); // Handle error
            }
        });
    }
//delete record
    $(document).on('click', '.delete', function () {
        var id = $(this).data('id');

       
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/school/' + id,
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content') // CSRF token for security
                    },
                    success: function (response) {
                        Swal.fire(
                            'Deleted!',
                            response.success,
                            'success'
                        );
                        // Optionally, you can remove the row from the table or reload the table
                        $('#schoolTable').DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        // Handle errors here
                        Swal.fire(
                            'Error!',
                            xhr.responseJSON.error || 'An error occurred while deleting the record.',
                            'error'
                        );
                    }
                });
            }
        });
    });

});








// $.ajax({
//     url: 'school_medium', // Correct URL for the 'school_medium' method
//     type: 'GET',
//     dataType: 'json',
//     success: function (response) {

//         var table = $('#school_medium_table');
//         response.data.forEach(function (item) {
//             table.append(
//                 `<tr>
                                
//                                 <td>
//                                     <div class="form-check form-switch">
//                                      <label class="form-check-label" for="flexSwitchCheck${item.id}">${item.name}</label>
//                                         <input class="form-check-input" type="checkbox" id="flexSwitchCheck${item.id}" />  
//                                     </div>
//                                 </td>
//                             </tr>`
//             );
//         });

//     },
//     error: function (xhr) {
//         alert('Error: ' + xhr.responseJSON.message); // Handle error
//     }
// });