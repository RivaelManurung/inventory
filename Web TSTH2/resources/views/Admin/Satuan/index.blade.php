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
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahSatuanModal">
                            <i class="fas fa-plus"></i> Tambah Satuan
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form id="searchForm">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="searchInput" placeholder="Cari satuan..." value="{{ request('search') }}">
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
                                    <i class="fas fa-stop-circle"></i> Stop Auto-Refresh
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
                        <!-- Table content will be loaded here via AJAX -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include your modals here -->
<!-- Tambah Satuan Modal -->
<div class="modal fade" id="tambahSatuanModal" tabindex="-1" role="dialog" aria-labelledby="tambahSatuanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahSatuanModalLabel">Tambah Satuan Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="tambahSatuanForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="satuan_nama">Nama Satuan</label>
                        <input type="text" class="form-control" id="satuan_nama" name="satuan_nama" required>
                    </div>
                    <div class="form-group">
                        <label for="satuan_slug">Slug</label>
                        <input type="text" class="form-control" id="satuan_slug" name="satuan_slug" required>
                    </div>
                    <div class="form-group">
                        <label for="satuan_keterangan">Keterangan</label>
                        <textarea class="form-control" id="satuan_keterangan" name="satuan_keterangan" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Satuan Modal -->
<div class="modal fade" id="editSatuanModal" tabindex="-1" role="dialog" aria-labelledby="editSatuanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSatuanModalLabel">Edit Satuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editSatuanForm">
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_satuan_nama">Nama Satuan</label>
                        <input type="text" class="form-control" id="edit_satuan_nama" name="satuan_nama" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_satuan_slug">Slug</label>
                        <input type="text" class="form-control" id="edit_satuan_slug" name="satuan_slug" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_satuan_keterangan">Keterangan</label>
                        <textarea class="form-control" id="edit_satuan_keterangan" name="satuan_keterangan" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    let lastUpdate = null;
    let currentPage = 1;
    let currentSearch = '';
    let pollingInterval = 5000; // 5 detik
    let pollingTimer;
    let isPollingActive = true;

    // Load initial data
    loadSatuanData();

    // Handle search form submission
    $('#searchForm').on('submit', function(e) {
        e.preventDefault();
        currentPage = 1;
        loadSatuanData();
    });

    // Handle refresh button click
    $('#refreshBtn').click(function() {
        loadSatuanData();
    });

    // Handle polling toggle button
    $('#pollingToggle').click(function() {
        isPollingActive = !isPollingActive;
        if (isPollingActive) {
            $(this).html('<i class="fas fa-stop-circle"></i> Stop Auto-Refresh');
            $(this).removeClass('btn-success').addClass('btn-outline-secondary');
            loadSatuanData();
        } else {
            $(this).html('<i class="fas fa-play-circle"></i> Start Auto-Refresh');
            $(this).removeClass('btn-outline-secondary').addClass('btn-success');
            clearTimeout(pollingTimer);
        }
    });

    // Function to load satuan data via AJAX
    function loadSatuanData(page = 1, search = '') {
        if (!isPollingActive) return;

        clearTimeout(pollingTimer);
        
        $('#loadingIndicator').show();
        $('#satuanTableContainer').hide();

        currentPage = page;
        currentSearch = $('#searchInput').val() || search;

        $.ajax({
            url: '/api/satuan/updates',
            type: 'GET',
            data: {
                page: currentPage,
                search: currentSearch,
                last_update: lastUpdate
            },
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('jwt_token')
            },
            success: function(response) {
                if (response.success) {
                    lastUpdate = response.last_update;
                    renderSatuanTable(response);
                } else {
                    showErrorAlert(response.message || 'Gagal memuat data satuan');
                }
                
                // Schedule next poll
                if (isPollingActive) {
                    scheduleNextPoll();
                }
            },
            error: function(xhr) {
                let errorMessage = 'Terjadi kesalahan saat memuat data';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                showErrorAlert(errorMessage);
                
                // Schedule next poll with backoff
                if (isPollingActive) {
                    scheduleNextPollWithBackoff();
                }
            },
            complete: function() {
                $('#loadingIndicator').hide();
                $('#satuanTableContainer').show();
            }
        });
    }

    // Schedule next poll
    function scheduleNextPoll() {
        clearTimeout(pollingTimer);
        pollingTimer = setTimeout(function() {
            loadSatuanData(currentPage, currentSearch);
        }, pollingInterval);
    }

    // Schedule next poll with exponential backoff
    let errorCount = 0;
    function scheduleNextPollWithBackoff() {
        clearTimeout(pollingTimer);
        errorCount++;
        let delay = Math.min(pollingInterval * Math.pow(2, errorCount), 300000); // Max 5 minutes
        
        pollingTimer = setTimeout(function() {
            loadSatuanData(currentPage, currentSearch);
        }, delay);
    }

    // Function to render satuan table
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

        if (response.data.length > 0) {
            response.data.forEach((satuan, index) => {
                html += `
                    <tr>
                        <td>${response.meta.from + index}</td>
                        <td>${satuan.satuan_nama}</td>
                        <td>${satuan.satuan_slug}</td>
                        <td>${satuan.satuan_keterangan || '-'}</td>
                        <td>
                            <button class="btn btn-sm btn-warning edit-satuan" 
                                data-id="${satuan.satuan_id}"
                                data-nama="${satuan.satuan_nama}"
                                data-slug="${satuan.satuan_slug}"
                                data-keterangan="${satuan.satuan_keterangan || ''}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-satuan" data-id="${satuan.satuan_id}">
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
        if (response.meta.last_page > 1) {
            html += `<div class="row">
                <div class="col-md-6">
                    <p>Menampilkan ${response.meta.from} sampai ${response.meta.to} dari ${response.meta.total} data</p>
                </div>
                <div class="col-md-6">
                    <div class="float-right">
                        <nav>
                            <ul class="pagination">`;

            // Previous page link
            if (response.meta.current_page > 1) {
                html += `<li class="page-item">
                    <a class="page-link" href="#" onclick="return loadPageData(${response.meta.current_page - 1})">Previous</a>
                </li>`;
            }

            // Page links
            for (let i = 1; i <= response.meta.last_page; i++) {
                html += `<li class="page-item ${response.meta.current_page === i ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="return loadPageData(${i})">${i}</a>
                </li>`;
            }

            // Next page link
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

    // Global function for pagination
    window.loadPageData = function(page) {
        loadSatuanData(page);
        return false;
    }

    // Initialize event handlers for dynamic elements
    function initializeEventHandlers() {
        // Edit button handler
        $('.edit-satuan').click(function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            var slug = $(this).data('slug');
            var keterangan = $(this).data('keterangan');

            $('#edit_satuan_nama').val(nama);
            $('#edit_satuan_slug').val(slug);
            $('#edit_satuan_keterangan').val(keterangan);

            $('#editSatuanForm').attr('action', '/api/satuans/' + id);
            $('#editSatuanModal').modal('show');
        });

        // Delete button handler
        $('.delete-satuan').click(function() {
            var id = $(this).data('id');
            confirmDelete(id);
        });
    }

    // Confirm delete function
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Satuan ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                deleteSatuan(id);
            }
        });
    }

    // Delete satuan via API
    function deleteSatuan(id) {
        $.ajax({
            url: '/api/satuans' + id,
            type: 'DELETE',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('jwt_token'),
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    showSuccessAlert(response.message);
                    loadSatuanData();
                } else {
                    showErrorAlert(response.message || 'Gagal menghapus satuan');
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

    // Handle create form submission
    $('#tambahSatuanForm').on('submit', function(e) {
        e.preventDefault();
        createSatuan($(this));
    });

    // Handle edit form submission
    $('#editSatuanForm').on('submit', function(e) {
        e.preventDefault();
        updateSatuan($(this));
    });

    // Create new satuan
    function createSatuan(form) {
        $.ajax({
            url: '/api/satuan',
            type: 'POST',
            data: form.serialize(),
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('jwt_token'),
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('#tambahSatuanModal').modal('hide');
                    form[0].reset();
                    showSuccessAlert(response.message);
                    loadSatuanData();
                } else {
                    showErrorAlert(response.message || 'Gagal membuat satuan baru');
                }
            },
            error: function(xhr) {
                let errorMessage = 'Terjadi kesalahan saat membuat satuan';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                showErrorAlert(errorMessage);
            }
        });
    }

    // Update satuan
    function updateSatuan(form) {
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize() + '&_method=PUT',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('jwt_token'),
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('#editSatuanModal').modal('hide');
                    showSuccessAlert(response.message);
                    loadSatuanData();
                } else {
                    showErrorAlert(response.message || 'Gagal memperbarui satuan');
                }
            },
            error: function(xhr) {
                let errorMessage = 'Terjadi kesalahan saat memperbarui satuan';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                showErrorAlert(errorMessage);
            }
        });
    }

    // Helper functions for alerts
    function showSuccessAlert(message) {
        Swal.fire({
            icon: 'success',
            title: 'Sukses!',
            text: message,
            timer: 3000,
            showConfirmButton: false
        });
    }

    function showErrorAlert(message) {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: message,
            timer: 3000,
            showConfirmButton: false
        });
    }

    // Auto generate slug from nama satuan
    $('#satuan_nama').on('keyup', function() {
        var nama = $(this).val();
        var slug = nama.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
        $('#satuan_slug').val(slug);
    });

    // When modal is closed, reset error count
    $('.modal').on('hidden.bs.modal', function() {
        errorCount = 0;
    });

    // Adjust polling when tab is not active
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            pollingInterval = 30000; // 30 seconds when tab is inactive
        } else {
            pollingInterval = 5000; // 5 seconds when tab is active
            loadSatuanData(); // Refresh immediately
        }
    });

    // Show success message from session
    @if(session('success'))
        showSuccessAlert('{{ session('success') }}');
    @endif
});
</script>
@endsection