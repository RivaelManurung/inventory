import 'package:flutter/material.dart';
import 'package:flutter_animate/flutter_animate.dart';
import 'package:flutter/services.dart';
import 'package:inventory_tsth2/screens/dahsboard/profile_page.dart';
import 'package:inventory_tsth2/screens/dahsboard/qr_dashboard_page.dart';
import 'package:inventory_tsth2/screens/dahsboard/satuan_list_page.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Inventory Pro',
      debugShowCheckedModeBanner: false,
      theme: ThemeData(
        primarySwatch: Colors.blue,
        scaffoldBackgroundColor: const Color(0xFFF8FAFD),
      ),
      home: const DashboardPage(),
    );
  }
}

class DashboardPage extends StatelessWidget {
  const DashboardPage({super.key});

  @override
  Widget build(BuildContext context) {
    SystemChrome.setSystemUIOverlayStyle(
      SystemUiOverlayStyle.light.copyWith(
        statusBarColor: Colors.transparent,
      ),
    );

    return Scaffold(
      backgroundColor: const Color(0xFFF8FAFD),
      body: LayoutBuilder(
        builder: (context, constraints) {
          final screenWidth = constraints.maxWidth;
          final isSmallScreen = screenWidth < 400;
          final isMediumScreen = screenWidth >= 400 && screenWidth <= 600;
          final isLargeScreen = screenWidth > 600;

          // Calculate card width based on screen size
          final cardWidth = isSmallScreen
              ? screenWidth * 0.35
              : isMediumScreen
                  ? 130.0
                  : 150.0;

          return CustomScrollView(
            physics: const BouncingScrollPhysics(),
            slivers: [
              _buildAppBar(context, isSmallScreen),
              _buildMainContent(
                context,
                isSmallScreen,
                isMediumScreen,
                isLargeScreen,
                cardWidth,
              ),
            ],
          );
        },
      ),
    );
  }

