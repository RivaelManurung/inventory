<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Limitless - Responsive Web Application Kit by Eugene Kopyov</title>

    <!-- Global stylesheets -->
    <link href="{{ asset('assets/fonts/inter/inter.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/icons/phosphor/styles.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/ltr/all.min.css') }}" id="stylesheet" rel="stylesheet">

    <!-- Third-party CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />

    <!-- Core JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    
    <!-- Third-party JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>

    <!-- Theme JS files -->
    <script src="{{ asset('assets/demo/demo_configurator.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/visualization/d3/d3.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/visualization/d3/d3_tooltip.js') }}"></script>
    <script src="{{ asset('assets/demo/pages/dashboard.js') }}"></script>
    <script src="{{ asset('assets/demo/charts/pages/dashboard/streamgraph.js') }}"></script>
    <script src="{{ asset('assets/demo/charts/pages/dashboard/sparklines.js') }}"></script>
    <script src="{{ asset('assets/demo/charts/pages/dashboard/lines.js') }}"></script>
    <script src="{{ asset('assets/demo/charts/pages/dashboard/areas.js') }}"></script>
    <script src="{{ asset('assets/demo/charts/pages/dashboard/donuts.js') }}"></script>
    <script src="{{ asset('assets/demo/charts/pages/dashboard/bars.js') }}"></script>
    <script src="{{ asset('assets/demo/charts/pages/dashboard/progress.js') }}"></script>
    <script src="{{ asset('assets/demo/charts/pages/dashboard/heatmaps.js') }}"></script>
    <script src="{{ asset('assets/demo/charts/pages/dashboard/pies.js') }}"></script>
    <script src="{{ asset('assets/demo/charts/pages/dashboard/bullets.js') }}"></script>

    @stack('resource')
</head>

<body>
    @include('Master.Layout.navbar')

    <div class="page-content d-flex">
        @include('Master.Layout.sidebar')

        <div class="content-wrapper">
            <div class="content-inner">
                @include('Master.Layout.header')

                <div class="content">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</body>

</html>