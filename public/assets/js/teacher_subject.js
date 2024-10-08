$(document).ready(function () {
    $('#teacher_name').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: '/autocomplete_teacher', // Ensure this matches your route
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
                    // Optional: Provide user feedback
                    alert('An error occurred while fetching autocomplete data.');
                }
            });
        },
        minLength: 2, // Minimum length of input before triggering autocomplete
        select: function (event, ui) {
            console.log('Selected:', ui.item); // Handle item selection
            $('#teacher_name').val(ui.item.value); // Update the input value
            $('#teacher_id').val(ui.item.id); // Update hidden input with selected ID
            return false; // Prevent default handling of the selection
        }
    });
    function getBoards() {

        $.ajax({
            url: 'teacher_subject_board', // Correct URL for the 'school_medium' method
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                var table = $('#board_div');
                table.empty();
                var filter_board_selectBox = $('#filter_teacher_board');
                filter_board_selectBox.empty();
                filter_board_selectBox.append('<option value="">Select a board</option>');
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
                    filter_board_selectBox.append(
                        `<option value="${item.id}">${item.name}</option>`
                    );
                });

            },
            error: function (xhr) {
                alert('Error: ' + xhr.responseJSON.message); // Handle error
            }
        });
    }
    getBoards();
    $(document).on('change', '.board_switchbox,#filter_teacher_board', function () {
        const isFilter = this.id === 'filter_teacher_board'; // Check the ID of the triggering element
        if (isFilter) {
            getmedium(mediumIds = [], filter = true);

        }
        else {
            getmedium();
        }

    });
    function getmedium(mediumIds = [], filter = false) {
        if (typeof mediumIds === 'number') {

            mediumIds = [mediumIds.toString()];
        }

        if (filter == true) {
            checkedValues = [$('#filter_teacher_board').val()];
        } else {
            checkedValues = $('.board_switchbox:checked').map(function () {
                return $(this).val();
            }).get();

        }
        $.ajax({
            url: 'teacher_subject_medium', // Correct URL for the 'school_medium' method
            type: 'GET',
            dataType: 'json',
            data: {
                board: checkedValues // Send checkedValues as part of the request
            },
            success: function (response) {
                var table = $('#medium_div');
                table.empty(); // Clear previous data
                var filter_medium_selectBox = $('#filter_teacher_medium');
                filter_medium_selectBox.empty();
                filter_medium_selectBox.append('<option value="">Select a medium</option>');
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
                    filter_medium_selectBox.append(
                        `<option value="${item.id}">${item.name}</option>`
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
    function getStandards() {

        $.ajax({
            url: 'school_standard', // Correct URL for the 'school_medium' method
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                var table = $('#standard_div');
                table.empty();
                var filter_standard_selectBox = $('#filter_teacher_standard');
                filter_standard_selectBox.empty();
                filter_standard_selectBox.append('<option value="">Select a standard</option>');
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
                    filter_standard_selectBox.append(
                        `<option value="${item.id}">${item.name}</option>`
                    );
                });


            },
            error: function (xhr) {
                alert('Error: ' + xhr.responseJSON.message); // Handle error
            }
        });
    }
    $(document).on('change', '.medium_switchbox,#filter_teacher_medium', function () {
        getStandards()
    });
    function getsubject(filter = false) {
        var boardValues = $('.board_switchbox:checked').map(function () {
            return $(this).val();
        }).get();
        var mediumValues = $('.medium_switchbox:checked').map(function () {
            return $(this).val();
        }).get();
        var standardValues = $('.standard_switchbox:checked').map(function () {
            return $(this).val();
        }).get();

        if (filter) {
            boardValues = [$('#filter_teacher_board').val()];
            mediumValues = [$('#filter_teacher_medium').val()];
            standardValues = [$('#filter_teacher_standard').val()];
        }
        $.ajax({
            url: 'teacher_subject_subjects', // Correct URL for the 'school_medium' method
            type: 'GET',
            dataType: 'json',
            data: {
                board: boardValues,
                medium: mediumValues,
                standard: standardValues
            },
            success: function (response) {
                var table = $('#subject_div');
                table.empty(); // Clear previous data
                var filter_standard_selectBox = $('#filter_teacher_subject');
                filter_standard_selectBox.empty();
                filter_standard_selectBox.append('<option value="">Select a subject</option>');

                response.data.forEach(function (item) {
                    table.append(
                        `<tr>
                        <td>
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="flexSwitchCheck${item.id}">${item.subject_name}</label>
                                <input class="form-check-input subject_switchbox" type="checkbox" value="${item.id}" id="medium${item.id}" />
                            </div>
                        </td>
                    </tr>`
                    );
                    filter_standard_selectBox.append(
                        `<option value="${item.id}">${item.subject_name}</option>`
                    );
                });

            },
            error: function (xhr) {
                alert('Error: ' + xhr.responseJSON.message); // Handle error
            }
        });

    }
    $(document).on('change', '.standard_switchbox,#filter_teacher_standard', function () {
        const isFilter = this.id === 'filter_teacher_standard'; // Check the ID of the triggering element
        if (isFilter) {
            getsubject(filter = true);
        }
        else {
            getsubject();
        }

    });
    $('#stdsubmit').on('click', function (e) {
        e.preventDefault(); // Prevent form submission
        var boardValues = $('.board_switchbox:checked').map(function () {
            return $(this).val();
        }).get();
        var mediumValues = $('.medium_switchbox:checked').map(function () {
            return $(this).val();
        }).get();
        var standardValues = $('.standard_switchbox:checked').map(function () {
            return $(this).val();
        }).get();
        var subjectValues = $('.subject_switchbox:checked').map(function () {
            return $(this).val();
        }).get();
        var formData = {
            teacher_id: $('#teacher_id').val(),

            board_array: boardValues,
            medium_array: mediumValues,
            standard_array: standardValues,
            subject_array: subjectValues
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/teacher_subject', // Correct URL for the 'store' method
            type: 'POST',
            data: formData,
            success: function (response) {
                success_error(type = 'success', msg = response.message);// Show success message

                $('#teacherTable').DataTable().ajax.reload();
                $('#TeacherSubjectmodalId').modal('hide');
            },
            error: function (xhr) {
                // Handle errors here

                success_error(type = 'error', msg = xhr.responseJSON.message);
            }
        });
    });
    //Data table
    var table = $('#teacherTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: 'teacher_subject', // Adjust if necessary
            type: 'GET',
            data: function (d) {
                d.board_id = $('#filter_teacher_board').val();
                d.medium_id = $('#filter_teacher_medium').val();
                d.standard_id = $('#filter_teacher_standard').val();
                d.subject_id = $('#filter_teacher_subject').val();

            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'teacher_name', name: 'teacher_name' },
            { data: 'board_array', name: 'board_array' },
            { data: 'medium_array', name: 'medium_array' },
            { data: 'standard_array', name: 'standard_array' },
            { data: 'subject_array', name: 'subject_array' },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ],
        initComplete: function () {


        }
    });
    $(document).on('click', '.delete', function () {
        var id = $(this).data('id');
        console.log(id);
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
                    url: '/teacher_subject/' + id,
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
    $('#stdmodalbtn').on('click', function () {
        $('#medium_div').empty();
        $('#standard_div').empty();
        $('#subject_div').empty();
        $('#teacherForm')[0].reset();
        $('.medium_switchbox, .board_switchbox, .standard_switchbox').prop('checked', false);
    });
    $('#filter').on('click', function () {
        $('#teacherTable').DataTable().ajax.reload();
    });
});