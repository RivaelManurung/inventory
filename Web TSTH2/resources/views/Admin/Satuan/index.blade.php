@extends('Master.Layout.app')
@section('title')
Satuan
@endsection
@section('menu')
Home
@endsection
@section('icon')
<i class="ph-ruler"></i>
@endsection

@push('resource')
<script>
    $(document).ready(function() {
        $('#satuanTable').DataTable();
        
        // Auto close alert after 5 seconds
        setTimeout(function() {
            $('.alert').alert('close');
        }, 5000);
        
        // Delete confirmation
        window.confirmDelete = function(id, name) {
            Swal.fire({
                title: 'Hapus Satuan?',
                text: `Yakin ingin menghapus satuan "${name}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-'+id).submit();
                }
            });
        }
    });
</script>
@endpush

@section('content')
<!-- Alert Notification -->
@include('Master.Layout.alert')

<!-- Create Modal -->
<div class="modal fade" id="formAddSatuan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Satuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('satuan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Satuan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama"
                            value="{{ old('nama') }}" required>
                        @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan"
                            rows="3">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- View/Edit/Delete Modals -->
@foreach ($satuans as $satuan)
<!-- View Modal -->
<div class="modal fade" id="detailSatuan{{ $satuan->satuan_id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Satuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nama:</strong> {{ $satuan->satuan_nama }}</p>
                <p><strong>Keterangan:</strong> {{ $satuan->satuan_keterangan ?? '-' }}</p>
                <p><strong>Dibuat Pada:</strong> {{ $satuan->created_at }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="updateSatuan{{ $satuan->satuan_id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Satuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('satuan.update', $satuan->satuan_id) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nama Satuan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama"
                            value="{{ old('nama', $satuan->satuan_nama) }}" required>
                        @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan"
                            rows="3">{{ old('keterangan', $satuan->satuan_keterangan) }}</textarea>
                        @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Form (hidden) -->
<form id="delete-form-{{ $satuan->satuan_id }}" method="POST"
    action="{{ route('satuan.delete', $satuan->satuan_id) }}">
    @csrf @method('DELETE')
</form>
@endforeach

<!-- Main Content -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Satuan</h5>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#formAddSatuan">
            <i class="ph-plus me-1"></i> Tambah
        </button>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="satuanTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>Keterangan</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($satuans as $key => $satuan)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $satuan->satuan_nama }}</td>
                        <td>{{ $satuan->satuan_keterangan ?? '-' }}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                    data-bs-target="#detailSatuan{{ $satuan->satuan_id }}" title="Detail">
                                    <i class="ph-eye"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#updateSatuan{{ $satuan->satuan_id }}" title="Edit">
                                    <i class="ph-pencil"></i>
                                </button>
                                <button
                                    onclick="confirmDelete('{{ $satuan->satuan_id }}', '{{ $satuan->satuan_nama }}')"
                                    class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="ph-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection