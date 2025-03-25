@extends('Master.Layout.app')
@section('content')
<main>
	<!-- Page content -->
	<div class="page-content">

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Inner content -->
			<div class="content-inner">

				<!-- Content area -->
				<div class="content">

				<!-- Main charts -->
				<div class="row">
					<div class="col-xl-7">

						<!-- Traffic sources -->
						<div class="card">
							<div class="card-header d-flex align-items-center">
								<h5 class="mb-0">Traffic sources</h5>
								<div class="ms-auto">
									<label class="form-check form-switch form-check-reverse">
										<input type="checkbox" class="form-check-input" checked>
										<span class="form-check-label">Live update</span>
									</label>
								</div>
							</div>

							<div class="card-body pb-0">
								<div class="row">
									<div class="col-sm-4">
										<div class="d-flex align-items-center justify-content-center mb-2">
											<a href="#" class="bg-success bg-opacity-10 text-success lh-1 rounded-pill p-2 me-3">
												<i class="ph-plus"></i>
											</a>
											<div>
												<div class="fw-semibold">New visitors</div>
												<span class="text-muted">2,349 avg</span>
											</div>
										</div>
										<div class="w-75 mx-auto mb-3" id="new-visitors"></div>
									</div>

									<div class="col-sm-4">
										<div class="d-flex align-items-center justify-content-center mb-2">
											<a href="#" class="bg-warning bg-opacity-10 text-warning lh-1 rounded-pill p-2 me-3">
												<i class="ph-clock"></i>
											</a>
											<div>
												<div class="fw-semibold">New sessions</div>
												<span class="text-muted">08:20 avg</span>
											</div>
										</div>
										<div class="w-75 mx-auto mb-3" id="new-sessions"></div>
									</div>

									<div class="col-sm-4">
										<div class="d-flex align-items-center justify-content-center mb-2">
											<a href="#" class="bg-indigo bg-opacity-10 text-indigo lh-1 rounded-pill p-2 me-3">
												<i class="ph-users-three"></i>
											</a>
											<div>
												<div class="fw-semibold">Total online</div>
												<span class="text-muted">5,378 avg</span>
											</div>
										</div>
										<div class="w-75 mx-auto mb-3" id="total-online"></div>
									</div>
								</div>
							</div>

							<div class="chart position-relative" id="traffic-sources"></div>
						</div>
						<!-- /traffic sources -->

					</div>

					<div class="col-xl-5">

						<!-- Sales stats -->
						<div class="card">
							<div class="card-header d-sm-flex align-items-sm-center py-sm-0">
								<h5 class="py-sm-2 my-sm-1">Sales statistics</h5>
								<div class="mt-2 mt-sm-0 ms-sm-auto">
									<select class="form-select" id="select_date">
										<option value="val1">June, 29 - July, 5</option>
										<option value="val2">June, 22 - June 28</option>
										<option value="val3" selected>June, 15 - June, 21</option>
										<option value="val4">June, 8 - June, 14</option>
									</select>
								</div>
							</div>

							<div class="card-body pb-0">
								<div class="row text-center">
									<div class="col-4">
										<div class="mb-3">
											<h5 class="mb-0">5,689</h5>
											<div class="text-muted fs-sm">new orders</div>
										</div>
									</div>

									<div class="col-4">
										<div class="mb-3">
											<h5 class="mb-0">32,568</h5>
											<div class="text-muted fs-sm">this month</div>
										</div>
									</div>

									<div class="col-4">
										<div class="mb-3">
											<h5 class="mb-0">$23,464</h5>
											<div class="text-muted fs-sm">expected profit</div>
										</div>
									</div>
								</div>
							</div>

							<div class="chart mb-2" id="app_sales"></div>
							<div class="chart" id="monthly-sales-stats"></div>
						</div>
						<!-- /sales stats -->

					</div>
				</div>
				<!-- /main charts -->


					<!-- Dashboard content -->
					<div class="row">
						<div class="col-xl-8">

							<!-- Quick stats boxes -->
							<div class="row">
								<div class="col-lg-4">

									<!-- Members online -->
									<div class="card bg-teal text-white">
										<div class="card-body">
											<div class="d-flex">
												<h3 class="font-weight-semibold mb-0">3,450</h3>
												<span
													class="badge badge-dark badge-pill align-self-center ml-auto">+53,6%</span>
											</div>

											<div>
												Members online
												<div class="font-size-sm opacity-75">489 avg</div>
											</div>
										</div>

										<div class="container-fluid">
											<div id="members-online"></div>
										</div>
									</div>
									<!-- /members online -->

								</div>

								<div class="col-lg-4">

									<!-- Current server load -->
									<div class="card bg-pink text-white">
										<div class="card-body">
											<div class="d-flex">
												<h3 class="font-weight-semibold mb-0">49.4%</h3>
												<div class="list-icons ml-auto">
													<div class="dropdown">
														<a href="#" class="list-icons-item dropdown-toggle"
															data-toggle="dropdown"><i class="icon-cog3"></i></a>
														<div class="dropdown-menu dropdown-menu-right">
															<a href="#" class="dropdown-item"><i class="icon-sync"></i>
																Update data</a>
															<a href="#" class="dropdown-item"><i
																	class="icon-list-unordered"></i> Detailed log</a>
															<a href="#" class="dropdown-item"><i class="icon-pie5"></i>
																Statistics</a>
															<a href="#" class="dropdown-item"><i
																	class="icon-cross3"></i> Clear list</a>
														</div>
													</div>
												</div>
											</div>

											<div>
												Current server load
												<div class="font-size-sm opacity-75">34.6% avg</div>
											</div>
										</div>

										<div id="server-load"></div>
									</div>
									<!-- /current server load -->

								</div>

								<div class="col-lg-4">

									<!-- Today's revenue -->
									<div class="card bg-primary text-white">
										<div class="card-body">
											<div class="d-flex">
												<h3 class="font-weight-semibold mb-0">$18,390</h3>
												<div class="list-icons ml-auto">
													<a class="list-icons-item" data-action="reload"></a>
												</div>
											</div>

											<div>
												Today's revenue
												<div class="font-size-sm opacity-75">$37,578 avg</div>
											</div>
										</div>

										<div id="today-revenue"></div>
									</div>
									<!-- /today's revenue -->

								</div>
							</div>
							<!-- /quick stats boxes -->



							<!-- Latest posts -->
							<div class="card">
								<div class="card-header">
									<h6 class="card-title">Latest posts</h6>
								</div>

								<div class="card-body pb-0">
									<div class="row">
										<div class="col-xl-6">
											<div class="media flex-column flex-sm-row mt-0 mb-3">
												<div class="mr-sm-3 mb-2 mb-sm-0">
													<div class="card-img-actions">
														<a href="#">
															<img src="{{ asset('assets/images/placeholders/placeholder.jpg') }}"
																class="img-fluid img-preview rounded" alt="">
															<span class="card-img-actions-overlay card-img">
																<i class="icon-play3 icon-2x"></i>
															</span>
														</a>
													</div>
												</div>

												<div class="media-body">
													<h6 class="media-title"><a href="#">Up unpacked friendly</a></h6>
													<ul class="list-inline list-inline-dotted text-muted mb-2">
														<li class="list-inline-item"><i class="icon-book-play mr-2"></i>
															Video tutorials</li>
													</ul>
													The him father parish looked has sooner. Attachment frequently
													terminated son hello...
												</div>
											</div>

											<div class="media flex-column flex-sm-row mt-0 mb-3">
												<div class="mr-sm-3 mb-2 mb-sm-0">
													<div class="card-img-actions">
														<a href="#">
															<img src="{{ asset('assets/images/placeholders/placeholder.jpg') }}"
																class="img-fluid img-preview rounded" alt="">
															<span class="card-img-actions-overlay card-img">
																<i class="icon-play3 icon-2x"></i>
															</span>
														</a>
													</div>
												</div>

												<div class="media-body">
													<h6 class="media-title"><a href="#">It allowance prevailed</a></h6>
													<ul class="list-inline list-inline-dotted text-muted mb-2">
														<li class="list-inline-item"><i class="icon-book-play mr-2"></i>
															Video tutorials</li>
													</ul>
													Alteration literature to or an sympathize mr imprudence. Of is
													ferrars subject enjoyed...
												</div>
											</div>
										</div>

										<div class="col-xl-6">
											<div class="media flex-column flex-sm-row mt-0 mb-3">
												<div class="mr-sm-3 mb-2 mb-sm-0">
													<div class="card-img-actions">
														<a href="#">
															<img src="{{ asset('assets/images/placeholders/placeholder.jpg') }}"
																class="img-fluid img-preview rounded" alt="">
															<span class="card-img-actions-overlay card-img">
																<i class="icon-play3 icon-2x"></i>
															</span>
														</a>
													</div>
												</div>

												<div class="media-body">
													<h6 class="media-title"><a href="#">Case read they must</a></h6>
													<ul class="list-inline list-inline-dotted text-muted mb-2">
														<li class="list-inline-item"><i class="icon-book-play mr-2"></i>
															Video tutorials</li>
													</ul>
													On it differed repeated wandered required in. Then girl neat why yet
													knew rose spot...
												</div>
											</div>

											<div class="media flex-column flex-sm-row mt-0 mb-3">
												<div class="mr-sm-3 mb-2 mb-sm-0">
													<div class="card-img-actions">
														<a href="#">
															<img src="{{ asset('assets/images/placeholders/placeholder.jpg') }}"
																class="img-fluid img-preview rounded" alt="">
															<span class="card-img-actions-overlay card-img">
																<i class="icon-play3 icon-2x"></i>
															</span>
														</a>
													</div>
												</div>

												<div class="media-body">
													<h6 class="media-title"><a href="#">Too carriage attended</a></h6>
													<ul class="list-inline list-inline-dotted text-muted mb-2">
														<li class="list-inline-item"><i class="icon-book-play mr-2"></i>
															FAQ section</li>
													</ul>
													Marianne or husbands if at stronger ye. Considered is as middletons
													uncommonly...
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- /latest posts -->


						</div>

						<div class="col-xl-4">

							<!-- Progress counters -->
							<div class="row">
								<div class="col-sm-6">

									<!-- Available hours -->
									<div class="card text-center">
										<div class="card-body">

											<!-- Progress counter -->
											<div class="svg-center position-relative" id="hours-available-progress">
											</div>
											<!-- /progress counter -->


											<!-- Bars -->
											<div id="hours-available-bars"></div>
											<!-- /bars -->

										</div>
									</div>
									<!-- /available hours -->

								</div>

								<div class="col-sm-6">

									<!-- Productivity goal -->
									<div class="card text-center">
										<div class="card-body">

											<!-- Progress counter -->
											<div class="svg-center position-relative" id="goal-progress"></div>
											<!-- /progress counter -->

											<!-- Bars -->
											<div id="goal-bars"></div>
											<!-- /bars -->

										</div>
									</div>
									<!-- /productivity goal -->
								</div>
							</div>
							<!-- /progress counters -->
						</div>
					</div>
					<!-- /dashboard content -->

				</div>
				<!-- /content area -->

				<!-- Footer -->
				<div class="navbar navbar-expand-lg navbar-light border-bottom-0 border-top">
					<div class="text-center d-lg-none w-100">
						<button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse"
							data-target="#navbar-footer">
							<i class="icon-unfold mr-2"></i>
							Footer
						</button>
					</div>

					<div class="navbar-collapse collapse" id="navbar-footer">
						<span class="navbar-text">
							&copy; 2015 - 2018. <a href="#">Limitless Web App Kit</a> by <a
								href="https://themeforest.net/user/Kopyov" target="_blank">Eugene Kopyov</a>
						</span>

						<ul class="navbar-nav ml-lg-auto">
							<li class="nav-item"><a href="https://kopyov.ticksy.com/" class="navbar-nav-link"
									target="_blank"><i class="icon-lifebuoy mr-2"></i> Support</a></li>
							<li class="nav-item"><a href="https://demo.interface.club/limitless/docs/"
									class="navbar-nav-link" target="_blank"><i class="icon-file-text2 mr-2"></i>
									Docs</a></li>
							<li class="nav-item"><a
									href="https://themeforest.net/item/limitless-responsive-web-application-kit/13080328?ref=kopyov"
									class="navbar-nav-link font-weight-semibold"><span class="text-pink"><i
											class="icon-cart2 mr-2"></i> Purchase</span></a></li>
						</ul>
					</div>
				</div>
				<!-- /footer -->

			</div>
			<!-- /inner content -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->


</main>
@endsection