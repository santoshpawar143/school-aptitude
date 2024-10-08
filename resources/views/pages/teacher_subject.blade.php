@extends('layout.main')



<!-- ======= Header ======= -->
<!-- End Header -->

<!-- ======= Sidebar ======= -->

<!-- End Sidebar-->



@section('content')
    <script src="{{ asset('assets/js/teacher_subject.js') }}" type="text/javascript"></script>
    <div class="pagetitle">
        <h1>Teachers</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Teacher subject</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Sales Card -->




                    <!-- Recent Sales -->
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">

                            {{-- modal trigger button --}}
                            <div class="card col-sm-2 m-3">
                                <button type="button" class="btn btn-primary" id="stdmodalbtn" data-bs-toggle="modal"
                                    data-bs-target="#TeacherSubjectmodalId">
                                    Add subject to teacher
                                </button>
                            </div>
                            {{-- modal-form-start --}}



                            <!-- Modal Body -->
                            <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                            <div class="modal fade" id="TeacherSubjectmodalId" tabindex="-1" data-bs-backdrop="static"
                                data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable " role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalTitleId">
                                                Teacher subject
                                            </h5>
                                            <button type="button" class="btn-danger" data-bs-dismiss="modal"
                                                aria-label="Close">X</button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="teacherForm">
                                                <div class="mb-3">
                                                    <label for="teacher_name" class="form-label">Select Teacher</label>
                                                    <input type="hidden" class="form-control" id="teacher_id"
                                                        name="teacher_id">
                                                    <input type="text" class="form-control" id="teacher_name"
                                                        name="teacher_name" required placeholder="Enter Teacher Name">
                                                </div>


                                                <div class=" col mb-3">
                                                    <label for="teacher_board" class="form-label">Board</label>
                                                    <div id='board_div'>

                                                    </div>
                                                </div>
                                                <div class=" col mb-3">
                                                    <label for="teacher_medium" class="form-label">Medium</label>
                                                    <div id='medium_div'>

                                                    </div>
                                                </div>
                                                <div class="col mb-3">
                                                    <label for="teacher_standard" class="form-label">Standard</label>
                                                    <div id='standard_div'>

                                                    </div>
                                                </div>
                                                <div class="col mb-3">
                                                    <label for="teacher_subject" class="form-label">Subject</label>
                                                    <div id='subject_div'>

                                                    </div>
                                                </div>
                                                <button id="stdsubmit" class="btn btn-primary">Create</button>
                                                {{-- <button id="stdupdate" class="btn btn-primary">Update</button> --}}
                                            </form>
                                        </div>
                                        <div class="modal-footer">


                                        </div>
                                    </div>
                                </div>
                            </div>




                            {{-- modal-form-end --}}
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class=" col-sm-2">
                                        <label for="filter_test_subject" class="form-label">Board</label>
                                        <select class="form-select form-select filter_student" name="filter_teacher_board"
                                            id="filter_teacher_board">

                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="filter_test_medium" class="form-label">Medium</label>
                                        <select class="form-select form-select filter_student" name="filter_teacher_medium"
                                            id="filter_teacher_medium">

                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="test_standard" class="form-label">Standard</label>
                                        <select class="form-select form-select" name="filter_teacher_standard"
                                            id="filter_teacher_standard">

                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="test_standard" class="form-label">Subject</label>
                                        <select class="form-select form-select" name="filter_teacher_subject"
                                            id="filter_teacher_subject">

                                        </select>
                                    </div>
                                    <div class="col-sm-2 align-self-center">
                                        <button type="button" class="btn btn-primary" id='filter'>
                                            Search
                                        </button>

                                    </div>
                                </div>
                                <table id="teacherTable" class="table">
                                    <thead>
                                        <tr>
                                            <th>id</th> <!-- Added Agent Code -->
                                            <th>Name</th>
                                            <th>Board</th>
                                            <th>Medium</th>
                                            <th>Standard</th>
                                            <th>Subject</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Data will be populated by DataTables via AJAX -->
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div><!-- End Recent Sales -->



                </div>
            </div><!-- End Left side columns -->

            <!-- Right side columns -->


        </div>

    </section>
@endsection

<!-- End #main -->

<!-- ======= Footer ======= -->
