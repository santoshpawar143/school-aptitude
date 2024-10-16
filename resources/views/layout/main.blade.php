@include('layout.navbar')


<!-- ======= Header ======= -->
<!-- End Header -->

<!-- ======= Sidebar ======= -->
@include('layout.sidbar')
<!-- End Sidebar-->
<main id="main" class="main">
    <div class="pagetitle card p-2" style="padding-left:30px; ">
        <h1>
            {{ ucwords(
                str_replace(['.index', '.', 'index'], ['', ' ', ''], \Illuminate\Support\Facades\Route::currentRouteName()),
            ) }}
        </h1>
        {{-- <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav> --}}
    </div>
    @yield('content')
</main>

@include('layout.footer')
