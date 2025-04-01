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

@push('resource')
<script>
    $(document).ready(function() {
        $('#jenisBarangTable').DataTable();
    });
</script>
@endpush

@section('content')
<!-- Create Modal -->
<div class="modal fade" id="formAddJenisBarang" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Jenis Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('jenis-barang.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Jenis Barang <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('jenisbarang_nama') is-invalid @enderror"
                            name="jenisbarang_nama" value="{{ old('jenisbarang_nama') }}" required>
                        @error('jenisbarang_nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control @error('jenisbarang_ket') is-invalid @enderror"
                            name="jenisbarang_ket" rows="3">{{ old('jenisbarang_ket') }}</textarea>
                        @error('jenisbarang_ket')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Main Content --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Jenis Barang</h5>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
            data-bs-target="#formAddJenisBarang">
            <i class="ph-plus me-1"></i> Tambah
        </button>
    </div>

    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="table-responsive">
            <table id="jenisBarangTable" class="display">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>Slug</th>
                        <th>Keterangan</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jenisBarangs as $key => $jenisBarang)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $jenisBarang->jenisbarang_nama }}</td>
                        <td>{{ $jenisBarang->jenisbarang_slug }}</td>
                        <td>{{ $jenisBarang->jenisbarang_ket ?? '-' }}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                    data-bs-target="#detailJenisBarang{{ $jenisBarang->jenis_barang_id }}"
                                    title="Detail">
                                    <i class="ph-eye"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#updateJenisBarang{{ $jenisBarang->jenis_barang_id }}" title="Edit">
                                    <i class="ph-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteJenisBarang{{ $jenisBarang->jenis_barang_id }}"
                                    title="Hapus">
                                    <i class="ph-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Detail Modal --}}
                    <div class="modal fade" id="detailJenisBarang{{ $jenisBarang->jenis_barang_id }}" tabindex="-1"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Detail Jenis Barang</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Nama:</strong> {{ $jenisBarang->jenisbarang_nama }}</p>
                                    <p><strong>Slug:</strong> {{ $jenisBarang->jenisbarang_slug }}</p>
                                    <p><strong>Keterangan:</strong> {{ $jenisBarang->jenisbarang_ket ?? '-' }}</p>
                                    <p><strong>Dibuat Pada:</strong> {{ $jenisBarang->created_at }}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="updateJenisBarang{{ $jenisBarang->jenis_barang_id }}" tabindex="-1"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Jenis Barang</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form method="POST"
                                    action="{{ route('jenis-barang.update', $jenisBarang->jenis_barang_id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Nama Jenis Barang <span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('jenisbarang_nama') is-invalid @enderror"
                                                name="jenisbarang_nama"
                                                value="{{ old('jenisbarang_nama', $jenisBarang->jenisbarang_nama) }}"
                                                required>
                                            @error('jenisbarang_nama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Keterangan</label>
                                            <textarea
                                                class="form-control @error('jenisbarang_ket') is-invalid @enderror"
                                                name="jenisbarang_ket"
                                                rows="3">{{ old('jenisbarang_ket', $jenisBarang->jenisbarang_ket) }}</textarea>
                                            @error('jenisbarang_ket')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Delete Modal --}}
                    <div class="modal fade" id="deleteJenisBarang{{ $jenisBarang->jenis_barang_id }}" tabindex="-1"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form method="POST"
                                    action="{{ route('jenis-barang.destroy', $jenisBarang->jenis_barang_id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-body">
                                        <p>Apakah Anda yakin ingin menghapus jenis barang "{{
                                            $jenisBarang->jenisbarang_nama }}"?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection