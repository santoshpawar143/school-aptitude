$(document).ready(function () {
    //standard page create or update entry
    $('#stdsubmit').on('click', function (e) {
        e.preventDefault(); // Prevent form submission

        var formData = {
            name: $('#standard_name').val(),
            id: $('#standard_id').val()
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/standard', // Correct URL for the 'store' method
            type: 'POST',
            data: formData,
            success: function (response) {
                $('#StandardmodalId').modal('hide');
                success_error(type = 'success', msg = response.message); // Show success message
                $('#standardTable').DataTable().ajax.reload();
            },
            error: function (xhr) {
                // Handle errors here
                success_error(type = 'error', msg = xhr.responseJSON.message);
            }
        });
    });
    // standard page data table
    var table = $('#standardTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: 'standard', // Adjust if necessary
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
                    url: '/standard/' + id,
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
        var row = $(this).closest('tr');
        var data = table.row(row).data();
        $('#standard_id').val(data.id);
        $('#standard_name').val(data.name);
        $('#StandardmodalId').modal('show');
        $('#modalTitleId').html('Edit standard');
    });
    //standard page rest modal
    $('#stdmodalbtn').on('click', function () {
        $('#standardForm')[0].reset();
        $('#StandardmodalId').modal('show');
        $('#modalTitleId').html('Create standard');

    });
});