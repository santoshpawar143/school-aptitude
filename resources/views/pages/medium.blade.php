@extends('layout.main')



<!-- ======= Header ======= -->
<!-- End Header -->

<!-- ======= Sidebar ======= -->

<!-- End Sidebar-->



@section('content')
    <script src="{{ asset('assets/js/medium.js') }}" type="text/javascript"></script>
    {{-- <div class="pagetitle">
        <h1>Medium</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Medium</li>
            </ol>
        </nav>
    </div><!-- End Page Title --> --}}

    <section class="section dashboard">
        <div class=" col-sm-3 m-3">
            <div>
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="card-title">Mediums List</h6>
                    <button type="button" class="btn pro-btn" id="medium_modalbtn">
                        <i class="bi bi-plus-lg"></i> ADD MEDIUM
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
                            <div class="modal fade" id="MediummodalId" tabindex="-1" data-bs-backdrop="static"
                                data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-xl-custom" role="document">
                                    <div class="modal-content custom-rounded add-popup-bg">
                                        <div class="modal-header add-card-bg">
                                            <h5 class="modal-title" id="modalTitleId">
                                                Medium
                                            </h5>
                                            <button type="button" class="btn-danger" data-bs-dismiss="modal"
                                                aria-label="Close">X</button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="modelForm">
                                                <div class="mb-3">
                                                    <label for="standard_name" class="form-label">Medium Name</label>
                                                    <input type="hidden" class="form-control" id="medium_id"
                                                        name="board_id">
                                                    <input type="text" class="form-control form-control" id="medium_name"
                                                        name="board_name" required placeholder="-">
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
                            <div class="card-body">


                                <table id="mediumTable" class="datatable">
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
