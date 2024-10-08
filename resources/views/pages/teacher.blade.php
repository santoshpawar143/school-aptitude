@extends('layout.main')



<!-- ======= Header ======= -->
<!-- End Header -->

<!-- ======= Sidebar ======= -->

<!-- End Sidebar-->



@section('content')
    <script src="{{ asset('assets/js/teacher.js') }}" type="text/javascript"></script>
    <div class="pagetitle">
        <h1>Teachers</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Teachers</li>
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
                                <button type="button" class="btn btn-primary " id='stdmodalbtn'>
                                    Add Teacher
                                </button>
                            </div>
                            {{-- modal-form-start --}}



                            <!-- Modal Body -->
                            <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                            <div class="modal fade" id="TeachermodalId" tabindex="-1" data-bs-backdrop="static"
                                data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable " role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalTitleId">
                                                Teacher
                                            </h5>
                                            <button type="button" class="btn-danger" data-bs-dismiss="modal"
                                                aria-label="Close">X</button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="teacherForm">
                                                <div class="mb-3">
                                                    <label for="teacher_name" class="form-label">Teacher Name</label>
                                                    <input type="hidden" class="form-control" id="teacher_id"
                                                        name="teacher_id">
                                                    <input type="text" class="form-control" id="teacher_name"
                                                        name="teacher_name" required placeholder="Enter Teacher Name">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="teacher_roll_no" class="form-label">Teacher no</label>
                                                    <input type="text" class="form-control" id="teacher_roll_no"
                                                        name="teacher_roll_no" required placeholder="Enter Teacher Number">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="teacher_email" class="form-label">email</label>
                                                    <input type="text" class="form-control" id="teacher_email"
                                                        name="teacher_email" required placeholder="Enter email">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="teacher_password" class="form-label">password</label>
                                                    <input type="text" class="form-control" id="teacher_password"
                                                        name="teacher_password" required placeholder="Enter password">
                                                </div>

                                                <button id="stdsubmit" class="btn btn-primary">Create</button>
                                                <button id="stdupdate" class="btn btn-primary">Update</button>
                                            </form>
                                        </div>
                                        <div class="modal-footer">


                                        </div>
                                    </div>
                                </div>
                            </div>




                            {{-- modal-form-end --}}
                            <div class="card-body">


                                <table id="teacherTable" class="table">
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
