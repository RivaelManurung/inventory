@extends('Master.Layout.app')

@section('content')
<!-- CSS Libraries -->
<link href="{{ asset('assets_inven/plugins/datatable/css/dataTables.bootstrap5.css') }}" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0">Barang Keluar</h5>
                    <div class="d-flex">
                        <div class="input-group input-group-sm me-2" style="width: 150px;">
                            <span class="input-group-text">Show</span>
                            <select class="form-select" id="entriesSelect">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahModal">
                            <i class="fas fa-plus me-1"></i> Tambah
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="dataTable">
                            <thead class="bg-light">
                                <tr>
                                    <th width="50">NO</th>
                                    <th>TANGGAL KELUAR</th>
                                    <th>KODE BARANG KELUAR</th>
                                    <th>KODE BARANG</th>
                                    <th>BARANG</th>
                                    <th>JUNLAH KELUAR</th>
                                    <th>TUJUAN</th>
                                    <th width="100">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data Statis 1 -->
                                <tr>
                                    <td>1</td>
                                    <td>02 November 2022</td>
                                    <td>BK-1669812439198</td>
                                    <td>BRG-1669390175622</td>
                                    <td>Motherboard</td>
                                    <td>30</td>
                                    <td>Gudang Prindapan</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                
                                <!-- Data Statis 2 -->
                                <tr>
                                    <td>2</td>
                                    <td>01 November 2022</td>
                                    <td>BK-1669811950758</td>
                                    <td>BRG-1669390220236</td>
                                    <td>Baut 24mm</td>
                                    <td>20</td>
                                    <td>Gudang Tasikmalaya</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Showing 1 to 2 of 2 entries
                    </div>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Previous</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item disabled">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript Libraries -->
<script src="{{ asset('assets_inven/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets_inven/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets_inven/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets_inven/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>

<script>
    $(document).ready(function() {
        // Inisialisasi DataTables dengan konfigurasi minimal
        $('#dataTable').DataTable({
            searching: true,
            paging: true,
            info: false,
            lengthChange: false,
            language: {
                search: "",
                searchPlaceholder: "Cari..."
            },
            dom: '<"top"f>rt<"bottom"p>'
        });

        // Handler untuk select entries
        $('#entriesSelect').change(function() {
            $('#dataTable').DataTable().page.len($(this).val()).draw();
        });
    });
</script>
@endsection