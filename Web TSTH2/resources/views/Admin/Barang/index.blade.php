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
    {{-- Create Modal --}}
    <div class="modal fade" id="formAddBarang" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('barang.create') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="barang_nama" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="barang_harga" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Satuan <span class="text-danger">*</span></label>
                            <select class="form-select" name="satuan_id" required>
                                @foreach($satuans as $satuan)
                                    <option value="{{ $satuan->satuan_id }}">{{ $satuan->satuan_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Barang <span class="text-danger">*</span></label>
                            <select class="form-select" name="jenisbarang_id" required>
                                @foreach($jenisBarangs as $jenisBarang)
                                    <option value="{{ $jenisBarang->jenis_barang_id }}">{{ $jenisBarang->jenisbarang_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Klasifikasi <span class="text-danger">*</span></label>
                            <select class="form-select" name="klasifikasi_barang" required>
                                <option value="sekali_pakai">Sekali Pakai</option>
                                <option value="berulang">Berulang</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- View/Edit/Delete Modals --}}
    @foreach ($barangs as $barang)
        {{-- View Modal --}}
        <div class="modal fade" id="detailBarang{{ $barang->barang_id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Nama:</strong> {{ $barang->barang_nama }}</p>
                        <p><strong>Harga:</strong> Rp {{ number_format($barang->barang_harga, 0, ',', '.') }}</p>
                        <p><strong>Satuan:</strong> {{ $barang->satuan->satuan_nama ?? '-' }}</p>
                        <p><strong>Jenis Barang:</strong> {{ $barang->jenisBarang->jenisbarang_nama ?? '-' }}</p>
                        <p><strong>Klasifikasi:</strong> {{ $barang->klasifikasi_barang == 'sekali_pakai' ? 'Sekali Pakai' : 'Berulang' }}</p>
                        <p><strong>Dibuat Pada:</strong> {{ $barang->created_at }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit Modal --}}
        <div class="modal fade" id="updateBarang{{ $barang->barang_id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('barang.update', $barang->barang_id) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="barang_nama" value="{{ $barang->barang_nama }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Harga <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="barang_harga" value="{{ $barang->barang_harga }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Satuan <span class="text-danger">*</span></label>
                                <select class="form-select" name="satuan_id" required>
                                    @foreach($satuans as $satuan)
                                        <option value="{{ $satuan->satuan_id }}" {{ $satuan->satuan_id == $barang->satuan_id ? 'selected' : '' }}>
                                            {{ $satuan->satuan_nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Barang <span class="text-danger">*</span></label>
                                <select class="form-select" name="jenisbarang_id" required>
                                    @foreach($jenisBarangs as $jenisBarang)
                                        <option value="{{ $jenisBarang->jenis_barang_id }}" {{ $jenisBarang->jenis_barang_id == $barang->jenisbarang_id ? 'selected' : '' }}>
                                            {{ $jenisBarang->jenisbarang_nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Klasifikasi <span class="text-danger">*</span></label>
                                <select class="form-select" name="klasifikasi_barang" required>
                                    <option value="sekali_pakai" {{ $barang->klasifikasi_barang == 'sekali_pakai' ? 'selected' : '' }}>Sekali Pakai</option>
                                    <option value="berulang" {{ $barang->klasifikasi_barang == 'berulang' ? 'selected' : '' }}>Berulang</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Delete Modal --}}
        <div class="modal fade" id="formDeleteBarang{{ $barang->barang_id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Hapus barang "{{ $barang->barang_nama }}"?</p>
                        <form method="POST" action="{{ route('barang.delete', $barang->barang_id) }}">
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
            <h5 class="mb-0">Data Barang</h5>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#formAddBarang">
                <i class="ph-plus me-1"></i> Tambah
            </button>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table id="barangTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Satuan</th>
                            <th>Jenis Barang</th>
                            <th>Klasifikasi</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barangs as $key => $barang)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $barang->barang_nama }}</td>
                                <td>Rp {{ number_format($barang->barang_harga, 0, ',', '.') }}</td>
                                <td>{{ $barang->satuan->satuan_nama ?? '-' }}</td>
                                <td>{{ $barang->jenisBarang->jenisbarang_nama ?? '-' }}</td>
                                <td>{{ $barang->klasifikasi_barang == 'sekali_pakai' ? 'Sekali Pakai' : 'Berulang' }}</td>
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
@endsection