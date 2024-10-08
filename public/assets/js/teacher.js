$(document).ready(function () {
    //teacher page create or update entry
    $('#stdsubmit').on('click', function (e) {
        e.preventDefault(); // Prevent form submission

        var formData = {
            teacher_name: $('#teacher_name').val(),
            teacher_no: $('#teacher_roll_no').val(),
            email: $('#teacher_email').val(),
            password: $('#teacher_password').val(),
        };
        // console.log(formData);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/teacher', // Correct URL for the 'store' method
            type: 'POST',
            data: formData,
            success: function (response) {
                $('#TeachermodalId').modal('hide');
                success_error(type = 'success', msg = response.message);// Show success message
                $('#teacherTable').DataTable().ajax.reload();
            },
            error: function (xhr) {
                // Handle errors here

                success_error(type = 'error', msg = xhr.responseJSON.message);
            }
        });
    });
    // standard page data table
    var table = $('#teacherTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: 'teacher', // Adjust if necessary
            type: 'GET'
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'teacher_name', name: 'teacher_name' },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ]

    });

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
                    url: '/teacher/' + id,
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
                        $('#teacherTable').DataTable().ajax.reload();
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
    //teacher page modal populate
    $(document).on('click', '.edit', function () {
        $('#teacherForm')[0].reset();
        $('#stdupdate').show();
        $('#stdsubmit').hide();
        var row = $(this).closest('tr');
        var data = table.row(row).data();

        // Populate fields for editing
        $('#teacher_id').val(data.user_id);
        $('#teacher_name').val(data.teacher_name);
        $('#teacher_email').val(data.email);
        $('#teacher_roll_no').val(data.teacher_no);

        $('#TeachermodalId').modal('show');
        $('#TeachermodalId').attr('data-state', 'edit');

    });

    // Event listener for the create button
    $('#stdmodalbtn').on('click', function () {
        // Reset fields for creating a new entry
        $('#stdupdate').hide();
        $('#stdsubmit').show();
        $('#teacherForm')[0].reset();
        $('#TeachermodalId').modal('show');
        $('#TeachermodalId').attr('data-state', 'create');

    });



    // Event listeners for dropdown changes


    $('#stdupdate').on('click', function (e) {
        e.preventDefault();
        var formData = {
            teacher_name: $('#teacher_name').val(),
            id: $('#teacher_id').val(),
            teacher_no: $('#teacher_roll_no').val(),
            email: $('#teacher_email').val(),
            password: $('#teacher_password').val()
        };
        // console.log(formData);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/teacher/' + formData.id, // Correct URL for the 'store' method
            type: 'PUT',
            data: formData,
            success: function (response) {
                $('#TeachermodalId').modal('hide');
                success_error(type = 'success', msg = response.message); // Show success message
                $('#teacherTable').DataTable().ajax.reload();
            },
            error: function (xhr) {
                // Handle errors here
                success_error(type = 'error', msg = xhr.responseJSON.message);
            }
        });
    })

});