$(document).ready(function () {
    var table = $('#questionsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: 'questions', // Ensure this URL matches the route
            type: 'GET',
            data: function (d) {
                // Add additional parameters to the request
                d.chapter_id = $('#filter_questions_chapter').val();
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'question', name: 'question' },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ]
    });

    // Reload table data when chapter filter changes
    $('#filter_questions_chapter').on('change', function () {
        table.ajax.reload();
    });
    //modal for creating chapter
    $('#stdmodalbtn').on('click', function () {
        $('#stdsubmit').show();
        $('#stdupdate').hide();
        resetChapterForm();
    });
    //edit modal show and populate
    $(document).on('click', '.edit', function () {
        $('#stdsubmit').hide();
        $('#stdupdate').show();
        $('#QuestionmodalId').modal('show');
        resetChapterForm();
        var row = $(this).closest('tr');
        var data = table.row(row).data();
        $('#question_id').val(data.id);
        $('#questions_chapter').val(data.chapter_id);
        $('#question').val(data.question);
        $('#option_a').val(data.option_a);
        $('#option_b').val(data.option_b);
        $('#option_c').val(data.option_c);
        $('#option_d').val(data.option_d);

        $('#correct_ans').val(data.correct_ans);
        $('#QuestionmodalId').attr('status', 'edit');
        $('#QuestionmodalId').attr('board_id', data.board_id);
        $('#QuestionmodalId').attr('medium_id', data.medium_id);
        $('#QuestionmodalId').attr('standard_id', data.standard_id);
        $('#QuestionmodalId').attr('subject_id', data.subject_id);
        $('#QuestionmodalId').attr('chapter_id', data.chapter_id);
        getBoard();
    });
    //store chapter

    $('#stdsubmit').on('click', function (e) {
        e.preventDefault();
        formData = {
            chapter_id: $('#questions_chapter').val(),
            question: $('#question').val(),
            correct_ans: $('#correct_ans').val(),
            option_a: $('#option_a').val(),
            option_b: $('#option_b').val(),
            option_c: $('#option_c').val(),
            option_d: $('#option_d').val(),
        };
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: 'questions', // Correct URL for the 'store' method
            type: 'POST',
            data: formData,
            success: function (response) {
                $('#question').val('');
                $('#option_a').val('');
                $('#option_b').val('');
                $('#option_c').val('');
                $('#option_d').val('');
                $('#correct_ans').prop('selectedIndex', 0);
                success_error(type = 'success', msg = response.message);

                $('#questionsTable').DataTable().ajax.reload();
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
            id: $('#question_id').val(),
            chapter_id: $('#questions_chapter').val(),
            question: $('#question').val(),
            correct_ans: $('#correct_ans').val(),
            option_a: $('#option_a').val(),
            option_b: $('#option_b').val(),
            option_c: $('#option_c').val(),
            option_d: $('#option_d').val(),
        };
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/questions/' + formData.id, // Correct URL for the 'store' method
            type: 'PUT',
            data: formData,
            success: function (response) {

                success_error(type = 'success', msg = response.message);
                $('#QuestionmodalId').modal('hide');
                $('#questionsTable').DataTable().ajax.reload();
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
                    url: '/questions/' + id,
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
                        $('#questionsTable').DataTable().ajax.reload();
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
    function getchapter(filter = false) {
        const formData = {
            'board_id': filter ? $('#filter_questions_board').val() : $('#questions_board').val(),
            'medium_id': filter ? $('#filter_questions_medium').val() : $('#questions_medium').val(),
            'standard_id': filter ? $('#filter_questions_standard').val() : $('#questions_standard').val(),
            'subject_id': filter ? $('#filter_questions_subject').val() : $('#questions_subject').val(),
        };

        $.ajax({
            url: 'questions_getChapters', // Correct URL for the 'store' method
            type: 'GET',
            data: formData,
            success: function (response) {
                var questions_selectBox = $('#questions_chapter');
                var filter_questions_selectBox = $('#filter_questions_chapter');
                questions_selectBox.empty();
                filter_questions_selectBox.empty();
                questions_selectBox.append('<option value="">Select a chapter</option>');
                filter_questions_selectBox.append('<option value="">Select a chapter</option>');
                response.data.forEach(function (item) {
                    questions_selectBox.append(`<option value="${item.id}">${item.chapter_name}</option>`);
                    filter_questions_selectBox.append(`<option value="${item.id}">${item.chapter_name}</option>`);
                });
                modal = $('#QuestionmodalId');
                if (modal.attr('status') == 'edit') {
                    $('#questions_chapter').val(modal.attr('chapter_id'));

                }
            },
            error: function (xhr) {
                success_error(type = 'error', msg = xhr.responseJSON.message);
            }
        });
    }

    function getBoard() {
        $.ajax({
            url: 'questions_board', // Correct URL for the 'store' method
            type: 'GET',

            success: function (response) {

                var questions_selectBox = $('#questions_board');
                var filter_questions_selectBox = $('#filter_questions_board');
                questions_selectBox.empty();
                filter_questions_selectBox.empty();
                questions_selectBox.append('<option value="">Select a board</option>');
                filter_questions_selectBox.append('<option value="">Select a board</option>');
                response.data.forEach(function (item) {
                    questions_selectBox.append(`<option value="${item.id}">${item.name}</option>`);
                    filter_questions_selectBox.append(`<option value="${item.id}">${item.name}</option>`);
                });

                modal = $('#QuestionmodalId');
                if (modal.attr('status') == 'edit') {

                    $('#questions_board').val(modal.attr('board_id'));
                    getMedium();
                }


            },
            error: function (xhr) {
                success_error(type = 'error', msg = xhr.responseJSON.message);
            }
        });
    }
    getBoard();

    function getMedium(filter = false) {

        const formData = {
            'board_id': filter ? $('#filter_questions_board').val() : $('#questions_board').val(),
        };
        $.ajax({
            url: 'questions_medium', // Correct URL for the 'store' method
            type: 'GET',
            data: formData,
            success: function (response) {
                var questions_selectBox = $('#questions_medium');
                var filter_questions_selectBox = $('#filter_questions_medium');
                questions_selectBox.empty();
                filter_questions_selectBox.empty();
                questions_selectBox.append('<option value="">Select a medium</option>');
                filter_questions_selectBox.append('<option value="">Select a medium</option>');
                response.data.forEach(function (item) {
                    questions_selectBox.append(`<option value="${item.id}">${item.name}</option>`);
                    filter_questions_selectBox.append(`<option value="${item.id}">${item.name}</option>`);
                });
                modal = $('#QuestionmodalId');
                if (modal.attr('status') == 'edit') {
                    $('#questions_medium').val(modal.attr('medium_id'));

                    getStandard();
                }

            },
            error: function (xhr) {
                success_error(type = 'error', msg = xhr.responseJSON.message);
            }
        });
    }
    function getStandard(filter = false) {
        const formData = {
            'board_id': filter ? $('#filter_questions_board').val() : $('#questions_board').val(),
            'medium_id': filter ? $('#filter_questions_medium').val() : $('#questions_medium').val(),
        };

        $.ajax({
            url: 'questions_standard', // Correct URL for the 'store' method
            type: 'GET',
            data: formData,
            success: function (response) {
                var questions_selectBox = $('#questions_standard');
                var filter_questions_selectBox = $('#filter_questions_standard');
                filter_questions_selectBox.empty();
                questions_selectBox.empty();
                filter_questions_selectBox.append('<option value="">Select a standard</option>');
                questions_selectBox.append('<option value="">Select a standard</option>');
                response.data.forEach(function (item) {
                    filter_questions_selectBox.append(`<option value="${item.id}">${item.name}</option>`);
                    questions_selectBox.append(`<option value="${item.id}">${item.name}</option>`);
                });
                modal = $('#QuestionmodalId');
                if (modal.attr('status') == 'edit') {
                    questions_selectBox.val(modal.attr('standard_id'));

                    getSubject();
                }
            },
            error: function (xhr) {
                success_error(type = 'error', msg = xhr.responseJSON.message);
            }
        });
    }

    function getSubject(filter = false) {
        const formData = {
            'board_id': filter ? $('#filter_questions_board').val() : $('#questions_board').val(),
            'medium_id': filter ? $('#filter_questions_medium').val() : $('#questions_medium').val(),
            'standard_id': filter ? $('#filter_questions_standard').val() : $('#questions_standard').val(),
        };

        $.ajax({
            url: 'questions_subject', // Correct URL for the 'store' method
            type: 'GET',
            data: formData,
            success: function (response) {


                var questions_selectBox = $('#questions_subject');
                var filter_questions_selectBox = $('#filter_questions_subject');
                questions_selectBox.empty();
                filter_questions_selectBox.empty();
                questions_selectBox.append('<option value="">Select a subject</option>');
                filter_questions_selectBox.append('<option value="">Select a subject</option>');
                response.data.forEach(function (item) {
                    questions_selectBox.append(`<option value="${item.id}">${item.subject_name}</option>`);
                    filter_questions_selectBox.append(`<option value="${item.id}">${item.subject_name}</option>`);
                });
                modal = $('#QuestionmodalId');
                if (modal.attr('status') == 'edit') {
                    $('#questions_subject').val(modal.attr('subject_id'));
                    getchapter();
                }
            },
            error: function (xhr) {
                success_error(type = 'error', msg = xhr.responseJSON.message);
            }
        });
    }

    function resetChapterForm() {
        $('#questionsForm')[0].reset(); // Reset the form
        $('#questionsForm input[type="hidden"]').val('');
        $('#questions_medium').empty();
        $('#questions_standard').empty();
        $('#questions_subject').empty();
        $('#questions_chapter').empty();
        $('#QuestionmodalId').removeAttr('board_id');
        $('#QuestionmodalId').removeAttr('medium_id');
        $('#QuestionmodalId').removeAttr('standard_id');
        $('#QuestionmodalId').removeAttr('subject_id');
        $('#QuestionmodalId').removeAttr('chapter_id');
        $('#QuestionmodalId').removeAttr('status');
    }
    $(document).on('change', '#questions_board,#filter_questions_board', function () {
        const isFilter = this.id === 'filter_questions_board'; // Check the ID of the triggering element
        if (isFilter) {
            getMedium(filter = true);
        }
        else {
            getMedium();
        }
    });
    $(document).on('change', ' #questions_standard,#filter_questions_standard', function () {
        const isFilter = this.id === 'filter_questions_standard'; // Check the ID of the triggering element
        if (isFilter) {
            getSubject(filter = true);
        }
        else {
            getSubject();
        }
    });
    $(document).on('change', ' #questions_subject,#filter_questions_subject', function () {
        const isFilter = this.id === 'filter_questions_subject'; // Check the ID of the triggering element
        if (isFilter) {

            getchapter(filter = true);
        }
        else {
            getchapter();
        }
    });
    $(document).on('change', '#questions_medium,#filter_questions_medium', function () {
        const isFilter = this.id === 'filter_questions_medium'; // Check the ID of the triggering element
        if (isFilter) {
            getStandard(filter = true);
        }
        else {
            getStandard();
        }

    });

});