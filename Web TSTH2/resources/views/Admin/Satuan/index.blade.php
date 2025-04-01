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

@push('styles')
<style>
    /* Custom table styling */
    #satuanTable_wrapper .dataTables_filter input {
        border-radius: 5px;
        padding: 5px 10px;
        border: 1px solid #ddd;
    }
    #satuanTable_wrapper .dataTables_length select {
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
        $('#satuanTable').DataTable({
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
    <div class="modal fade" id="formAddSatuan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Satuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('satuan.create') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Satuan <span class="text-danger">*</span></label>
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
    @foreach ($satuans as $satuan)
        {{-- View Modal --}}
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

        {{-- Edit Modal --}}
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
                                <input type="text" class="form-control" name="nama" value="{{ $satuan->satuan_nama }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keterangan</label>
                                <textarea class="form-control" name="keterangan" rows="3">{{ $satuan->satuan_keterangan }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Delete Modal --}}
        <div class="modal fade" id="formDeleteSatuan{{ $satuan->satuan_id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Hapus satuan "{{ $satuan->satuan_nama }}"?</p>
                        <form method="POST" action="{{ route('satuan.destroy', $satuan->satuan_id) }}">
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
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#formDeleteSatuan{{ $satuan->satuan_id }}" title="Hapus">
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