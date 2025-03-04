class JenisBarangModel {
  int jenisBarangId;
  String jenisBarangNama;
  String jenisBarangSlug;

  JenisBarangModel({
    required this.jenisBarangId,
    required this.jenisBarangNama,
    required this.jenisBarangSlug,
  });

  factory JenisBarangModel.fromJson(Map<String, dynamic> json) {
    return JenisBarangModel(
      jenisBarangId: json['jenisbarang_id'] ?? 0,
      jenisBarangNama: json['jenisbarang_nama'] ?? '',
      jenisBarangSlug: json['jenisbarang_slug'] ?? '',
    );
  }
}




