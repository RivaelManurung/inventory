class UserModel {
  final int userId;
  final String roleId;
  final String userNama;
  final String userNamaLengkap;
  final String userEmail;
  final String? userFoto;

  UserModel({
    required this.userId,
    required this.roleId,
    required this.userNama,
    required this.userNamaLengkap,
    required this.userEmail,
    this.userFoto,
  });

  // Factory method untuk membuat instance dari JSON
  factory UserModel.fromJson(Map<String, dynamic> json) {
    return UserModel(
      userId: json['user_id'],
      roleId: json['role_id'].toString(), // Convert role_id to String if needed
      userNama: json['user_nama'],
      userNamaLengkap: json['user_nmlengkap'],
      userEmail: json['user_email'],
      userFoto: json['user_foto'],
    );
  }

  // Method untuk mengonversi UserModel ke JSON
  Map<String, dynamic> toJson() {
    return {
      'user_id': userId,
      'role_id': roleId,
      'user_nama': userNama,
      'user_nmlengkap': userNamaLengkap,
      'user_email': userEmail,
      'user_foto': userFoto,
    };
  }
}
