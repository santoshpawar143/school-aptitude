$(document).ready(function () {
    //standard page create or update entry
    $('#stdsubmit').on('click', function (e) {
        e.preventDefault(); // Prevent form submission
        var formData = {
            id: $('#result_id').val(),
            student_id: $('#result_roll_no').val(),
            marks_obtained: $('#result_marks_obtained').val(),
            total_marks: $('#result_total_marks').val(),
        };
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/result/' + formData.id, // Correct URL for the 'store' method
            type: 'PUT',
            data: formData,
            success: function (response) {
                success_error(type = 'success', msg = response.message);
                $('#resultTable').DataTable().ajax.reload();
                $('#ResultmodalId').modal('hide');
            },
            error: function (xhr) {
                // Handle errors here
                alert('Error: ' + xhr.responseJSON.message);
                success_error(type = 'error', msg = xhr.responseJSON.message);
            }
        });
    });
    // standard page data table
    var table = $('#resultTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: 'result', // Adjust if necessary
            type: 'GET',
            data: function (d) {
                d.chapter_id = $('#filter_result_chapter').val();
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'roll_no', name: 'roll_no' },
            { data: 'student_name', name: 'student_name' },
            { data: 'chapter_name', name: 'chapter_name' },
            { data: 'marks_obtained', name: 'markse_obtained' },
            { data: 'total_marks', name: 'total_marks' },
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
                    url: '/result/' + id,
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
                        $('#resultTable').DataTable().ajax.reload();
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
        $('#result_id').val(data.id);

        $('#result_roll_no').val(data.student_id);
        $('#result_marks_obtained').val(data.marks_obtained);
        $('#result_total_marks').val(data.total_marks);
        $('#ResultmodalId').modal('show');
    });
    //standard page rest modal
    $('#stdmodalbtn').on('click', function () {
        $('#standardForm')[0].reset();
        $('#ResultmodalId').modal('show');
    });
    function getchapter() {
        const formData = {
            'board_id': $('#filter_result_board').val(),
            'medium_id': $('#filter_result_medium').val(),
            'standard_id': $('#filter_result_standard').val(),
            'subject_id': $('#filter_result_subject').val(),
        };

        $.ajax({
            url: 'result_getChapters', // Correct URL for the 'store' method
            type: 'GET',
            data: formData,
            success: function (response) {
                var filter_result_selectBox = $('#filter_result_chapter');
                filter_result_selectBox.empty();
                filter_result_selectBox.append('<option value="">Select a chapter</option>');
                response.data.forEach(function (item) {
                    filter_result_selectBox.append(`<option value="${item.id}">${item.chapter_name}</option>`);
                });

            },
            error: function (xhr) {
                success_error(type = 'error', msg = xhr.responseJSON.message);
            }
        });
    }

    function getBoard() {
        $.ajax({
            url: 'result_board', // Correct URL for the 'store' method
            type: 'GET',

            success: function (response) {
                var filter_result_selectBox = $('#filter_result_board');
                filter_result_selectBox.empty();
                filter_result_selectBox.append('<option value="">Select a board</option>');
                response.data.forEach(function (item) {
                    filter_result_selectBox.append(`<option value="${item.id}">${item.name}</option>`);
                });
            },
            error: function (xhr) {
                success_error(type = 'error', msg = xhr.responseJSON.message);
            }
        });
    }
    getBoard();

    function getMedium() {

        const formData = {
            'board_id': $('#filter_result_board').val(),
        };
        $.ajax({
            url: 'result_medium', // Correct URL for the 'store' method
            type: 'GET',
            data: formData,
            success: function (response) {
                var filter_result_selectBox = $('#filter_result_medium');
                filter_result_selectBox.empty();
                filter_result_selectBox.append('<option value="">Select a medium</option>');
                response.data.forEach(function (item) {
                    filter_result_selectBox.append(`<option value="${item.id}">${item.name}</option>`);
                });
            },
            error: function (xhr) {
                success_error(type = 'error', msg = xhr.responseJSON.message);
            }
        });
    }

    function getStandard() {
        const formData = {
            'board_id': $('#filter_result_board').val(),
            'medium_id': $('#filter_result_medium').val(),
        };

        $.ajax({
            url: 'result_standard', // Correct URL for the 'store' method
            type: 'GET',
            data: formData,
            success: function (response) {

                var filter_result_selectBox = $('#filter_result_standard');
                filter_result_selectBox.empty();
                filter_result_selectBox.append('<option value="">Select a standard</option>');
                response.data.forEach(function (item) {
                    filter_result_selectBox.append(`<option value="${item.id}">${item.name}</option>`);
                });

            },
            error: function (xhr) {
                success_error(type = 'error', msg = xhr.responseJSON.message);
            }
        });
    }

    function getSubject() {
        const formData = {
            'board_id': $('#filter_result_board').val(),
            'medium_id': $('#filter_result_medium').val(),
            'standard_id': $('#filter_result_standard').val(),
        };

        $.ajax({
            url: 'result_subject', // Correct URL for the 'store' method
            type: 'GET',
            data: formData,
            success: function (response) {
                var filter_result_selectBox = $('#filter_result_subject');
                filter_result_selectBox.empty();
                filter_result_selectBox.append('<option value="">Select a subject</option>');
                response.data.forEach(function (item) {
                    filter_result_selectBox.append(`<option value="${item.id}">${item.subject_name}</option>`);
                });
            },
            error: function (xhr) {
                success_error(type = 'error', msg = xhr.responseJSON.message);
            }
        });
    }
    $(document).on('change', '#filter_result_board', function () {
        getMedium();
    });
    $(document).on('change', ' #filter_result_standard', function () {
        getSubject();
    });
    $(document).on('change', '#filter_result_subject', function () {
        getchapter();
    });
    $(document).on('change', '#filter_result_medium', function () {
        getStandard();
    });
    $('#filter').on('click', function (e) {
        e.preventDefault();
        $('#resultTable').DataTable().ajax.reload();
    });
});