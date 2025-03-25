<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Limitless - Responsive Web Application Kit by Eugene Kopyov</title>

	<!-- Global stylesheets -->
	<link href="{{ asset('global_assets/fonts/inter/inter.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('global_assets/icons/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('global_assets/css/ltr/all.min.css') }}" id="stylesheet" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="{{ asset('global_assets/demo/demo_configurator.js') }}"></script>
	<script src="{{ asset('global_assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="{{ asset('global_assets/js/vendor/visualization/d3/d3.min.js') }}"></script>
	<script src="{{ asset('global_assets/js/vendor/visualization/d3/d3_tooltip.js') }}"></script>

	<script src="{{ asset('global_assets/js/app.js') }}"></script>
	<script src="{{ asset('global_assets/demo/pages/dashboard.js') }}"></script>
	<script src="{{ asset('global_assets/demo/charts/pages/dashboard/streamgraph.js') }}"></script>
	<script src="{{ asset('global_assets/demo/charts/pages/dashboard/sparklines.js') }}"></script>
	<script src="{{ asset('global_assets/demo/charts/pages/dashboard/lines.js') }}"></script>
	<script src="{{ asset('global_assets/demo/charts/pages/dashboard/areas.js') }}"></script>
	<script src="{{ asset('global_assets/demo/charts/pages/dashboard/donuts.js') }}"></script>
	<script src="{{ asset('global_assets/demo/charts/pages/dashboard/bars.js') }}"></script>
	<script src="{{ asset('global_assets/demo/charts/pages/dashboard/progress.js') }}"></script>
	<script src="{{ asset('global_assets/demo/charts/pages/dashboard/heatmaps.js') }}"></script>
	<script src="{{ asset('global_assets/demo/charts/pages/dashboard/pies.js') }}"></script>
	<script src="{{ asset('global_assets/demo/charts/pages/dashboard/bullets.js') }}"></script>
	<!-- /theme JS files -->
</head>

<body>

{{-- 
	<!-- Include Navbar -->
	@include('Master.Layout.navbar')

	<div class="page-content">
		<!-- Include Header -->
		@include('Master.Layout.sidebar')

		@include('Master.Layout.header')



		<div class="body-wrapper-inner">
			<div class="container-fluid">
				<main>
					<!-- Include dynamic content -->
					@yield('content')
				</main>
			</div>
		</div>
	</div> --}}
	<!-- Main Navbar -->
    <div class="navbar navbar-dark navbar-expand-lg navbar-static border-bottom border-bottom-white border-opacity-10">
        @include('Master.Layout.navbar')
    </div>

    <!-- Page Content -->
    <div class="page-content d-flex">

        <!-- Sidebar -->
        <div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">
            <div class="sidebar-content">
                <!-- Sidebar Header -->
                <div class="sidebar-section">
                    @include('Master.Layout.sidebar')
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="content-wrapper flex-fill">
            <div class="content-inner">
                <div class="container-fluid py-3">
                    @yield('content')
                </div>
            </div>
        </div>
        
    </div>


</body>

</html>