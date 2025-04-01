@extends('Master.Layout.app')

@section('title')
    Jenis Barang
@endsection
@section('menu')
    Home
@endsection
@section('icon')
    <i class="ph-package"></i>
@endsection

@push('styles')
<style>
    /* Custom table styling */
    #jenisBarangTable_wrapper .dataTables_filter input {
        border-radius: 5px;
        padding: 5px 10px;
        border: 1px solid #ddd;
    }
    #jenisBarangTable_wrapper .dataTables_length select {
        border-radius: 5px;
        padding: 5px;
        border: 1px solid #ddd;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
</style>
@endpush

@push('resource')
<script>
    $(document).ready(function() {
        $('#jenisBarangTable').DataTable({
            responsive: true,
            autoWidth: true,
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            }
        });
    });
</script>
@endpush

@section('content')
    {{-- Create Modal --}}
    <div class="modal fade" id="formAddJenisBarang" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jenis Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('jenis-barang.create') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Jenis Barang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control" name="keterangan" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- View/Edit/Delete Modals --}}
    @foreach ($jenisBarangs as $jenisBarang)
        {{-- View Modal --}}
        <div class="modal fade" id="detailJenisBarang{{ $jenisBarang->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Jenis Barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Nama:</strong> {{ $jenisBarang->nama }}</p>
                        <p><strong>Keterangan:</strong> {{ $jenisBarang->keterangan ?? '-' }}</p>
                        <p><strong>Dibuat Pada:</strong> {{ $jenisBarang->created_at }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit Modal --}}
        <div class="modal fade" id="updateJenisBarang{{ $jenisBarang->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Jenis Barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('jenis-barang.update', $jenisBarang->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Nama Jenis Barang <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama" value="{{ $jenisBarang->nama }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keterangan</label>
                                <textarea class="form-control" name="keterangan" rows="3">{{ $jenisBarang->keterangan }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Delete Modal --}}
        <div class="modal fade" id="formDeleteJenisBarang{{ $jenisBarang->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Hapus jenis barang "{{ $jenisBarang->nama }}"?</p>
                        <form method="POST" action="{{ route('jenis-barang.delete', $jenisBarang->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Main Content --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Jenis Barang</h5>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#formAddJenisBarang">
                <i class="ph-plus me-1"></i> Tambah
            </button>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table id="jenisBarangTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>Keterangan</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jenisBarangs as $key => $jenisBarang)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $jenisBarang->nama }}</td>
                                <td>{{ $jenisBarang->keterangan ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                            data-bs-target="#detailJenisBarang{{ $jenisBarang->id }}" title="Detail">
                                            <i class="ph-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#updateJenisBarang{{ $jenisBarang->id }}" title="Edit">
                                            <i class="ph-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#formDeleteJenisBarang{{ $jenisBarang->id }}" title="Hapus">
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