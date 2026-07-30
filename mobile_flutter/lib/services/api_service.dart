import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

class ApiService {
  static const String baseUrl = 'https://education-familiale-api.onrender.com/api';

  static Future<String> getCurrentLang() async {
    final prefs = await SharedPreferences.getInstance();

    final lang = prefs.getString('language_code') ?? 'fr';

    if (lang == 'mg') {
      return 'mg';
    }

    return 'fr';
  }

  static Future<Uri> localizedUrl(String path) async {
    final lang = await getCurrentLang();

    return Uri.parse('$baseUrl$path').replace(
      queryParameters: {
        'lang': lang,
      },
    );
  }

  static Future<Map<String, dynamic>> register({
    required String name,
    required String email,
    required String password,
  }) async {
    final response = await http.post(
      Uri.parse('$baseUrl/register'),
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      },
      body: jsonEncode({
        'name': name,
        'email': email,
        'password': password,
        'password_confirmation': password,
        'role': 'parent',
      }),
    );

    return jsonDecode(response.body);
  }

  static Future<Map<String, dynamic>> login({
    required String email,
    required String password,
  }) async {
    final response = await http.post(
      Uri.parse('$baseUrl/login'),
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      },
      body: jsonEncode({
        'email': email,
        'password': password,
      }),
    );

    final data = jsonDecode(response.body);

    if (response.statusCode == 200 && data['token'] != null) {
      final prefs = await SharedPreferences.getInstance();

      await prefs.setString('token', data['token']);
      await prefs.setString('userName', data['user']['name']);
      await prefs.setString('userEmail', data['user']['email']);
    }

    return data;
  }

  static Future<String?> getToken() async {
    final prefs = await SharedPreferences.getInstance();
    return prefs.getString('token');
  }

  static Future<Map<String, dynamic>> saveDeviceToken({
    required String firebaseToken,
    required String deviceType,
  }) async {
    final token = await getToken();

    final response = await http.post(
      Uri.parse('$baseUrl/device-token'),
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'Authorization': 'Bearer $token',
      },
      body: jsonEncode({
        'token': firebaseToken,
        'device_type': deviceType,
      }),
    );

    return jsonDecode(response.body);
  }

  static Future<List<dynamic>> getModules() async {
    final token = await getToken();

    final response = await http.get(
      await localizedUrl('/modules'),
      headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer $token',
      },
    );

    final data = jsonDecode(response.body);

    if (response.statusCode == 200) {
      return data['modules'];
    } else {
      throw Exception('Erreur lors du chargement des modules.');
    }
  }

  static Future<Map<String, dynamic>> completeModule(int moduleId) async {
    final token = await getToken();

    final response = await http.post(
      Uri.parse('$baseUrl/modules/$moduleId/complete'),
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'Authorization': 'Bearer $token',
      },
    );

    return jsonDecode(response.body);
  }

  static Future<List<dynamic>> getProgressions() async {
    final token = await getToken();

    final response = await http.get(
      Uri.parse('$baseUrl/progressions'),
      headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer $token',
      },
    );

    final data = jsonDecode(response.body);

    if (response.statusCode == 200) {
      return data['progressions'];
    } else {
      throw Exception('Erreur lors du chargement des progressions.');
    }
  }

  static Future<List<dynamic>> getConseils() async {
    final token = await getToken();

    final response = await http.get(
      await localizedUrl('/conseils'),
      headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer $token',
      },
    );

    final data = jsonDecode(response.body);

    if (response.statusCode == 200) {
      return data['conseils'];
    } else {
      throw Exception('Erreur lors du chargement des conseils.');
    }
  }

  static Future<List<dynamic>> getQuizzes() async {
    final token = await getToken();

    final response = await http.get(
      Uri.parse('$baseUrl/quizzes'),
      headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer $token',
      },
    );

    final data = jsonDecode(response.body);

    if (response.statusCode == 200) {
      return data['quizzes'];
    } else {
      throw Exception('Erreur lors du chargement des quiz.');
    }
  }

  static Future<Map<String, dynamic>> getQuizDetail(int quizId) async {
    final token = await getToken();

    final response = await http.get(
      Uri.parse('$baseUrl/quizzes/$quizId'),
      headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer $token',
      },
    );

    final data = jsonDecode(response.body);

    if (response.statusCode == 200) {
      return data['quiz'];
    } else {
      throw Exception('Erreur lors du chargement du quiz.');
    }
  }

  static Future<Map<String, dynamic>> submitQuiz({
    required int quizId,
    required List<Map<String, int>> answers,
  }) async {
    final token = await getToken();

    final response = await http.post(
      Uri.parse('$baseUrl/quizzes/$quizId/submit'),
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'Authorization': 'Bearer $token',
      },
      body: jsonEncode({
        'answers': answers,
      }),
    );

    return jsonDecode(response.body);
  }

  static Future<List<dynamic>> getMyScores() async {
    final token = await getToken();

    final response = await http.get(
      Uri.parse('$baseUrl/my-scores'),
      headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer $token',
      },
    );

    final data = jsonDecode(response.body);

    if (response.statusCode == 200) {
      return data['scores'];
    } else {
      throw Exception('Erreur lors du chargement des scores.');
    }
  }

  static Future<void> logout() async {
    final token = await getToken();

    if (token != null) {
      await http.post(
        Uri.parse('$baseUrl/logout'),
        headers: {
          'Accept': 'application/json',
          'Authorization': 'Bearer $token',
        },
      );
    }

    final prefs = await SharedPreferences.getInstance();
    await prefs.clear();
  }
}