  SliverAppBar _buildAppBar(BuildContext context, bool isSmallScreen) {
    return SliverAppBar(
      expandedHeight: isSmallScreen ? 160 : 180,
      floating: false,
      pinned: true,
      elevation: 0,
      backgroundColor: Colors.transparent,
      flexibleSpace: FlexibleSpaceBar(
        collapseMode: CollapseMode.pin,
        background: Stack(
          children: [
            // Gradient background with decorative elements
            Container(
              decoration: BoxDecoration(
                gradient: LinearGradient(
                  begin: Alignment.topLeft,
                  end: Alignment.bottomRight,
                  colors: [
                    Colors.blue.shade800,
                    Colors.blue.shade600,
                  ],
                ),
              ),
              child: Stack(
                children: [
                  // Decorative circles
                  Positioned(
                    top: -30,
                    right: -30,
                    child: Container(
                      width: 120,
                      height: 120,
                      decoration: BoxDecoration(
                        shape: BoxShape.circle,
                        color: Colors.white.withOpacity(0.05),
                      ),
                    ),
                  ),
                  Positioned(
                    bottom: -50,
                    left: -20,
                    child: Container(
                      width: 150,
                      height: 150,
                      decoration: BoxDecoration(
                        shape: BoxShape.circle,
                        color: Colors.white.withOpacity(0.05),
                      ),
                    ),
                  ),
                ],
              ),
            ),
            
            // Content
            SafeArea(
              child: Padding(
                padding: EdgeInsets.symmetric(
                  horizontal: isSmallScreen ? 24 : 32,
                  vertical: 16,
                ),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    const SizedBox(height: 16),
                    Row(
                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      children: [
                        Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Text(
                              'Welcome back,',
                              style: TextStyle(
                                color: Colors.white.withOpacity(0.9),
                                fontSize: isSmallScreen ? 16 : 18,
                              ),
                            ),
                            const SizedBox(height: 4),
                            Text(
                              'Inventory Pro',
                              style: TextStyle(
                                color: Colors.white,
                                fontSize: isSmallScreen ? 20 : 24,
                                fontWeight: FontWeight.bold,
                              ),
                            ),
                          ],
                        ),
                        // Profile avatar in top-right corner
                        InkWell(
                          onTap: () => Navigator.push(
                            context,
                            MaterialPageRoute(builder: (context) => ProfilePage()),
                          ),
                          borderRadius: BorderRadius.circular(30),
                          child: Hero(
                            tag: 'profile-avatar',
                            child: Container(
                              width: isSmallScreen ? 40 : 48,
                              height: isSmallScreen ? 40 : 48,
                              decoration: BoxDecoration(
                                shape: BoxShape.circle,
                                gradient: LinearGradient(
                                  colors: [
                                    Colors.white,
                                    Colors.white.withOpacity(0.8),
                                  ],
                                  begin: Alignment.topLeft,
                                  end: Alignment.bottomRight,
                                ),
                                border: Border.all(
                                  color: Colors.white.withOpacity(0.5),
                                  width: 1.5,
                                ),
                              ),
                              child: Center(
                                child: Text(
                                  'AJ',
                                  style: TextStyle(
                                    color: Colors.blue.shade800,
                                    fontSize: isSmallScreen ? 16 : 18,
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                              ),
                            ),
                          ),
                        ),
                      ],
                    ),
                  ],
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  SliverPadding _buildMainContent(
    BuildContext context,
    bool isSmallScreen,
    bool isMediumScreen,
    bool isLargeScreen,
    double cardWidth,
  ) {
    return SliverPadding(
      padding: EdgeInsets.symmetric(
        horizontal: isSmallScreen ? 16 : 24,
        vertical: 16,
      ),
      sliver: SliverList(
        delegate: SliverChildListDelegate([
          // Stats cards with constrained width
          SizedBox(
            height: isSmallScreen ? 100 : 110,
            child: ListView(
              scrollDirection: Axis.horizontal,
              physics: const BouncingScrollPhysics(),
              children: [
                SizedBox(width: isSmallScreen ? 8 : 12),
                _buildStatCard(
                  width: cardWidth,
                  title: 'Total Items',
                  value: '1,248',
                  icon: Icons.inventory_2_outlined,
                  color: Colors.blue.shade600,
                  isSmallScreen: isSmallScreen,
                ),
                SizedBox(width: isSmallScreen ? 8 : 12),
                _buildStatCard(
                  width: cardWidth,
                  title: 'Categories',
                  value: '24',
                  icon: Icons.category_outlined,
                  color: Colors.green.shade600,
                  isSmallScreen: isSmallScreen,
                ),
                SizedBox(width: isSmallScreen ? 8 : 12),
                _buildStatCard(
                  width: cardWidth,
                  title: 'Warehouses',
                  value: '5',
                  icon: Icons.warehouse_outlined,
                  color: Colors.orange.shade600,
                  isSmallScreen: isSmallScreen,
                ),
                SizedBox(width: isSmallScreen ? 8 : 12),
              ],
            ),
          ),

          SizedBox(height: isSmallScreen ? 24 : 32),

          const Text(
            'Quick Actions',
            style: TextStyle(
              fontSize: 18,
              fontWeight: FontWeight.w600,
              color: Color(0xFF333333),
            ),
          ),
          SizedBox(height: isSmallScreen ? 12 : 16),

          GridView.count(
            shrinkWrap: true,
            physics: const NeverScrollableScrollPhysics(),
            crossAxisCount: isLargeScreen ? 3 : 2,
            crossAxisSpacing: isSmallScreen ? 8 : 12,
            mainAxisSpacing: isSmallScreen ? 8 : 12,
            childAspectRatio: isLargeScreen ? 1.2 : 1.05,
            children: [
              _buildActionCard(
                context: context,
                icon: Icons.straighten,
                title: 'Units',
                color: const Color(0xFF6E45E2),
                isSmallScreen: isSmallScreen,
                onTap: () => Navigator.push(
                  context,
                  MaterialPageRoute(builder: (_) => SatuanListPage()),
                ),
              ),
              _buildActionCard(
                context: context,
                icon: Icons.qr_code_scanner,
                title: 'QR Tools',
                color: const Color(0xFF4CC9F0),
                isSmallScreen: isSmallScreen,
                onTap: () => Navigator.push(
                  context,
                  MaterialPageRoute(builder: (_) => QRDashboardPage()),
                ),
              ),
              _buildActionCard(
                context: context,
                icon: Icons.category,
                title: 'Categories',
                color: const Color(0xFF88D3CE),
                isSmallScreen: isSmallScreen,
                onTap: () {},
              ),
              _buildActionCard(
                context: context,
                icon: Icons.warehouse,
                title: 'Warehouses',
                color: const Color(0xFFFF9A9E),
                isSmallScreen: isSmallScreen,
                onTap: () {},
              ),
              if (isLargeScreen) ...[
                _buildActionCard(
                  context: context,
                  icon: Icons.settings,
                  title: 'Settings',
                  color: Colors.purple.shade600,
                  isSmallScreen: isSmallScreen,
                  onTap: () {},
                ),
                _buildActionCard(
                  context: context,
                  icon: Icons.analytics,
                  title: 'Reports',
                  color: Colors.teal.shade600,
                  isSmallScreen: isSmallScreen,
                  onTap: () {},
                ),
              ],
            ],
          ),
          SizedBox(height: isSmallScreen ? 16 : 24),
        ]),
      ),
    );
  }

  Widget _buildStatCard({
    required double width,
    required String title,
    required String value,
    required IconData icon,
    required Color color,
    required bool isSmallScreen,
  }) {
    return SizedBox(
      width: width,
      child: Container(
        padding: EdgeInsets.all(isSmallScreen ? 10 : 12),
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(isSmallScreen ? 12 : 14),
          boxShadow: [
            BoxShadow(
              color: Colors.black.withOpacity(0.03),
              blurRadius: 12,
              offset: const Offset(0, 4),
            ),
          ],
        ),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Container(
              padding: const EdgeInsets.all(6),
              decoration: BoxDecoration(
                color: color.withOpacity(0.08),
                borderRadius: BorderRadius.circular(8),
              ),
              child: Icon(
                icon,
                color: color,
                size: isSmallScreen ? 16 : 18,
              ),
            ),
            SizedBox(height: isSmallScreen ? 6 : 8),
            Text(
              value,
              style: TextStyle(
                fontSize: isSmallScreen ? 16 : 18,
                fontWeight: FontWeight.w700,
              ),
              maxLines: 1,
              overflow: TextOverflow.ellipsis,
            ),
            const SizedBox(height: 2),
            Text(
              title,
              style: TextStyle(
                fontSize: isSmallScreen ? 11 : 12,
                color: Colors.grey.shade600,
              ),
              maxLines: 1,
              overflow: TextOverflow.ellipsis,
            ),
          ],
        ),
      ),
    ).animate().fadeIn(delay: 100.ms).slideY(begin: 0.1);
  }

  Widget _buildActionCard({
    required BuildContext context,
    required IconData icon,
    required String title,
    required Color color,
    required bool isSmallScreen,
    required VoidCallback onTap,
  }) {
    return Material(
      color: Colors.transparent,
      child: InkWell(
        onTap: onTap,
        borderRadius: BorderRadius.circular(isSmallScreen ? 12 : 14),
        child: Container(
          decoration: BoxDecoration(
            borderRadius: BorderRadius.circular(isSmallScreen ? 12 : 14),
            color: color.withOpacity(0.9),
            boxShadow: [
              BoxShadow(
                color: color.withOpacity(0.2),
                blurRadius: 8,
                offset: const Offset(0, 4),
              ),
            ],
          ),
          child: Stack(
            children: [
              Positioned(
                right: -12,
                bottom: -12,
                child: Icon(
                  icon,
                  size: isSmallScreen ? 60 : 72,
                  color: Colors.white.withOpacity(0.1),
                ),
              ),
              Padding(
                padding: EdgeInsets.all(isSmallScreen ? 12 : 14),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    Container(
                      width: isSmallScreen ? 32 : 36,
                      height: isSmallScreen ? 32 : 36,
                      decoration: BoxDecoration(
                        color: Colors.white.withOpacity(0.18),
                        borderRadius: BorderRadius.circular(10),
                      ),
                      child: Center(
                        child: Icon(
                          icon,
                          color: Colors.white,
                          size: isSmallScreen ? 16 : 18,
                        ),
                      ),
                    ),
                    Text(
                      title,
                      style: TextStyle(
                        color: Colors.white,
                        fontSize: isSmallScreen ? 14 : 15,
                        fontWeight: FontWeight.w600,
                      ),
                      maxLines: 1,
                      overflow: TextOverflow.ellipsis,
                    ),
                  ],
                ),
              ),
            ],
          ),
        ),
      ).animate().fadeIn(delay: 200.ms).slideY(begin: 0.2),
    );
  }
}