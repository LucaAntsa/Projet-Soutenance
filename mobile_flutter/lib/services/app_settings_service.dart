import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';

class AppSettingsService extends ChangeNotifier {
  static final AppSettingsService instance = AppSettingsService._internal();

  AppSettingsService._internal();

  ThemeMode _themeMode = ThemeMode.light;
  Locale _locale = const Locale('fr');

  ThemeMode get themeMode => _themeMode;
  Locale get locale => _locale;

  bool get isDarkMode => _themeMode == ThemeMode.dark;
  bool get isMalagasy => _locale.languageCode == 'mg';

  Future<void> loadSettings() async {
    final prefs = await SharedPreferences.getInstance();

    final theme = prefs.getString('theme_mode') ?? 'light';
    final language = prefs.getString('language_code') ?? 'fr';

    _themeMode = theme == 'dark' ? ThemeMode.dark : ThemeMode.light;
    _locale = Locale(language);

    notifyListeners();
  }

  Future<void> toggleTheme() async {
    final prefs = await SharedPreferences.getInstance();

    _themeMode = _themeMode == ThemeMode.dark
        ? ThemeMode.light
        : ThemeMode.dark;

    await prefs.setString(
      'theme_mode',
      _themeMode == ThemeMode.dark ? 'dark' : 'light',
    );

    notifyListeners();
  }

  Future<void> changeLanguage(String languageCode) async {
    final prefs = await SharedPreferences.getInstance();

    _locale = Locale(languageCode);
    await prefs.setString('language_code', languageCode);

    notifyListeners();
  }

  String tr(String key) {
    return _translations[_locale.languageCode]?[key] ??
        _translations['fr']?[key] ??
        key;
  }
}

