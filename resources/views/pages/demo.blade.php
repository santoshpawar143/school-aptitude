@include('layout.navbar')



<!-- ======= Header ======= -->
<!-- End Header -->

<!-- ======= Sidebar ======= -->

<!-- End Sidebar-->




<script src="{{ asset('assets/js/apptitude.js') }}" type="text/javascript"></script>
<div class="pagetitle">
    <h1>Apptitude</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Apptitude</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard border">
    <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
            <div class="row">


                <div class="col-12">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-body d-flex justify-content-center align-items-center ">
                            <div class="row">
                                <div class="mb-3  col">
                                    <label for="test_standard" class="form-label">Roll Number</label>
                                    <input type="text" class="form-control" id="student_roll_no"
                                        name="student_roll_no">
                                </div>
                                <div class="mb-3 col">
                                    <label for="test_standard" class="form-label">Test code</label>
                                    <input type="text" class="form-control" id="test_code" name="test_code">
                                </div>

                                <div class=" col m-1">
                                    <button type="button" class="btn btn-primary " id='start_test'>
                                        Start test
                                    </button>
                                </div>
                                <div id="toast-container" class="toast-container mb-3 col">

                                </div>


                            </div>

                        </div>




                        <div class="container mt-4 col-sm-7" style="height: 700px;">
                            <div class="card">

                                <div class="card-body" id="test_create">
                                    <!-- Dynamic form content will be inserted here -->
                                </div>

                            </div>

                        </div>


                    </div>
                </div><!-- End Recent Sales -->



            </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->


    </div>

    <button type="button" class="btn btn-primary" data-bs-toggle="toast" data-bs-target="#liveToast">
        Show toast
    </button>
</section>


<!-- End #main -->

<!-- ======= Footer ======= -->
@include('layout.footer')
<button type="button" class="btn btn-primary" data-bs-toggle="toast" data-bs-target="#liveToast">
    Show toast
</button>
