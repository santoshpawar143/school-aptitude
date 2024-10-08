$(document).ready(function () {
    var table = $('#chapter_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: 'progress', // Ensure this URL matches the route
            type: 'GET',
            data: function (d) {
                // Add additional parameters to the request
                d.subject_id = $('#student_subject').val();
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'chapter_name', name: 'chapter_name' },
            { data: 'marks_obtained', name: 'marks_obtained' },
            { data: 'total_marks', name: 'total_marks' },
            { data: 'result', name: 'result' },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ]

    });




    //get subjects
    function getSubjects() {
        $.ajax({
            url: 'progress_all_subject', // Correct URL for the 'store' method
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
    $(document).on('click', '.review', function () {
        var row = $(this).closest('tr');
        var data = table.row(row).data();
        console.log(data.chapter_id);
        formData = {
            chapter_id: data.chapter_id
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
                    chapterName: response.chapter_name,
                    selected_ans: data.selected_ans
                };
                const dataString = JSON.stringify(dataToStore);
                sessionStorage.setItem('testData', dataString);

                window.location.href = '/aptitude';
            },
            error: function (xhr) {
                success_error(type = 'error', msg = xhr.responseJSON.message);
            }
        });
    });
});