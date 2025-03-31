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

@section('scripts')
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
        loadSatuanData();
    });

    // Load data function
    function loadSatuanData(page = 1) {
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
            if (response.success) {
                renderSatuanTable(response);
            } else {
                showErrorAlert(response.message || 'Gagal memuat data satuan');
                // Show empty state
                $('#satuanTableContainer').html(`
                    <div class="alert alert-danger">
                        ${response.message || 'Gagal memuat data satuan'}
                    </div>
                `).show();
            }
        },
        error: function(xhr) {
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
    // Render table function - Updated to match your service response
    function renderSatuanTable(response) {
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

        if (response.data && response.data.length > 0) {
            response.data.forEach((satuan, index) => {
                // Adjusted to match SatuanResource structure
                const satuanData = satuan.resource ? satuan.resource : satuan;
                html += `
                    <tr>
                        <td>${(response.meta.current_page - 1) * response.meta.per_page + index + 1}</td>
                        <td>${satuanData.satuan_nama}</td>
                        <td>${satuanData.satuan_slug}</td>
                        <td>${satuanData.satuan_keterangan || '-'}</td>
                        <td>
                            <button class="btn btn-sm btn-warning edit-satuan" 
                                data-id="${satuanData.satuan_id}"
                                data-nama="${satuanData.satuan_nama}"
                                data-slug="${satuanData.satuan_slug}"
                                data-keterangan="${satuanData.satuan_keterangan || ''}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-satuan" data-id="${satuanData.satuan_id}">
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

        $('#satuanTableContainer').html(html);
        initializeEventHandlers();
    }

    // Form submissions - Updated to match your controller endpoints
    $('#tambahSatuanForm').on('submit', function(e) {
        e.preventDefault();
        createSatuan($(this));
    });

    $('#editSatuanForm').on('submit', function(e) {
        e.preventDefault();
        updateSatuan($(this));
    });

    // Create satuan - Updated endpoint
    function createSatuan(form) {
        $('#submitButton').prop('disabled', true);
        $('.text-danger').text('');

        $.ajax({
            url: '/satuan', // Changed from '/api/satuan'
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
                    loadSatuanData();
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

    // Update satuan - Updated endpoint
    function updateSatuan(form) {
        $('#updateButton').prop('disabled', true);
        $('.text-danger').text('');

        const id = $('#edit_satuan_id').val();

        $.ajax({
            url: `/satuan/${id}`, // Changed from `/api/satuan/${id}`
            type: 'POST',
            data: form.serialize() + '&_method=PUT',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('#editSatuanModal').modal('hide');
                    showSuccessAlert(response.message);
                    loadSatuanData();
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

    // Delete satuan - Updated endpoint
    function deleteSatuan(id) {
        $.ajax({
            url: `/satuan/${id}`, // Changed from `/api/satuan/${id}`
            type: 'POST',
            data: {
                _method: 'DELETE',
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    showSuccessAlert(response.message);
                    loadSatuanData();
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

    // ... (keep the rest of your existing helper functions)
});
</script>
@endsection