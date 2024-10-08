$(document).ready(function () {
    //standard page create or update entry
    $('#stdsubmit').on('click', function (e) {
        e.preventDefault(); // Prevent form submission

        var formData = {
            name: $('#standard_name').val(),
            id: $('#standard_id').val(),
            email: $('#user_email').val(),
            password: $('#user_password').val(),
            role: $('#user_role').val(),
            school_id: $('#user_school_id').val(),
        };



        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/user', // Correct URL for the 'store' method
            type: 'POST',
            data: formData,
            success: function (response) {

                success_error(type = 'success', msg = response.message);
                $('#StandardmodalId').modal('hide');
                $('#standardTable').DataTable().ajax.reload();
            },
            error: function (xhr) {

                success_error(type = 'error', msg = xhr.responseJSON.message);
            }
        });
    });
    // standard page data table
    var table = $('#standardTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: 'user', // Adjust if necessary
            type: 'GET'
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ]
    });
    //standard page delete
    $(document).on('click', '.delete', function () {
        var id = $(this).data('id');

        // Confirm the action with the user
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
                    url: '/user/' + id,
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
                        $('#standardTable').DataTable().ajax.reload();
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
    //standard page modal populate
    $(document).on('click', '.edit', function () {
        $('#modalTitleId').html('Edit user');
        var row = $(this).closest('tr');
        var data = table.row(row).data();
        $('#standard_id').val(data.id);
        $('#standard_name').val(data.name);
        $('#StandardmodalId').modal('show');
        $('#user_email').val(data.email);
        $('#user_password').show();
        $('#user_label_password').show();
        $('#user_role').val(data.role);
        $('#user_school').val(data.school_name);
        $('#user_school_id').val(data.school_id);
    });
    //standard page rest modal
    $('#stdmodalbtn').on('click', function () {
        $('#standardForm')[0].reset();
        $('#StandardmodalId').modal('show');
        $('#user_password').show();
        $('#user_label_password').show();

        $('#modalTitleId').html('Create user');
    });
    //role_select_box
    function role_select_box() {
        $.ajax({
            url: 'user-role',
            type: 'GET',
            success: function (response) {
                // Clear existing options except the first one
                var $select = $('#user_role');
                $select.find('option').not(':first').remove();

                // Append new options
                $.each(response, function (index, role) {
                    $select.append(
                        $('<option></option>').val(role.id).text(role.role_name)
                    );
                });
            },
            error: function (xhr) {
                // Handle errors here
                alert('Error: ' + xhr.responseJSON.message);
            }
        });
    }
    role_select_box();
    $('#user_school').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: '/autocomplete_school', // Ensure this matches your route
                type: 'GET',
                dataType: 'json',
                data: {
                    term: request.term // Send the search term to the server
                },
                success: function (data) {
                    response(data); // Pass the formatted data to the autocomplete widget
                },
                error: function (xhr) {
                    // Handle errors here
                    console.error('Error:', xhr.responseText);
                }
            });
        },
        minLength: 2, // Minimum length of input before triggering autocomplete
        select: function (event, ui) {
            console.log('Selected:', ui.item.value); // Handle item selection
            $('#user_school').val(ui.item.value).html(ui.item.label); // Update the input value
            $('#user_school_id').val(ui.item.id);
            return false; // Prevent default handling of the selection
        }
    });

});