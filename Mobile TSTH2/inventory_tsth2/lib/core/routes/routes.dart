import 'package:flutter/material.dart';
import 'package:inventory_tsth2/core/routes/routes_name.dart';
import 'package:inventory_tsth2/screens/auth/login.dart' as auth;
import 'package:inventory_tsth2/screens/dahsboard/dashboard.dart';

class Routes {
  static Route<dynamic> onGenerateRoute(RouteSettings routeSettings) {
    switch (routeSettings.name) {
      case RoutesName.login:
        return MaterialPageRoute(builder: (context) => auth.LoginPage());
      case RoutesName.main:
        return MaterialPageRoute(builder: (context) => DashboardPage());
      default:
        return MaterialPageRoute(
          builder: (context) => const Scaffold(
            body: Text("No routes found"),
          ),
        );
    }
  }
}
