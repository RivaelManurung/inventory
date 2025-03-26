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
                    <li class="nav-item">
                        <a href="#" class="nav-link active">
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
                            <li class="nav-item"><a href="#" class="nav-link active">Jenis</a></li>
                            <li class="nav-item"><a href="#" class="nav-link">Satuan</a></li>
                            <li class="nav-item"><a href="#" class="nav-link">Merk</a></li>
                            <li class="nav-item"><a href="#" class="nav-link">Barang</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
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
                            <li class="nav-item"><a href="#" class="nav-link">Barang Masuk</a></li>
                            <li class="nav-item"><a href="#" class="nav-link">Barang Keluar</a></li>
                            <li class="nav-item"><a href="#" class="nav-link">Peminjaman</a></li>
                            <li class="nav-item"><a href="#" class="nav-link">Pengembalian</a></li>
                            <li class="nav-item"><a href="#" class="nav-link">Maintenance</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="ph-list-numbers"></i>
                            <span>Laporan</span>
                            <span class="badge bg-primary align-self-center rounded-pill ms-auto">4.0</span>
                        </a>
                    </li>
                    <!-- Main -->
                    <li class="nav-item-header pt-0">
                        <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Other</div>
                        <i class="ph-dots-three sidebar-resize-show"></i>
                    </li>
                    <!-- Pengaturan -->
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="ph-gear"></i>
                            <span>Pengaturan</span>
                        </a>
                    </li>
    
                    <!-- Logout -->
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
    
    <!-- SweetAlert for Logout -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.getElementById('logoutBtn').addEventListener('click', async function(event) {
        event.preventDefault();
    
        Swal.fire({
            title: "Apakah Anda yakin ingin logout?",
            text: "Anda akan keluar dari sesi saat ini!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, Logout!",
            cancelButtonText: "Batal"
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    let token = localStorage.getItem('access_token');
                    if (!token) throw new Error("Tidak ada sesi login.");
    
                    let response = await fetch("{{ url('http://127.0.0.1:8000/api/auth/logout') }}", {
                        method: "POST",
                        headers: {
                            "Authorization": `Bearer ${token}`,
                            "Accept": "application/json"
                        }
                    });
    
                    if (!response.ok) throw new Error("Gagal logout.");
    
                    // Hapus token dari Local Storage
                    localStorage.removeItem('access_token');
                    localStorage.removeItem('remembered_email');
    
                    Swal.fire({
                        title: "Logout Berhasil!",
                        text: "Anda telah keluar dari sistem.",
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });
    
                    setTimeout(() => {
                        window.location.href = "{{ url('/login') }}";
                    }, 2000);
    
                } catch (error) {
                    Swal.fire("Error", error.message, "error");
                }
            }
        });
    });
    </script>
    