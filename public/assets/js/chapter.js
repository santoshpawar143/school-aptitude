$(document).ready(function () {

    var table = $('#chapter_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: 'chapters', // Adjust if necessary
            type: 'GET',
            data: function (d) {
                // Append additional data from the form
                d.board_id = $('#filter_chapter_board').val();
                d.medium_id = $('#filter_chapter_medium').val();
                d.standard_id = $('#filter_chapter_standard').val();
                d.subject_id = $('#filter_chapter_subject').val();
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'chapter_name', name: 'chapter_name' },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ]
    });

    //modal for creating chapter
    $('#stdmodalbtn').on('click', function () {
        $('#stdsubmit').show();
        $('#stdupdate').hide();
        resetChapterForm();
        $('#chaptermodalId').attr('status', 'status');
    });

    //edit modal show and populate
    $(document).on('click', '.edit', function () {
        resetChapterForm();
        $('#stdsubmit').hide();
        $('#stdupdate').show();
        $('#chaptermodalId').modal('show');
        var row = $(this).closest('tr');
        var data = table.row(row).data();
        $('#chaptermodalId').attr('status', 'edit');
        $('#chaptermodalId').attr('board_id', data.board_id);
        $('#chaptermodalId').attr('medium_id', data.medium_id);
        $('#chaptermodalId').attr('standard_id', data.standard_id);
        $('#chaptermodalId').attr('subject_id', data.subject_id);
        $('#chapter_name').val(data.chapter_name);
        $('#chapter_id').val(data.id);
        getBoard();

    });

    //store chapter
    $('#stdsubmit').on('click', function (e) {
        e.preventDefault();
        formData = {
            'chapter_name': $('#chapter_name').val(),
            'board_id': $('#chapter_board').val(),
            'medium_id': $('#chapter_medium').val(),
            'standard_id': $('#chapter_standard').val(),
            'subject_id': $('#chapter_subject').val(),
        };
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: 'chapters', // Correct URL for the 'store' method
            type: 'POST',
            data: formData,
            success: function (response) {

                success_error(type = 'success', msg = response.message);
                $('#chaptermodalId').modal('hide');
                $('#chapter_table').DataTable().ajax.reload();
            },
            error: function (xhr) {
                success_error(type = 'error', msg = xhr.responseJSON.message);
            }
        });

    });

    //update 
    $('#stdupdate').on('click', function (e) {
        e.preventDefault();
        formData = {
            'chapter_name': $('#chapter_name').val(),
            'board_id': $('#chapter_board').val(),
            'medium_id': $('#chapter_medium').val(),
            'standard_id': $('#chapter_standard').val(),
            'subject_id': $('#chapter_subject').val(),
            'id': $('#chapter_id').val()
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/chapters/' + formData.id, // Correct URL for the 'store' method
            type: 'PUT',
            data: formData,
            success: function (response) {

                success_error(type = 'success', msg = response.message);
                $('#chaptermodalId').modal('hide');
                $('#chapter_table').DataTable().ajax.reload();
            },
            error: function (xhr) {
                success_error(type = 'error', msg = xhr.responseJSON.message);
            }
        });

    });
    //delete
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
                    url: '/chapters/' + id,
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
                        $('#chapter_table').DataTable().ajax.reload();
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
    //get board
    function getBoard() {
        $.ajax({
            url: 'chapter_board', // Correct URL for the 'store' method
            type: 'GET',

            success: function (response) {
                // var chapter_selectBox = $('#questions_chapter');
                var chapter_selectBox = $('#chapter_board');
                var filter_chapter_selectBox = $('#filter_chapter_board');
                // chapter_selectBox.empty();
                chapter_selectBox.empty();
                filter_chapter_selectBox.empty();
                // chapter_selectBox.append('<option value="">Select a chapter</option>');
                chapter_selectBox.append('<option value="">Select a board</option>');
                filter_chapter_selectBox.append('<option value="">Select a board</option>');
                response.data.forEach(function (item) {

                    chapter_selectBox.append(`<option value="${item.id}">${item.name}</option>`);
                    filter_chapter_selectBox.append(`<option value="${item.id}">${item.name}</option>`);
                });


                modal = $('#chaptermodalId');
                if (modal.attr('status') == 'edit') {
                    $('#chapter_board').val(modal.attr('board_id'));
                    getMedium();
                }
            },
            error: function (xhr) {
                success_error(type = 'error', msg = xhr.responseJSON.message);
            }
        });
    }
    getBoard();

    $(document).on('change', '#chapter_board,#filter_chapter_board', function () {
        const isFilter = this.id === 'filter_chapter_board'; // Check the ID of the triggering element
        if (isFilter) {
            getMedium(filter = true);
        }
        else {
            getMedium();
        }

    });
    //get medium

    function getMedium(filter = false) {
        if (filter == false) {
            formData = {
                'board_id': $('#chapter_board').val()
            };
        }
        else {
            formData = {
                'board_id': $('#filter_chapter_board').val()
            };
        }

        $.ajax({
            url: 'chapter_medium', // Correct URL for the 'store' method
            type: 'GET',
            data: formData,
            success: function (response) {

                var chapter_selectBox = $('#chapter_medium');
                var filter_chapter_selectBox = $('#filter_chapter_medium');
                chapter_selectBox.empty();
                filter_chapter_selectBox.empty();
                chapter_selectBox.append('<option value="">Select a medium</option>');
                filter_chapter_selectBox.append('<option value="">Select a medium</option>');
                response.data.forEach(function (item) {
                    chapter_selectBox.append(`<option value="${item.id}">${item.name}</option>`);
                    filter_chapter_selectBox.append(`<option value="${item.id}">${item.name}</option>`);
                });

                modal = $('#chaptermodalId');
                if (modal.attr('status') == 'edit') {
                    $('#chapter_medium').val(modal.attr('medium_id'));
                    getStandard();
                }

            },
            error: function (xhr) {
                success_error(type = 'error', msg = xhr.responseJSON.message);
            }
        });
    }
    //get standard
    $(document).on('change', '#chapter_medium,#filter_chapter_medium', function () {

        const isFilter = this.id === 'filter_chapter_medium'; // Check the ID of the triggering element
        if (isFilter) {
            getStandard(filter = true);
        }
        else {
            getStandard();
        }
    });
    function getStandard(filter = false) {
        const formData = {
            'board_id': filter ? $('#filter_chapter_board').val() : $('#chapter_board').val(),
            'medium_id': filter ? $('#filter_chapter_medium').val() : $('#chapter_medium').val()
        };
        $.ajax({
            url: 'chapter_standard', // Correct URL for the 'store' method
            type: 'GET',
            data: formData,
            success: function (response) {


                var chapter_selectBox = $('#chapter_standard');
                var filter_chapter_selectBox = $('#filter_chapter_standard');
                chapter_selectBox.empty();
                filter_chapter_selectBox.empty();
                chapter_selectBox.append('<option value="">Select a standard</option>');
                filter_chapter_selectBox.append('<option value="">Select a standard</option>');
                response.data.forEach(function (item) {
                    chapter_selectBox.append(`<option value="${item.id}">${item.name}</option>`);
                    filter_chapter_selectBox.append(`<option value="${item.id}">${item.name}</option>`);
                });
                modal = $('#chaptermodalId');
                if (modal.attr('status') == 'edit') {
                    $('#chapter_standard').val(modal.attr('standard_id'));
                    getSubject();
                }
            },
            error: function (xhr) {
                success_error(type = 'error', msg = xhr.responseJSON.message);
            }
        });
    }
    //get subject
    $(document).on('change', ' #chapter_standard,#filter_chapter_standard', function () {
        const isFilter = this.id === 'filter_chapter_standard'; // Check the ID of the triggering element
        if (isFilter) {
            getSubject(filter = true);
        }
        else {
            getSubject();
        }
    });
    function getSubject(filter = false) {

        const formData = {
            'board_id': filter ? $('#filter_chapter_board').val() : $('#chapter_board').val(),
            'medium_id': filter ? $('#filter_chapter_medium').val() : $('#chapter_medium').val(),
            'standard_id': filter ? $('#filter_chapter_standard').val() : $('#chapter_standard').val()
        };
        $.ajax({
            url: 'chapter_subject', // Correct URL for the 'store' method
            type: 'GET',
            data: formData,
            success: function (response) {

                var chapter_selectBox = $('#chapter_subject');
                var filter_chapter_selectBox = $('#filter_chapter_subject');
                chapter_selectBox.empty();
                filter_chapter_selectBox.empty();
                chapter_selectBox.append('<option value="">Select a subject</option>');
                filter_chapter_selectBox.append('<option value="">Select a subject</option>');
                response.data.forEach(function (item) {
                    chapter_selectBox.append(`<option value="${item.id}">${item.subject_name}</option>`);
                    filter_chapter_selectBox.append(`<option value="${item.id}">${item.subject_name}</option>`);
                });
                modal = $('#chaptermodalId');
                if (modal.attr('status') == 'edit') {
                    $('#chapter_subject').val(modal.attr('subject_id'));
                }
            },
            error: function (xhr) {
                success_error(type = 'error', msg = xhr.responseJSON.message);
            }
        });
    }
    function resetChapterForm() {
        $('#chapterForm')[0].reset(); // Reset the form

        $('#chapterForm input[type="hidden"]').val('');
        $('#chapter_medium').empty();
        $('#chapter_standard').empty();
        $('#chapter_subject').empty();
        $('#chaptermodalId').removeAttr('board_id');
        $('#chaptermodalId').removeAttr('medium_id');
        $('#chaptermodalId').removeAttr('standard_id');
        $('#chaptermodalId').removeAttr('subject_id');
        $('#chaptermodalId').removeAttr('status');
    }
    $('#chapter_filter').on('click', function (e) {
        e.preventDefault();
        $('#chapter_table').DataTable().ajax.reload();
    });
});