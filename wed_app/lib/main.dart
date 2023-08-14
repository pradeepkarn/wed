// ignore_for_file: prefer_const_constructors

import 'package:flutter/material.dart';
import 'package:wed_app/style/theme.dart';
import 'package:wed_app/ui/auth_pages/login_page.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Wed',
      theme: AppTheme.light,
      home: LoginPage(),
    );
  }
}
