$(document).ready(function () {
    var table = $('#chapter_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: 'student_subject', // Ensure this URL matches the route
            type: 'GET',
            data: function (d) {
                // Add additional parameters to the request
                d.subject_id = $('#student_subject').val();
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
    });
    //store chapter

    $('#stdsubmit').on('click', function (e) {

        e.preventDefault();
        formData = {
            'chapter_name': $('#chapter_name').val(),
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
    //edit modal show and populate
    $(document).on('click', '.edit', function () {
        $('#stdsubmit').hide();
        $('#stdupdate').show();
        $('#chaptermodalId').modal('show');
        var row = $(this).closest('tr');
        var data = table.row(row).data();
        $('#chapter_name').val(data.chapter_name);
        $('#chapter_id').val(data.id);
    });
    //update 
    $('#stdupdate').on('click', function (e) {
        e.preventDefault();
        formData = {
            'chapter_name': $('#chapter_name').val(),
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
    //get subjects
    function getSubjects() {
        $.ajax({
            url: 'student_all_subject', // Correct URL for the 'store' method
            type: 'GET',
            success: function (response) {
                var subject_selectBox = $('#student_subject');
                subject_selectBox.empty();
                subject_selectBox.append('<option value="">Select a subject</option>');
                response.data.forEach(function (item) {
                    subject_selectBox.append(`<option value="${item.id}">${item.subject_name}</option>`);
                });

            },
            error: function (xhr) {
                success_error(type = 'error', msg = xhr.responseJSON.message);
            }
        });
    }
    getSubjects();
    $('#student_subject').on('change', function () {
        $('#chapter_table').DataTable().ajax.reload();
    });
    $(document).on('click', '.aptitude', function () {
        formData = {
            chapter_id: $(this).data('id')
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: 'start_test', // Correct URL for the 'store' method
            type: 'POST',
            data: formData,
            success: function (response) {
                console.log(response);
                const dataToStore = {
                    testData: response.data,
                    chapterId: response.chapter_id,
                    chapterName: response.chapter_name
                };
                const dataString = JSON.stringify(dataToStore);
                sessionStorage.setItem('testData', dataString);
                window.location.href = '/aptitude';
            },
            error: function (xhr) {
                success_error(type = 'error', msg = xhr.responseJSON.message);
            }
        });
    })
});