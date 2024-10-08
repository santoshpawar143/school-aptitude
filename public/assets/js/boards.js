$(document).ready(function () {
    //standard page create or update entry
    $('#stdsubmit').on('click', function (e) {
        e.preventDefault(); // Prevent form submission
        var checkedValues = $('input[name="medium_checkbox"]:checked').map(function () {
            return $(this).val();
        }).get();

        var formData = {
            name: $('#board_name').val(),
            id: $('#board_id').val(),
            medium: checkedValues.length > 0 ? checkedValues : ""
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/boards', // Correct URL for the 'store' method
            type: 'POST',
            data: formData,
            success: function (response) {
                success_error(type = 'success', msg = response.message) // Show success message
                $('#BoardmodalId').modal('hide');
                $('#boardTable').DataTable().ajax.reload();
            },
            error: function (xhr) {
                success_error(type = 'error', msg = xhr.responseJSON.message) // Show success message
            }
        });
    });
    // standard page data table
    var table = $('#boardTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: 'boards', // Adjust if necessary
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
                    url: '/boards/' + id,
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
                        $('#boardTable').DataTable().ajax.reload();
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
        $('input[name="medium_checkbox"]').prop('checked', false);
        try {
            var checkboxData = $(this).data('checkbox');
            if (Array.isArray(checkboxData)) {
                checkboxData.forEach(function (item, index) {
                    $('#flexSwitchCheck' + item).prop('checked', true);
                });
            }
        } catch (e) {
            console.error('Error parsing JSON data:', e);
        }
        var row = $(this).closest('tr');
        var data = table.row(row).data();
        $('#board_id').val(data.id);
        $('#board_name').val(data.name);
        $('#BoardmodalId').modal('show');
    });
    //standard page rest modal
    $('#stdmodalbtn').on('click', function () {
        $('#boardForm')[0].reset();
        $('#BoardmodalId').modal('show');
    });
    //medium switch buttons
    $.ajax({
        url: 'board_medium', // Correct URL for the 'school_medium' method
        type: 'GET',
        dataType: 'json',
        success: function (response) {

            var table = $('#board_medium_table');
            response.data.forEach(function (item) {
                table.append(
                    `<tr>   
                                <td>
                                    <div class="form-check form-switch">
                                     <label class="form-check-label" for="flexSwitchCheck${item.id}">${item.name}</label>
                                        <input class="form-check-input" name="medium_checkbox" type="checkbox" value="${item.id}" id="flexSwitchCheck${item.id}" />  
                                    </div>
                                </td>
                            </tr>`
                );
            });

        },
        error: function (xhr) {
            success_error(type = 'error', msg = xhr.responseJSON.message);
        }
    });
});