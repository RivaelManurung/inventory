@extends('Master.Layout.app')

@section('title')
Barang
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
    #barangTable_wrapper .dataTables_filter input {
        border-radius: 5px;
        padding: 5px 10px;
        border: 1px solid #ddd;
    }

    #barangTable_wrapper .dataTables_length select {
        border-radius: 5px;
        padding: 5px;
        border: 1px solid #ddd;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }

    .badge-sekali_pakai {
        background-color: #f44336;
        color: white;
    }

    .badge-berulang {
        background-color: #4CAF50;
        color: white;
    }
</style>
@endpush

@push('resource')
<script>
    $(document).ready(function() {
        $('#barangTable').DataTable({
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
<!-- Create Modal -->
<div class="modal fade" id="formAddBarang" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('barang.create') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Barang <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('barang_kode') is-invalid @enderror"
                            name="barang_kode" value="{{ old('barang_kode') }}" required>
                        @error('barang_kode')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('barang_nama') is-invalid @enderror"
                            name="barang_nama" value="{{ old('barang_nama') }}" required>
                        @error('barang_nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('barang_harga') is-invalid @enderror"
                            name="barang_harga" value="{{ old('barang_harga') }}" required>
                        @error('barang_harga')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Satuan <span class="text-danger">*</span></label>
                        <select class="form-select @error('satuan_id') is-invalid @enderror" name="satuan_id" required>
                            <option value="">Pilih Satuan</option>
                            @foreach($satuans as $satuan)
                            <option value="{{ $satuan->satuan_id }}" {{ old('satuan_id')==$satuan->satuan_id ?
                                'selected' : '' }}>
                                {{ $satuan->satuan_nama }}
                            </option>
                            @endforeach
                        </select>
                        @error('satuan_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Barang <span class="text-danger">*</span></label>
                        <select class="form-select @error('jenisbarang_id') is-invalid @enderror" name="jenisbarang_id"
                            required>
                            <option value="">Pilih Jenis Barang</option>
                            @foreach($jenisBarangs as $jenisBarang)
                            <option value="{{ $jenisBarang->jenis_barang_id }}" {{ old('jenisbarang_id')==$jenisBarang->
                                jenis_barang_id ? 'selected' : '' }}>
                                {{ $jenisBarang->jenisbarang_nama }}
                            </option>
                            @endforeach
                        </select>
                        @error('jenisbarang_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Klasifikasi <span class="text-danger">*</span></label>
                        <select class="form-select @error('klasifikasi_barang') is-invalid @enderror"
                            name="klasifikasi_barang" required>
                            <option value="">Pilih Klasifikasi</option>
                            <option value="sekali_pakai" {{ old('klasifikasi_barang')=='sekali_pakai' ? 'selected' : ''
                                }}>Sekali Pakai</option>
                            <option value="berulang" {{ old('klasifikasi_barang')=='berulang' ? 'selected' : '' }}>
                                Berulang</option>
                        </select>
                        @error('klasifikasi_barang')
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

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Barang</h5>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#formAddBarang">
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
            <table id="barangTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Satuan</th>
                        <th>Jenis Barang</th>
                        <th>Klasifikasi</th>
                        <th>Dibuat Pada</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barangs as $key => $barang)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $barang->barang_kode }}</td>
                        <td>{{ $barang->barang_nama }}</td>
                        <td>Rp {{ number_format($barang->barang_harga, 0, ',', '.') }}</td>
                        <td>{{ $barang->satuan->satuan_nama ?? '-' }}</td>
                        <td>{{ $barang->jenisBarang->jenisbarang_nama ?? '-' }}</td>
                        <td>
                            <span
                                class="badge {{ $barang->klasifikasi_barang == 'sekali_pakai' ? 'badge-sekali_pakai' : 'badge-berulang' }}">
                                {{ $barang->klasifikasi_barang == 'sekali_pakai' ? 'Sekali Pakai' : 'Berulang' }}
                            </span>
                        </td>
                        <td>{{ $barang->created_at }}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                    data-bs-target="#detailBarang{{ $barang->barang_id }}" title="Detail">
                                    <i class="ph-eye"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#updateBarang{{ $barang->barang_id }}" title="Edit">
                                    <i class="ph-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#formDeleteBarang{{ $barang->barang_id }}" title="Hapus">
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

<!-- Detail Modals -->
@foreach ($barangs as $barang)
<div class="modal fade" id="detailBarang{{ $barang->barang_id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Kode Barang:</div>
                    <div class="col-md-8">{{ $barang->barang_kode }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Nama Barang:</div>
                    <div class="col-md-8">{{ $barang->barang_nama }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Slug:</div>
                    <div class="col-md-8">{{ Str::slug($barang->barang_nama) }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Harga:</div>
                    <div class="col-md-8">Rp {{ number_format($barang->barang_harga, 0, ',', '.') }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Satuan:</div>
                    <div class="col-md-8">{{ $barang->satuan->satuan_nama ?? '-' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Jenis Barang:</div>
                    <div class="col-md-8">{{ $barang->jenisBarang->jenisbarang_nama ?? '-' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Klasifikasi:</div>
                    <div class="col-md-8">
                        <span
                            class="badge {{ $barang->klasifikasi_barang == 'sekali_pakai' ? 'badge-sekali_pakai' : 'badge-berulang' }}">
                            {{ $barang->klasifikasi_barang == 'sekali_pakai' ? 'Sekali Pakai' : 'Berulang' }}
                        </span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Dibuat Pada:</div>
                    <div class="col-md-8">{{ $barang->created_at }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Terakhir Diupdate:</div>
                    <div class="col-md-8">{{ $barang->updated_at }}</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="updateBarang{{ $barang->barang_id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('barang.update', $barang->barang_id) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Barang <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('barang_kode') is-invalid @enderror"
                            name="barang_kode" value="{{ old('barang_kode', $barang->barang_kode) }}" required>
                        @error('barang_kode')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('barang_nama') is-invalid @enderror"
                            name="barang_nama" value="{{ old('barang_nama', $barang->barang_nama) }}" required>
                        @error('barang_nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('barang_harga') is-invalid @enderror"
                            name="barang_harga" value="{{ old('barang_harga', $barang->barang_harga) }}" required>
                        @error('barang_harga')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Satuan <span class="text-danger">*</span></label>
                        <select class="form-select @error('satuan_id') is-invalid @enderror" name="satuan_id" required>
                            <option value="">Pilih Satuan</option>
                            @foreach($satuans as $satuan)
                            {{ $barang->satuan_id ?? 'N/A' }}

                            <!-- For select options in edit modal -->
                            <option value="{{ $satuan->satuan_id }}" {{ (old('satuan_id', $barang->satuan_id ?? null) ==
                                $satuan->satuan_id) ? 'selected' : '' }}>
                                {{ $satuan->satuan_nama }}
                            </option>
                            @endforeach
                        </select>
                        @error('satuan_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Barang <span class="text-danger">*</span></label>
                        <select class="form-select @error('jenisbarang_id') is-invalid @enderror" name="jenisbarang_id"
                            required>
                            <option value="">Pilih Jenis Barang</option>
                            @foreach($jenisBarangs as $jenisBarang)
                            <option value="{{ $jenisBarang->jenis_barang_id }}" {{ (old('jenisbarang_id', $barang->
                                jenisbarang_id) == $jenisBarang->jenis_barang_id) ? 'selected' : '' }}>
                                {{ $jenisBarang->jenisbarang_nama }}
                            </option>
                            @endforeach
                        </select>
                        @error('jenisbarang_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Klasifikasi <span class="text-danger">*</span></label>
                        <select class="form-select @error('klasifikasi_barang') is-invalid @enderror"
                            name="klasifikasi_barang" required>
                            <option value="">Pilih Klasifikasi</option>
                            <option value="sekali_pakai" {{ (old('klasifikasi_barang', $barang->klasifikasi_barang) ==
                                'sekali_pakai') ? 'selected' : '' }}>Sekali Pakai</option>
                            <option value="berulang" {{ (old('klasifikasi_barang', $barang->klasifikasi_barang) ==
                                'berulang') ? 'selected' : '' }}>Berulang</option>
                        </select>
                        @error('klasifikasi_barang')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="formDeleteBarang{{ $barang->barang_id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('barang.delete', $barang->barang_id) }}">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus barang <strong>{{ $barang->barang_nama }}</strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection