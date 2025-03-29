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
                            <form action="{{ route('satuan.index') }}" method="GET">
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

                    @if($satuans->count() > 0)
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
                                <tbody>
                                    @foreach($satuans as $key => $satuan)
                                    <tr>
                                        <td>{{ $satuans->firstItem() + $key }}</td>
                                        <td>{{ $satuan->satuan_nama }}</td>
                                        <td>{{ $satuan->satuan_slug }}</td>
                                        <td>{{ $satuan->satuan_keterangan ?? '-' }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning edit-satuan" 
                                                data-id="{{ $satuan->satuan_id }}"
                                                data-nama="{{ $satuan->satuan_nama }}"
                                                data-slug="{{ $satuan->satuan_slug }}"
                                                data-keterangan="{{ $satuan->satuan_keterangan }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('satuan.destroy', $satuan->satuan_id) }}" method="POST" class="d-inline">
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
                                <p>Menampilkan {{ $satuans->firstItem() }} sampai {{ $satuans->lastItem() }} dari {{ $satuans->total() }} data</p>
                            </div>
                            <div class="col-md-6">
                                <div class="float-right">
                                    {{ $satuans->links() }}
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
            <form id="editSatuanForm" method="POST">
                @csrf
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
    // Edit Satuan Modal
    $('.edit-satuan').click(function() {
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        var slug = $(this).data('slug');
        var keterangan = $(this).data('keterangan');

        $('#edit_satuan_nama').val(nama);
        $('#edit_satuan_slug').val(slug);
        $('#edit_satuan_keterangan').val(keterangan);

        $('#editSatuanForm').attr('action', '/admin/satuan/' + id);
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

    // Auto generate slug from nama satuan
    $('#satuan_nama').on('keyup', function() {
        var nama = $(this).val();
        var slug = nama.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
        $('#satuan_slug').val(slug);
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