@extends('Master.Layout.app')
@section('page-title', 'Data Barang')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
@section('breadcrumb')
    <a href="{{ url('/dashboard') }}" class="breadcrumb-item"><i class="ph-house"></i> Home</a>
    <span class="breadcrumb-item active">Data Barang</span>
@endsection
@section('content')
<!-- ROW -->
<div class="container mt-5">
    <h2 class="mb-4">Data Barang</h2>
    <a href="#" class="btn btn-success mb-3"><i class="bi bi-plus-lg"></i> Tambah Barang</a>
    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Barcode</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Jenis</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <script>
                let barang = [
                    {id: 1, gambar: "https://via.placeholder.com/50", kode: "BRG001", nama: "Beras", jenis: "Makanan", harga: 12000},
                    {id: 2, gambar: "https://via.placeholder.com/50", kode: "BRG002", nama: "Minyak Goreng", jenis: "Sembako", harga: 15000},
                    {id: 3, gambar: "https://via.placeholder.com/50", kode: "BRG003", nama: "Gula Pasir", jenis: "Makanan", harga: 14000},
                ];
                barang.forEach((item, index) => {
                    document.write(`
                        <tr>
                            <td>${index + 1}</td>
                            <td><img src="${item.gambar}" alt="Gambar" width="50"></td>
                            <td><svg id="barcode${item.id}"></svg></td>
                            <td>${item.kode}</td>
                            <td>${item.nama}</td>
                            <td>${item.jenis}</td>
                            <td>Rp${item.harga.toLocaleString()}</td>
                            <td>
                                <button class="btn btn-info"><i class="bi bi-pencil"></i> Edit</button>
                                <button class="btn btn-danger" onclick="confirmDelete(${item.id})"><i class="bi bi-trash"></i> Hapus</button>
                            </td>
                        </tr>
                    `);
                });
            </script>
        </tbody>
    </table>
</div>

<script>
    barang.forEach(item => {
        JsBarcode(`#barcode${item.id}`, item.kode, {
            format: "CODE128",
            width: 1.5,
            height: 40,
            displayValue: false
        });
    });
    function confirmDelete(id) {
        alert("Apakah Anda yakin ingin menghapus barang dengan ID: " + id + "?");
    }
</script>
<!-- END ROW -->
@endsection
{{-- @extends('Master.Layout.app')
@section('page-title', 'Data Barang')
@section('breadcrumb')
    <a href="{{ url('/dashboard') }}" class="breadcrumb-item"><i class="ph-house"></i> Home</a>
    <span class="breadcrumb-item active">Data Barang</span>
@endsection
@section('content')
<!-- ROW -->
<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header justify-content-between">
                <h3 class="card-title">Data</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap border-bottom">
                        <thead>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Barcode</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Jenis</th>
                            <th>Satuan</th>
                            <th>Gudang</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @php
                            $barang = [
                                ['kode' => 'BRG-001', 'nama' => 'Beras', 'jenis' => 'Makanan', 'satuan' => 'Kg', 'gudang' => 'Gudang A', 'stok' => 100, 'harga' => 15000, 'gambar' => 'no_image.png', 'barcode' => '-'],
                                ['kode' => 'BRG-002', 'nama' => 'Minyak Goreng', 'jenis' => 'Makanan', 'satuan' => 'Liter', 'gudang' => 'Gudang B', 'stok' => 50, 'harga' => 20000, 'gambar' => 'no_image.png', 'barcode' => '-'],
                            ];
                            @endphp
                            @foreach($barang as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td><img src="{{ asset('storage/barang/'.$item['gambar']) }}" alt="Gambar" width="50"></td>
                                <td>{!! $item['barcode'] !!}</td>
                                <td>{{ $item['kode'] }}</td>
                                <td>{{ $item['nama'] }}</td>
                                <td>{{ $item['jenis'] }}</td>
                                <td>{{ $item['satuan'] }}</td>
                                <td>{{ $item['gudang'] }}</td>
                                <td>{{ $item['stok'] }}</td>
                                <td>{{ number_format($item['harga'], 0, ',', '.') }}</td>
                                <td>
                                    <a class="btn btn-info">Edit</a>
                                    <a class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END ROW -->
@endsection --}}
