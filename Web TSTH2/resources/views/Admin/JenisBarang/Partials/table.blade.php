<table class="table table-bordered" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Jenis Barang</th>
            <th>Slug</th>
            <th>Keterangan</th>
            <th>Dibuat Pada</th>
            <th>Diperbarui Pada</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($jenisBarangs as $index => $jenisBarang)
        <tr>
            <td>{{ ($jenisBarangs->currentPage() - 1) * $jenisBarangs->perPage() + $index + 1 }}</td>
            <td>{{ $jenisBarang->nama }}</td>
            <td>{{ $jenisBarang->slug }}</td>
            <td>{{ $jenisBarang->keterangan ?? '-' }}</td>
            <td>{{ \Carbon\Carbon::parse($jenisBarang->created_at)->format('d/m/Y H:i') }}</td>
            <td>{{ \Carbon\Carbon::parse($jenisBarang->updated_at)->format('d/m/Y H:i') }}</td>
            <td class="text-center">
                <a href="{{ route('jenis-barang.show', $jenisBarang->jenis_barang_id) }}" class="btn btn-info btn-sm">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('jenis-barang.edit', $jenisBarang->jenis_barang_id) }}"
                    class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('jenis-barang.destroy', $jenisBarang->jenis_barang_id) }}" method="POST"
                    style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"
                        onclick="return confirm('Apakah Anda yakin ingin menghapus?')">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center">Tidak ada data jenis barang</td>
        </tr>
        @endforelse
    </tbody>
</table>