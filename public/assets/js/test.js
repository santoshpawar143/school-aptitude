$(document).ready(function () {
    //test page create or update entry
    $('#stdsubmit').on('click', function (e) {
        e.preventDefault(); // Prevent form submission

        var formData = {
            subject: $('#test_subject').val(),
            id: $('#test_id').val(),
            medium: $('#test_medium').val(),
            standard: $('#test_standard').val(),
            question: $('#test_question').val(),
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
            url: '/test', // Correct URL for the 'store' method
            type: 'POST',
            data: formData,
            success: function (response) {
                alert('Success: ' + response.message); // Show success message
                $('#TestmodalId').modal('hide');
                $('#testTable').DataTable().ajax.reload();
            },
            error: function (xhr) {
                // Handle errors here
                alert('Error: ' + xhr.responseJSON.message);
            }
        });
    });
    // test page data table
    var table = $('#testTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: 'test', // Adjust URL if necessary
            type: 'GET',
            data: function (d) {
                // Append custom filters to the default DataTable request
                d.subject = $('#filter_test_subject').val();
                d.medium = $('#filter_test_medium').val();
                d.standard = $('#filter_test_standard').val();
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
    //test page question delete
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
                    url: '/test/' + id,
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
                        $('#testTable').DataTable().ajax.reload();
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
    //test page generated test delete
    $(document).on('click', '.g-delete', function () {
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
                    url: '/generate_test/' + id,
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
                        $('#generated_test_Table').DataTable().ajax.reload();
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
    //test page modal edit populate
    $(document).on('click', '.edit', function () {
        var row = $(this).closest('tr');
        var data = table.row(row).data();
        $('#test_medium').val(data.medium);
        $('#test_standard').val(data.standard);
        $('#test_subject').val(data.subject);
        $('#test_id').val(data.id);
        $('#test_question').val(data.question);
        $('#option_a').val(data.option_a);
        $('#option_b').val(data.option_b);
        $('#option_c').val(data.option_c);
        $('#option_d').val(data.option_d);
        $('#correct_ans').val(data.correct_ans);
        $('#TestmodalId').modal('show');
    });
    //test page rest modal
    $('#stdmodalbtn').on('click', function () {
        $('#testForm')[0].reset();
        $('#testForm').find('input[type="hidden"]').val('');
        $('#TestmodalId').modal('show');
    });
    //get test medium
    function getmedium() {
        $.ajax({
            url: 'test_medium', // Correct URL for the 'subject_medium' method
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                var selectBox = $('#test_medium');
                var filter_selectBox = $('#filter_test_medium');
                selectBox.empty(); // Clear any existing options
                filter_selectBox.empty();
                // Add a default option
                selectBox.append('<option value="">Select a medium</option>');
                filter_selectBox.append('<option value="">Select a medium</option>');
                // Append new options from the response
                response.data.forEach(function (item) {
                    selectBox.append(
                        `<option value="${item.id}">${item.name}</option>`
                    );
                    filter_selectBox.append(
                        `<option value="${item.id}">${item.name}</option>`
                    );
                });

            },
            error: function (xhr) {
                alert('Error: ' + xhr.responseJSON.message); // Handle error
            }
        });
    }
    getmedium();
    function getstandard() {
        $.ajax({
            url: 'test_standard', // Correct URL for the 'subject_medium' method
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                var selectBox = $('#test_standard');
                var filter_selectBox = $('#filter_test_standard');
                selectBox.empty();
                filter_selectBox.empty(); // Clear any existing options

                // Add a default option
                selectBox.append('<option value="">Select a standard</option>');
                filter_selectBox.append('<option value="">Select a standard</option>');
                // Append new options from the response
                response.data.forEach(function (item) {
                    selectBox.append(
                        `<option value="${item.id}">${item.name}</option>`
                    );

                    filter_selectBox.append(
                        `<option value="${item.id}">${item.name}</option>`
                    );

                });

                filter_selectBox.append('<option value="">Select a standard</option>');
                // Append new options from the response

            },
            error: function (xhr) {
                alert('Error: ' + xhr.responseJSON.message); // Handle error
            }
        });
    }
    getstandard();
    function getsubject() {
        $.ajax({
            url: 'test_subject', // Correct URL for the 'subject_medium' method
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                console.log(response);
                var selectBox = $('#test_subject');
                var filter_selectBox = $('#filter_test_subject');
                selectBox.empty(); // Clear any existing options
                filter_selectBox.empty();
                // Add a default option
                selectBox.append('<option value="">Select a subject</option>');
                filter_selectBox.append('<option value="">Select a subject</option>');
                // Append new options from the response
                response.data.forEach(function (item) {
                    console.log(item);
                    selectBox.append(

                        `<option value="${item.id}">${item.subject_name}</option>`
                    );
                    filter_selectBox.append(

                        `<option value="${item.id}">${item.subject_name}</option>`
                    );
                });
            },
            error: function (xhr) {
                alert('Error: ' + xhr.responseJSON.message); // Handle error
            }
        });
    }
    getsubject();
    $('#test_generate_btn').on('click', function () {
        questions_check_box = $('.generate_test:checked').map(function () {
            return $(this).data('id');
        }).get();
        var formData = {
            test_name: $('#test_name').val(),

            questions: questions_check_box,
            id: $('#test_name_id').val(),
            subject: $('#filter_test_subject').val(),
            medium: $('#filter_test_medium').val(),
            standard: $('#filter_test_standard').val(),
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/generate_test', // Correct URL for the 'store' method
            type: 'POST',
            data: formData,
            success: function (response) {
                alert('Success: ' + response.message); // Show success message
                $('#TestmodalId').modal('hide');
                $('#generated_test_Table').DataTable().ajax.reload();
            },
            error: function (xhr) {
                // Handle errors here
                alert('Error: ' + xhr.responseJSON.message);
            }
        });
    });
    $('#filter_search').on('click', function () {
        table.ajax.reload();
    });
    //all Generated tests

    var all_test_table = $('#generated_test_Table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: 'generate_test', // Adjust if necessary
            type: 'GET'
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'test_name', name: 'test_name' },
            { data: 'test_code', name: 'test_code' },
            { data: 'medium_name', name: 'medium_name' },
            { data: 'standard_name', name: 'standard_name' },
            { data: 'subject_name', name: 'subject_name' },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
            {
                data: 'status',
                name: 'status',
                orderable: false,
                searchable: false
            }
        ]
    });
    $(document).on('change', '.status_switchbox', function () {
        formData = {
            id: $(this).data('id')
        };
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/generate_test_status_update', // Correct URL for the 'store' method
            type: 'POST',
            data: formData,
            success: function (response) {
                alert('Success: ' + response.message); // Show success message
                $('#TestmodalId').modal('hide');
                $('#testTable').DataTable().ajax.reload();
            },
            error: function (xhr) {
                // Handle errors here
                alert('Error: ' + xhr.responseJSON.message);
            }
        });
    });
});