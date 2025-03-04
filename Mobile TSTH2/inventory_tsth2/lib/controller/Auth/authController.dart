import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import 'package:inventory_tsth2/config/api.dart';

class AuthController {
  Future<Map<String, dynamic>> login(String email, String password) async {
    try {
      print('Login request: $email - $password');
      print('Requesting: $url/auth/login');

      final response = await http.post(
        Uri.parse('$url/auth/login'),
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json', // Pastikan ini diterima oleh backend
        },
        body: jsonEncode({
          'user_email': email,
          'user_password': password,
        }),
      );

      print('Response status: ${response.statusCode}');
      print('Response body: ${response.body}');

      if (response.statusCode == 200) {
        final Map<String, dynamic> data = jsonDecode(response.body);

        if (data.containsKey('data') && data['data'].containsKey('access_token')) {
          final token = data['data']['access_token'];

          // Simpan token ke SharedPreferences
          final prefs = await SharedPreferences.getInstance();
          await prefs.setString('token', token);
          await prefs.setString('user_nama', data['data']['user']['user_nama']);
          await prefs.setString('user_email', data['data']['user']['user_email']);
          await prefs.setString('user_role', data['data']['user']['role']);

          // Cek apakah foto user tersedia sebelum menyimpannya
          if (data['data']['user']['user_foto'] != null) {
            await prefs.setString('user_foto', data['data']['user']['user_foto']);
          }

          return {
            'success': true,
            'message': data['message'],
            'data': data['data']
          };
        } else {
          print("Response tidak sesuai format yang diharapkan.");
          return {'success': false, 'message': 'Invalid response format'};
        }
      } else {
        try {
          final errorData = jsonDecode(response.body);
          return {'success': false, 'message': errorData['message']};
        } catch (_) {
          return {'success': false, 'message': 'Unknown error occurred'};
        }
      }
    } catch (e) {
      print('Unexpected Error: $e');
      return {'success': false, 'message': 'Unexpected error: ${e.toString()}'};  
    }
  }
}
