@extends('Master.Layout.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Satuan</h6>
            <a href="{{ route('satuan.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Satuan
            </a>
        </div>
        <div class="card-body">
            <!-- Search and pagination controls (same as before) -->
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Satuan</th>
                            <th>Slug</th>
                            <th>Keterangan</th>
                            <th>Dibuat Pada</th>
                            <th>Diperbarui Pada</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($satuans) && count($satuans) > 0)
                        @foreach($satuans as $index => $satuan)
                        <tr>
                            <td>{{ (($pagination['current_page'] ?? 1) - 1) * ($pagination['per_page'] ?? 10) + $index +
                                1 }}</td>
                            <td>{{ $satuan->satuan_nama }}</td>
                            <td>{{ $satuan->satuan_slug }}</td>
                            <td>{{ $satuan->satuan_keterangan ?? '-' }}</td>
                            <td>{{ $satuan->created_at }}</td>
                            <td>{{ $satuan->updated_at }}</td>
                            <td>
                                <a href="{{ route('satuan.show', $satuan->satuan_id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                                <a href="{{ route('satuan.edit', $satuan->satuan_id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('satuan.destroy', $satuan->satuan_id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data satuan</td>
                        </tr>
                        @endif
                    </tbody>
                </table>

                <!-- Pagination (same as before) -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<!-- Add Font Awesome CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection