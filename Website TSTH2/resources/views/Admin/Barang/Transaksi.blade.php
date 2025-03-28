@extends('Master.Layout.app')
@section('page-title', 'Data Barang')
@section('breadcrumb')
    <a href="{{ url('/dashboard') }}" class="breadcrumb-item"><i class="ph-house"></i> Home</a>
    <span class="breadcrumb-item active">Data Barang</span>
@endsection
@section('content')

<!-- Page content -->
<div class="content-wrapper">

    <!-- Inner content -->
    <div class="content-inner">
        <!-- Content area -->
        <div class="content">

            <!-- Basic datatable -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Daftar Barang</h5>
                </div>

                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <a href="#" class="btn btn-primary"><i class="ph-plus-circle me-2"></i>Tambah Barang</a>
                        <div class="d-flex">
                            <input type="text" class="form-control me-2" placeholder="Cari barang..." id="search-input">
                            <button class="btn btn-light" id="search-button"><i class="ph-magnifying-glass"></i></button>
                        </div>
                    </div>
                </div>

                <table class="table datatable-basic">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Barcode</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Jenis</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $barang = [
                                [
                                    'id' => 1,
                                    'gambar' => 'pupuk_kompos.jpg',
                                    'kode' => 'PUP-001',
                                    'nama' => 'Pupuk Kompos',
                                    'jenis' => 'Pupuk',
                                    'harga' => 15000,
                                    'stok' => 80
                                ],
                                // ... your other data items ...
                            ];
                            $perPage = 10; // Items per page
                            $currentPage = request()->get('page', 1);
                            $offset = ($currentPage - 1) * $perPage;
                            $paginatedItems = array_slice($barang, $offset, $perPage);
                            $totalItems = count($barang);
                        @endphp

                        @foreach($paginatedItems as $key => $item)
                        <tr>
                            <td>{{ $offset + $key + 1 }}</td>
                            <td>
                                <img src="{{ asset('storage/barang/'.$item['gambar']) }}" alt="{{ $item['nama'] }}" class="img-fluid rounded" width="60">
                            </td>
                            <td>
                                <svg id="barcode{{ $item['id'] }}"></svg>
                                <script>
                                    JsBarcode(`#barcode{{ $item['id'] }}`, "{{ $item['kode'] }}", {
                                        format: "CODE128",
                                        width: 1.5,
                                        height: 40,
                                        displayValue: false
                                    });
                                </script>
                            </td>
                            <td>{{ $item['kode'] }}</td>
                            <td>{{ $item['nama'] }}</td>
                            <td>{{ $item['jenis'] }}</td>
                            <td>Rp{{ number_format($item['harga'], 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary">{{ $item['stok'] }}</span>
                            </td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <a href="#" class="text-body mx-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                        <i class="ph-pen"></i>
                                    </a>
                                    <a href="#" class="text-body mx-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus" onclick="confirmDelete({{ $item['id'] }})">
                                        <i class="ph-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="card-footer d-flex justify-content-between">
                    <div class="showing-items">
                        Menampilkan {{ $offset + 1 }} sampai {{ min($offset + $perPage, $totalItems) }} dari {{ $totalItems }} item
                    </div>
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-flat">
                            <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                                <a class="page-link" href="?page={{ $currentPage - 1 }}" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            
                            @for ($i = 1; $i <= ceil($totalItems / $perPage); $i++)
                                <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                    <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
                                </li>
                            @endfor
                            
                            <li class="page-item {{ $currentPage == ceil($totalItems / $perPage) ? 'disabled' : '' }}">
                                <a class="page-link" href="?page={{ $currentPage + 1 }}" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <!-- /Pagination -->
            </div>
            <!-- /basic datatable -->

        </div>
        <!-- /content area -->

    </div>
    <!-- /inner content -->

</div>
<!-- /page content -->

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data barang akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-light ms-2'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: 'Terhapus!',
                    text: 'Data barang telah dihapus.',
                    buttonsStyling: false,
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                });
            }
        });
    }

    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>

@endsection