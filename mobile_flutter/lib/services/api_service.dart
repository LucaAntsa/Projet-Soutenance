import 'dart:async';
import 'dart:convert';

import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

class ApiService {
  static const String baseUrl =
      'https://education-familiale-api.onrender.com/api';

  // Une instance Render gratuite peut mettre plusieurs secondes à se réveiller.
  static const Duration _requestTimeout = Duration(seconds: 90);

  static Map<String, String> _headers({
    String? token,
    bool json = false,
  }) {
    return {
      'Accept': 'application/json',
      if (json) 'Content-Type': 'application/json',
      if (token != null && token.isNotEmpty)
        'Authorization': 'Bearer $token',
    };
  }

  static Map<String, dynamic> _decodeMap(http.Response response) {
    if (response.body.trim().isEmpty) {
      return {
        'success': response.statusCode >= 200 && response.statusCode < 300,
        'status_code': response.statusCode,
      };
    }

    try {
      final dynamic decoded = jsonDecode(response.body);

      if (decoded is Map<String, dynamic>) {
        return {
          ...decoded,
          'status_code': response.statusCode,
        };
      }

      if (decoded is Map) {
        return {
          ...Map<String, dynamic>.from(decoded),
          'status_code': response.statusCode,
        };
      }
    } on FormatException {
      // La réponse n'était pas du JSON exploitable.
    }

    return {
      'success': false,
      'status_code': response.statusCode,
      'message': response.statusCode >= 500
          ? 'Le serveur rencontre une erreur temporaire.'
          : 'Réponse invalide reçue du serveur.',
    };
  }

  static List<dynamic> _extractList(
    Map<String, dynamic> data,
    String key,
    String errorMessage,
  ) {
    final dynamic value = data[key];

    if (value is List<dynamic>) {
      return value;
    }

    throw Exception(data['message']?.toString() ?? errorMessage);
  }

  static Future<String> getCurrentLang() async {
    final prefs = await SharedPreferences.getInstance();
    final lang = prefs.getString('language_code') ?? 'fr';

    return lang == 'mg' ? 'mg' : 'fr';
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
    final response = await http
        .post(
          Uri.parse('$baseUrl/register'),
          headers: _headers(json: true),
          body: jsonEncode({
            'name': name.trim(),
            'email': email.trim().toLowerCase(),
            'password': password,
            'password_confirmation': password,
          }),
        )
        .timeout(_requestTimeout);

    return _decodeMap(response);
  }

