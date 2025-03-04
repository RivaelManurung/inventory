import 'package:flutter/material.dart';
import 'package:inventory_tsth2/screens/auth/login.dart';
import 'package:inventory_tsth2/screens/barang/index_barang.dart';
import 'package:inventory_tsth2/screens/barang_keluar/index_bk.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:inventory_tsth2/screens/barang_keluar/qrcode.dart';

void main() {
  runApp(MyApp());
}

class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      theme: ThemeData(
        brightness: Brightness.light,
        primaryColor: Colors.blueAccent,
        textTheme: TextTheme(
          bodyLarge: TextStyle(fontSize: 16, fontWeight: FontWeight.bold, color: Colors.black87),
        ),
      ),
      home: LoginPage(), // Awal ke halaman login
    );
  }
}

// Halaman Dashboard dengan Logout
class DashboardPage extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text("Dashboard", style: TextStyle(fontWeight: FontWeight.bold)),
        centerTitle: true,
        backgroundColor: Colors.blueAccent,
        elevation: 0,
        actions: [
          IconButton(
            icon: Icon(Icons.exit_to_app, color: Colors.white),
            onPressed: () async {
              // Hapus data login
              final prefs = await SharedPreferences.getInstance();
              await prefs.clear();

              // Navigasi ke halaman login
              Navigator.pushReplacement(
                context,
                MaterialPageRoute(builder: (context) => LoginPage()),
              );
            },
          ),
        ],
      ),
      body: Container(
        padding: const EdgeInsets.all(16.0),
        decoration: BoxDecoration(
          gradient: LinearGradient(
            colors: [Colors.blueAccent.shade100, Colors.blueAccent.shade700],
            begin: Alignment.topLeft,
            end: Alignment.bottomRight,
          ),
        ),
        child: GridView.count(
          crossAxisCount: 2,
          crossAxisSpacing: 16,
          mainAxisSpacing: 16,
          children: [
            _buildDashboardCard(context, "Barang Masuk", Icons.inventory_2, Colors.green, BarangMasukPage()),
            _buildDashboardCard(context, "Barang Keluar", Icons.outbox, Colors.red, BarangKeluarPage()),
            _buildDashboardCard(context, "Barang", Icons.category, Colors.orange, IndexBarangPage()),
          ],
        ),
      ),
    );
  }

  Widget _buildDashboardCard(BuildContext context, String title, IconData icon, Color color, Widget page) {
    return GestureDetector(
      onTap: () => Navigator.push(
        context,
        MaterialPageRoute(builder: (context) => page),
      ),
      child: Card(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
        elevation: 6,
        color: Colors.white,
        shadowColor: Colors.black54,
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Container(
              padding: EdgeInsets.all(12),
              decoration: BoxDecoration(
                color: color.withOpacity(0.2),
                shape: BoxShape.circle,
              ),
              child: Icon(icon, size: 50, color: color),
            ),
            SizedBox(height: 12),
            Text(
              title,
              style: TextStyle(
                color: Colors.black87,
                fontSize: 18,
                fontWeight: FontWeight.bold,
              ),
            ),
          ],
        ),
      ),
    );
  }
}

// Placeholder Pages
class BarangMasukPage extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text("Barang Masuk")),
      body: Center(child: Text("Fitur Barang Masuk")),
    );
  }
}

