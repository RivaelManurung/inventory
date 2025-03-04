class GudangModel {
  int? gudangId;
  String? gudangNama;

  GudangModel({this.gudangId, this.gudangNama});

  factory GudangModel.fromJson(Map<String, dynamic> json) {
    return GudangModel(
      gudangId: json['gudang_id'],
      gudangNama: json['gudang_nama'],
    );
  }
}