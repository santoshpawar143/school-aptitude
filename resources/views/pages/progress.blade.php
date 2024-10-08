@extends('layout.main')



<!-- ======= Header ======= -->
<!-- End Header -->

<!-- ======= Sidebar ======= -->

<!-- End Sidebar-->



@section('content')
    <script src="{{ asset('assets/js/progress.js') }}" type="text/javascript"></script>
    <div class="pagetitle">
        <h1>Progress</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Syllabus</li>
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
                                    <h1 class="card-title">Subjects</h1>
                                </div>
                                <div class="row">

                                    <div class="mb-3 col-md-3 col-12">
                                        <label for="" class="form-label">Select a subject</label>
                                        <select class="form-select form-select" name="student_subject" id="student_subject">

                                        </select>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>




                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">
                            <div class="card-body">
                                <div class="card-head">
                                    <h1 class="card-title">Chapters</h1>
                                </div>
                                <div class="card-content">
                                    <div class="class">
                                        <table id="chapter_table" class="table">
                                            <thead>
                                                <tr>
                                                    <th>id</th>
                                                    <!-- Added Agent Code -->
                                                    <th>Chapter Name</th>
                                                    <th>Marks Obtained</th>
                                                    <th>Total Marks</th>
                                                    <th>Result</th>
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

            <!-- Right side columns -->


        </div>

    </section>
@endsection

<!-- End #main -->

<!-- ======= Footer ======= -->
