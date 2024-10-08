@extends('layout.main')



<!-- ======= Header ======= -->
<!-- End Header -->

<!-- ======= Sidebar ======= -->

<!-- End Sidebar-->



@section('content')
    <script src="{{ asset('assets/js/boards.js') }}" type="text/javascript"></script>
    <div class="pagetitle">
        <h1>Boards</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Boards</li>
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
                                <button type="button" class="btn btn-primary " id='stdmodalbtn' data-bs-toggle="modal">
                                    Add Board
                                </button>
                            </div>
                            {{-- modal-form-start --}}



                            <!-- Modal Body -->
                            <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                            <div class="modal fade" id="BoardmodalId" tabindex="-1" data-bs-backdrop="static"
                                data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable " role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalTitleId">
                                                Boards
                                            </h5>
                                            <button type="button" class="btn-danger" data-bs-dismiss="modal"
                                                aria-label="Close">X</button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="boardForm">
                                                <div class="mb-3">
                                                    <label for="standard_name" class="form-label">Board Name</label>
                                                    <input type="hidden" class="form-control" id="board_id"
                                                        name="board_id">
                                                    <input type="text" class="form-control" id="board_name"
                                                        name="board_name" required placeholder="Enter Board name">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="board_medium_table" class="form-label">Medium</label>
                                                    <table id='board_medium_table'>
                                                    </table>
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
                            <div class="card-body">


                                <table id="boardTable" class="table ">
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
                    </div><!-- End Recent Sales -->



                </div>
            </div><!-- End Left side columns -->

            <!-- Right side columns -->


        </div>

    </section>
@endsection

<!-- End #main -->

<!-- ======= Footer ======= -->
