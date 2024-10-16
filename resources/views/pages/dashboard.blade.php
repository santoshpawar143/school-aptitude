@extends('layout.main')



<!-- ======= Header ======= -->
<!-- End Header -->

<!-- ======= Sidebar ======= -->

<!-- End Sidebar-->


@section('content')
    {{-- <div class="pagetitle card p-2" style="padding-left:30px; "> --}}
    {{-- <h1>Dashboard</h1> --}}
    {{-- <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav> --}}
    {{-- </div><!-- End Page Title --> --}}

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Sales Card -->
                    <div class="col-xxl-3 col-md-3">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Student</h5> <!-- Bold text for "Student" -->
                                    <h6 class="mb-0">59</h6> <!-- Number of students -->
                                </div>
                                <p>Number of students</p> <!-- Below row text -->


                            </div>


                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Revenue Card -->
                    <div class="col-xxl-3 col-md-3">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Teachers</h5> <!-- Bold text for "Student" -->
                                    <h6 class="mb-0">59</h6> <!-- Number of students -->
                                </div>
                                <p>Number of teachers</p> <!-- Below row text -->


                            </div>


                        </div>
                    </div><!-- End Revenue Card -->

                    <!-- Customers Card -->
                    <div class="col-xxl-3 col-md-3">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Subjects</h5> <!-- Bold text for "Student" -->
                                    <h6 class="mb-0">59</h6> <!-- Number of students -->
                                </div>
                                <p>Number of subjects</p> <!-- Below row text -->


                            </div>


                        </div>
                    </div><!-- End Customers Card -->
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="card">
                                <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                            class="bi bi-three-dots"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>
                                        <li><a class="dropdown-item" href="#">Today</a></li>
                                        <li><a class="dropdown-item" href="#">This Month</a></li>
                                        <li><a class="dropdown-item" href="#">This Year</a></li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Reports <span>/Today</span></h5>
                                    <!-- Line Chart -->
                                    <div id="reportsChart"></div>
                                    <script>
                                        document.addEventListener("DOMContentLoaded", () => {
                                            new ApexCharts(document.querySelector("#reportsChart"), {
                                                series: [{
                                                    name: 'Sales',
                                                    data: [31, 40, 28, 51, 42, 82, 56],
                                                }, {
                                                    name: 'Revenue',
                                                    data: [11, 32, 45, 32, 34, 52, 41]
                                                }, {
                                                    name: 'Customers',
                                                    data: [15, 11, 32, 18, 9, 24, 11]
                                                }],
                                                chart: {
                                                    height: 350,
                                                    type: 'area',
                                                    toolbar: {
                                                        show: false
                                                    },
                                                },
                                                markers: {
                                                    size: 4
                                                },
                                                colors: ['#4154f1', '#2eca6a', '#ff771d'],
                                                fill: {
                                                    type: "gradient",
                                                    gradient: {
                                                        shadeIntensity: 1,
                                                        opacityFrom: 0.3,
                                                        opacityTo: 0.4,
                                                        stops: [0, 90, 100]
                                                    }
                                                },
                                                dataLabels: {
                                                    enabled: false
                                                },
                                                stroke: {
                                                    curve: 'smooth',
                                                    width: 2
                                                },
                                                xaxis: {
                                                    type: 'datetime',
                                                    categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z",
                                                        "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z",
                                                        "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z",
                                                        "2018-09-19T06:30:00.000Z"
                                                    ]
                                                },
                                                tooltip: {
                                                    x: {
                                                        format: 'dd/MM/yy HH:mm'
                                                    },
                                                }
                                            }).render();
                                        });
                                    </script>
                                    <!-- End Line Chart -->
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="card">
                                <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                            class="bi bi-three-dots"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>
                                        <li><a class="dropdown-item" href="#">Today</a></li>
                                        <li><a class="dropdown-item" href="#">This Month</a></li>
                                        <li><a class="dropdown-item" href="#">This Year</a></li>
                                    </ul>
                                </div>
                                <div class="card-body pb-0">
                                    <h5 class="card-title">Website Traffic <span>| Today</span></h5>
                                    <div id="trafficChart" style="min-height: 400px;" class="echart"></div>
                                    <script>
                                        document.addEventListener("DOMContentLoaded", () => {
                                            echarts.init(document.querySelector("#trafficChart")).setOption({
                                                tooltip: {
                                                    trigger: 'item'
                                                },
                                                legend: {
                                                    top: '5%',
                                                    left: 'center'
                                                },
                                                series: [{
                                                    name: 'Access From',
                                                    type: 'pie',
                                                    radius: ['40%', '70%'],
                                                    avoidLabelOverlap: false,
                                                    label: {
                                                        show: false,
                                                        position: 'center'
                                                    },
                                                    emphasis: {
                                                        label: {
                                                            show: true,
                                                            fontSize: '18',
                                                            fontWeight: 'bold'
                                                        }
                                                    },
                                                    labelLine: {
                                                        show: false
                                                    },
                                                    data: [{
                                                            value: 1048,
                                                            name: 'Search Engine'
                                                        },
                                                        {
                                                            value: 735,
                                                            name: 'Direct'
                                                        },
                                                        {
                                                            value: 580,
                                                            name: 'Email'
                                                        },
                                                        {
                                                            value: 484,
                                                            name: 'Union Ads'
                                                        },
                                                        {
                                                            value: 300,
                                                            name: 'Video Ads'
                                                        }
                                                    ]
                                                }]
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Sales -->
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Recent Sales <span>| Today</span></h5>

                                {{-- <table class="table lms_table_active">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Customer</th>
                                            <th scope="col">Product</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row"><a href="#">#2457</a></th>
                                            <td>Brandon Jacob</td>
                                            <td><a href="#" class="text-primary">At praesentium minu</a>
                                            </td>
                                            <td>$64</td>
                                            <td><span class="badge bg-success">Approved</span></td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><a href="#">#2147</a></th>
                                            <td>Bridie Kessler</td>
                                            <td><a href="#" class="text-primary">Blanditiis dolor omnis
                                                    similique</a></td>
                                            <td>$47</td>
                                            <td><span class="badge bg-warning">Pending</span></td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><a href="#">#2049</a></th>
                                            <td>Ashleigh Langosh</td>
                                            <td><a href="#" class="text-primary">At recusandae
                                                    consectetur</a></td>
                                            <td>$147</td>
                                            <td><span class="badge bg-success">Approved</span></td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><a href="#">#2644</a></th>
                                            <td>Angus Grady</td>
                                            <td><a href="#" class="text-primar">Ut voluptatem id earum
                                                    et</a></td>
                                            <td>$67</td>
                                            <td><span class="badge bg-danger">Rejected</span></td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><a href="#">#2644</a></th>
                                            <td>Raheem Lehner</td>
                                            <td><a href="#" class="text-primary">Sunt similique
                                                    distinctio</a></td>
                                            <td>$165</td>
                                            <td><span class="badge bg-success">Approved</span></td>
                                        </tr>
                                    </tbody>
                                </table> --}}
                                <div class="white_box QA_section mt_30">
                                    <div class="white_box_tittle list_header">
                                        <h4>Total student by each course</h4>
                                    </div>
                                    <div class="table-responsive QA_table" style="max-height: 800px; overflow:auto">
                                        <table class="table lms_table_active">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Course Title</th>
                                                    <th scope="col">Instructor</th>
                                                    <th scope="col">Enrolled</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">
                                                        <a target="_blank"
                                                            href="https://edume.infixlive.com/courses-details/1/fundamentals-of-interior-design"
                                                            class="question_content">Fundamentals of Interior Design
                                                        </a>
                                                    </th>
                                                    <td>Super admin</td>
                                                    <td>1</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <a target="_blank"
                                                            href="https://edume.infixlive.com/courses-details/4/fundamentals-of-interior-design-1"
                                                            class="question_content">Fundamentals of Interior Design
                                                        </a>
                                                    </th>
                                                    <td>Super admin</td>
                                                    <td>1</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <a target="_blank"
                                                            href="https://edume.infixlive.com/courses-details/5/the-complete-web-developer"
                                                            class="question_content">The complete web developer
                                                        </a>
                                                    </th>
                                                    <td>Super admin</td>
                                                    <td>1</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <a target="_blank"
                                                            href="https://edume.infixlive.com/courses-details/6/fundamentals-of-interior-web-design"
                                                            class="question_content">Fundamentals of Interior Web
                                                            Design
                                                        </a>
                                                    </th>
                                                    <td>Super admin</td>
                                                    <td>1</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <a target="_blank"
                                                            href="https://edume.infixlive.com/courses-details/8/learning-python-for-data-analysis-and-visualization"
                                                            class="question_content">Learning Python for Data Analysis
                                                            and
                                                            Visualization
                                                        </a>
                                                    </th>
                                                    <td>Super admin</td>
                                                    <td>0</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <a target="_blank"
                                                            href="https://edume.infixlive.com/courses-details/9/microsoft-excel-excel-from-beginner-to-advanced"
                                                            class="question_content">Microsoft Excel - Excel from
                                                            Beginner
                                                            to Advanced
                                                        </a>
                                                    </th>
                                                    <td>Super admin</td>
                                                    <td>1</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <a target="_blank"
                                                            href="https://edume.infixlive.com/courses-details/10/the-complete-2022-web-development-bootcamp"
                                                            class="question_content">The Complete 2022 Web Development
                                                            Bootcamp
                                                        </a>
                                                    </th>
                                                    <td>Super admin</td>
                                                    <td>0</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <a target="_blank"
                                                            href="https://edume.infixlive.com/courses-details/11/complete-next-js-developer-in-2022-zero-to-mastery"
                                                            class="question_content">Complete Next.js Developer in
                                                            2022:
                                                            Zero to
                                                            Mastery
                                                        </a>
                                                    </th>
                                                    <td>Super admin</td>
                                                    <td>1</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <a target="_blank"
                                                            href="https://edume.infixlive.com/courses-details/12/the-complete-javascript-course-2022-from-zero-to-expert"
                                                            class="question_content">The Complete JavaScript Course
                                                            2022:
                                                            From Zero to
                                                            Expert!
                                                        </a>
                                                    </th>
                                                    <td>Super admin</td>
                                                    <td>1</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <a target="_blank"
                                                            href="https://edume.infixlive.com/courses-details/13/build-responsive-real-world-websites-with-html-and-css"
                                                            class="question_content">Build Responsive Real-World
                                                            Websites
                                                            with HTML and
                                                            CSS
                                                        </a>
                                                    </th>
                                                    <td>Super admin</td>
                                                    <td>1</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <a target="_blank"
                                                            href="https://edume.infixlive.com/courses-details/14/web-design-for-beginners-real-world-coding-in-html-css"
                                                            class="question_content">Web Design for Beginners: Real
                                                            World
                                                            Coding in
                                                            HTML &amp; CSS
                                                        </a>
                                                    </th>
                                                    <td>Super admin</td>
                                                    <td>1</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <a target="_blank"
                                                            href="https://edume.infixlive.com/courses-details/15/css-the-complete-guide-2022-incl-flexbox-grid-sass"
                                                            class="question_content">CSS - The Complete Guide 2022
                                                            (incl.
                                                            Flexbox, Grid
                                                            &amp; Sass)
                                                        </a>
                                                    </th>
                                                    <td>Super admin</td>
                                                    <td>1</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <a target="_blank"
                                                            href="https://edume.infixlive.com/courses-details/16/javascript-the-complete-guide-2022-beginner-advanced"
                                                            class="question_content">JavaScript - The Complete Guide
                                                            2022
                                                            (Beginner +
                                                            Advanced)
                                                        </a>
                                                    </th>
                                                    <td>Super admin</td>
                                                    <td>1</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <a target="_blank"
                                                            href="https://edume.infixlive.com/courses-details/17/advanced-css-and-sass-flexbox-grid-animations-and-more"
                                                            class="question_content">Advanced CSS and Sass: Flexbox,
                                                            Grid,
                                                            Animations
                                                            and More!
                                                        </a>
                                                    </th>
                                                    <td>Super admin</td>
                                                    <td>1</td>
                                                </tr>

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
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>

    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>


    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
@endsection
<!-- End #main -->

<!-- ======= Footer ======= -->
