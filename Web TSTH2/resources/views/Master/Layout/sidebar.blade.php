<!-- Main sidebar -->
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">
    <!-- Sidebar content -->
    <div class="sidebar-content">
        <!-- Sidebar header -->
        <div class="sidebar-section">
            <div class="sidebar-section-body d-flex justify-content-center">
                <h5 class="sidebar-resize-hide flex-grow-1 my-auto">Navigation</h5>
                <div>
                    <button type="button"
                        class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                        <i class="ph-arrows-left-right"></i>
                    </button>
                    <button type="button"
                        class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
                        <i class="ph-x"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- /sidebar header -->

        <!-- Main navigation -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">
                <!-- Main -->
                <li class="nav-item-header pt-0">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Main</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>

                @if(hasPermission('dashboard.view'))
                <li class="nav-item">
                    <a href="{{ url('/dashboard') }}" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                        <i class="ph-house"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @endif

                @if(hasPermission('barang.view') || hasPermission('jenis-barang.view') ||
                hasPermission('satuan.view') || hasPermission('gudang.view'))
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link">
                        <i class="ph-layout"></i>
                        <span>Master Barang</span>
                    </a>
                    <ul class="nav-group-sub collapse">
                        @if(hasPermission('jenis-barang.view'))
                        <li class="nav-item"><a href="{{ url('/jenis-barang') }}"
                                class="nav-link {{ Request::is('jenis-barang') ? 'active' : '' }}">Jenis</a></li>
                        @endif

                        @if(hasPermission('satuan.view'))
                        <li class="nav-item"><a href="{{ url('/satuan') }}"
                                class="nav-link {{ Request::is('satuan') ? 'active' : '' }}">Satuan</a></li>
                        @endif

                        @if(hasPermission('barang.view'))
                        <li class="nav-item"><a href="{{ url('/barang') }}"
                                class="nav-link {{ Request::is('barang') ? 'active' : '' }}">Barang</a></li>
                        @endif

                        @if(hasPermission('gudang.view'))
                        <li class="nav-item"><a href="{{ url('/gudang') }}"
                                class="nav-link {{ Request::is('gudang') ? 'active' : '' }}">Gudang</a></li>
                        @endif
                    </ul>
                </li>
                @endif

                @if(hasPermission('customer.view'))
                <li class="nav-item">
                    <a href="{{ url('/customer') }}" class="nav-link {{ Request::is('customer') ? 'active' : '' }}">
                        <i class="ph-swatches"></i>
                        <span>Customer</span>
                    </a>
                </li>
                @endif

                @if(hasPermission('transaksi.view') || hasPermission('peminjaman.view') ||
                hasPermission('pengembalian.view') || hasPermission('maintenance.view'))
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link">
                        <i class="ph-note-blank"></i>
                        <span>Transaksi</span>
                    </a>
                    <ul class="nav-group-sub collapse">
                        @if(hasPermission('transaksi.view'))
                        <li class="nav-item"><a href="{{ url('/transaksi') }}"
                                class="nav-link {{ Request::is('transaksi') ? 'active' : '' }}">Barang
                                Masuk</a></li>
                        @endif

                        @if(hasPermission('transaksi.view'))
                        <li class="nav-item"><a href="{{ url('/transaksi/barang-keluar') }}"
                                class="nav-link {{ Request::is('transaksi/barang-keluar') ? 'active' : '' }}">Barang
                                Keluar</a></li>
                        @endif

                        @if(hasPermission('peminjaman.view'))
                        <li class="nav-item"><a href="{{ url('/transaksi/peminjaman') }}"
                                class="nav-link {{ Request::is('transaksi/peminjaman') ? 'active' : '' }}">Peminjaman</a>
                        </li>
                        @endif

                        @if(hasPermission('pengembalian.view'))
                        <li class="nav-item"><a href="{{ url('/transaksi/pengembalian') }}"
                                class="nav-link {{ Request::is('transaksi/pengembalian') ? 'active' : '' }}">Pengembalian</a>
                        </li>
                        @endif

                        @if(hasPermission('maintenance.view'))
                        <li class="nav-item"><a href="{{ url('/transaksi/maintenance') }}"
                                class="nav-link {{ Request::is('transaksi/maintenance') ? 'active' : '' }}">Maintenance</a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif

                @if(hasPermission('laporan.view'))
                <li class="nav-item">
                    <a href="{{ url('/laporan') }}" class="nav-link {{ Request::is('laporan') ? 'active' : '' }}">
                        <i class="ph-list-numbers"></i>
                        <span>Laporan</span>
                        <span class="badge bg-primary align-self-center rounded-pill ms-auto">4.0</span>
                    </a>
                </li>
                @endif

                <!-- System Management -->
                @if(hasPermission('access-control.users.view') || hasPermission('access-control.manage'))
                <li class="nav-item-header pt-0">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">System</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>

                @if(hasPermission('access-control.manage'))
                <li class="nav-item">
                    <a href="{{ url('/role-permission') }}"
                        class="nav-link {{ Request::is('role-permission') ? 'active' : '' }}">
                        <i class="ph-shield-check"></i>
                        <span>Role & Permission</span>
                    </a>
                </li>
                @endif

                @if(hasPermission('access-control.users.view'))
                <li class="nav-item">
                    <a href="{{ url('/user-access') }}"
                        class="nav-link {{ Request::is('user-access') ? 'active' : '' }}">
                        <i class="ph-users"></i>
                        <span>User Management</span>
                    </a>
                </li>
                @endif
                @endif

                <!-- Other -->
                @if(hasPermission('pengaturan.view') || hasPermission('user.logout'))
                <li class="nav-item-header pt-0">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Other</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>

                @if(hasPermission('pengaturan.view'))
                <li class="nav-item">
                    <a href="{{ url('/pengaturan') }}" class="nav-link {{ Request::is('pengaturan') ? 'active' : '' }}">
                        <i class="ph-gear"></i>
                        <span>Pengaturan</span>
                    </a>
                </li>
                @endif

                @if(hasPermission('user.logout'))
                <li class="nav-item">
                    <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                        @csrf
                    </form>
                    <a href="#" class="nav-link text-danger"
                        onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                        <i class="ph-sign-out"></i>
                        <span>Logout</span>
                    </a>
                </li>
                @endif
                @endif
            </ul>
        </div>
        <!-- /main navigation -->
    </div>
    <!-- /sidebar content -->
</div>
<!-- /main sidebar -->