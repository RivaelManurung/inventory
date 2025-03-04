import 'package:flutter/material.dart';
import 'package:inventory_tsth2/controller/Barang/BarangController.dart';

class IndexBarangPage extends StatefulWidget {
  @override
  _IndexBarangPageState createState() => _IndexBarangPageState();
}

class _IndexBarangPageState extends State<IndexBarangPage> {
  final BarangController _barangController = BarangController();

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Daftar Barang'),
        backgroundColor: Colors.blueAccent,
      ),
      body: FutureBuilder<List<Map<String, dynamic>>>(
        future: _barangController.getAllBarang(),
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return Center(child: CircularProgressIndicator());
          } else if (snapshot.hasError) {
            return Center(child: Text('Terjadi kesalahan: ${snapshot.error}'));
          } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
            return Center(child: Text('Tidak ada data barang'));
          }

          final barangList = snapshot.data!;
          return ListView.builder(
            itemCount: barangList.length,
            itemBuilder: (context, index) {
              final barang = barangList[index];
              return Card(
                margin: EdgeInsets.symmetric(horizontal: 16, vertical: 8),
                child: ListTile(
                  title: Text(barang['nama_barang']),
                  subtitle: Text('Stok: ${barang['stok']}'),
                  trailing: IconButton(
                    icon: Icon(Icons.delete, color: Colors.red),
                    onPressed: () => _deleteBarang(barang['kode']),
                  ),
                  onTap: () => _showDetail(barang),
                ),
              );
            },
          );
        },
      ),
    );
  }

  void _deleteBarang(String kode) async {
    final result = await _barangController.deleteBarang(kode);
    if (result['success']) {
      ScaffoldMessenger.of(context).showSnackBar( 
        SnackBar(content: Text('Barang berhasil dihapus')),
      );
      setState(() {});
    } else {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Gagal menghapus barang: ${result['message']}')),
      );
    }
  }

  void _showDetail(Map<String, dynamic> barang) {
    showDialog(
      context: context,
      builder: (context) {
        return AlertDialog(
          title: Text(barang['nama_barang']),
          content: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              Text('Kode: ${barang['kode']}'),
              Text('Kategori: ${barang['kategori']}'),
              Text('Stok: ${barang['stok']}'),
            ],
          ),
          actions: [
            TextButton(
              onPressed: () => Navigator.pop(context),
              child: Text('Tutup'),
            ),
          ],
        );
      },
    );
  }
}
