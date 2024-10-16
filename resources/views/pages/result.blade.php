@extends('layout.main')



<!-- ======= Header ======= -->
<!-- End Header -->

<!-- ======= Sidebar ======= -->

<!-- End Sidebar-->



@section('content')
    <script src="{{ asset('assets/js/result.js') }}" type="text/javascript"></script>
    {{-- <div class="pagetitle">
        <h1>Result</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Result</li>
            </ol>
        </nav>
    </div><!-- End Page Title --> --}}

    <section class="section dashboard">
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
                            <div class="modal fade" id="ResultmodalId" tabindex="-1" data-bs-backdrop="static"
                                data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable " role="document">
                                    <div class="modal-content add-popup-bg custom-rounded">
                                        <div class="modal-header add-card-bg">
                                            <h5 class="modal-title" id="modalTitleId">
                                                Edit Result
                                            </h5>
                                            <button type="button" class="btn-danger" data-bs-dismiss="modal"
                                                aria-label="Close">X</button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="resultForm">
                                                <div class="mb-3">
                                                    <label for="result_name" class="form-label">Roll No</label>
                                                    <input type="hidden" class="form-control" id="result_id"
                                                        name="result_id">
                                                    <input type="text"
                                                        class="form-control form-control-lg custom-rounded"
                                                        id="result_roll_no" name="result_name" required
                                                        placeholder="Enter Roll No">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="result_name" class="form-label">Marks Obtained</label>

                                                    <input type="text"
                                                        class="form-control form-control-lg custom-rounded"
                                                        id="result_marks_obtained" name="result_name" required
                                                        placeholder="Enter Marks Obtained">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="result_name" class="form-label">Total Marks</label>
                                                    <input type="text"
                                                        class="form-control form-control-lg custom-rounded"
                                                        id="result_total_marks" name="result_name" required
                                                        placeholder="Enter Total Marks">
                                                </div>
                                                <button id="stdsubmit" class="btn pro-btn">Submit</button>
                                            </form>
                                        </div>
                                        <div class="modal-footer">


                                        </div>
                                    </div>
                                </div>
                            </div>




                            {{-- modal-form-end --}}
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="mb-3 col-sm-2 ">
                                        <label for="chapter_board" class="form-label">Board</label>
                                        <select class="form-select form-select custom-rounded" name="filter_result_board"
                                            id="filter_result_board">

                                        </select>
                                    </div>
                                    <div class="mb-3 col-sm-2 ">
                                        <label for="chapter_medium" class="form-label">Medium</label>
                                        <select class="form-select form-select custom-rounded" name="filter_result_medium"
                                            id="filter_result_medium">

                                        </select>
                                    </div>
                                    <div class="mb-3 col-sm-2 ">
                                        <label for="chapter_medium" class="form-label">Standard</label>
                                        <select class="form-select form-select custom-rounded" name="filter_result_standard"
                                            id="filter_result_standard">

                                        </select>
                                    </div>
                                    <div class="mb-3 col-sm-2 ">
                                        <label for="chapter_medium" class="form-label">subject</label>
                                        <select class="form-select form-select custom-rounded" name="filter_result_subject"
                                            id="filter_result_subject">

                                        </select>
                                    </div>
                                    <div class="mb-3 col-sm-2">
                                        <label for="test_standard" class="form-label">Chapter</label>
                                        <select class="form-select form-select custom-rounded" name="filter_result_chapter"
                                            id="filter_result_chapter">

                                        </select>
                                    </div>
                                    <div class="mb-3 col-sm-2  align-self-center">
                                        <button type="button" id='filter' class="btn pro-btn">
                                            search
                                        </button>
                                    </div>
                                </div>

                                <table id="resultTable" class="table">
                                    <thead>
                                        <tr>
                                            <th>id</th> <!-- Added Agent Code -->
                                            <th>Roll No</th>
                                            <th>Student Name</th>
                                            <th>Chapter Name</th>
                                            <th>Marks Obtained</th>
                                            <th>Out Of</th>
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
