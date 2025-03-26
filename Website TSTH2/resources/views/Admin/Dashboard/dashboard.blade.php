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

				<!-- Advanced Inventory Overview -->
				<div class="row">
					<div class="col-xl-9">
						<!-- Comprehensive Inventory Status -->
						<div class="card">
							<div class="card-header d-flex align-items-center">
								<h5 class="mb-0">Advanced Inventory Analytics</h5>
								<div class="ms-auto d-flex align-items-center">
									<div class="me-3">
										<select class="form-select form-select-sm">
											<option>This Week</option>
											<option>This Month</option>
											<option selected>Last 30 Days</option>
											<option>Custom Range</option>
										</select>
									</div>
									<label class="form-check form-switch form-check-reverse">
										<input type="checkbox" class="form-check-input" checked>
										<span class="form-check-label">Live Sync</span>
									</label>
								</div>
							</div>

							<div class="card-body">
								<div class="row">
									<div class="col-md-3">
										<div class="d-flex align-items-center mb-3">
											<div class="flex-shrink-0 bg-primary bg-opacity-10 text-primary rounded-pill p-2 me-3">
												<i class="ph-package-fill"></i>
											</div>
											<div>
												<h6 class="mb-0">Total Products</h6>
												<span class="text-muted">1,784 SKUs</span>
											</div>
										</div>
									</div>

									<div class="col-md-3">
										<div class="d-flex align-items-center mb-3">
											<div class="flex-shrink-0 bg-warning bg-opacity-10 text-warning rounded-pill p-2 me-3">
												<i class="ph-warning-circle-fill"></i>
											</div>
											<div>
												<h6 class="mb-0">Critical Items</h6>
												<span class="text-muted">127 products</span>
											</div>
										</div>
									</div>

									<div class="col-md-3">
										<div class="d-flex align-items-center mb-3">
											<div class="flex-shrink-0 bg-success bg-opacity-10 text-success rounded-pill p-2 me-3">
												<i class="ph-truck-fill"></i>
											</div>
											<div>
												<h6 class="mb-0">Pending Shipments</h6>
												<span class="text-muted">24 shipments</span>
											</div>
										</div>
									</div>

									<div class="col-md-3">
										<div class="d-flex align-items-center mb-3">
											<div class="flex-shrink-0 bg-danger bg-opacity-10 text-danger rounded-pill p-2 me-3">
												<i class="ph-chart-line-up-fill"></i>
											</div>
											<div>
												<h6 class="mb-0">Inventory Turnover</h6>
												<span class="text-muted">1.8x monthly</span>
											</div>
										</div>
									</div>
								</div>

								<div class="chart" id="advanced-inventory-flow"></div>
							</div>
						</div>
					</div>

					<div class="col-xl-3">
						<!-- Warehouse Health Score -->
						<div class="card bg-dark text-white">
							<div class="card-body text-center">
								<div class="svg-center position-relative" id="warehouse-health-score"></div>
								<h5 class="mt-3">Warehouse Performance</h5>
								<div class="d-flex justify-content-between mt-3">
									<div>
										<h6 class="mb-0">Efficiency</h6>
										<span class="text-success">92%</span>
									</div>
									<div>
										<h6 class="mb-0">Accuracy</h6>
										<span class="text-warning">88%</span>
									</div>
									<div>
										<h6 class="mb-0">Utilization</h6>
										<span class="text-info">75%</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Detailed Inventory Management -->
				<div class="row">
					<div class="col-xl-8">
						<!-- Inventory Breakdown -->
						<div class="card">
							<div class="card-header">
								<h6 class="card-title">Detailed Inventory Breakdown</h6>
								<div class="d-flex align-items-center ms-auto">
									<button class="btn btn-sm btn-outline-primary me-2">
										<i class="ph-download-simple me-1"></i>Export
									</button>
									<button class="btn btn-sm btn-primary">
										<i class="ph-plus me-1"></i>Add Product
									</button>
								</div>
							</div>

							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-striped table-hover">
										<thead>
											<tr>
												<th>Product</th>
												<th>Category</th>
												<th>Current Stock</th>
												<th>Minimum Level</th>
												<th>Status</th>
												<th>Actions</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>
													<div class="d-flex align-items-center">
														<img src="{{ asset('assets/images/placeholders/product-placeholder.jpg') }}" 
															class="rounded me-2" width="40" height="40" alt="">
														<div>
															<div>Microcontroller X200</div>
															<div class="text-muted">SKU: MC-X200-001</div>
														</div>
													</div>
												</td>
												<td>Electronic Components</td>
												<td>
													<span class="text-success">1,250</span>
													<small class="d-block text-muted">+250 this week</small>
												</td>
												<td>500</td>
												<td>
													<span class="badge bg-success bg-opacity-10 text-success">Healthy</span>
												</td>
												<td>
													<div class="btn-group">
														<button class="btn btn-sm btn-primary">Edit</button>
														<button class="btn btn-sm btn-outline-danger">Adjust</button>
													</div>
												</td>
											</tr>
											<!-- More inventory items would be listed here -->
										</tbody>
									</table>
								</div>
							</div>
						</div>

						<!-- Supplier Performance -->
						<div class="card mt-3">
							<div class="card-header">
								<h6 class="card-title">Supplier Performance Metrics</h6>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-md-4">
										<div class="card bg-light">
											<div class="card-body">
												<h6>Top Supplier</h6>
												<div class="d-flex align-items-center">
													<img src="{{ asset('assets/images/placeholders/company-logo.jpg') }}" 
														class="rounded me-2" width="40" height="40" alt="">
													<div>
														<div>XYZ Electronics</div>
														<div class="text-muted">On-time Delivery: 95%</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="card bg-light">
											<div class="card-body">
												<h6>Delivery Performance</h6>
												<div class="progress" style="height: 20px;">
													<div class="progress-bar bg-success" style="width: 85%">
														85% On-time
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="card bg-light">
											<div class="card-body">
												<h6>Quality Rating</h6>
												<div class="d-flex align-items-center">
													<div class="fs-4 me-2">4.2</div>
													<div class="text-warning">
														<i class="ph-star-fill"></i>
														<i class="ph-star-fill"></i>
														<i class="ph-star-fill"></i>
														<i class="ph-star-fill"></i>
														<i class="ph-star-half-fill"></i>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xl-4">
						<!-- Alerts & Notifications -->
						<div class="card">
							<div class="card-header">
								<h6 class="card-title">Inventory Alerts</h6>
								<div class="ms-auto">
									<span class="badge bg-danger">3 Critical</span>
								</div>
							</div>
							<div class="card-body">
								<div class="alert alert-danger alert-dismissible fade show" role="alert">
									<div class="d-flex align-items-center">
										<i class="ph-warning-circle me-2 fs-4"></i>
										<div>
											<strong>Low Stock Alert:</strong> Aluminum Alloy below 20% of required level
										</div>
									</div>
									<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
								</div>

								<div class="alert alert-warning alert-dismissible fade show" role="alert">
									<div class="d-flex align-items-center">
										<i class="ph-truck-fill me-2 fs-4"></i>
										<div>
											<strong>Delayed Shipment:</strong> Electronic Components from Supplier A
										</div>
									</div>
									<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
								</div>

								<div class="alert alert-info alert-dismissible fade show" role="alert">
									<div class="d-flex align-items-center">
										<i class="ph-chart-line-up-fill me-2 fs-4"></i>
										<div>
											<strong>Reorder Recommendation:</strong> Microcontroller X200 needs restocking
										</div>
									</div>
									<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
								</div>
							</div>
						</div>

						<!-- Quick Actions -->
						<div class="card mt-3">
							<div class="card-header">
								<h6 class="card-title">Quick Actions</h6>
							</div>
							<div class="card-body">
								<div class="row g-2">
									<div class="col-6">
										<button class="btn btn-outline-primary w-100">
											<i class="ph-plus-circle me-1"></i>Create Purchase Order
										</button>
									</div>
									<div class="col-6">
										<button class="btn btn-outline-success w-100">
											<i class="ph-clipboard-text me-1"></i>Inventory Audit
										</button>
									</div>
									<div class="col-6">
										<button class="btn btn-outline-warning w-100">
											<i class="ph-truck me-1"></i>Track Shipments
										</button>
									</div>
									<div class="col-6">
										<button class="btn btn-outline-info w-100">
											<i class="ph-chart-bar me-1"></i>Generate Report
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				</div>
				<!-- /content area -->

				<!-- Footer -->
				<div class="navbar navbar-expand-lg navbar-light border-bottom-0 border-top">
					<div class="navbar-collapse collapse" id="navbar-footer">
						<span class="navbar-text">
							&copy; 2024 Advanced Warehouse Inventory Management System
						</span>

						<ul class="navbar-nav ml-lg-auto">
							<li class="nav-item">
								<a href="#" class="navbar-nav-link">
									<i class="ph-lifebuoy me-2"></i>Support
								</a>
							</li>
							<li class="nav-item">
								<a href="#" class="navbar-nav-link">
									<i class="ph-file-text me-2"></i>Documentation
								</a>
							</li>
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

