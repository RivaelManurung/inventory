@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Master Satuan</h2>
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahSatuanModal">Tambah Satuan</button>
    <input type="text" id="searchSatuan" class="form-control mb-3" placeholder="Cari Satuan...">
    <button class="btn btn-secondary mb-3" id="refreshSatuan">Refresh</button>
    <div id="satuanTableContainer"></div>
</div>

<!-- Modal Tambah Satuan -->
<div class="modal fade" id="tambahSatuanModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Satuan</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="tambahSatuanForm">
                    <div class="form-group">
                        <label>Nama Satuan</label>
                        <input type="text" name="satuan_nama" class="form-control" required>
                        <span class="text-danger" id="satuan_nama_error"></span>
                    </div>
                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" name="satuan_slug" class="form-control" required>
                        <span class="text-danger" id="satuan_slug_error"></span>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Satuan -->
<div class="modal fade" id="editSatuanModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Satuan</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editSatuanForm">
                    <input type="hidden" id="edit_satuan_id">
                    <div class="form-group">
                        <label>Nama Satuan</label>
                        <input type="text" id="edit_satuan_nama" class="form-control" required>
                        <span class="text-danger" id="edit_satuan_nama_error"></span>
                    </div>
                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" id="edit_satuan_slug" class="form-control" required>
                        <span class="text-danger" id="edit_satuan_slug_error"></span>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    function loadSatuanData(page = 1, search = '') {
        $.get(`/api/satuan?page=${page}&search=${search}`, function(response) {
            let html = '<table class="table table-bordered">';
            html += '<tr><th>Nama</th><th>Slug</th><th>Aksi</th></tr>';
            response.data.forEach(satuan => {
                html += `<tr>
                            <td>${satuan.nama}</td>
                            <td>${satuan.slug}</td>
                            <td>
                                <button class="btn btn-warning edit-satuan" data-id="${satuan.id}" data-nama="${satuan.nama}" data-slug="${satuan.slug}">Edit</button>
                                <button class="btn btn-danger delete-satuan" data-id="${satuan.id}">Hapus</button>
                            </td>
                         </tr>`;
            });
            html += '</table>';
            $('#satuanTableContainer').html(html);
        });
    }
    
    loadSatuanData();
    setInterval(loadSatuanData, 5000); // Auto refresh setiap 5 detik

    $('#searchSatuan').keyup(function() {
        let search = $(this).val();
        loadSatuanData(1, search);
    });

    $('#refreshSatuan').click(function() {
        loadSatuanData();
    });

    $(document).on('click', '.edit-satuan', function() {
        let satuanId = $(this).data('id');
        let nama = $(this).data('nama');
        let slug = $(this).data('slug');

        $('#edit_satuan_id').val(satuanId);
        $('#edit_satuan_nama').val(nama);
        $('#edit_satuan_slug').val(slug);
        $('#editSatuanModal').modal('show');
    });

    $(document).on('click', '.delete-satuan', function() {
        let satuanId = $(this).data('id');
        if (confirm('Apakah Anda yakin ingin menghapus satuan ini?')) {
            $.ajax({
                url: `/api/satuan/${satuanId}`,
                type: 'DELETE',
                headers: { 'Authorization': 'Bearer ' + localStorage.getItem('jwt_token') },
                success: function(response) {
                    alert('Satuan berhasil dihapus.');
                    loadSatuanData();
                }
            });
        }
    });

    $('#tambahSatuanForm').submit(function(e) {
        e.preventDefault();
        $.post('/api/satuan', $(this).serialize(), function(response) {
            alert('Satuan berhasil ditambahkan.');
            $('#tambahSatuanModal').modal('hide');
            loadSatuanData();
        }).fail(function(xhr) {
            let errors = xhr.responseJSON.errors;
            $('#satuan_nama_error').text(errors.satuan_nama ? errors.satuan_nama[0] : '');
            $('#satuan_slug_error').text(errors.satuan_slug ? errors.satuan_slug[0] : '');
        });
    });

    $('#editSatuanForm').submit(function(e) {
        e.preventDefault();
        let satuanId = $('#edit_satuan_id').val();
        $.ajax({
            url: `/api/satuan/${satuanId}`,
            type: 'PUT',
            data: $(this).serialize(),
            headers: { 'Authorization': 'Bearer ' + localStorage.getItem('jwt_token') },
            success: function(response) {
                alert('Satuan berhasil diperbarui.');
                $('#editSatuanModal').modal('hide');
                loadSatuanData();
            }
        });
    });
});
</script>
@endsection
