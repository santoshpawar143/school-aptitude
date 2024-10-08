$(document).ready(function () {
    //standard page create or update entry
    $('#role_submit').on('click', function (e) {
        e.preventDefault(); // Prevent form submission

        var formData = {
            role_name: $('#role_name').val(),
            id: $('#role_id').val()
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/role', // Correct URL for the 'store' method
            type: 'POST',
            data: formData,
            success: function (response) {
                $('#role_modalId').modal('hide');
                success_error(type = 'success', msg = response.message);
                $('#roleTable').DataTable().ajax.reload();
            },
            error: function (xhr) {
                // Handle errors here
                success_error(type = 'error', msg = xhr.responseJSON.message);

            }
        });
    });
    // standard page data table
    var table = $('#roleTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: 'role', // Adjust if necessary
            type: 'GET'
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'role_name', name: 'role_name' },
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
                    url: '/role/' + id,
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
                        $('#roleTable').DataTable().ajax.reload();
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
        var row = $(this).closest('tr');
        var data = table.row(row).data();
        $('#role_id').val(data.id);
        $('#role_name').val(data.role_name);
        $('#role_modalTitleId').html('Edit role');
        $('#role_modalId').modal('show');

    });
    //standard page rest modal
    $('#role_modalbtn').on('click', function () {
        $('#roleForm')[0].reset();
        $('#role_modalTitleId').html('Create role');
        $('#role_modalId').modal('show');


    });
});