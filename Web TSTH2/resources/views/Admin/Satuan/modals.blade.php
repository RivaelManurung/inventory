<!-- Tambah Satuan Modal -->
<div class="modal fade" id="tambahSatuanModal" tabindex="-1" role="dialog" aria-labelledby="tambahSatuanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahSatuanModalLabel">Tambah Satuan Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="tambahSatuanForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="satuan_nama">Nama Satuan *</label>
                        <input type="text" class="form-control" id="satuan_nama" name="satuan_nama" required>
                        <small class="text-danger" id="satuan_nama_error"></small>
                    </div>
                    <div class="form-group">
                        <label for="satuan_slug">Slug *</label>
                        <input type="text" class="form-control" id="satuan_slug" name="satuan_slug" required>
                        <small class="text-danger" id="satuan_slug_error"></small>
                    </div>
                    <div class="form-group">
                        <label for="satuan_keterangan">Keterangan</label>
                        <textarea class="form-control" id="satuan_keterangan" name="satuan_keterangan" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Satuan Modal -->
<div class="modal fade" id="editSatuanModal" tabindex="-1" role="dialog" aria-labelledby="editSatuanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSatuanModalLabel">Edit Satuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editSatuanForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_satuan_id" name="satuan_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_satuan_nama">Nama Satuan *</label>
                        <input type="text" class="form-control" id="edit_satuan_nama" name="satuan_nama" required>
                        <small class="text-danger" id="edit_satuan_nama_error"></small>
                    </div>
                    <div class="form-group">
                        <label for="edit_satuan_slug">Slug *</label>
                        <input type="text" class="form-control" id="edit_satuan_slug" name="satuan_slug" required>
                        <small class="text-danger" id="edit_satuan_slug_error"></small>
                    </div>
                    <div class="form-group">
                        <label for="edit_satuan_keterangan">Keterangan</label>
                        <textarea class="form-control" id="edit_satuan_keterangan" name="satuan_keterangan" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="updateButton">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>