$(function () {
    //to open submitbtn modal
    $('#subject_modalbtn').on('click', function () {
        $('#subjectForm')[0].reset();
        $('#subjectForm').find('input[type="hidden"]').val('');
        $('#subject_modalId').modal('show');
        $('#subject_modalTitleId').html('Create Subject');
    });
    //create or update
    $('#subject_sub_btn').on('click', function (e) {
        e.preventDefault(); // Prevent form submission
        var checkedValues = $('.board_switchbox:checked').map(function () {
            return $(this).val();
        }).get();
        var medium_switch_box = $('.medium_switchbox:checked').map(function () {
            return $(this).val();
        }).get();
        var standard_switch_box = $('.standard_switchbox:checked').map(function () {
            return $(this).val();
        }).get();
        var formData = {
            subject_name: $('#subject_name').val(),
            id: $('#subject_id').val(),
            medium_array: medium_switch_box.length > 0 ? JSON.stringify(medium_switch_box) : "",
            standard_array: standard_switch_box.length > 0 ? JSON.stringify(standard_switch_box) : "",
            board_array: checkedValues.length > 0 ? JSON.stringify(checkedValues) : ""
        };


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: 'subject', // Correct URL for the 'store' method
            type: 'POST',
            data: formData,
            success: function (response) {

                success_error(type = 'success', msg = response.message);
                $('#subject_modalId').modal('hide');
                $('#subjectTable').DataTable().ajax.reload();
            },
            error: function (xhr) {
                success_error(type = 'error', msg = xhr.responseJSON.message);
            }
        });
    });

    // subject page data table
    var table = $('#subjectTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: 'subject', // Adjust if necessary
            type: 'GET'
        },
        columns: [
            {
                data: null,
                name: 'index',
                render: function (data, type, row, meta) {
                    return meta.row + 1; // Sequential numbering
                },
                orderable: false, // Disable ordering on this column
                searchable: false // Disable searching on this column
            },
            { data: 'subject_name', name: 'subject_name' },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ]
    });
    $(document).on('click', '.edit', function () {
        $('#subjectForm')[0].reset();
        $('#subject_modalId').modal('show');
        $('#subject_modalTitleId').html('Update Subject');



        var row = $(this).closest('tr');
        var data = table.row(row).data();
        $('#subject_id').val(data.id);
        $('#subject_name').val(data.subject_name);


        var boardIds = $(this).data('board');
        var mediumIds = $(this).data('medium');
        var stadardIds = $(this).data('standard');
        $('.board_switchbox').each(function () {
            $(this).attr('data-state', 'edit');
            $(this).attr('data-medium', mediumIds);
        });

        $('.board_switchbox').each(function () {
            if (boardIds.includes($(this).val())) {
                $(this).prop('checked', true);

            } else {
                $(this).prop('checked', false);
            }
        });
        $('.standard_switchbox').each(function () {
            if (stadardIds.includes($(this).val())) {
                $(this).prop('checked', true);

            } else {
                $(this).prop('checked', false);
            }
        });

        getmedium(mediumIds);



    });


    //to fetch the boards from board table
    function getBoards() {

        $.ajax({
            url: 'subject_board', // Correct URL for the 'subject_medium' method
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                var table = $('#subject_board_table');
                table.empty();
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
                });

            },
            error: function (xhr) {
                alert('Error: ' + xhr.responseJSON.message); // Handle error
            }
        });
    }
    getBoards();
    function getStandards() {

        $.ajax({
            url: 'subject_standard', // Correct URL for the 'subject_medium' method
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                var table = $('#subject_standard_table');
                table.empty();
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
                });

            },
            error: function (xhr) {
                alert('Error: ' + xhr.responseJSON.message); // Handle error
            }
        });
    }
    getStandards();
    //to fetch medium based on board   
    $(document).on('change', '.board_switchbox', function () {
        var state = $(this).attr('data-state');
        var medium = $(this).data('medium');
        if (state == "edit") { getmedium(medium); }
        else { getmedium(); }
    });
    function getmedium(mediumIds = []) {
        if (typeof mediumIds === 'number') {

            mediumIds = [mediumIds.toString()];
        }
        var checkedValues = $('.board_switchbox:checked').map(function () {
            return $(this).val();
        }).get();

        $.ajax({
            url: 'subject_medium', // Correct URL for the 'subject_medium' method
            type: 'GET',
            dataType: 'json',
            data: {
                board: checkedValues // Send checkedValues as part of the request
            },
            success: function (response) {
                var table = $('#subject_medium_table');
                table.empty(); // Clear previous data
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
                    url: '/subject/' + id,
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
                        $('#subjectTable').DataTable().ajax.reload();
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

});






