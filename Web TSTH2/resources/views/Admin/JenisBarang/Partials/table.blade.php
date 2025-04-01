<div class="table-responsive">
    <table class="table table-bordered" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Slug</th>
                <th>Keterangan</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jenisBarangs->data as $key => $jenisBarang)
            <tr data-id="{{ $jenisBarang->jenis_barang_id }}">
                <td>{{ ($jenisBarangs->current_page - 1) * $jenisBarangs->per_page + $key + 1 }}</td>
                <td>{{ $jenisBarang->nama }}</td>
                <td>{{ $jenisBarang->slug }}</td>
                <td>{{ $jenisBarang->keterangan }}</td>
                <td>{{ \Carbon\Carbon::parse($jenisBarang->created_at)->format('d/m/Y H:i') }}</td>
                <td>{{ \Carbon\Carbon::parse($jenisBarang->updated_at)->format('d/m/Y H:i') }}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-success" data-toggle="modal" 
                            data-target="#detailModal{{ $jenisBarang->jenis_barang_id }}">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" 
                            data-target="#editModal{{ $jenisBarang->jenis_barang_id }}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" 
                            data-target="#deleteModal{{ $jenisBarang->jenis_barang_id }}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>