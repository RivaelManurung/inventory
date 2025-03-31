@if($jenisBarangs->hasPages())
<div class="row mt-3">
    <div class="col-md-6">
        <div class="pagination-info">
            Menampilkan {{ $jenisBarangs->firstItem() }} - {{ $jenisBarangs->lastItem() }} dari {{ $jenisBarangs->total() }} data
        </div>
    </div>
    <div class="col-md-6">
        <div class="pagination-links float-right">
            {{ $jenisBarangs->links() }}
        </div>
    </div>
</div>
@endif