@extends('layout.main')



<!-- ======= Header ======= -->
<!-- End Header -->

<!-- ======= Sidebar ======= -->

<!-- End Sidebar-->



@section('content')
    <script src="{{ asset('assets/js/role.js') }}" type="text/javascript"></script>
    {{-- <div class="pagetitle">
        <h1>Roles</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Standard</li>
            </ol>
        </nav>
    </div><!-- End Page Title --> --}}

    <section class="section dashboard">
        <div class=" col-sm-2 m-3">
            <div>
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="card-title">Roles List</h6>
                    <button type="button" class="btn pro-btn" id="role_modalbtn">
                        <i class="bi bi-plus-lg"></i> ADD ROLE
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

                            {{-- modal trigger button --}}

                            {{-- modal-form-start --}}



                            <!-- Modal Body -->
                            <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                            <div class="modal fade custom-rounded" id="role_modalId" tabindex="-1"
                                data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                                aria-labelledby="role_modalTitleId" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-lg " role="document">
                                    <div class="modal-content add-popup-bg custom-rounded">
                                        <div class="modal-header add-card-bg ">
                                            <h5 class="modal-title" id="role_modalTitleId">
                                                Create Role
                                            </h5>
                                            <button type="button" class="btn-danger rounded" data-bs-dismiss="modal"
                                                aria-label="Close">X</button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="roleForm">
                                                <div class="mb-3">
                                                    <label for="role_name" class="form-label">Role Name</label>
                                                    <input type="hidden" class="form-control " id="role_id"
                                                        name="role_id">
                                                    <input type="text"
                                                        class="form-control form-control-lg custom-rounded" id="role_name"
                                                        name="role_name" required placeholder="-">
                                                </div>
                                                <button id="role_submit" class="btn pro-btn">Submit</button>
                                            </form>
                                        </div>
                                        <div class="modal-footer">


                                        </div>
                                    </div>
                                </div>
                            </div>




                            {{-- modal-form-end --}}
                            <div class="card-body">


                                <table id="roleTable" class="datatable ">
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
