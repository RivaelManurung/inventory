<!-- Main navbar -->
<div class="navbar navbar-expand-lg navbar-light navbar-static px-0">
    <div class="container px-2 px-lg-3">
        <div class="d-flex flex-1 d-lg-none">
            <button type="button" class="navbar-toggler sidebar-mobile-main-toggle">
                <i class="icon-transmission"></i>
            </button>
            <button data-target="#navbar_search" type="button" class="navbar-toggler" data-toggle="collapse">
                <i class="icon-search4"></i>
            </button>
        </div>

        <div class="navbar-brand text-center text-lg-left">
            <a href="index.html" class="d-inline-block">
                <img src="../../../../global_assets/images/logo_light.png" class="d-none d-sm-block" alt="">
                <img src="../../../../global_assets/images/logo_icon_light.png" class="d-sm-none" alt="">
            </a>
        </div>

        <div class="collapse navbar-collapse order-2 order-lg-1" id="navbar_search">
            <div class="navbar-search d-flex align-items-center py-3 py-lg-0">
                <div class="form-group-feedback form-group-feedback-left flex-grow-1">
                    <input type="text" class="form-control" placeholder="Search">
                    <div class="form-control-feedback">
                        <i class="icon-search4 text-white opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="order-1 order-lg-2 d-flex flex-1 flex-lg-0 justify-content-end align-items-center">
            <span class="badge badge-success d-none d-lg-inline-block mr-3">Active</span>

            <ul class="navbar-nav flex-row align-items-center h-100">
                <li class="nav-item nav-item-dropdown-lg dropdown">
                    <a href="#" class="navbar-nav-link navbar-nav-link-toggler" data-toggle="modal"
                        data-target="#notifications">
                        <i class="icon-bell2"></i>
                        <span class="badge badge-yellow badge-pill">3</span>
                    </a>
                </li>

                <li class="nav-item nav-item-dropdown-lg dropdown dropdown-user h-100">
                    <a href="#"
                        class="navbar-nav-link navbar-nav-link-toggler dropdown-toggle d-inline-flex align-items-center h-100"
                        data-toggle="dropdown">
                        <img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-pill"
                            height="34" alt="">
                        <span class="d-none d-lg-inline-block ml-2">Victoria</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right wmin-lg-250 py-2">
                        <div class="dropdown-item d-flex py-2">
                            <div class="flex-1">
                                <div class="font-weight-semibold">Account summary</div>
                                <span class="text-muted font-size-sm">Profile, overview</span>
                            </div>
                            <span
                                class="btn btn-dark-100 btn-icon btn-sm text-body border-transparent rounded-pill ml-1">
                                <i class="icon-arrow-right8"></i>
                            </span>
                        </div>

                        <div class="dropdown-item d-flex py-2">
                            <div class="flex-1">
                                <div class="font-weight-semibold">Privacy</div>
                                <span class="text-muted font-size-sm">Access, permissions</span>
                            </div>
                            <span
                                class="btn btn-dark-100 btn-icon btn-sm text-body border-transparent rounded-pill ml-1">
                                <i class="icon-arrow-right8"></i>
                            </span>
                        </div>

                        <div class="dropdown-item d-flex py-2">
                            <div class="flex-1">
                                <div class="font-weight-semibold">Payments</div>
                                <span class="text-muted font-size-sm">Expenses, subscription</span>
                            </div>
                            <span
                                class="btn btn-dark-100 btn-icon btn-sm text-body border-transparent rounded-pill ml-1">
                                <i class="icon-arrow-right8"></i>
                            </span>
                        </div>

                        <div class="dropdown-item d-flex py-2">
                            <div class="flex-1">
                                <div class="font-weight-semibold">Settings</div>
                                <span class="text-muted font-size-sm">Security, app config</span>
                            </div>
                            <span
                                class="btn btn-dark-100 btn-icon btn-sm text-body border-transparent rounded-pill ml-1">
                                <i class="icon-arrow-right8"></i>
                            </span>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- /main navbar -->