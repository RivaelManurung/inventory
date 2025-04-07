// TODO Implement this library.// models/user_model.dart
class User {
  final String id;
  final String fullName;
  final String username;
  final String email;
  final String? photo;
  final String phone;
  final String address;
  final String position;
  final String joinDate;

  User({
    required this.id,
    required this.fullName,
    required this.username,
    required this.email,
    this.photo,
    required this.phone,
    required this.address,
    required this.position,
    required this.joinDate,
  });

  // Static data for demo
  static User get currentUser => User(
        id: '1',
        fullName: 'Alex Johnson',
        username: 'alexj',
        email: 'alex.johnson@example.com',
        photo: null,
        phone: '+1 (555) 123-4567',
        address: '123 Main St, New York, USA',
        position: 'Inventory Manager',
        joinDate: 'March 15, 2022',
      );
}