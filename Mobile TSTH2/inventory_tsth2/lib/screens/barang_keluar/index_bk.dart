import 'package:flutter/material.dart';
import 'package:inventory_tsth2/controller/Barang/BarangController.dart';
import 'package:inventory_tsth2/widget/custom_button.dart';
import 'package:inventory_tsth2/widget/custom_formfield.dart';

class BarangKeluarPage extends StatefulWidget {
  @override
  _BarangKeluarPageState createState() => _BarangKeluarPageState();
}

class _BarangKeluarPageState extends State<BarangKeluarPage> {
  final BarangKeluarController _controller = BarangKeluarController();
  bool isLoading = false;

  @override
  void initState() {
    super.initState();
    _loadData();
  }

  Future<void> _loadData() async {
    setState(() => isLoading = true);
    await _controller.getBarangKeluar();
    setState(() => isLoading = false);
  }

  void _showFormDialog({Map<String, dynamic>? data}) {
    final TextEditingController namaController =
        TextEditingController(text: data?['nama'] ?? '');
    final TextEditingController jumlahController =
        TextEditingController(text: data?['jumlah']?.toString() ?? '');

    showDialog(
      context: context,
      builder: (context) {
        return AlertDialog(
          title: Text(data == null ? 'Tambah Barang Keluar' : 'Edit Barang Keluar'),
          content: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              CustomFormField(
                headingText: "Nama Barang",
                hintText: "Masukkan nama barang",
                obsecureText: false,
                controller: namaController,
              ),
              SizedBox(height: 10),
              CustomFormField(
                headingText: "Jumlah",
                hintText: "Masukkan jumlah",
                obsecureText: false,
                controller: jumlahController,
                textInputType: TextInputType.number,
              ),
            ],
          ),
          actions: [
            TextButton(
              onPressed: () => Navigator.pop(context),
              child: Text("Batal"),
            ),
            CustomButton(
              text: data == null ? 'Tambah' : 'Update',
              onTap: () async {
                if (namaController.text.isEmpty || jumlahController.text.isEmpty) {
                  ScaffoldMessenger.of(context).showSnackBar(
                    SnackBar(content: Text("Semua field harus diisi")),
                  );
                  return;
                }
                final barang = {
                  'nama': namaController.text.trim(),
                  'jumlah': int.parse(jumlahController.text.trim()),
                };
                if (data == null) {
                  await _controller.tambahBarangKeluar(barang);
                } else {
                  await _controller.updateBarangKeluar(data['id'], barang);
                }
                Navigator.pop(context);
                _loadData();
              },
            ),
          ],
        );
      },
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text("Barang Keluar")),
      body: isLoading
          ? Center(child: CircularProgressIndicator())
          : ListView.builder(
              itemCount: _controller.barangKeluar.length,
              itemBuilder: (context, index) {
                final barang = _controller.barangKeluar[index];
                return ListTile(
                  title: Text(barang['nama']),
                  subtitle: Text("Jumlah: ${barang['jumlah']}"),
                  trailing: Row(
                    mainAxisSize: MainAxisSize.min,
                    children: [
                      IconButton(
                        icon: Icon(Icons.edit, color: Colors.blue),
                        onPressed: () => _showFormDialog(data: barang),
                      ),
                      IconButton(
                        icon: Icon(Icons.delete, color: Colors.red),
                        onPressed: () async {
                          await _controller.hapusBarangKeluar(barang['id']);
                          _loadData();
                        },
                      ),
                    ],
                  ),
                );
              },
            ),
      floatingActionButton: FloatingActionButton(
        child: Icon(Icons.add),
        onPressed: () => _showFormDialog(),
      ),
    );
  }
}