const Map<String, Map<String, String>> _translations = {
  'fr': {
    'app_name': 'Éducation Familiale',
    'parent_space': 'Espace parent',
    'welcome': 'Bienvenue 👋',
    'home_description':
        'Suivez les modules, consultez les conseils et testez vos connaissances grâce aux quiz.',
    'modules': 'Modules',
    'modules_subtitle': 'Cours éducatifs',
    'conseils': 'Conseils',
    'conseils_subtitle': 'Astuces pratiques',
    'quiz': 'Quiz',
    'quiz_subtitle': 'Exercices',
    'progression': 'Progression',
    'progression_subtitle': 'Suivi personnel',
    'scores': 'Mes scores',
    'scores_subtitle': 'Résultats quiz',
    'settings': 'Paramètres',
    'language': 'Langue',
    'theme': 'Thème',
    'french': 'Français',
    'malagasy': 'Malagasy',
    'dark_mode': 'Mode sombre',
    'light_mode': 'Mode clair',
    'login': 'Connexion',
    'login_subtitle': 'Connectez-vous pour accéder aux modules, conseils et quiz.',
    'email_address': 'Adresse email',
    'password': 'Mot de passe',
    'login_button': 'Se connecter',
    'login_loading': 'Connexion...',
    'no_account': 'Pas encore de compte ?',
    'create_account': 'Créer un compte',
    'platform_subtitle': 'Plateforme d’accompagnement parental',
    'login_failed': 'Connexion échouée.',
    'server_error': 'Erreur de connexion au serveur Laravel.',
    'account_info': 'Informations du compte',
    'register_subtitle': 'Remplissez les informations ci-dessous pour accéder aux contenus éducatifs.',
    'full_name': 'Nom complet',
    'register_button': 'S’inscrire',
    'register_loading': 'Inscription...',
    'already_have_account': 'J’ai déjà un compte',
    'parent_registration': 'Inscription réservée aux parents',
    'register_success': 'Compte créé avec succès. Vous pouvez maintenant vous connecter.',
    'register_failed': 'Inscription échouée.',
    'error': 'Erreur',
    'retry': 'Réessayer',
    'refresh': 'Actualiser',
    'no_title': 'Sans titre',
    'no_category': 'Non classé',
    'no_description': 'Aucune description disponible.',
    'no_content': 'Aucun contenu disponible.',

    'modules_title': 'Modules éducatifs',
    'modules_header_subtitle': 'Apprendre à son rythme',
    'modules_load_error': 'Impossible de charger les modules.',
    'modules_empty_title': 'Aucun module',
    'modules_empty_message': 'Aucun module éducatif n’est disponible pour le moment.',

    'conseils_title': 'Conseils pratiques',
    'conseils_header_subtitle': 'Accompagnement parental',
    'conseils_load_error': 'Impossible de charger les conseils.',
    'conseils_empty_title': 'Aucun conseil',
    'conseils_empty_message': 'Aucun conseil disponible pour le moment.',
    'conseil_parental': 'Conseil parental',

    'quiz_title': 'Quiz',
    'quiz_header_subtitle': 'Testez vos connaissances',
    'quiz_load_error': 'Impossible de charger les quiz.',
    'quiz_empty_title': 'Aucun quiz',
    'quiz_empty_message': 'Aucun quiz disponible pour le moment.',
    'educational_quiz': 'Quiz éducatif',
    'answer_quiz_questions': 'Répondez aux questions du quiz.',
    'module_label': 'Module',

    'progression_title': 'Ma progression',
    'progression_header_subtitle': 'Suivi des modules terminés',
    'progression_load_error': 'Impossible de charger la progression.',
    'progression_empty_title': 'Aucune progression',
    'progression_empty_message': 'Aucun module terminé pour le moment.',
    'unknown_module': 'Module inconnu',
    'completed': 'Terminé',
    'in_progress': 'En cours',
    'completed_percent': '% complété',

    'scores_title': 'Mes scores',
    'scores_header_subtitle': 'Historique des résultats',
    'scores_load_error': 'Impossible de charger les scores.',
    'scores_empty_title': 'Aucun score',
    'scores_empty_message': 'Aucun résultat de quiz enregistré.',
    'unknown_quiz': 'Quiz inconnu',
    'score_label': 'Score',
    'success_percent': '% réussi',
    'module_detail_title': 'Détail du module',
    'module_detail_subtitle': 'Lecture du contenu éducatif',
    'description': 'Description',
    'module_content': 'Contenu du module',
    'no_description_short': 'Aucune description.',
    'module_completed_success': 'Module marqué comme terminé.',
    'module_completed_error': 'Erreur lors de l’enregistrement de la progression.',
    'saving': 'Enregistrement...',
    'mark_as_completed': 'Marquer comme terminé',
    'conseil_detail_title': 'Détail du conseil',
    'conseil_content': 'Contenu du conseil',
    'quiz_detail_title': 'Détail du quiz',
    'quiz_detail_subtitle': 'Répondez aux questions',
    'must_answer_all': 'Veuillez répondre à toutes les questions.',
    'quiz_submit_success': 'Quiz soumis avec succès.',
    'quiz_submit_error': 'Erreur lors de la soumission du quiz.',
    'submitting': 'Soumission...',
    'submit_quiz': 'Soumettre le quiz',
    'question_label': 'Question',
    'no_question_available': 'Aucune question disponible pour ce quiz.',
    'quiz_load_detail_error': 'Erreur lors du chargement du quiz.',
  },
  'mg': {
    'app_name': 'Fanabeazana ara-pianakaviana',
    'parent_space': 'Sehatra ho an’ny ray aman-dreny',
    'welcome': 'Tongasoa 👋',
    'home_description':
        'Araho ny modules, vakio ny torohevitra ary sedrao amin’ny quiz ny fahalalanao.',
    'modules': 'Modules',
    'modules_subtitle': 'Lesona fanabeazana',
    'conseils': 'Torohevitra',
    'conseils_subtitle': 'Torohevitra azo ampiharina',
    'quiz': 'Quiz',
    'quiz_subtitle': 'Fanazaran-tena',
    'progression': 'Fandrosoana',
    'progression_subtitle': 'Fanaraha-maso manokana',
    'scores': 'Naotiko',
    'scores_subtitle': 'Vokatry ny quiz',
    'settings': 'Paramètres',
    'language': 'Fiteny',
    'theme': 'Endrika',
    'french': 'Français',
    'malagasy': 'Malagasy',
    'dark_mode': 'Mode sombre',
    'light_mode': 'Mode clair',
    'login': 'Hiditra',
    'login_subtitle': 'Midira raha hijery modules, torohevitra ary quiz.',
    'email_address': 'Adiresy email',
    'password': 'Teny miafina',
    'login_button': 'Hiditra',
    'login_loading': 'Miandry...',
    'no_account': 'Mbola tsy manana kaonty ?',
    'create_account': 'Hamorona kaonty',
    'platform_subtitle': 'Sehatra fanampiana ny ray aman-dreny',
    'login_failed': 'Tsy tafiditra.',
    'server_error': 'Tsy afaka mifandray amin’ny serveur Laravel.',
    'account_info': 'Mombamomba ny kaonty',
    'register_subtitle': 'Fenoy ireto mombamomba ireto mba hahafahanao miditra amin’ny votoaty fanabeazana.',
    'full_name': 'Anarana feno',
    'register_button': 'Hisoratra anarana',
    'register_loading': 'Miandry...',
    'already_have_account': 'Efa manana kaonty aho',
    'parent_registration': 'Fisoratana ho an’ny ray aman-dreny ihany',
    'register_success': 'Vita soa aman-tsara ny famoronana kaonty. Afaka miditra ianao izao.',
    'register_failed': 'Tsy tontosa ny fisoratana anarana.',
    'error': 'Hadisoana',
    'retry': 'Andramo indray',
    'refresh': 'Havaozy',
    'no_title': 'Tsy misy lohateny',
    'no_category': 'Tsy voasokajy',
    'no_description': 'Tsy misy fanazavana.',
    'no_content': 'Tsy misy votoaty.',

    'modules_title': 'Modules fanabeazana',
    'modules_header_subtitle': 'Mianara araka ny hafainganana tianao',
    'modules_load_error': 'Tsy afaka maka ny modules.',
    'modules_empty_title': 'Tsy misy module',
    'modules_empty_message': 'Tsy mbola misy module fanabeazana amin’izao fotoana izao.',

    'conseils_title': 'Torohevitra',
    'conseils_header_subtitle': 'Fanampiana ny ray aman-dreny',
    'conseils_load_error': 'Tsy afaka maka ny torohevitra.',
    'conseils_empty_title': 'Tsy misy torohevitra',
    'conseils_empty_message': 'Tsy mbola misy torohevitra amin’izao fotoana izao.',
    'conseil_parental': 'Torohevitra ho an’ny ray aman-dreny',

    'quiz_title': 'Quiz',
    'quiz_header_subtitle': 'Sedrao ny fahalalanao',
    'quiz_load_error': 'Tsy afaka maka ny quiz.',
    'quiz_empty_title': 'Tsy misy quiz',
    'quiz_empty_message': 'Tsy mbola misy quiz amin’izao fotoana izao.',
    'educational_quiz': 'Quiz fanabeazana',
    'answer_quiz_questions': 'Valio ireo fanontaniana ao amin’ny quiz.',
    'module_label': 'Module',

    'progression_title': 'Fandrosoako',
    'progression_header_subtitle': 'Fanaraha-maso ireo modules vita',
    'progression_load_error': 'Tsy afaka maka ny fandrosoana.',
    'progression_empty_title': 'Tsy misy fandrosoana',
    'progression_empty_message': 'Tsy mbola misy module vita.',
    'unknown_module': 'Module tsy fantatra',
    'completed': 'Vita',
    'in_progress': 'An-dalana',
    'completed_percent': '% vita',

    'scores_title': 'Naotiko',
    'scores_header_subtitle': 'Tantaran’ny vokatra',
    'scores_load_error': 'Tsy afaka maka ny naoty.',
    'scores_empty_title': 'Tsy misy naoty',
    'scores_empty_message': 'Tsy mbola misy vokatra quiz voatahiry.',
    'unknown_quiz': 'Quiz tsy fantatra',
    'score_label': 'Naoty',
    'success_percent': '% nahomby',
    'module_detail_title': 'Antsipirian’ny module',
    'module_detail_subtitle': 'Famakiana ny votoaty fanabeazana',
    'description': 'Fanazavana',
    'module_content': 'Votoatin’ny module',
    'no_description_short': 'Tsy misy fanazavana.',
    'module_completed_success': 'Voamarika ho vita ny module.',
    'module_completed_error': 'Nisy olana tamin’ny fitahirizana ny fandrosoana.',
    'saving': 'Mitahiry...',
    'mark_as_completed': 'Mariho ho vita',
    'conseil_detail_title': 'Antsipirian’ny torohevitra',
    'conseil_content': 'Votoatin’ny torohevitra',
    'quiz_detail_title': 'Antsipirian’ny quiz',
    'quiz_detail_subtitle': 'Valio ireo fanontaniana',
    'must_answer_all': 'Valio avokoa aloha ny fanontaniana rehetra.',
    'quiz_submit_success': 'Nalefa soa aman-tsara ny quiz.',
    'quiz_submit_error': 'Nisy olana tamin’ny fandefasana ny quiz.',
    'submitting': 'Mandefa...',
    'submit_quiz': 'Alefa ny quiz',
    'question_label': 'Fanontaniana',
    'no_question_available': 'Tsy mbola misy fanontaniana amin’ity quiz ity.',
    'quiz_load_detail_error': 'Nisy olana tamin’ny fakana ny quiz.',
  },
};