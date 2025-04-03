import 'package:get/get.dart';

import 'package:flutter/material.dart';
import 'package:inventory_tsth2/core/routes/routes.dart';
import 'package:inventory_tsth2/core/routes/routes_name.dart';

void main() {
  runApp(const App());
}

class App extends StatelessWidget {
  const App({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return GetMaterialApp(
      debugShowCheckedModeBanner: false,
      initialRoute: RoutesName.main,
      onGenerateRoute: Routes.onGenerateRoute,
      theme: ThemeData(canvasColor: Colors.white),
    );
  }
}