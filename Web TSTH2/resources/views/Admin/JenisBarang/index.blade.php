@extends('Master.Layout.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Jenis Barang</h6>
            <a href="{{ route('jenis-barang.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah
            </a>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchInput" 
                               placeholder="Cari jenis barang..." value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" id="searchButton">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-right">
                    <select name="per_page" id="perPageSelect" class="form-control form-control-sm d-inline-block w-auto">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 per halaman</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 per halaman</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 per halaman</option>
                    </select>
                </div>
            </div>

            <div id="loadingIndicator" class="text-center py-3" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="mt-2">Memuat data...</p>
            </div>

            <div id="tableContainer">
                @include('admin.jenisbarang.partials.table', ['jenisBarangs' => $jenisBarangs])
                @include('admin.jenisbarang.partials.pagination', ['jenisBarangs' => $jenisBarangs])
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    /* Gaya untuk pagination */
    .pagination {
        margin: 0;
    }
    .page-item.active .page-link {
        background-color: #4e73df;
        border-color: #4e73df;
    }
    .page-link {
        color: #4e73df;
    }
    .pagination-info {
        padding-top: 6px;
        font-size: 0.9rem;
        color: #6c757d;
    }
    /* Gaya untuk loading indicator */
    #loadingIndicator {
        background-color: rgba(255, 255, 255, 0.8);
        position: absolute;
        left: 0;
        right: 0;
        z-index: 100;
    }
    /* Gaya untuk tabel */
    .table td, .table th {
        vertical-align: middle;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
    }
</style>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    let typingTimer;
    const doneTypingInterval = 500;
    const $tableContainer = $('#tableContainer');
    const $loadingIndicator = $('#loadingIndicator');
    
    // Fungsi untuk memuat data via AJAX
    function loadData(search = '', perPage = 10, pageUrl = null) {
        $loadingIndicator.show();
        $tableContainer.hide();
        
        const url = pageUrl || '{{ route("jenis-barang.index") }}';
        const params = {
            search: search,
            per_page: perPage,
            ajax: 1
        };
        
        $.ajax({
            url: url,
            type: 'GET',
            data: params,
            success: function(response) {
                if (response.success) {
                    $tableContainer.html(response.html + response.pagination);
                } else {
                    showError(response.message || 'Terjadi kesalahan');
                }
            },
            error: function(xhr) {
                showError(xhr.responseJSON?.message || 'Terjadi kesalahan server');
            },
            complete: function() {
                $loadingIndicator.hide();
                $tableContainer.show();
            }
        });
    }
    
    // Fungsi untuk menampilkan error
    function showError(message) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: message,
            timer: 3000
        });
    }
    
    // Event untuk real-time search
    $('#searchInput').on('keyup', function() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(function() {
            loadData($('#searchInput').val(), $('#perPageSelect').val());
        }, doneTypingInterval);
    });
    
    // Event untuk tombol search
    $('#searchButton').on('click', function() {
        loadData($('#searchInput').val(), $('#perPageSelect').val());
    });
    
    // Event untuk perubahan per page
    $('#perPageSelect').on('change', function() {
        loadData($('#searchInput').val(), $(this).val());
    });
    
    // Event untuk pagination (menggunakan event delegation)
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        loadData($('#searchInput').val(), $('#perPageSelect').val(), $(this).attr('href'));
    });
    
    // Trigger load data pertama kali jika perlu
    @if(request()->ajax())
    loadData('{{ request('search') }}', '{{ request('per_page', 10) }}');
    @endif
});
</script>
@endsection