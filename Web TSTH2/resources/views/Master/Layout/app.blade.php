<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Limitless - Responsive Web Application Kit by Eugene Kopyov</title>

	<!-- Global stylesheets -->
	<link href="{{ asset('assets/fonts/inter/inter.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/icons/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/ltr/all.min.css') }}" id="stylesheet" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->
	<link href="{{ asset('assets/fonts/inter/inter.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/icons/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/ltr/all.min.css') }}" id="stylesheet" rel="stylesheet" type="text/css">

	<!-- DataTables CSS -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

	<!-- jQuery first -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<!-- Core JS files -->
	<script src="{{ asset('assets/demo/demo_configurator.js') }}"></script>
	<!-- /core JS files -->
	<!-- Core JS -->
	<script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>

	<!-- DataTables JS -->
	<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

	<!-- Theme JS -->
	<script src="{{ asset('assets/js/app.js') }}"></script>



	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


	<!-- Theme JS files -->
	<script src="{{ asset('assets/js/vendor/visualization/d3/d3.min.js') }}"></script>
	<script src="{{ asset('assets/js/vendor/visualization/d3/d3_tooltip.js') }}"></script>

	<script src="{{ asset('assets/js/app.js') }}"></script>
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
	<script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>

	<!-- /theme JS files -->
</head>

<body>



	@include('Master.Layout.navbar')

	<div class="page-content d-flex">

		@include('Master.Layout.sidebar')

		<div class="content-wrapper">
			<div class="content-inner">
				<!-- **Pastikan ini ada** -->
				@include('Master.Layout.header')

				<div class="content">
					@yield('content')
				</div>
			</div>
		</div>
	</div>

	</div>


</body>

</html>