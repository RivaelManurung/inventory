<!-- Main sidebar -->
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">
    <!-- Sidebar content -->
    <div class="sidebar-content">
        <!-- Sidebar header -->
        <div class="sidebar-section">
            <div class="sidebar-section-body d-flex justify-content-center">
                <h5 class="sidebar-resize-hide flex-grow-1 my-auto">Navigation</h5>
                <div>
                    <button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                        <i class="ph-arrows-left-right"></i>
                    </button>
                    <button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
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
                <li class="nav-item">
                    <a href="{{ url('/dashboard') }}" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                        <i class="ph-house"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link">
                        <i class="ph-layout"></i>
                        <span>Master Barang</span>
                    </a>
                    <ul class="nav-group-sub collapse">
                        <li class="nav-item"><a href="{{ url('/jenisbarang') }}" class="nav-link {{ Request::is('jenis') ? 'active' : '' }}">Jenis</a></li>
                        <li class="nav-item"><a href="{{ url('/satuan') }}" class="nav-link {{ Request::is('satuan') ? 'active' : '' }}">Satuan</a></li>
                        <li class="nav-item"><a href="{{ url('/merk') }}" class="nav-link {{ Request::is('merk') ? 'active' : '' }}">Merk</a></li>
                        <li class="nav-item"><a href="{{ url('/barang') }}" class="nav-link {{ Request::is('barang') ? 'active' : '' }}">Barang</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/customer') }}" class="nav-link {{ Request::is('customer') ? 'active' : '' }}">
                        <i class="ph-swatches"></i>
                        <span>Customer</span>
                    </a>
                </li>
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link">
                        <i class="ph-note-blank"></i>
                        <span>Transaksi</span>
                    </a>
                    <ul class="nav-group-sub collapse">
                        <li class="nav-item"><a href="{{ url('/transaksi') }}" class="nav-link {{ Request::is('transaksi/barang-masuk') ? 'active' : '' }}">Barang Masuk</a></li>
                        <li class="nav-item"><a href="{{ url('/transaksi/barang-keluar') }}" class="nav-link {{ Request::is('transaksi/barang-keluar') ? 'active' : '' }}">Barang Keluar</a></li>
                        <li class="nav-item"><a href="{{ url('/transaksi/peminjaman') }}" class="nav-link {{ Request::is('transaksi/peminjaman') ? 'active' : '' }}">Peminjaman</a></li>
                        <li class="nav-item"><a href="{{ url('/transaksi/pengembalian') }}" class="nav-link {{ Request::is('transaksi/pengembalian') ? 'active' : '' }}">Pengembalian</a></li>
                        <li class="nav-item"><a href="{{ url('/transaksi/maintenance') }}" class="nav-link {{ Request::is('transaksi/maintenance') ? 'active' : '' }}">Maintenance</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/laporan') }}" class="nav-link {{ Request::is('laporan') ? 'active' : '' }}">
                        <i class="ph-list-numbers"></i>
                        <span>Laporan</span>
                        <span class="badge bg-primary align-self-center rounded-pill ms-auto">4.0</span>
                    </a>
                </li>
                <!-- Other -->
                <li class="nav-item-header pt-0">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Other</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/pengaturan') }}" class="nav-link {{ Request::is('pengaturan') ? 'active' : '' }}">
                        <i class="ph-gear"></i>
                        <span>Pengaturan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-danger" id="logoutBtn">
                        <i class="ph-sign-out"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- /main navigation -->
    </div>
    <!-- /sidebar content -->
</div>
<!-- /main sidebar -->
