<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Test Form</title>
    <!-- Bootstrap CSS -->
    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    {{-- <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet"> --}}

    <!-- Vendor CSS Files -->
    {{-- jquery --}}
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery-ui.js"></script>
    <link href="assets/css/jquery-ui.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets/js/apptitude.js') }}" type="text/javascript"></script>
    {{-- jquery --}}
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('sweetAlert/sweetalert2.min.css') }}">
    <script src="{{ asset('sweetAlert/sweetalert2.all.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            background-image: url({{ asset('assets/img/aptitude_background.jpg') }});
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .full-height-container {
            display: flex;
            align-items: center;
            /* Center vertically */
            justify-content: center;
            /* Center horizontally */
            height: 100vh;

        }

        .form-container {
            background-color: #4d98af;
            /* Purple background color */
            color: white;
            /* White text for contrast */

            /* Add padding for spacing */
            border-radius: 15px;
            /* Rounded corners */
            box-shadow: 0 4px 8px rgba(211, 199, 199, 0.2);
            /* Subtle shadow for depth */
            max-width: 500px;
            /* Limit width */

        }

        .card {
            border-radius: 10px;
            /* Rounded corners */
            background-color: transparent;
            /* Ensure the card background is transparent */
        }

        .card-body {
            padding: 2rem;
            /* Add padding inside the card */
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .transition-fade {
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .fade-out {
            opacity: 0;
            transform: scale(0.9);
        }
    </style>
    <style>
        .step-container {
            display: none;
        }

        .step-container.active {
            display: block;
        }

        .step-navigation {
            display: flex;
            justify-content: space-between;
        }
    </style>
    <style>
        .quiz-header {
            background-color: #6db0ba;
            padding: 20px;
            border-radius: 10px 10px 0 0;
            text-align: center;
        }

        .quiz-question {
            margin: 20px 0;
        }

        .quiz-options {
            list-style-type: none;
            padding: 0;
        }


        .quiz-options input[type="radio"] {
            display: none;
        }

        .quiz-options label {
            display: block;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .quiz-options input[type="radio"]:hover+label {
            background-color: #6db0ba;
        }

        .quiz-options input[type="radio"]:checked+label {
            background-color: #6db0ba;
        }
    </style>



</head>

<body>
    <div class="full-height-container transition-fade" id="test_card" style="display: none;">
        <div class="container form-container">
            <!-- First Card: Test Form -->
            <div class="card transition-fade">
                <div class="card-body">
                    <h4 class="card-title mb-4">Start Your Test</h4>
                    <form>
                        <div class="row">
                            {{-- <div class="mb-3 col-md-6">
                                <label for="student_roll_no" class="form-label">Roll Number</label>
                                <input type="text" class="form-control" id="student_roll_no" name="student_roll_no"
                                    required>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="test_code" class="form-label">Test Code</label>
                                <input type="text" class="form-control" id="test_code" name="test_code" required>
                            </div> --}}
                            <h1>Are you ready!!!!</h1>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-primary" id="start_test">Start Test</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="full-height-container" style="display: none;" id="result_container">
        <div class="container form-container ">

            <div class="card transition-fade" id="result_card">
                <div class="card-body " id="test_create">

                </div>
            </div>
        </div>
    </div>



    <!-- Bootstrap JS and dependencies -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

</body>

</html>
