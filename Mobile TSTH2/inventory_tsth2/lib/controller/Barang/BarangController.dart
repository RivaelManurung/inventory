import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import 'package:inventory_tsth2/config/api.dart';

class BarangController {
  Future<List<Map<String, dynamic>>> getAllBarang() async {
    try {
      final prefs = await SharedPreferences.getInstance();
      String? token = prefs.getString('token');

      final response = await http.get(
        Uri.parse('$url/barang'),
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer $token', // Tambahkan token di sini
        },
      );

      print('Response Code: ${response.statusCode}');
      print('Response Body: ${response.body}');

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        if (data is Map && data.containsKey('data') && data['data'] is List) {
          return List<Map<String, dynamic>>.from(data['data']);
        } else {
          print('Data tidak dalam format yang diharapkan');
          return [];
        }
      } else {
        print(
            'Gagal mendapatkan data barang, Status Code: ${response.statusCode}');
        return [];
      }
    } catch (e) {
      print('Error: $e');
      return [];
    }
  }

  Future<Map<String, dynamic>> getBarang(String kode) async {
    try {
      final response = await http.get(Uri.parse('$url/barang/$kode'));

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        return {'success': true, 'data': data['data']};
      } else {
        return {'success': false, 'message': 'Barang tidak ditemukan'};
      }
    } catch (e) {
      return {'success': false, 'message': e.toString()};
    }
  }

  Future<Map<String, dynamic>> addBarang(
      Map<String, dynamic> barangData) async {
    try {
      final prefs = await SharedPreferences.getInstance();
      String? token = prefs.getString('token');

      final response = await http.post(
        Uri.parse('$url/barang'),
        headers: {
          'Content-Type': 'application/json',
          'Authorization': 'Bearer $token',
        },
        body: jsonEncode(barangData),
      );

      final data = jsonDecode(response.body);
      if (response.statusCode == 201) {
        return {'success': true, 'message': data['message']};
      } else {
        return {'success': false, 'message': data['message']};
      }
    } catch (e) {
      return {'success': false, 'message': e.toString()};
    }
  }

  Future<Map<String, dynamic>> updateBarang(
      String kode, Map<String, dynamic> barangData) async {
    try {
      final prefs = await SharedPreferences.getInstance();
      String? token = prefs.getString('token');

      final response = await http.put(
        Uri.parse('$url/barang/$kode'),
        headers: {
          'Content-Type': 'application/json',
          'Authorization': 'Bearer $token',
        },
        body: jsonEncode(barangData),
      );

      final data = jsonDecode(response.body);
      if (response.statusCode == 200) {
        return {'success': true, 'message': data['message']};
      } else {
        return {'success': false, 'message': data['message']};
      }
    } catch (e) {
      return {'success': false, 'message': e.toString()};
    }
  }

  Future<Map<String, dynamic>> deleteBarang(String kode) async {
    try {
      final prefs = await SharedPreferences.getInstance();
      String? token = prefs.getString('token');

      final response = await http.delete(
        Uri.parse('$url/barang/$kode'),
        headers: {
          'Authorization': 'Bearer $token',
        },
      );

      final data = jsonDecode(response.body);
      if (response.statusCode == 200) {
        return {'success': true, 'message': data['message']};
      } else {
        return {'success': false, 'message': data['message']};
      }
    } catch (e) {
      return {'success': false, 'message': e.toString()};
    }
  }

  Future<Map<String, dynamic>> getStockCalculation(String kode,
      {String? startDate, String? endDate}) async {
    try {
      String urlApi = '$url/barang/$kode/stock';

      if (startDate != null && endDate != null) {
        urlApi += '?start_date=$startDate&end_date=$endDate';
      }

      final response = await http.get(Uri.parse(urlApi));

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        return {'success': true, 'data': data['data']};
      } else {
        return {'success': false, 'message': 'Gagal menghitung stok'};
      }
    } catch (e) {
      return {'success': false, 'message': e.toString()};
    }
  }
}
