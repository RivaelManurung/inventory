<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
        type="text/css">
    <link href="../../../../global_assets/css/icons/icomoon/styles.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
</head>

<body>
    <!-- Page content -->
    <div class="page-content container pt-0">


        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Content area -->
            <div class="content">

                <!-- Traffic sources -->
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h6 class="card-title">Traffic sources</h6>
                        <div class="header-elements">
                            <label class="custom-control custom-switch custom-control-right">
                                <input type="checkbox" class="custom-control-input" checked>
                                <span class="custom-control-label">Live update</span>
                            </label>
                        </div>
                    </div>

                    <div class="card-body py-0">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <a href="#" class="btn btn-outline-success rounded-pill border-2 btn-icon mr-3">
                                        <i class="icon-plus3"></i>
                                    </a>
                                    <div>
                                        <div class="font-weight-semibold">New visitors</div>
                                        <span class="text-muted">2,349 avg</span>
                                    </div>
                                </div>
                                <div class="w-75 mx-auto mb-3" id="new-visitors"></div>
                            </div>

                            <div class="col-sm-4">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <a href="#" class="btn btn-outline-warning rounded-pill border-2 btn-icon mr-3">
                                        <i class="icon-watch2"></i>
                                    </a>
                                    <div>
                                        <div class="font-weight-semibold">New sessions</div>
                                        <span class="text-muted">08:20 avg</span>
                                    </div>
                                </div>
                                <div class="w-75 mx-auto mb-3" id="new-sessions"></div>
                            </div>

                            <div class="col-sm-4">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <a href="#" class="btn btn-outline-primary rounded-pill border-2 btn-icon mr-3">
                                        <i class="icon-accessibility"></i>
                                    </a>
                                    <div>
                                        <div class="font-weight-semibold">Total online</div>
                                        <span class="text-muted"><span
                                                class="badge badge-mark border-success-100 mr-2"></span> 5,378
                                            avg</span>
                                    </div>
                                </div>
                                <div class="w-75 mx-auto mb-3" id="total-online"></div>
                            </div>
                        </div>
                    </div>

                    <div class="chart position-relative" id="traffic-sources"></div>
                </div>
                <!-- /traffic sources -->


                <!-- Quick stats boxes -->
                <div class="row">
                    <div class="col-md-4">

                        <!-- Members online -->
                        <div class="card bg-teal">
                            <div class="card-body">
                                <div class="d-flex">
                                    <h3 class="font-weight-semibold mb-0">3,450</h3>
                                    <span class="badge badge-teal badge-pill align-self-center ml-auto">+53,6%</span>
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

                    <div class="col-md-4">

                        <!-- Current server load -->
                        <div class="card bg-pink">
                            <div class="card-body">
                                <div class="d-flex">
                                    <h3 class="font-weight-semibold mb-0">49.4%</h3>
                                    <div class="list-icons ml-auto">
                                        <div class="dropdown">
                                            <a href="#" class="list-icons-item dropdown-toggle"
                                                data-toggle="dropdown"><i class="icon-cog3"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item"><i class="icon-sync"></i> Update
                                                    data</a>
                                                <a href="#" class="dropdown-item"><i class="icon-list-unordered"></i>
                                                    Detailed log</a>
                                                <a href="#" class="dropdown-item"><i class="icon-pie5"></i>
                                                    Statistics</a>
                                                <a href="#" class="dropdown-item"><i class="icon-cross3"></i> Clear
                                                    list</a>
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

                    <div class="col-md-4">

                        <!-- Today's revenue -->
                        <div class="card bg-primary">
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


                <!-- Marketing campaigns -->
                <div class="card">
                    <div class="card-header header-elements-sm-inline">
                        <h6 class="card-title">Marketing campaigns</h6>
                        <div class="header-elements">
                            <span class="badge badge-success badge-pill">28 active</span>
                            <div class="list-icons ml-3">
                                <div class="dropdown">
                                    <a href="#" class="list-icons-item dropdown-toggle" data-toggle="dropdown"><i
                                            class="icon-menu7"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item"><i class="icon-sync"></i> Update data</a>
                                        <a href="#" class="dropdown-item"><i class="icon-list-unordered"></i> Detailed
                                            log</a>
                                        <a href="#" class="dropdown-item"><i class="icon-pie5"></i> Statistics</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="#" class="dropdown-item"><i class="icon-cross3"></i> Clear list</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body d-sm-flex align-items-sm-center justify-content-sm-between flex-sm-wrap">
                        <div class="d-flex align-items-center mb-3 mb-sm-0">
                            <div id="campaigns-donut"></div>
                            <div class="ml-3">
                                <h5 class="font-weight-semibold mb-0">38,289 <span
                                        class="text-success font-size-sm font-weight-normal"><i
                                            class="icon-arrow-up12"></i> (+16.2%)</span></h5>
                                <span class="badge badge-mark border-success-100 mr-1"></span> <span
                                    class="text-muted">May 12, 12:30 am</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-3 mb-sm-0">
                            <div id="campaign-status-pie"></div>
                            <div class="ml-3">
                                <h5 class="font-weight-semibold mb-0">2,458 <span
                                        class="text-warning font-size-sm font-weight-normal"><i
                                            class="icon-arrow-down12"></i> (-4.9%)</span></h5>
                                <span class="badge badge-mark border-warning-100 mr-1"></span> <span
                                    class="text-muted">Jun 4, 4:00 am</span>
                            </div>
                        </div>

                        <div>
                            <a href="#" class="btn btn-indigo"><i class="icon-statistics mr-2"></i> View report</a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead>
                                <tr>
                                    <th>Campaign</th>
                                    <th>Client</th>
                                    <th>Changes</th>
                                    <th>Budget</th>
                                    <th>Status</th>
                                    <th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="table-active table-border-double">
                                    <td colspan="5">Today</td>
                                    <td class="text-right">
                                        <span class="progress-meter" id="today-progress" data-progress="30"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                <a href="#">
                                                    <img src="../../../../global_assets/images/brands/facebook.svg"
                                                        class="rounded-circle" width="32" height="32" alt="">
                                                </a>
                                            </div>
                                            <div>
                                                <a href="#" class="text-body font-weight-semibold">Facebook</a>
                                                <div class="text-muted font-size-sm">
                                                    <span class="badge badge-mark border-primary-100 mr-1"></span>
                                                    02:00 - 03:00
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="text-muted">Mintlime</span></td>
                                    <td><span class="text-success"><i class="icon-stats-growth2 mr-2"></i> 2.43%</span>
                                    </td>
                                    <td>
                                        <h6 class="font-weight-semibold mb-0">$5,489</h6>
                                    </td>
                                    <td><span class="badge badge-primary">Active</span></td>
                                    <td class="text-center">
                                        <div class="list-icons">
                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item" data-toggle="dropdown"><i
                                                        class="icon-menu7"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="#" class="dropdown-item"><i class="icon-file-stats"></i>
                                                        View statement</a>
                                                    <a href="#" class="dropdown-item"><i class="icon-file-text2"></i>
                                                        Edit campaign</a>
                                                    <a href="#" class="dropdown-item"><i class="icon-file-locked"></i>
                                                        Disable campaign</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a href="#" class="dropdown-item"><i class="icon-gear"></i>
                                                        Settings</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                <a href="#">
                                                    <img src="../../../../global_assets/images/brands/youtube.svg"
                                                        class="rounded-circle" width="32" height="32" alt="">
                                                </a>
                                            </div>
                                            <div>
                                                <a href="#" class="text-body font-weight-semibold">Youtube videos</a>
                                                <div class="text-muted font-size-sm">
                                                    <span class="badge badge-mark border-danger-100 mr-1"></span>
                                                    13:00 - 14:00
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="text-muted">CDsoft</span></td>
                                    <td><span class="text-success"><i class="icon-stats-growth2 mr-2"></i> 3.12%</span>
                                    </td>
                                    <td>
                                        <h6 class="font-weight-semibold mb-0">$2,592</h6>
                                    </td>
                                    <td><span class="badge badge-danger">Closed</span></td>
                                    <td class="text-center">
                                        <div class="list-icons">
                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item" data-toggle="dropdown"><i
                                                        class="icon-menu7"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="#" class="dropdown-item"><i class="icon-file-stats"></i>
                                                        View statement</a>
                                                    <a href="#" class="dropdown-item"><i class="icon-file-text2"></i>
                                                        Edit campaign</a>
                                                    <a href="#" class="dropdown-item"><i class="icon-file-locked"></i>
                                                        Disable campaign</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a href="#" class="dropdown-item"><i class="icon-gear"></i>
                                                        Settings</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                <a href="#">
                                                    <img src="../../../../global_assets/images/brands/spotify.svg"
                                                        class="rounded-circle" width="32" height="32" alt="">
                                                </a>
                                            </div>
                                            <div>
                                                <a href="#" class="text-body font-weight-semibold">Spotify ads</a>
                                                <div class="text-muted font-size-sm">
                                                    <span class="badge badge-mark border-secondary-100 mr-1"></span>
                                                    10:00 - 11:00
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="text-muted">Diligence</span></td>
                                    <td><span class="text-danger"><i class="icon-stats-decline2 mr-2"></i> -
                                            8.02%</span></td>
                                    <td>
                                        <h6 class="font-weight-semibold mb-0">$1,268</h6>
                                    </td>
                                    <td><span class="badge badge-secondary">On hold</span></td>
                                    <td class="text-center">
                                        <div class="list-icons">
                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item" data-toggle="dropdown"><i
                                                        class="icon-menu7"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="#" class="dropdown-item"><i class="icon-file-stats"></i>
                                                        View statement</a>
                                                    <a href="#" class="dropdown-item"><i class="icon-file-text2"></i>
                                                        Edit campaign</a>
                                                    <a href="#" class="dropdown-item"><i class="icon-file-locked"></i>
                                                        Disable campaign</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a href="#" class="dropdown-item"><i class="icon-gear"></i>
                                                        Settings</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                <a href="#">
                                                    <img src="../../../../global_assets/images/brands/twitter.svg"
                                                        class="rounded-circle" width="32" height="32" alt="">
                                                </a>
                                            </div>
                                            <div>
                                                <a href="#" class="text-body font-weight-semibold">Twitter ads</a>
                                                <div class="text-muted font-size-sm">
                                                    <span class="badge badge-mark border-secondary-100 mr-1"></span>
                                                    04:00 - 05:00
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="text-muted">Deluxe</span></td>
                                    <td><span class="text-success"><i class="icon-stats-growth2 mr-2"></i> 2.78%</span>
                                    </td>
                                    <td>
                                        <h6 class="font-weight-semibold mb-0">$7,467</h6>
                                    </td>
                                    <td><span class="badge badge-secondary">On hold</span></td>
                                    <td class="text-center">
                                        <div class="list-icons">
                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item" data-toggle="dropdown"><i
                                                        class="icon-menu7"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="#" class="dropdown-item"><i class="icon-file-stats"></i>
                                                        View statement</a>
                                                    <a href="#" class="dropdown-item"><i class="icon-file-text2"></i>
                                                        Edit campaign</a>
                                                    <a href="#" class="dropdown-item"><i class="icon-file-locked"></i>
                                                        Disable campaign</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a href="#" class="dropdown-item"><i class="icon-gear"></i>
                                                        Settings</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="table-active table-border-double">
                                    <td colspan="5">Yesterday</td>
                                    <td class="text-right">
                                        <span class="progress-meter" id="yesterday-progress" data-progress="65"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                <a href="#">
                                                    <img src="../../../../global_assets/images/brands/bing.svg"
                                                        class="rounded-circle" width="32" height="32" alt="">
                                                </a>
                                            </div>
                                            <div>
                                                <a href="#" class="text-body font-weight-semibold">Bing campaign</a>
                                                <div class="text-muted font-size-sm">
                                                    <span class="badge badge-mark border-success-100 mr-1"></span>
                                                    15:00 - 16:00
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="text-muted">Metrics</span></td>
                                    <td><span class="text-danger"><i class="icon-stats-decline2 mr-2"></i> -
                                            5.78%</span></td>
                                    <td>
                                        <h6 class="font-weight-semibold mb-0">$970</h6>
                                    </td>
                                    <td><span class="badge badge-success">Pending</span></td>
                                    <td class="text-center">
                                        <div class="list-icons">
                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item" data-toggle="dropdown"><i
                                                        class="icon-menu7"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="#" class="dropdown-item"><i class="icon-file-stats"></i>
                                                        View statement</a>
                                                    <a href="#" class="dropdown-item"><i class="icon-file-text2"></i>
                                                        Edit campaign</a>
                                                    <a href="#" class="dropdown-item"><i class="icon-file-locked"></i>
                                                        Disable campaign</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a href="#" class="dropdown-item"><i class="icon-gear"></i>
                                                        Settings</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                <a href="#">
                                                    <img src="../../../../global_assets/images/brands/amazon.svg"
                                                        class="rounded-circle" width="32" height="32" alt="">
                                                </a>
                                            </div>
                                            <div>
                                                <a href="#" class="text-body font-weight-semibold">Amazon ads</a>
                                                <div class="text-muted font-size-sm">
                                                    <span class="badge badge-mark border-danger-100 mr-1"></span>
                                                    18:00 - 19:00
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="text-muted">Blueish</span></td>
                                    <td><span class="text-success"><i class="icon-stats-growth2 mr-2"></i> 6.79%</span>
                                    </td>
                                    <td>
                                        <h6 class="font-weight-semibold mb-0">$1,540</h6>
                                    </td>
                                    <td><span class="badge badge-primary">Active</span></td>
                                    <td class="text-center">
                                        <div class="list-icons">
                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item" data-toggle="dropdown"><i
                                                        class="icon-menu7"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="#" class="dropdown-item"><i class="icon-file-stats"></i>
                                                        View statement</a>
                                                    <a href="#" class="dropdown-item"><i class="icon-file-text2"></i>
                                                        Edit campaign</a>
                                                    <a href="#" class="dropdown-item"><i class="icon-file-locked"></i>
                                                        Disable campaign</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a href="#" class="dropdown-item"><i class="icon-gear"></i>
                                                        Settings</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                <a href="#">
                                                    <img src="../../../../global_assets/images/brands/dribbble.svg"
                                                        class="rounded-circle" width="32" height="32" alt="">
                                                </a>
                                            </div>
                                            <div>
                                                <a href="#" class="text-body font-weight-semibold">Dribbble ads</a>
                                                <div class="text-muted font-size-sm">
                                                    <span class="badge badge-mark border-primary-100 mr-1"></span>
                                                    20:00 - 21:00
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="text-muted">Teamable</span></td>
                                    <td><span class="text-danger"><i class="icon-stats-decline2 mr-2"></i> 9.83%</span>
                                    </td>
                                    <td>
                                        <h6 class="font-weight-semibold mb-0">$8,350</h6>
                                    </td>
                                    <td><span class="badge badge-danger">Closed</span></td>
                                    <td class="text-center">
                                        <div class="list-icons">
                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item" data-toggle="dropdown"><i
                                                        class="icon-menu7"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="#" class="dropdown-item"><i class="icon-file-stats"></i>
                                                        View statement</a>
                                                    <a href="#" class="dropdown-item"><i class="icon-file-text2"></i>
                                                        Edit campaign</a>
                                                    <a href="#" class="dropdown-item"><i class="icon-file-locked"></i>
                                                        Disable campaign</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a href="#" class="dropdown-item"><i class="icon-gear"></i>
                                                        Settings</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /marketing campaigns -->


            


                <!-- Sales stats -->
                <div class="card">
                    <div class="card-header header-elements-sm-inline py-sm-0">
                        <h6 class="card-title py-sm-3">Sales statistics</h6>
                        <div class="header-elements">
                            <select class="form-control custom-select" id="select_date">
                                <option value="val1">June, 29 - July, 5</option>
                                <option value="val2">June, 22 - June 28</option>
                                <option value="val3" selected>June, 15 - June, 21</option>
                                <option value="val4">June, 8 - June, 14</option>
                            </select>
                        </div>
                    </div>

                    <div class="card-body py-0">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="mb-3">
                                    <h5 class="font-weight-semibold mb-0">5,689</h5>
                                    <span class="text-muted font-size-sm">new orders</span>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="mb-3">
                                    <h5 class="font-weight-semibold mb-0">32,568</h5>
                                    <span class="text-muted font-size-sm">this month</span>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="mb-3">
                                    <h5 class="font-weight-semibold mb-0">$23,464</h5>
                                    <span class="text-muted font-size-sm">expected profit</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="chart mb-2" id="app_sales"></div>
                    <div class="chart" id="monthly-sales-stats"></div>
                </div>
                <!-- /sales stats -->


                <!-- Support tickets -->
                <div class="card">
                    <div class="card-header header-elements-sm-inline">
                        <h6 class="card-title">Support tickets</h6>
                        <div class="header-elements">
                            <a class="text-body daterange-ranges font-weight-semibold cursor-pointer dropdown-toggle">
                                <i class="icon-calendar3 mr-2"></i>
                                <span></span>
                            </a>
                        </div>
                    </div>

                    <div class="card-body d-lg-flex align-items-lg-center justify-content-lg-between flex-lg-wrap">
                        <div class="d-flex align-items-center mb-3 mb-lg-0">
                            <div id="tickets-status"></div>
                            <div class="ml-3">
                                <h5 class="font-weight-semibold mb-0">14,327 <span
                                        class="text-success font-size-sm font-weight-normal"><i
                                            class="icon-arrow-up12"></i> (+2.9%)</span></h5>
                                <span class="badge badge-mark border-success-100 mr-1"></span> <span
                                    class="text-muted">Jun 16, 10:00 am</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-3 mb-lg-0">
                            <a href="#" class="btn btn-outline-primary rounded-pill border-2 btn-icon">
                                <i class="icon-alarm-add"></i>
                            </a>
                            <div class="ml-3">
                                <h5 class="font-weight-semibold mb-0">1,132</h5>
                                <span class="text-muted">total tickets</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-3 mb-lg-0">
                            <a href="#" class="btn btn-outline-primary rounded-pill border-2 btn-icon">
                                <i class="icon-spinner11"></i>
                            </a>
                            <div class="ml-3">
                                <h5 class="font-weight-semibold mb-0">06:25:00</h5>
                                <span class="text-muted">response time</span>
                            </div>
                        </div>

                        <div>
                            <a href="#" class="btn btn-teal"><i class="icon-statistics mr-2"></i> Report</a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead>
                                <tr>
                                    <th style="width: 50px">Due</th>
                                    <th style="width: 300px;">User</th>
                                    <th>Description</th>
                                    <th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="table-active table-border-double">
                                    <td colspan="3">Active tickets</td>
                                    <td class="text-right">
                                        <span class="badge badge-primary badge-pill">24</span>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-center">
                                        <h6 class="mb-0">12</h6>
                                        <div class="font-size-sm text-muted line-height-1">hours</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                <a href="#" class="btn btn-teal rounded-pill btn-icon btn-sm">
                                                    <span class="letter-icon"></span>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="#"
                                                    class="text-body font-weight-semibold letter-icon-title">Annabelle
                                                    Doney</a>
                                                <div class="text-muted font-size-sm"><span
                                                        class="badge badge-mark border-primary-100 mr-1"></span> Active
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#" class="text-body">
                                            <div class="font-weight-semibold">[#1183] Workaround for OS X selects
                                                printing bug</div>
                                            <span class="text-muted">Chrome fixed the bug several versions ago, thus
                                                rendering this...</span>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <div class="list-icons">
                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item" data-toggle="dropdown"><i
                                                        class="icon-menu7"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="#" class="dropdown-item"><i class="icon-undo"></i> Quick
                                                        reply</a>
                                                    <a href="#" class="dropdown-item"><i class="icon-history"></i> Full
                                                        history</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a href="#" class="dropdown-item"><i
                                                            class="icon-checkmark3 text-success"></i> Resolve issue</a>
                                                    <a href="#" class="dropdown-item"><i
                                                            class="icon-cross2 text-danger"></i> Close issue</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-center">
                                        <h6 class="mb-0">16</h6>
                                        <div class="font-size-sm text-muted line-height-1">hours</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                <a href="#">
                                                    <img src="../../../../global_assets/images/placeholders/placeholder.jpg"
                                                        class="rounded-circle" width="32" height="32" alt="">
                                                </a>
                                            </div>
                                            <div>
                                                <a href="#" class="text-body font-weight-semibold">Chris Macintyre</a>
                                                <div class="text-muted font-size-sm"><span
                                                        class="badge badge-mark border-primary-100 mr-1"></span> Active
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#" class="text-body">
                                            <div class="font-weight-semibold">[#1249] Vertically center carousel
                                                controls</div>
                                            <span class="text-muted">Try any carousel control and reduce the screen
                                                width below...</span>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <div class="list-icons">
                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item" data-toggle="dropdown"><i
                                                        class="icon-menu7"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="#" class="dropdown-item"><i class="icon-undo"></i> Quick
                                                        reply</a>
                                                    <a href="#" class="dropdown-item"><i class="icon-history"></i> Full
                                                        history</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a href="#" class="dropdown-item"><i
                                                            class="icon-checkmark3 text-success"></i> Resolve issue</a>
                                                    <a href="#" class="dropdown-item"><i
                                                            class="icon-cross2 text-danger"></i> Close issue</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-center">
                                        <h6 class="mb-0">20</h6>
                                        <div class="font-size-sm text-muted line-height-1">hours</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                <a href="#" class="btn btn-primary rounded-pill btn-icon btn-sm">
                                                    <span class="letter-icon"></span>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="#"
                                                    class="text-body font-weight-semibold letter-icon-title">Robert
                                                    Hauber</a>
                                                <div class="text-muted font-size-sm"><span
                                                        class="badge badge-mark border-primary-100 mr-1"></span> Active
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#" class="text-body">
                                            <div class="font-weight-semibold">[#1254] Inaccurate small pagination height
                                            </div>
                                            <span class="text-muted">The height of pagination elements is not consistent
                                                with...</span>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <div class="list-icons">
                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item" data-toggle="dropdown"><i
                                                        class="icon-menu7"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="#" class="dropdown-item"><i class="icon-undo"></i> Quick
                                                        reply</a>
                                                    <a href="#" class="dropdown-item"><i class="icon-history"></i> Full
                                                        history</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a href="#" class="dropdown-item"><i
                                                            class="icon-checkmark3 text-success"></i> Resolve issue</a>
                                                    <a href="#" class="dropdown-item"><i
                                                            class="icon-cross2 text-danger"></i> Close issue</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-center">
                                        <h6 class="mb-0">40</h6>
                                        <div class="font-size-sm text-muted line-height-1">hours</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                <a href="#" class="btn btn-warning rounded-pill btn-icon btn-sm">
                                                    <span class="letter-icon"></span>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="#"
                                                    class="text-body font-weight-semibold letter-icon-title">Robert
                                                    Hauber</a>
                                                <div class="text-muted font-size-sm"><span
                                                        class="badge badge-mark border-primary-100 mr-1"></span> Active
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#" class="text-body">
                                            <div class="font-weight-semibold">[#1184] Round grid column gutter
                                                operations</div>
                                            <span class="text-muted">Left rounds up, right rounds down. should keep
                                                everything...</span>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <div class="list-icons">
                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item" data-toggle="dropdown"><i
                                                        class="icon-menu7"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="#" class="dropdown-item"><i class="icon-undo"></i> Quick
                                                        reply</a>
                                                    <a href="#" class="dropdown-item"><i class="icon-history"></i> Full
                                                        history</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a href="#" class="dropdown-item"><i
                                                            class="icon-checkmark3 text-success"></i> Resolve issue</a>
                                                    <a href="#" class="dropdown-item"><i
                                                            class="icon-cross2 text-danger"></i> Close issue</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="table-active table-border-double">
                                    <td colspan="3">Resolved tickets</td>
                                    <td class="text-right">
                                        <span class="badge badge-success badge-pill">42</span>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-center">
                                        <i class="icon-checkmark3 text-success"></i>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                <a href="#" class="btn btn-success rounded-pill btn-icon btn-sm">
                                                    <span class="letter-icon"></span>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="#"
                                                    class="text-body font-weight-semibold letter-icon-title">Alan
                                                    Macedo</a>
                                                <div class="text-muted font-size-sm"><span
                                                        class="badge badge-mark border-success-100 mr-1"></span>
                                                    Resolved</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#" class="text-body">
                                            <div>[#1046] Avoid some unnecessary HTML string</div>
                                            <span class="text-muted">Rather than building a string of HTML and then
                                                parsing it...</span>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <div class="list-icons">
                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item" data-toggle="dropdown"><i
                                                        class="icon-menu7"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="#" class="dropdown-item"><i class="icon-undo"></i> Quick
                                                        reply</a>
                                                    <a href="#" class="dropdown-item"><i class="icon-history"></i> Full
                                                        history</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a href="#" class="dropdown-item"><i
                                                            class="icon-plus3 text-primary"></i> Unresolve issue</a>
                                                    <a href="#" class="dropdown-item"><i
                                                            class="icon-cross2 text-danger"></i> Close issue</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-center">
                                        <i class="icon-checkmark3 text-success"></i>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                <a href="#" class="btn btn-pink rounded-pill btn-icon btn-sm">
                                                    <span class="letter-icon"></span>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="#"
                                                    class="text-body font-weight-semibold letter-icon-title">Brett
                                                    Castellano</a>
                                                <div class="text-muted font-size-sm"><span
                                                        class="badge badge-mark border-success-100 mr-1"></span>
                                                    Resolved</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#" class="text-body">
                                            <div>[#1038] Update json configuration</div>
                                            <span class="text-muted">The <code>files</code> property is necessary to
                                                override the files property...</span>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <div class="list-icons">
                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item" data-toggle="dropdown"><i
                                                        class="icon-menu7"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="#" class="dropdown-item"><i class="icon-undo"></i> Quick
                                                        reply</a>
                                                    <a href="#" class="dropdown-item"><i class="icon-history"></i> Full
                                                        history</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a href="#" class="dropdown-item"><i
                                                            class="icon-plus3 text-primary"></i> Unresolve issue</a>
                                                    <a href="#" class="dropdown-item"><i
                                                            class="icon-cross2 text-danger"></i> Close issue</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-center">
                                        <i class="icon-checkmark3 text-success"></i>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                <a href="#">
                                                    <img src="../../../../global_assets/images/placeholders/placeholder.jpg"
                                                        class="rounded-circle" width="32" height="32" alt="">
                                                </a>
                                            </div>
                                            <div>
                                                <a href="#" class="text-body font-weight-semibold">Roxanne Forbes</a>
                                                <div class="text-muted font-size-sm"><span
                                                        class="badge badge-mark border-success-100 mr-1"></span>
                                                    Resolved</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#" class="text-body">
                                            <div>[#1034] Tooltip multiple event</div>
                                            <span class="text-muted">Fix behavior when using tooltips and popovers that
                                                are...</span>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <div class="list-icons">
                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item" data-toggle="dropdown"><i
                                                        class="icon-menu7"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="#" class="dropdown-item"><i class="icon-undo"></i> Quick
                                                        reply</a>
                                                    <a href="#" class="dropdown-item"><i class="icon-history"></i> Full
                                                        history</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a href="#" class="dropdown-item"><i
                                                            class="icon-plus3 text-primary"></i> Unresolve issue</a>
                                                    <a href="#" class="dropdown-item"><i
                                                            class="icon-cross2 text-danger"></i> Close issue</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="table-active table-border-double">
                                    <td colspan="3">Closed tickets</td>
                                    <td class="text-right">
                                        <span class="badge badge-danger badge-pill">37</span>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-center">
                                        <i class="icon-cross2 text-danger"></i>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                <a href="#">
                                                    <img src="../../../../global_assets/images/placeholders/placeholder.jpg"
                                                        class="rounded-circle" width="32" height="32" alt="">
                                                </a>
                                            </div>
                                            <div>
                                                <a href="#" class="text-body font-weight-semibold">Mitchell Sitkin</a>
                                                <div class="text-muted font-size-sm"><span
                                                        class="badge badge-mark border-danger-100 mr-1"></span> Closed
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#" class="text-body">
                                            <div>[#1040] Account for static form controls in form group</div>
                                            <span class="text-muted">Resizes control label's font-size and account for
                                                the standard...</span>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <div class="list-icons">
                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item" data-toggle="dropdown"><i
                                                        class="icon-menu7"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="#" class="dropdown-item"><i class="icon-undo"></i> Quick
                                                        reply</a>
                                                    <a href="#" class="dropdown-item"><i class="icon-history"></i> Full
                                                        history</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a href="#" class="dropdown-item"><i
                                                            class="icon-plus3 text-primary"></i> Unresolve issue</a>
                                                    <a href="#" class="dropdown-item"><i
                                                            class="icon-spinner11 text-success"></i> Reopen issue</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-center">
                                        <i class="icon-cross2 text-danger"></i>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                <a href="#" class="btn btn-indigo rounded-pill btn-icon btn-sm">
                                                    <span class="letter-icon"></span>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="#"
                                                    class="text-body font-weight-semibold letter-icon-title">Katleen
                                                    Jensen</a>
                                                <div class="text-muted font-size-sm"><span
                                                        class="badge badge-mark border-danger-100 mr-1"></span> Closed
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#" class="text-body">
                                            <div>[#1038] Proper sizing of form control feedback</div>
                                            <span class="text-muted">Feedback icon sizing inside a larger/smaller
                                                form-group...</span>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <div class="list-icons">
                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item" data-toggle="dropdown"><i
                                                        class="icon-menu7"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="#" class="dropdown-item"><i class="icon-undo"></i> Quick
                                                        reply</a>
                                                    <a href="#" class="dropdown-item"><i class="icon-history"></i> Full
                                                        history</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a href="#" class="dropdown-item"><i
                                                            class="icon-plus3 text-primary"></i> Unresolve issue</a>
                                                    <a href="#" class="dropdown-item"><i
                                                            class="icon-spinner11 text-success"></i> Reopen issue</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /support tickets -->

            </div>
            <!-- /content area -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->


    <!-- Footer -->
    <div class="navbar navbar-expand-lg navbar-light px-0">
        <div class="container px-2 px-lg-3">
            <div class="text-center d-lg-none w-100">
                <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse"
                    data-target="#navbar-third">
                    <i class="icon-menu mr-2"></i>
                    Bottom navbar
                </button>
            </div>

            <div class="navbar-collapse collapse" id="navbar-third">
                <span class="navbar-text">
                    &copy; 2015 - 2018. <a href="#">Limitless Web App Kit</a> by <a
                        href="https://themeforest.net/user/Kopyov" target="_blank">Eugene Kopyov</a>
                </span>

                <ul class="navbar-nav ml-lg-auto">
                    <li class="nav-item"><a href="#" class="navbar-nav-link">Help center</a></li>
                    <li class="nav-item"><a href="#" class="navbar-nav-link">Policy</a></li>
                    <li class="nav-item"><a href="#" class="navbar-nav-link font-weight-semibold">Upgrade your
                            account</a></li>
                    <li class="nav-item dropup">
                        <a href="#" class="navbar-nav-link" data-toggle="dropdown">
                            <i class="icon-share4 d-none d-lg-inline-block"></i>
                            <span class="d-lg-none">Share</span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="#" class="dropdown-item"><i class="icon-dribbble3"></i> Dribbble</a>
                            <a href="#" class="dropdown-item"><i class="icon-pinterest2"></i> Pinterest</a>
                            <a href="#" class="dropdown-item"><i class="icon-github"></i> Github</a>
                            <a href="#" class="dropdown-item"><i class="icon-stackoverflow"></i> Stack Overflow</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /footer -->


    <!-- Notifications -->
    <div id="notifications" class="modal modal-right fade" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-transparent border-0 align-items-center">
                    <h5 class="modal-title font-weight-semibold">Notifications</h5>
                    <button type="button" class="btn btn-icon btn-light btn-sm border-0 rounded-pill ml-auto"
                        data-dismiss="modal"><i class="icon-cross2"></i></button>
                </div>

                <div class="modal-body p-0">
                    <div class="bg-light text-muted py-2 px-3">New notifications</div>
                    <div class="p-3">
                        <div class="d-flex mb-3">
                            <a href="#" class="mr-3">
                                <img src="../../../../global_assets/images/placeholders/placeholder.jpg" width="36"
                                    height="36" class="rounded-circle" alt="">
                            </a>
                            <div class="flex-1">
                                <a href="#" class="font-weight-semibold">James</a> has completed the task <a
                                    href="#">Submit documents</a> from <a href="#">Onboarding</a> list

                                <div class="bg-light border rounded p-2 mt-2">
                                    <label class="custom-control custom-checkbox custom-control-inline mx-1">
                                        <input type="checkbox" class="custom-control-input" checked disabled>
                                        <del class="custom-control-label">Submit personal documents</del>
                                    </label>
                                </div>

                                <div class="font-size-sm text-muted mt-1">2 hours ago</div>
                            </div>
                        </div>

                        <div class="d-flex mb-3">
                            <a href="#" class="mr-3">
                                <img src="../../../../global_assets/images/placeholders/placeholder.jpg" width="36"
                                    height="36" class="rounded-circle" alt="">
                            </a>
                            <div class="flex-1">
                                <a href="#" class="font-weight-semibold">Margo</a> was added to <span
                                    class="font-weight-semibold">Customer enablement</span> channel by <a
                                    href="#">William Whitney</a>

                                <div class="font-size-sm text-muted mt-1">3 hours ago</div>
                            </div>
                        </div>

                        <div class="d-flex">
                            <div class="mr-3">
                                <div class="bg-danger-100 text-black rounded-pill">
                                    <i class="icon-undo position-static p-2"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                Subscription <a href="#">#466573</a> from 10.12.2021 has been cancelled. Refund case <a
                                    href="#">#4492</a> created

                                <div class="font-size-sm text-muted mt-1">4 hours ago</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-light text-muted py-2 px-3">Older notifications</div>
                    <div class="p-3">
                        <div class="d-flex mb-3">
                            <a href="#" class="mr-3">
                                <img src="../../../../global_assets/images/placeholders/placeholder.jpg" width="36"
                                    height="36" class="rounded-circle" alt="">
                            </a>
                            <div class="flex-1">
                                <a href="#" class="font-weight-semibold">Christine</a> commented on your community <a
                                    href="#">post</a> from 10.12.2021

                                <div class="font-size-sm text-muted mt-1">2 days ago</div>
                            </div>
                        </div>

                        <div class="d-flex mb-3">
                            <a href="#" class="mr-3">
                                <img src="../../../../global_assets/images/placeholders/placeholder.jpg" width="36"
                                    height="36" class="rounded-circle" alt="">
                            </a>
                            <div class="flex-1">
                                <a href="#" class="font-weight-semibold">Mike</a> added 1 new file(s) to <a
                                    href="#">Product management</a> project

                                <div class="bg-light rounded p-2 mt-2">
                                    <div class="d-flex align-items-center mx-1">
                                        <div class="mr-2">
                                            <i class="icon-file-pdf text-danger icon-2x position-static"></i>
                                        </div>
                                        <div class="flex-1">
                                            new_contract.pdf
                                            <div class="font-size-sm text-muted">112KB</div>
                                        </div>
                                        <div class="ml-2">
                                            <a href="#"
                                                class="btn btn-dark-100 text-body btn-icon btn-sm border-transparent rounded-pill">
                                                <i class="icon-arrow-down8"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="font-size-sm text-muted mt-1">1 day ago</div>
                            </div>
                        </div>

                        <div class="d-flex mb-3">
                            <div class="mr-3">
                                <div class="bg-success-100 text-black rounded-pill">
                                    <i class="icon-calendar3 position-static p-2"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                All hands meeting will take place coming Thursday at 13:45. <a href="#">Add to
                                    calendar</a>

                                <div class="font-size-sm text-muted mt-1">2 days ago</div>
                            </div>
                        </div>

                        <div class="d-flex mb-3">
                            <a href="#" class="mr-3">
                                <img src="../../../../global_assets/images/placeholders/placeholder.jpg" width="36"
                                    height="36" class="rounded-circle" alt="">
                            </a>
                            <div class="flex-1">
                                <a href="#" class="font-weight-semibold">Nick</a> requested your feedback and approval
                                in support request <a href="#">#458</a>

                                <div class="font-size-sm text-muted mt-1">3 days ago</div>
                            </div>
                        </div>

                        <div class="d-flex">
                            <div class="mr-3">
                                <div class="bg-primary-100 text-black rounded-pill">
                                    <i class="icon-people position-static p-2"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <span class="font-weight-semibold">HR department</span> requested you to complete
                                internal survey by Friday

                                <div class="font-size-sm text-muted mt-1">3 days ago</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /notifications -->

    <script src="{{ asset('/global_assets/js/main/jquery.min.js') }}"></script>
    <script src="{{ asset('/global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="{{ asset('/global_assets/js/plugins/visualization/d3/d3.min.js') }}"></script>
    <script src="{{ asset('/global_assets/js/plugins/visualization/d3/d3_tooltip.js') }}"></script>
    <script src="{{ asset('/global_assets/js/plugins/ui/moment/moment.min.js') }}"></script>
    <script src="{{ asset('/global_assets/js/plugins/pickers/daterangepicker.js') }}"></script>

    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('/global_assets/js/demo_pages/dashboard.js') }}"></script>
    <script src="{{ asset('/global_assets/js/demo_charts/pages/dashboard/dark/streamgraph.js') }}"></script>
    <script src="{{ asset('/global_assets/js/demo_charts/pages/dashboard/dark/sparklines.js') }}"></script>
    <script src="{{ asset('/global_assets/js/demo_charts/pages/dashboard/dark/lines.js') }}"></script>
    <script src="{{ asset('/global_assets/js/demo_charts/pages/dashboard/dark/areas.js') }}"></script>
    <script src="{{ asset('/global_assets/js/demo_charts/pages/dashboard/dark/donuts.js') }}"></script>
    <script src="{{ asset('/global_assets/js/demo_charts/pages/dashboard/dark/bars.js') }}"></script>
    <script src="{{ asset('/global_assets/js/demo_charts/pages/dashboard/dark/progress.js') }}"></script>
    <script src="{{ asset('/global_assets/js/demo_charts/pages/dashboard/dark/pies.js') }}"></script>
</body>

</html>