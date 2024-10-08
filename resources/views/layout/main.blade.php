@include('layout.navbar')


<!-- ======= Header ======= -->
<!-- End Header -->

<!-- ======= Sidebar ======= -->
@include('layout.sidbar')
<!-- End Sidebar-->
<main id="main" class="main">
    @yield('content')
</main>

@include('layout.footer')
