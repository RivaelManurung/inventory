import 'package:inventory_tsth2/Model/gudangModel.dart';
import 'package:inventory_tsth2/Model/jenisbarangModel.dart';
import 'package:inventory_tsth2/Model/satuanModel.dart';

class BarangModel {
  int barangId;
  String barangKode;
  String barangNama;
  String barangHarga;
  String barangStok;
  String barangGambar;
  String barcodeUrl;
  JenisBarangModel? jenisBarang; 
  SatuanModel? satuan; 
  GudangModel? gudang; 

  BarangModel({
    required this.barangId,
    required this.barangKode,
    required this.barangNama,
    required this.barangHarga,
    required this.barangStok,
    required this.barangGambar,
    required this.barcodeUrl,
    this.jenisBarang, 
    this.satuan, 
    this.gudang, 
  });

  factory BarangModel.fromJson(Map<String, dynamic> json) {
    return BarangModel(
      barangId: json['barang_id'] ?? 0,
      barangKode: json['barang_kode'] ?? '',
      barangNama: json['barang_nama'] ?? '',
      barangHarga: json['barang_harga'] ?? '0',
      barangStok: json['barang_stok'] ?? '0',
      barangGambar: json['barang_gambar'] ?? '',
      barcodeUrl: json['barcodeUrl'] ?? '',
      jenisBarang: json['jenis_barang'] != null
          ? JenisBarangModel.fromJson(json['jenis_barang'])
          : null, // Bisa null
      satuan: json['satuan'] != null ? SatuanModel.fromJson(json['satuan']) : null,
      gudang: json['gudang'] != null ? GudangModel.fromJson(json['gudang']) : null,
    );
  }
}
