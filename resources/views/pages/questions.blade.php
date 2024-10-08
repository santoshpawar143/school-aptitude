@extends('layout.main')



<!-- ======= Header ======= -->
<!-- End Header -->

<!-- ======= Sidebar ======= -->

<!-- End Sidebar-->



@section('content')
    <script src="{{ asset('assets/js/questions.js') }}" type="text/javascript"></script>
    <div class="pagetitle">
        <h1>Questions</h1>
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
                                            data-bs-toggle="modal" data-bs-target="#QuestionmodalId">
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
                    <div class="modal fade" id="QuestionmodalId" tabindex="-1" data-bs-backdrop="static"
                        data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable " role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalTitleId">
                                        Question
                                    </h5>


                                    <button type="button" class="btn-danger" data-bs-dismiss="modal"
                                        aria-label="Close">X</button>
                                </div>
                                <div class="modal-body">
                                    <form id="questionsForm">
                                        <p id='board'></p>
                                        <p id="medium"></p>
                                        <p id="standard"></p>
                                        <p id="subject"></p>
                                        <div class="mb-3">

                                            <input type="hidden" class="form-control" id="question_id" name="question_id">

                                        </div>
                                        <div class="mb-3 ">
                                            <label for="chapter_board" class="form-label">Board</label>
                                            <select class="form-select form-select" name="questions_board"
                                                id="questions_board">

                                            </select>
                                        </div>
                                        <div class="mb-3 ">
                                            <label for="chapter_medium" class="form-label">Medium</label>
                                            <select class="form-select form-select" name="questions_medium"
                                                id="questions_medium">

                                            </select>
                                        </div>
                                        <div class="mb-3 ">
                                            <label for="chapter_medium" class="form-label">Standard</label>
                                            <select class="form-select form-select" name="questions_standard"
                                                id="questions_standard">

                                            </select>
                                        </div>
                                        <div class="mb-3 ">
                                            <label for="chapter_medium" class="form-label">subject</label>
                                            <select class="form-select form-select" name="questions_subject"
                                                id="questions_subject">

                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="test_standard" class="form-label">Chapter</label>
                                            <select class="form-select form-select" name="questions_chapter"
                                                id="questions_chapter">

                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label">Question</label>
                                            <textarea class="form-control" name="question" id="question" rows="3"></textarea>
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
                                            <label for="test_standard" class="form-label">Correct Ans</label>
                                            <select class="form-select form-select" name="correct_ans" id="correct_ans">
                                                <option>Select an option</option>

                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>

                                            </select>
                                        </div>
                                        <button id="stdsubmit" class="btn btn-primary">Submit</button>
                                        <button id="stdupdate" class="btn btn-primary">Update</button>
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
                                    <h1 class="card-title">Question based on chapter</h1>
                                </div>
                                <div class="card-content">
                                    <div class="row">
                                        <div class="mb-3 col-sm-2 ">
                                            <label for="chapter_board" class="form-label">Board</label>
                                            <select class="form-select form-select" name="filter_questions_board"
                                                id="filter_questions_board">

                                            </select>
                                        </div>
                                        <div class="mb-3 col-sm-2 ">
                                            <label for="chapter_medium" class="form-label">Medium</label>
                                            <select class="form-select form-select" name="filter_questions_medium"
                                                id="filter_questions_medium">

                                            </select>
                                        </div>
                                        <div class="mb-3 col-sm-2 ">
                                            <label for="chapter_medium" class="form-label">Standard</label>
                                            <select class="form-select form-select" name="filter_questions_standard"
                                                id="filter_questions_standard">

                                            </select>
                                        </div>
                                        <div class="mb-3 col-sm-2 ">
                                            <label for="chapter_medium" class="form-label">subject</label>
                                            <select class="form-select form-select" name="filter_questions_subject"
                                                id="filter_questions_subject">

                                            </select>
                                        </div>
                                        <div class="mb-3 col-sm-2">
                                            <label for="test_standard" class="form-label">Chapter</label>
                                            <select class="form-select form-select" name="filter_questions_chapter"
                                                id="filter_questions_chapter">

                                            </select>
                                        </div>
                                        {{-- <div class="mb-3 col-sm-2  align-self-center">
                                            <button type="button" id='chapter_filter' class="btn btn-primary">
                                                search
                                            </button>
                                        </div> --}}
                                    </div>

                                    <div class="class">
                                        <table id="questionsTable" class="table">
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

                                </div>
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
