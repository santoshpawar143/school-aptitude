$(document).ready(function () {
    //student page create or update entry
    $('#stdsubmit').on('click', function (e) {
        e.preventDefault(); // Prevent form submission

        var formData = {
            student_name: $('#student_name').val(),
            id: $('#student_id').val(),
            roll_no: $('#student_roll_no').val(),
            email: $('#student_email').val(),
            password: $('#student_password').val(),
            board_id: $('#student_board').val(),
            medium_id: $('#student_medium').val(),
            standard_id: $('#student_standard').val(),
        };
        // console.log(formData);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/student', // Correct URL for the 'store' method
            type: 'POST',
            data: formData,
            success: function (response) {
                $('#StudentmodalId').modal('hide');
                success_error(type = 'success', msg = response.message); // Show success message
                $('#studentTable').DataTable().ajax.reload();
            },
            error: function (xhr) {
                // Handle errors here

                success_error(type = 'error', msg = xhr.responseJSON.message);
            }
        });
    });
    // standard page data table
    var table = $('#studentTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: 'student', // Adjust if necessary
            type: 'GET',
            data: function (d) {
                // Append additional data from the form
                d.board_id = $('#filter_student_board').val();
                d.medium_id = $('#filter_student_medium').val();
                d.standard_id = $('#filter_student_standard').val();
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'roll_no', name: 'roll_no' },
            { data: 'student_name', name: 'student_name' },
            { data: 'board', name: 'board_id' }, // Updated to use board_name
            { data: 'medium', name: 'medium_id' }, // Updated to use medium_name
            { data: 'standard', name: 'standard_id' }, // Updated to use standard_name
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ]
    });

    //student page delete
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
                    url: '/student/' + id,
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
                        $('#studentTable').DataTable().ajax.reload();
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
    //student page modal populate
    $(document).on('click', '.edit', function () {
        $('#studentForm')[0].reset();
        var row = $(this).closest('tr');
        var data = table.row(row).data();
        $('#student_id').val(data.user_id);
        $('#student_name').val(data.student_name);
        $('#student_roll_no').val(data.roll_no);
        $('#student_email').val(data.email);
        $('#StudentmodalId').modal('show');
        $('#stdupdate').show();
        $('#stdsubmit').hide();
        // Populate fields for editing
        $('#StudentmodalId').attr('data-state', 'edit');
        $('#StudentmodalId').attr('data-medium', data.medium_id);
        $('#StudentmodalId').attr('data-board', data.board_id);
        $('#StudentmodalId').attr('data-standard', data.standard_id);
        $('#StudentmodalId').attr('data-subject', data.subject_id);

        // Populate board
        getboard(data.board_id);
    });
    //student page rest modal
    $('#stdmodalbtn').on('click', function () {
        $('#studentForm')[0].reset();
        $('#StudentmodalId').modal('show');
        $('#stdsubmit').show();
        $('#stdupdate').hide();
        $('#StudentmodalId').attr('data-state', 'create');
        $('#StudentmodalId').removeAttr('data-medium');
        $('#StudentmodalId').removeAttr('data-board');
        $('#StudentmodalId').removeAttr('data-standard');
        $('#StudentmodalId').removeAttr('data-subject');
        $('#student_medium').empty();
        $('#student_standard').empty();
        getboard();
    });
    function getboard(selectedBoardId = '') {
        $.ajax({
            url: 'student_board', // Correct URL for the 'subject_medium' method
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                var board_selectBox = $('#student_board');
                filter_board_selectBox = $('#filter_student_board');
                board_selectBox.empty();
                filter_board_selectBox.empty();

                board_selectBox.append('<option value="">Select a board</option>');
                filter_board_selectBox.append('<option value="">Select a board</option>');

                response.data.forEach(function (item) {
                    board_selectBox.append(
                        `<option value="${item.id}">${item.name}</option>`
                    );
                    filter_board_selectBox.append(
                        `<option value="${item.id}">${item.name}</option>`
                    );
                });
                if ($('#StudentmodalId').attr('data-state') == 'edit') {
                    $('#student_board').val(selectedBoardId);
                    getmedium(selectedBoardId);
                }

            },
            error: function (xhr) {
                success_error(type = 'error', msg = xhr.responseJSON.message); // Handle error
            }
        });
    }
    getboard();
    $('#student_board,#filter_student_board').on('change', function () {

        getmedium($(this).val());
    });
    $('#student_medium,#filter_student_medium').on('change', function () {
        getstandard();
    });
    function getmedium(id) {
        if (id != '') {

            $.ajax({
                url: 'student_medium', // Correct URL for the 'subject_medium' method
                type: 'GET',
                data: { board_id: id },
                dataType: 'json',
                success: function (response) {

                    var medium_selectBox = $('#student_medium');
                    var filter_medium_selectBox = $('#filter_student_medium');

                    medium_selectBox.empty();
                    filter_medium_selectBox.empty();
                    medium_selectBox.append('<option value="">Select a medium</option>');
                    filter_medium_selectBox.append('<option value="">Select a medium</option>');
                    response.data.forEach(function (item) {

                        medium_selectBox.append(
                            `<option value="${item.id}">${item.name}</option>`
                        );
                        filter_medium_selectBox.append(
                            `<option value="${item.id}">${item.name}</option>`
                        );
                    });
                    if ($('#StudentmodalId').attr('data-state') == 'edit') {
                        $('#student_medium').val($('#StudentmodalId').attr('data-medium'));
                        getstandard();
                    }

                },
                error: function (xhr) {
                    success_error(type = 'error', msg = xhr.responseJSON.message); // Handle error
                }
            });
        }
        else {
            $('#student_medium').empty();
        }
    }

    function getstandard() {


        $.ajax({
            url: 'student_standard', // Correct URL for the 'subject_medium' method
            type: 'GET',

            dataType: 'json',
            success: function (response) {

                var standard_selectBox = $('#student_standard');
                var filter_standard_selectBox = $('#filter_student_standard');

                standard_selectBox.empty();
                filter_standard_selectBox.empty();

                standard_selectBox.append('<option value="">Select a standard</option>');
                filter_standard_selectBox.append('<option value="">Select a standard</option>');
                response.data.forEach(function (item) {
                    standard_selectBox.append(
                        `<option value="${item.id}">${item.name}</option>`
                    );
                    filter_standard_selectBox.append(
                        `<option value="${item.id}">${item.name}</option>`
                    );
                });
                if ($('#StudentmodalId').attr('data-state') == 'edit') {
                    $('#student_standard').val($('#StudentmodalId').attr('data-standard'));

                }
            },
            error: function (xhr) {
                success_error(type = 'error', msg = xhr.responseJSON.message); // Handle error
            }
        });

    }




    $('#stdupdate').on('click', function (e) {
        e.preventDefault();
        var formData = {
            student_name: $('#student_name').val(),
            id: $('#student_id').val(),
            roll_no: $('#student_roll_no').val(),
            email: $('#student_email').val(),
            password: $('#student_password').val(),
            board_id: $('#student_board').val(),
            medium_id: $('#student_medium').val(),
            standard_id: $('#student_standard').val(),
        };
        // console.log(formData);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/student/' + formData.id, // Correct URL for the 'store' method
            type: 'PUT',
            data: formData,
            success: function (response) {
                $('#StudentmodalId').modal('hide');

                success_error(type = 'success', msg = response.message); // Show success message
                $('#studentTable').DataTable().ajax.reload();
            },
            error: function (xhr) {
                // Handle errors here
                success_error(type = 'error', msg = xhr.responseJSON.message);
            }
        });
    })
    $('#filter').on('click', function () {
        $('#studentTable').DataTable().ajax.reload();
    });
});