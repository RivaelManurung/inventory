class SatuanModel {
  int? satuanId;
  String? satuanNama;

  SatuanModel({this.satuanId, this.satuanNama});

  factory SatuanModel.fromJson(Map<String, dynamic> json) {
    return SatuanModel(
      satuanId: json['satuan_id'],
      satuanNama: json['satuan_nama'],
    );
  }
}