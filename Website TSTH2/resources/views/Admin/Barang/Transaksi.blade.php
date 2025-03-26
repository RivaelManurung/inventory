@extends('Master.Layout.app')
@section('title', 'Transaksi Barang')

@section('content')
<main>
    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">Data Barang</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-gray">Master Data</li>
                <li class="breadcrumb-item active" aria-current="page">Barang</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->
    
    <!-- ROW -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h3 class="card-title">Data Barang</h3>
                    <div>
                        <a class="modal-effect btn btn-primary-light" onclick="generateID()"
                            data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#modaldemo8">Tambah Data <i
                                class="fe fe-plus"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-1"
                            class="table table-bordered text-nowrap border-bottom dataTable no-footer dtr-inline collapsed">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0" width="1%">No</th>
                                    <th class="border-bottom-0">Gambar</th>
                                    <th class="border-bottom-0">Barcode</th>
                                    <th class="border-bottom-0">Kode Barang</th>
                                    <th class="border-bottom-0">Nama Barang</th>
                                    <th class="border-bottom-0">Jenis</th>
                                    <th class="border-bottom-0">Satuan</th>
                                    <th class="border-bottom-0">Gudang</th>
                                    <th class="border-bottom-0">Stok</th>
                                    <th class="border-bottom-0">Harga</th>
                                    <th class="border-bottom-0" width="1%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $barang = [
                                        [
                                            'gambar' => 'assets/images/barang1.jpg',
                                            'barcode' => 'assets/images/barcode1.png',
                                            'barcode_html' => '<img src="assets/images/barcode1.png" width="50">',
                                            'kode' => 'BRG001',
                                            'nama' => 'Beras Premium',
                                            'jenis' => 'Makanan',
                                            'satuan' => 'Karung',
                                            'gudang' => 'Gudang Utama',
                                            'stok' => 100,
                                            'harga' => 150000
                                        ],
                                        [
                                            'gambar' => 'assets/images/barang2.jpg',
                                            'barcode' => 'assets/images/barcode2.png',
                                            'barcode_html' => '<img src="assets/images/barcode2.png" width="50">',
                                            'kode' => 'BRG002',
                                            'nama' => 'Minyak Goreng',
                                            'jenis' => 'Minuman',
                                            'satuan' => 'Liter',
                                            'gudang' => 'Gudang Cabang',
                                            'stok' => 50,
                                            'harga' => 20000
                                        ]
                                    ];
                                @endphp

                                @foreach($barang as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <img src="{{ asset($item['gambar']) }}" alt="Gambar Barang" width="50">
                                    </td>
                                    <td>{!! $item['barcode_html'] !!}</td>
                                    <td>{{ $item['kode'] }}</td>
                                    <td>{{ $item['nama'] }}</td>
                                    <td>{{ $item['jenis'] }}</td>
                                    <td>{{ $item['satuan'] }}</td>
                                    <td>{{ $item['gudang'] }}</td>
                                    <td>{{ $item['stok'] }}</td>
                                    <td>{{ number_format($item['harga'], 0, ',', '.') }}</td>
                                    <td>
                                        <a class="btn btn-info" onclick="update({{ json_encode($item) }})">Edit</a>
                                        <a class="btn btn-danger" onclick="hapus({{ json_encode($item) }})">Delete</a>
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
</main>

<script>
    function generateID() {
        alert("ID baru telah dibuat!");
    }

    function update(item) {
        alert("Edit data: " + item.nama);
    }

    function hapus(item) {
        if (confirm("Apakah Anda yakin ingin menghapus " + item.nama + "?")) {
            alert("Data telah dihapus.");
        }
    }
</script>
@endsection
