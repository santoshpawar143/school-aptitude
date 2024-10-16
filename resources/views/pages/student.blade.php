@extends('layout.main')



<!-- ======= Header ======= -->
<!-- End Header -->

<!-- ======= Sidebar ======= -->

<!-- End Sidebar-->



@section('content')
    <script src="{{ asset('assets/js/student.js') }}" type="text/javascript"></script>
    {{-- <div class="pagetitle">
        <h1>Students</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Apptiude</li>
            </ol>
        </nav>
    </div><!-- End Page Title --> --}}

    <section class="section dashboard">
        <div class=" col-sm-3 m-3">
            <div>
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="card-title">Subject List</h6>
                    <button type="button" class="btn pro-btn" id="stdmodalbtn">
                        <i class="bi bi-plus-lg"></i> ADD STUDENT
                    </button>
                </div>
            </div>
        </div>
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Sales Card -->




                    <!-- Recent Sales -->
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">




                            <!-- Modal Body -->
                            <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                            <div class="modal fade" id="StudentmodalId" tabindex="-1" data-bs-backdrop="static"
                                data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-xl-custom" role="document">
                                    <div class="modal-content add-popup-bg custom-rounded">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalTitleId">
                                                Student
                                            </h5>
                                            <button type="button" class="btn-danger" data-bs-dismiss="modal"
                                                aria-label="Close">X</button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="studentForm">
                                                <div class="mb-3">
                                                    <label for="student_name" class="form-label">Student Name</label>
                                                    <input type="hidden" class="form-control" id="student_id"
                                                        name="student_id">
                                                    <input type="text"
                                                        class="form-control form-control-lg custom-rounded"
                                                        id="student_name" name="student_name" required placeholder="-">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="student_roll_no" class="form-label">Roll no</label>
                                                    <input type="text"
                                                        class="form-control form-control-lg custom-rounded"
                                                        id="student_roll_no" name="student_roll_no" required
                                                        placeholder="-">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="student_roll_no" class="form-label">email</label>
                                                    <input type="text"
                                                        class="form-control form-control-lg custom-rounded"
                                                        id="student_email" name="student_email" required placeholder="-">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="student_roll_no" class="form-label">password</label>
                                                    <input type="text"
                                                        class="form-control form-control-lg custom-rounded"
                                                        id="student_password" name="student_password" required
                                                        placeholder="-">
                                                </div>
                                                <div class=" col">
                                                    <label for="filter_test_subject" class="form-label">Board</label>
                                                    <select class="form-select form-select-lg custom-rounded"
                                                        name="student_board" id="student_board">

                                                    </select>
                                                </div>
                                                <div class=" col">
                                                    <label for="filter_test_medium" class="form-label">Medium</label>
                                                    <select class="form-select form-select-lg custom-rounded"
                                                        name="student_medium" id="student_medium">

                                                    </select>
                                                </div>
                                                <div class="col mb-3">
                                                    <label for="test_standard" class="form-label">Standard</label>
                                                    <select class="form-select form-select-lg custom-rounded"
                                                        name="student_standard" id="student_standard">

                                                    </select>
                                                </div>
                                                <button id="stdsubmit" class="btn pro-btn">Submit</button>
                                                <button id="stdupdate" class="btn pro-btn">Update</button>
                                            </form>
                                        </div>
                                        <div class="modal-footer">


                                        </div>
                                    </div>
                                </div>
                            </div>




                            {{-- modal-form-end --}}
                            <div class="card-body">
                                <div class="row mb-3 p-3">
                                    <div class=" col-sm-2">
                                        <label for="filter_test_subject" class="form-label">Board</label>
                                        <select class="form-select form-select-lg custom-rounded filter_student"
                                            name="filter_student_board" id="filter_student_board">

                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="filter_test_medium" class="form-label">Medium</label>
                                        <select class="form-select form-select-lg custom-rounded filter_student"
                                            name="filter_student_medium" id="filter_student_medium">

                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="test_standard" class="form-label">Standard</label>
                                        <select class="form-select form-select-lg custom-rounded filter_student"
                                            name="filter_student_standard" id="filter_student_standard">

                                        </select>
                                    </div>
                                    <div class="col-sm-2 align-self-center">
                                        <button type="button" class="btn pro-btn" id='filter'>
                                            Search
                                        </button>

                                    </div>
                                </div>

                                <table id="studentTable" class="datatable">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>Roll no</th> <!-- Added Agent Code -->
                                            <th>Name</th>
                                            <th>Board</th>
                                            <th>Medium</th>
                                            <th>Standard</th>
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
