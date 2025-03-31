@extends('Master.layout.app')

@section('title', 'Master Satuan')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
<li class="breadcrumb-item active">Master Satuan</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Daftar Satuan Barang</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                            data-target="#tambahSatuanModal">
                            <i class="fas fa-plus"></i> Tambah Satuan
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form id="searchForm">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="searchInput"
                                        placeholder="Cari satuan..." value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 text-right">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="refreshBtn">
                                    <i class="fas fa-sync-alt"></i> Refresh
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="pollingToggle">
                                    <i class="fas fa-play-circle"></i> Start Auto-Refresh
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="loadingIndicator" class="text-center" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p>Memuat data...</p>
                    </div>

                    <div id="satuanTableContainer">
                        <!-- Table will be loaded here via AJAX -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
@include('Admin.satuan.modals')
@endsection

@section('styles')
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!-- SweetAlert2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    .table-responsive {
        overflow-x: auto;
    }

    .card {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e3e6f0;
    }

    .card-title {
        margin-bottom: 0;
        font-weight: 600;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }

    .spinner-border {
        width: 3rem;
        height: 3rem;
    }

    .pagination {
        margin-bottom: 0;
    }
</style>
@endsection

@section('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
    let currentPage = 1;
    let currentSearch = '';
    let isPollingActive = false;
    let pollingTimer;

    // Load initial data
    loadSatuanData();

    // Search form handler
    $('#searchForm').on('submit', function(e) {
        e.preventDefault();
        currentSearch = $('#searchInput').val();
        currentPage = 1;
        loadSatuanData();
    });

    // Refresh button handler
    $('#refreshBtn').click(function() {
        currentPage = 1;
        loadSatuanData();
    });

    // Polling toggle handler
    $('#pollingToggle').click(function() {
        isPollingActive = !isPollingActive;
        if (isPollingActive) {
            $(this).html('<i class="fas fa-stop-circle"></i> Stop Auto-Refresh');
            startPolling();
        } else {
            $(this).html('<i class="fas fa-play-circle"></i> Start Auto-Refresh');
            stopPolling();
        }
    });

    // Load data function
// Load data function
function loadSatuanData(page = 1) {
    console.log('Loading data for page:', page);
    $('#loadingIndicator').show();
    $('#satuanTableContainer').hide();

    $.ajax({
        url: '/satuan',
        type: 'GET',
        data: {
            page: page,
            search: currentSearch,
            per_page: 10
        },
        success: function(response) {
            console.log("API Response:", response);
            
            if (response.success) {
                // Perbaikan di sini - ambil data langsung dari response.data
                const dataItems = response.data.data || response.data; // Coba kedua format
                
                console.log("Data to render:", dataItems);
                
                if (dataItems && dataItems.length > 0) {
                    renderSatuanTable({
                        success: true,
                        data: dataItems,
                        meta: response.meta || {
                            current_page: 1,
                            from: 1,
                            to: dataItems.length,
                            total: dataItems.length,
                            last_page: 1,
                            per_page: 10
                        }
                    });
                } else {
                    $('#satuanTableContainer').html(`
                        <div class="alert alert-info">
                            Tidak ada data satuan ditemukan.
                        </div>
                    `).show();
                }
            } else {
                showErrorAlert(response.message || 'Gagal memuat data satuan');
                $('#satuanTableContainer').html(`
                    <div class="alert alert-danger">
                        ${response.message || 'Gagal memuat data satuan'}
                    </div>
                `).show();
            }
        },
        error: function(xhr) {
            console.error("AJAX Error:", xhr);
            let errorMessage = 'Terjadi kesalahan saat memuat data';
            if (xhr.status === 401) {
                errorMessage = 'Sesi telah berakhir, silakan login kembali';
                window.location.href = '/login';
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            showErrorAlert(errorMessage);
            $('#satuanTableContainer').html(`
                <div class="alert alert-danger">
                    ${errorMessage}
                </div>
            `).show();
        },
        complete: function() {
            $('#loadingIndicator').hide();
        }
    });
}

    // Render table function
// Render table function
function renderSatuanTable(response) {
    console.log("Rendering table with:", response);
    
    let html = `
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Satuan</th>
                        <th>Slug</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>`;

    const items = response.data;
    console.log("Items to render:", items);

    if (items && items.length > 0) {
        items.forEach((item, index) => {
            console.log("Rendering item:", item);
            html += `
                <tr>
                    <td>${(response.meta.current_page - 1) * response.meta.per_page + index + 1}</td>
                    <td>${item.satuan_nama || '-'}</td>
                    <td>${item.satuan_slug || '-'}</td>
                    <td>${item.satuan_keterangan || '-'}</td>
                    <td>
                        <button class="btn btn-sm btn-warning edit-satuan" 
                            data-id="${item.satuan_id}"
                            data-nama="${item.satuan_nama}"
                            data-slug="${item.satuan_slug}"
                            data-keterangan="${item.satuan_keterangan || ''}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger delete-satuan" data-id="${item.satuan_id}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>`;
        });
    } else {
        html += `
            <tr>
                <td colspan="5" class="text-center">
                    <div class="alert alert-info">
                        Tidak ada data satuan ditemukan.
                    </div>
                </td>
            </tr>`;
    }

    html += `</tbody></table></div>`;

    // Pagination
    if (response.meta && response.meta.last_page > 1) {
        html += `<div class="row">
            <div class="col-md-6">
                <p>Menampilkan ${response.meta.from} sampai ${response.meta.to} dari ${response.meta.total} data</p>
            </div>
            <div class="col-md-6">
                <div class="float-right">
                    <nav>
                        <ul class="pagination">`;

        if (response.meta.current_page > 1) {
            html += `<li class="page-item">
                <a class="page-link" href="#" onclick="return loadPageData(${response.meta.current_page - 1})">Previous</a>
            </li>`;
        }

        for (let i = 1; i <= response.meta.last_page; i++) {
            html += `<li class="page-item ${response.meta.current_page === i ? 'active' : ''}">
                <a class="page-link" href="#" onclick="return loadPageData(${i})">${i}</a>
            </li>`;
        }

        if (response.meta.current_page < response.meta.last_page) {
            html += `<li class="page-item">
                <a class="page-link" href="#" onclick="return loadPageData(${response.meta.current_page + 1})">Next</a>
            </li>`;
        }

        html += `</ul></nav></div></div></div>`;
    }

    $('#satuanTableContainer').html(html).show();
    initializeEventHandlers();
}

    // Helper function for pagination
    function loadPageData(page) {
        currentPage = page;
        loadSatuanData(page);
        return false;
    }

    // Initialize event handlers
    function initializeEventHandlers() {
        console.log("Initializing event handlers");
        
        // Edit button handlers
        $(document).off('click', '.edit-satuan').on('click', '.edit-satuan', function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            const slug = $(this).data('slug');
            const keterangan = $(this).data('keterangan');
            
            $('#edit_satuan_id').val(id);
            $('#edit_satuan_nama').val(nama);
            $('#edit_satuan_slug').val(slug);
            $('#edit_satuan_keterangan').val(keterangan);
            
            $('#editSatuanModal').modal('show');
        });

        // Delete button handlers
        $(document).off('click', '.delete-satuan').on('click', '.delete-satuan', function() {
            const id = $(this).data('id');
            if (confirm('Apakah Anda yakin ingin menghapus satuan ini?')) {
                deleteSatuan(id);
            }
        });
    }

    // Form submissions
    $('#tambahSatuanForm').on('submit', function(e) {
        e.preventDefault();
        createSatuan($(this));
    });

    $('#editSatuanForm').on('submit', function(e) {
        e.preventDefault();
        updateSatuan($(this));
    });

    // Create satuan
    function createSatuan(form) {
        $('#submitButton').prop('disabled', true);
        $('.text-danger').text('');

        $.ajax({
            url: '/satuan',
            type: 'POST',
            data: form.serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('#tambahSatuanModal').modal('hide');
                    form[0].reset();
                    showSuccessAlert(response.message);
                    loadSatuanData(currentPage);
                } else {
                    showErrorAlert(response.message);
                    if (response.errors) {
                        for (const [key, value] of Object.entries(response.errors)) {
                            $(`#${key}_error`).text(value[0]);
                        }
                    }
                }
            },
            error: function(xhr) {
                let errorMessage = 'Terjadi kesalahan saat membuat satuan';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                showErrorAlert(errorMessage);
            },
            complete: function() {
                $('#submitButton').prop('disabled', false);
            }
        });
    }

    // Update satuan
    function updateSatuan(form) {
        $('#updateButton').prop('disabled', true);
        $('.text-danger').text('');

        const id = $('#edit_satuan_id').val();

        $.ajax({
            url: `/satuan/${id}`,
            type: 'POST',
            data: form.serialize() + '&_method=PUT',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('#editSatuanModal').modal('hide');
                    showSuccessAlert(response.message);
                    loadSatuanData(currentPage);
                } else {
                    showErrorAlert(response.message);
                    if (response.errors) {
                        for (const [key, value] of Object.entries(response.errors)) {
                            $(`#edit_${key}_error`).text(value[0]);
                        }
                    }
                }
            },
            error: function(xhr) {
                let errorMessage = 'Terjadi kesalahan saat memperbarui satuan';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                showErrorAlert(errorMessage);
            },
            complete: function() {
                $('#updateButton').prop('disabled', false);
            }
        });
    }

    // Delete satuan
    function deleteSatuan(id) {
        $.ajax({
            url: `/satuan/${id}`,
            type: 'POST',
            data: {
                _method: 'DELETE',
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    showSuccessAlert(response.message);
                    loadSatuanData(currentPage);
                } else {
                    showErrorAlert(response.message);
                }
            },
            error: function(xhr) {
                let errorMessage = 'Terjadi kesalahan saat menghapus data';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                showErrorAlert(errorMessage);
            }
        });
    }

    // Polling functions
    function startPolling() {
        pollingTimer = setInterval(function() {
            loadSatuanData(currentPage);
        }, 5000);
    }

    function stopPolling() {
        if (pollingTimer) {
            clearInterval(pollingTimer);
        }
    }

    // Alert functions
    function showSuccessAlert(message) {
        Swal.fire({
            icon: 'success',
            title: 'Sukses',
            text: message,
            timer: 2000,
            showConfirmButton: false
        });
    }

    function showErrorAlert(message) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: message
        });
    }
});
</script>
@endsection