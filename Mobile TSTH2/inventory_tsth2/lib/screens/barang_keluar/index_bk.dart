import 'package:flutter/material.dart';
import 'package:inventory_tsth2/controller/Barang/BarangController.dart';
import 'package:inventory_tsth2/widget/custom_button.dart';
import 'package:inventory_tsth2/widget/custom_formfield.dart';
import 'package:inventory_tsth2/widget/custom_button.dart';

class BarangKeluarPage extends StatefulWidget {
  @override
  _BarangKeluarPageState createState() => _BarangKeluarPageState();
}

class _BarangKeluarPageState extends State<BarangKeluarPage> {
  final BarangController _controller = BarangController();
  bool isLoading = false;

  @override
  @override
  void initState() {
    super.initState();
    _loadData();
  }

  Future<void> _loadData() async {
    setState(() => isLoading = true);
    await _controller.getAllBarang(); // Ubah ini
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
          title: Text(
              data == null ? 'Tambah Barang Keluar' : 'Edit Barang Keluar'),
          content: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              CustomFormField(
                headingText: "Nama Barang",
                hintText: "Masukkan nama barang",
                obsecureText: false,
                controller: namaController,
                suffixIcon: const SizedBox(), // Tambahkan ini
                textInputType: TextInputType.text, // Tambahkan ini
                textInputAction: TextInputAction.next, // Tambahkan ini
                maxLines: 1, // Tambahkan ini
              ),
              SizedBox(height: 10),
              CustomFormField(
                headingText: "Jumlah",
                hintText: "Masukkan jumlah",
                obsecureText: false,
                controller: jumlahController,
                suffixIcon: const SizedBox(), // Tambahkan ini
                textInputType: TextInputType.number, // Tambahkan ini
                textInputAction: TextInputAction.done, // Tambahkan ini
                maxLines: 1, // Tambahkan ini
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
                if (namaController.text.isEmpty ||
                    jumlahController.text.isEmpty) {
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
                  await _controller.addBarang(barang);
                } else {
                  await _controller.updateBarang(data['id'], barang);
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
          : FutureBuilder<List<Map<String, dynamic>>>(
              future: _controller.getAllBarang(), // Panggil fungsi asinkron
              builder: (context, snapshot) {
                if (snapshot.connectionState == ConnectionState.waiting) {
                  return Center(child: CircularProgressIndicator());
                } else if (snapshot.hasError) {
                  return Center(child: Text("Terjadi kesalahan"));
                } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
                  return Center(child: Text("Tidak ada barang keluar"));
                }

                final barangList = snapshot.data!;

                return ListView.builder(
                  itemCount: barangList.length,
                  itemBuilder: (context, index) {
                    final barang = barangList[index];
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
                              await _controller.deleteBarang(barang['id']);
                              _loadData();
                            },
                          ),
                        ],
                      ),
                    );
                  },
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

class CustomButton extends StatelessWidget {
  final String text;
  final VoidCallback onTap;
  final Color color;

  const CustomButton({
    required this.text,
    required this.onTap,
    this.color = Colors.blue, // Warna default
  });

  @override
  Widget build(BuildContext context) {
    return ElevatedButton(
      onPressed: onTap,
      style: ElevatedButton.styleFrom(backgroundColor: color),
      child: Text(text),
    );
  }
}