$(document).ready(function () {
    //standard page create or update entry
    $('#stdsubmit').on('click', function (e) {
        e.preventDefault(); // Prevent form submission

        var formData = {
            name: $('#medium_name').val(),
            id: $('#medium_id').val()
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/medium', // Correct URL for the 'store' method
            type: 'POST',
            data: formData,
            success: function (response) {
                success_error(type = 'success', msg = response.message); // Show success message
                $('#MediummodalId').modal('hide');
                $('#mediumTable').DataTable().ajax.reload();
            },
            error: function (xhr) {
                success_error(type = 'error', msg = xhr.responseJSON.message);
            }
        });
    });
    // standard page data table
    var table = $('#mediumTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: 'medium', // Adjust if necessary
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
                    url: '/medium/' + id,
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
                        $('#mediumTable').DataTable().ajax.reload();
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
        $('#medium_id').val(data.id);
        $('#medium_name').val(data.name);
        $('#MediummodalId').modal('show');
    });
    //standard page rest modal
    $('#medium_modalbtn').on('click', function () {
        $('#modelForm')[0].reset();
        $('#MediummodalId').modal('show');
    });
});