@extends('layout.main')



<!-- ======= Header ======= -->
<!-- End Header -->

<!-- ======= Sidebar ======= -->

<!-- End Sidebar-->



@section('content')
    <script src="{{ asset('assets/js/school.js') }}" type="text/javascript"></script>
    <div class="pagetitle">
        <h1>Schools</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">School</li>
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
                                <button type="button" class="btn btn-primary " id='school_modalbtn'>
                                    Add School
                                </button>
                            </div>
                            {{-- modal-form-start --}}



                            <!-- Modal Body -->
                            <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                            <div class="modal fade" id="school_modalId" tabindex="-1" data-bs-backdrop="static"
                                data-bs-keyboard="false" role="dialog" aria-labelledby="school_modalTitleId"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable " role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="school_modalTitleId">
                                                Create School
                                            </h5>
                                            <button type="button" class="btn-danger" data-bs-dismiss="modal"
                                                aria-label="Close">X</button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="schoolForm">
                                                <div class="mb-3">
                                                    <label for="school_name" class="form-label">School Name</label>
                                                    <input type="text" class="form-control" name="school_name"
                                                        id="school_name" aria-describedby="helpId"
                                                        placeholder="Enter School Name" required />
                                                    <input type="hidden" class="form-control" name="id" id="school_id"
                                                        aria-describedby="helpId" required />
                                                </div>
                                                <div class="mb-3">
                                                    <label for="school_address" class="form-label">School Address</label>
                                                    <input type="text" class="form-control" name="school_address"
                                                        id="school_address" aria-describedby="helpId"
                                                        placeholder="Enter School Address" required />

                                                </div>
                                                <div class="form-group">
                                                    <label for="school_logo">Upload Logo</label>
                                                    <input type="file" name="school_logo" id="school_logo"
                                                        class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="school_board_table" class="form-label">Boards</label>
                                                    <table id='school_board_table'>
                                                    </table>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="school_medium_table" class="form-label">Mediums</label>
                                                    <table id='school_medium_table'>
                                                    </table>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="school_standard_table" class="form-label">Standards</label>
                                                    <table id='school_standard_table'>
                                                    </table>
                                                </div>
                                                <button id='school_sub_btn' class="btn btn-primary">Submit</button>
                                            </form>
                                        </div>
                                        <div class="modal-footer">


                                        </div>
                                    </div>
                                </div>
                            </div>




                            {{-- modal-form-end --}}
                            <div class="card-body">


                                <table id="schoolTable" class="table ">
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
