@extends('layout.main')



<!-- ======= Header ======= -->
<!-- End Header -->

<!-- ======= Sidebar ======= -->

<!-- End Sidebar-->



@section('content')
    <script src="{{ asset('assets/js/test.js') }}" type="text/javascript"></script>
    <div class="pagetitle">
        <h1>Generate Test</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Test</li>
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

                            <div class="card-body mt-2">
                                <div class="card-head">
                                    <h1 class="card-title">Add A New Question</h1>
                                </div>
                                <div class="row">

                                    {{-- modal trigger button --}}
                                    <div class="col-sm-2 m-1">

                                        <button type="button" class="btn btn-primary " id='stdmodalbtn'
                                            data-bs-toggle="modal">
                                            Add Question
                                        </button>
                                    </div>
                                    {{-- modal-form-start --}}
                                </div>

                            </div>
                        </div>
                    </div>



                    <!-- Modal Body -->
                    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                    <div class="modal fade" id="TestmodalId" tabindex="-1" data-bs-backdrop="static"
                        data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable " role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalTitleId">
                                        Add Question
                                    </h5>
                                    <button type="button" class="btn-danger" data-bs-dismiss="modal"
                                        aria-label="Close">X</button>
                                </div>
                                <div class="modal-body">
                                    <form id="testForm">
                                        <div class="mb-3">

                                            <input type="hidden" class="form-control" id="test_id" name="test_id">

                                        </div>
                                        <div class="mb-3">
                                            <label for="test_subject" class="form-label">Subject</label>
                                            <select class="form-select form-select" name="test_subject" id="test_subject">

                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="test_medium" class="form-label">Medium</label>
                                            <select class="form-select form-select" name="test_medium" id="test_medium">

                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="test_standard" class="form-label">Standard</label>
                                            <select class="form-select form-select" name="test_standard" id="test_standard">

                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label">Question</label>
                                            <textarea class="form-control" name="test_question" id="test_question" rows="3"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label">Option A</label>
                                            <textarea class="form-control" name="option_a" id="option_a" rows="3"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label">Option B</label>
                                            <textarea class="form-control" name="option_b" id="option_b" rows="3"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label">Option C</label>
                                            <textarea class="form-control" name="option_c" id="option_c" rows="3"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label">Option D</label>
                                            <textarea class="form-control" name="option_d" id="option_d" rows="3"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label">Correct Ans</label>
                                            <input type="text" class="form-control" name="correct_ans"
                                                id="correct_ans" aria-describedby="helpId" placeholder="" />
                                            <small id="helpId" class="form-text text-muted">Help text</small>
                                        </div>

                                        <button id="stdsubmit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                                <div class="modal-footer">


                                </div>
                            </div>
                        </div>
                    </div>




                    {{-- modal-form-end --}}
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">
                            <div class="card-body">
                                <div class="card-head">
                                    <h1 class="card-title">Create A New Test</h1>
                                </div>
                                <div class="card-content">
                                    <div class="row">
                                        <div class="mb-3">
                                            <label for="test_name" class="form-label">Test Name</label>
                                            <input type="text" class="form-control" name="test_name" id="test_name"
                                                aria-describedby="helpId" placeholder="Test Name" />
                                            <input type="hidden" class="form-control" name="test_name_id"
                                                id="test_name_id" aria-describedby="helpId" placeholder="Test Name" />

                                        </div>
                                        <div class=" col">
                                            <label for="filter_test_subject" class="form-label">Subject</label>
                                            <select class="form-select form-select" name="filter_test_subject"
                                                id="filter_test_subject">

                                            </select>
                                        </div>
                                        <div class=" col">
                                            <label for="filter_test_medium" class="form-label">Medium</label>
                                            <select class="form-select form-select" name="filter_test_medium"
                                                id="filter_test_medium">

                                            </select>
                                        </div>
                                        <div class="col mb-3">
                                            <label for="test_standard" class="form-label">Standard</label>
                                            <select class="form-select form-select" name="filter_test_standard"
                                                id="filter_test_standard">

                                            </select>
                                        </div>
                                        <div class="col mb-3 align-self-center">
                                            <a name="filter_search" id="filter_search" class="btn btn-primary"
                                                href="#" role="button">Search</a>
                                        </div>
                                    </div>
                                    <div class="class">
                                        <table id="testTable" class="table">
                                            <thead>
                                                <tr>
                                                    <th>id</th> <!-- Added Agent Code -->
                                                    <th>Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Data will be populated by DataTables via AJAX -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mb-3">
                                        <button id="test_generate_btn" class="btn btn-primary">Generate Test</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Recent Sales -->
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">
                            <div class="card-body">
                                <div class="card-head">
                                    <h1 class="card-title">All Created Tests</h1>
                                </div>
                                <div class="card-content">
                                    <div class="class">
                                        <table id="generated_test_Table" class="table">
                                            <thead>
                                                <tr>
                                                    <th>id</th> <!-- Added Agent Code -->
                                                    <th>Name</th>
                                                    <th>Test Code</th>
                                                    <th>Medium</th>
                                                    <th>Standard</th>
                                                    <th>Subject</th>
                                                    <th>Action</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Data will be populated by DataTables via AJAX -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
            </div><!-- End Left side columns -->

            <!-- Right side columns -->


        </div>

    </section>
@endsection

<!-- End #main -->

<!-- ======= Footer ======= -->