  static Future<Map<String, dynamic>> login({
    required String email,
    required String password,
  }) async {
    final response = await http
        .post(
          Uri.parse('$baseUrl/login'),
          headers: _headers(json: true),
          body: jsonEncode({
            'email': email.trim().toLowerCase(),
            'password': password,
          }),
        )
        .timeout(_requestTimeout);

    final data = _decodeMap(response);

    if (response.statusCode == 200 && data['token'] != null) {
      final prefs = await SharedPreferences.getInstance();
      final dynamic user = data['user'];

      await prefs.setString('token', data['token'].toString());

      if (user is Map) {
        final userMap = Map<String, dynamic>.from(user);
        await prefs.setString(
          'userName',
          userMap['name']?.toString() ?? '',
        );
        await prefs.setString(
          'userEmail',
          userMap['email']?.toString() ?? '',
        );
      }
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

    if (token == null || token.isEmpty) {
      return {
        'success': false,
        'message': 'Utilisateur non authentifié.',
      };
    }

    final response = await http
        .post(
          Uri.parse('$baseUrl/device-token'),
          headers: _headers(token: token, json: true),
          body: jsonEncode({
            'token': firebaseToken,
            'device_type': deviceType,
          }),
        )
        .timeout(_requestTimeout);

    return _decodeMap(response);
  }

  static Future<List<dynamic>> getModules() async {
    final token = await getToken();

    final response = await http
        .get(
          await localizedUrl('/modules'),
          headers: _headers(token: token),
        )
        .timeout(_requestTimeout);

    final data = _decodeMap(response);

    if (response.statusCode == 200) {
      return _extractList(
        data,
        'modules',
        'Erreur lors du chargement des modules.',
      );
    }

    throw Exception(
      data['message']?.toString() ??
          'Erreur lors du chargement des modules.',
    );
  }

  static Future<Map<String, dynamic>> completeModule(int moduleId) async {
    final token = await getToken();

    final response = await http
        .post(
          Uri.parse('$baseUrl/modules/$moduleId/complete'),
          headers: _headers(token: token, json: true),
        )
        .timeout(_requestTimeout);

    return _decodeMap(response);
  }

  static Future<List<dynamic>> getProgressions() async {
    final token = await getToken();

    final response = await http
        .get(
          Uri.parse('$baseUrl/progressions'),
          headers: _headers(token: token),
        )
        .timeout(_requestTimeout);

    final data = _decodeMap(response);

    if (response.statusCode == 200) {
      return _extractList(
        data,
        'progressions',
        'Erreur lors du chargement des progressions.',
      );
    }

    throw Exception(
      data['message']?.toString() ??
          'Erreur lors du chargement des progressions.',
    );
  }

  static Future<List<dynamic>> getConseils() async {
    final token = await getToken();

    final response = await http
        .get(
          await localizedUrl('/conseils'),
          headers: _headers(token: token),
        )
        .timeout(_requestTimeout);

    final data = _decodeMap(response);

    if (response.statusCode == 200) {
      return _extractList(
        data,
        'conseils',
        'Erreur lors du chargement des conseils.',
      );
    }

    throw Exception(
      data['message']?.toString() ??
          'Erreur lors du chargement des conseils.',
    );
  }

  static Future<List<dynamic>> getQuizzes() async {
    final token = await getToken();

    final response = await http
        .get(
          Uri.parse('$baseUrl/quizzes'),
          headers: _headers(token: token),
        )
        .timeout(_requestTimeout);

    final data = _decodeMap(response);

    if (response.statusCode == 200) {
      return _extractList(
        data,
        'quizzes',
        'Erreur lors du chargement des quiz.',
      );
    }

    throw Exception(
      data['message']?.toString() ??
          'Erreur lors du chargement des quiz.',
    );
  }

  static Future<Map<String, dynamic>> getQuizDetail(int quizId) async {
    final token = await getToken();

    final response = await http
        .get(
          Uri.parse('$baseUrl/quizzes/$quizId'),
          headers: _headers(token: token),
        )
        .timeout(_requestTimeout);

    final data = _decodeMap(response);

    if (response.statusCode == 200 && data['quiz'] is Map) {
      return Map<String, dynamic>.from(data['quiz'] as Map);
    }

    throw Exception(
      data['message']?.toString() ??
          'Erreur lors du chargement du quiz.',
    );
  }

  static Future<Map<String, dynamic>> submitQuiz({
    required int quizId,
    required List<Map<String, int>> answers,
  }) async {
    final token = await getToken();

    final response = await http
        .post(
          Uri.parse('$baseUrl/quizzes/$quizId/submit'),
          headers: _headers(token: token, json: true),
          body: jsonEncode({
            'answers': answers,
          }),
        )
        .timeout(_requestTimeout);

    return _decodeMap(response);
  }

  static Future<List<dynamic>> getMyScores() async {
    final token = await getToken();

    final response = await http
        .get(
          Uri.parse('$baseUrl/my-scores'),
          headers: _headers(token: token),
        )
        .timeout(_requestTimeout);

    final data = _decodeMap(response);

    if (response.statusCode == 200) {
      return _extractList(
        data,
        'scores',
        'Erreur lors du chargement des scores.',
      );
    }

    throw Exception(
      data['message']?.toString() ??
          'Erreur lors du chargement des scores.',
    );
  }

  static Future<Map<String, dynamic>> requestPasswordReset({
    required String email,
  }) async {
    final response = await http
        .post(
          Uri.parse('$baseUrl/forgot-password'),
          headers: _headers(json: true),
          body: jsonEncode({
            'email': email.trim().toLowerCase(),
          }),
        )
        .timeout(_requestTimeout);

    final data = _decodeMap(response);

    return {
      ...data,
      'success': response.statusCode >= 200 && response.statusCode < 300,
    };
  }

  static Future<Map<String, dynamic>> resetPassword({
    required String email,
    required String code,
    required String password,
    required String passwordConfirmation,
  }) async {
    final response = await http
        .post(
          Uri.parse('$baseUrl/reset-password'),
          headers: _headers(json: true),
          body: jsonEncode({
            'email': email.trim().toLowerCase(),
            'code': code.trim(),
            'password': password,
            'password_confirmation': passwordConfirmation,
          }),
        )
        .timeout(_requestTimeout);

    final data = _decodeMap(response);

    return {
      ...data,
      'success': response.statusCode >= 200 && response.statusCode < 300,
    };
  }

  static Future<void> logout() async {
    final token = await getToken();
    final prefs = await SharedPreferences.getInstance();

    try {
      if (token != null && token.isNotEmpty) {
        await http
            .post(
              Uri.parse('$baseUrl/logout'),
              headers: _headers(token: token),
            )
            .timeout(_requestTimeout);
      }
    } catch (_) {
      // La session locale est quand même supprimée si le serveur est indisponible.
    } finally {
      await prefs.clear();
    }
  }
}
