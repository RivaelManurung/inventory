@extends('layouts.app')

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
                            <form action="{{ url('/satuan') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" placeholder="Cari satuan..." value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if($satuan->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Satuan</th>
                                        <th>Nama Satuan</th>
                                        <th>Deskripsi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($satuan as $key => $item)
                                    <tr>
                                        <td>{{ $satuan->firstItem() + $key }}</td>
                                        <td>{{ $item->kode }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->deskripsi ?? '-' }}</td>
                                        <td>
                                            <span class="badge badge-{{ $item->status == 'Aktif' ? 'success' : 'danger' }}">
                                                {{ $item->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-warning edit-satuan" 
                                                data-id="{{ $item->id }}"
                                                data-kode="{{ $item->kode }}"
                                                data-nama="{{ $item->nama }}"
                                                data-deskripsi="{{ $item->deskripsi }}"
                                                data-status="{{ $item->status }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('satuan.destroy', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger confirm-delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <p>Menampilkan {{ $satuan->firstItem() }} sampai {{ $satuan->lastItem() }} dari {{ $satuan->total() }} data</p>
                            </div>
                            <div class="col-md-6">
                                <div class="float-right">
                                    {{ $satuan->links() }}
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info">
                            Tidak ada data satuan ditemukan.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

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
            <form action="{{ route('satuan.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kode">Kode Satuan</label>
                        <input type="text" class="form-control" id="kode" name="kode" required>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama Satuan</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="statusAktif" value="Aktif" checked>
                                <label class="form-check-label" for="statusAktif">Aktif</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="statusNonaktif" value="Nonaktif">
                                <label class="form-check-label" for="statusNonaktif">Nonaktif</label>
                            </div>
                        </div>
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
            <form id="editSatuanForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_kode">Kode Satuan</label>
                        <input type="text" class="form-control" id="edit_kode" name="kode" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_nama">Nama Satuan</label>
                        <input type="text" class="form-control" id="edit_nama" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_deskripsi">Deskripsi</label>
                        <textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="edit_statusAktif" value="Aktif">
                                <label class="form-check-label" for="edit_statusAktif">Aktif</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="edit_statusNonaktif" value="Nonaktif">
                                <label class="form-check-label" for="edit_statusNonaktif">Nonaktif</label>
                            </div>
                        </div>
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
    // Edit Satuan Modal
    $('.edit-satuan').click(function() {
        var id = $(this).data('id');
        var kode = $(this).data('kode');
        var nama = $(this).data('nama');
        var deskripsi = $(this).data('deskripsi');
        var status = $(this).data('status');

        $('#edit_kode').val(kode);
        $('#edit_nama').val(nama);
        $('#edit_deskripsi').val(deskripsi);
        
        if(status === 'Aktif') {
            $('#edit_statusAktif').prop('checked', true);
        } else {
            $('#edit_statusNonaktif').prop('checked', true);
        }

        $('#editSatuanForm').attr('action', '/satuan/' + id);
        $('#editSatuanModal').modal('show');
    });

    // Delete Confirmation
    $('.confirm-delete').click(function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        
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
                form.submit();
            }
        });
    });

    // Show success message
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Sukses!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif
});
</script>
@endsection