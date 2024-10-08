@extends('layout.main')

@section('content')
    <script src="{{ asset('assets/js/chapter.js') }}" type="text/javascript"></script>
    <div class="pagetitle">
        <h1>Chapters</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Chapters</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">

                            <div class="card-body mt-2">
                                <div class="card-head">
                                    <h1 class="card-title">Add A New Chapter</h1>
                                </div>
                                <div class="row">

                                    {{-- modal trigger button --}}
                                    <div class="col-sm-2 m-1">

                                        <button type="button" class="btn btn-primary" id="stdmodalbtn"
                                            data-bs-toggle="modal" data-bs-target="#chaptermodalId">
                                            Add Chapter
                                        </button>
                                    </div>
                                    {{-- modal-form-start --}}
                                </div>

                            </div>
                        </div>
                    </div>



                    <!-- Modal Body -->
                    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                    <div class="modal fade" id="chaptermodalId" tabindex="-1" data-bs-backdrop="static"
                        data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable " role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalTitleId">
                                        Add chapter
                                    </h5>
                                    <button type="button" class="btn-danger" data-bs-dismiss="modal"
                                        aria-label="Close">X</button>
                                </div>
                                <div class="modal-body">
                                    <form id="chapterForm">
                                        <div class="mb-3">

                                            <input type="hidden" class="form-control" id="chapter_id" name="chapter_id">

                                        </div>
                                        <div class="mb-3 ">
                                            <label for="chapter_board" class="form-label">Board</label>
                                            <select class="form-select form-select" name="chapter_board" id="chapter_board">

                                            </select>
                                        </div>
                                        <div class="mb-3 ">
                                            <label for="chapter_medium" class="form-label">Medium</label>
                                            <select class="form-select form-select" name="chapter_medium"
                                                id="chapter_medium">

                                            </select>
                                        </div>
                                        <div class="mb-3 ">
                                            <label for="chapter_medium" class="form-label">Standard</label>
                                            <select class="form-select form-select" name="chapter_standard"
                                                id="chapter_standard">

                                            </select>
                                        </div>
                                        <div class="mb-3 ">
                                            <label for="chapter_medium" class="form-label">subject</label>
                                            <select class="form-select form-select" name="chapter_subject"
                                                id="chapter_subject">

                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label">Chapter Name</label>
                                            <input type='text' class="form-control" name='chapter_name'
                                                id='chapter_name' />
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
                                    <h1 class="card-title">All Created Chapters</h1>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-sm-2 ">
                                        <label for="chapter_board" class="form-label">Board</label>
                                        <select class="form-select form-select" name="filter_chapter_board"
                                            id="filter_chapter_board">

                                        </select>
                                    </div>
                                    <div class="mb-3 col-sm-2 ">
                                        <label for="chapter_medium" class="form-label">Medium</label>
                                        <select class="form-select form-select" name="filter_chapter_medium"
                                            id="filter_chapter_medium">

                                        </select>
                                    </div>
                                    <div class="mb-3 col-sm-2 ">
                                        <label for="chapter_medium" class="form-label">Standard</label>
                                        <select class="form-select form-select" name="filter_chapter_standard"
                                            id="filter_chapter_standard">

                                        </select>
                                    </div>
                                    <div class="mb-3 col-sm-2 ">
                                        <label for="chapter_medium" class="form-label">subject</label>
                                        <select class="form-select form-select" name="filter_chapter_subject"
                                            id="filter_chapter_subject">

                                        </select>
                                    </div>
                                    <div class="mb-3 col-sm-2  align-self-center">
                                        <button type="button" id='chapter_filter' class="btn btn-primary">
                                            search
                                        </button>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="class">
                                        <table id="chapter_table" class="table">
                                            <thead>
                                                <tr>
                                                    <th>id</th> <!-- Added Agent Code -->
                                                    <th>Name</th>
                                                    {{-- <th>Medium</th>
                                                    <th>Standard</th>
                                                    <th>Subject</th> --}}
                                                    <th>Action</th>
                                                    {{-- <th>Status</th> --}}
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



        </div>

    </section>
@endsection
