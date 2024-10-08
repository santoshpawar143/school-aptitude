@include('layout.header')

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        @php
            $user = auth()->user(); // Get the authenticated user
            $school = $user ? $user->school : null; // Get the associated school
        @endphp

        @if ($school)
            <div class="d-flex align-items-center justify-content-between">
                @php
                    $logoPath = 'user_image/' . $school->logo;
                    $fullUrl = asset($logoPath); // Generate the full URL
                @endphp

                <a href="index.html" class="logo d-flex align-items-center">
                    <img src="{{ $fullUrl }}" alt="school"
                        onerror="this.onerror=null;this.src='{{ asset('public/storage/logos/default.png') }}';">
                    <span class="d-lg-block">{{ $school->school_name }}</span>
                </a>


            </div>
        @else
            <p>No school associated with this user.</p>
        @endif

        </div><!-- End Logo -->
        <!-- End Search Bar -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">







                <i class="bi bi-list toggle-sidebar-btn d-md-none"></i>

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->
