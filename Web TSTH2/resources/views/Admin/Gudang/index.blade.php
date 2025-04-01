@extends('Master.Layout.app')
@section('title')
    Gudang
@endsection
@section('menu')
    Home
@endsection
@section('icon')
    <i class="ph-warehouse"></i>
@endsection

@push('resource')
<script>
    $(document).ready(function() {
        $('#gudangTable').DataTable();
    });
</script>
@endpush

@section('content')
    {{-- Create Modal --}}
    <div class="modal fade" id="formAddGudang" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Gudang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('gudang.create') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Gudang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- View/Edit/Delete Modals --}}
    @foreach ($gudangs as $gudang)
        {{-- View Modal --}}
        <div class="modal fade" id="detailGudang{{ $gudang->gudang_id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Gudang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Nama:</strong> {{ $gudang->gudang_nama }}</p>
                        <p><strong>Deskripsi:</strong> {{ $gudang->gudang_deskripsi ?? '-' }}</p>
                        <p><strong>Dibuat Pada:</strong> {{ $gudang->created_at }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit Modal --}}
        <div class="modal fade" id="updateGudang{{ $gudang->gudang_id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Gudang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('gudang.update', $gudang->gudang_id) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Nama Gudang <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama" value="{{ $gudang->gudang_nama }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" rows="3">{{ $gudang->gudang_deskripsi }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Delete Modal --}}
        <div class="modal fade" id="formDeleteGudang{{ $gudang->gudang_id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Hapus gudang "{{ $gudang->gudang_nama }}"?</p>
                        <form method="POST" action="{{ route('gudang.delete', $gudang->gudang_id) }}">
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
            <h5 class="mb-0">Data Gudang</h5>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#formAddGudang">
                <i class="ph-plus me-1"></i> Tambah
            </button>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table id="gudangTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gudangs as $key => $gudang)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $gudang->gudang_nama }}</td>
                                <td>{{ $gudang->gudang_deskripsi ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                            data-bs-target="#detailGudang{{ $gudang->gudang_id }}" title="Detail">
                                            <i class="ph-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#updateGudang{{ $gudang->gudang_id }}" title="Edit">
                                            <i class="ph-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#formDeleteGudang{{ $gudang->gudang_id }}" title="Hapus">
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