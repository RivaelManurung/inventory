@extends('Master.Layout.app')

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title"></h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item text-gray">Master Data</li>
            <li class="breadcrumb-item active" aria-current="page"></li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

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
@endsection
