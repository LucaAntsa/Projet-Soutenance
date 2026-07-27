import 'package:flutter/material.dart';

import '../services/api_service.dart';
import '../services/app_settings_service.dart';
import '../theme/app_theme.dart';

import 'quiz_detail_screen.dart';

class QuizzesScreen extends StatefulWidget {
  const QuizzesScreen({super.key});

  @override
  State<QuizzesScreen> createState() => _QuizzesScreenState();
}

class _QuizzesScreenState extends State<QuizzesScreen> {
  late Future<List<dynamic>> quizzesFuture;

  @override
  void initState() {
    super.initState();
    quizzesFuture = ApiService.getQuizzes();
  }

  Future<void> refreshQuizzes() async {
    setState(() {
      quizzesFuture = ApiService.getQuizzes();
    });
  }

  @override
  Widget build(BuildContext context) {
    final settings = AppSettingsService.instance;

    return Scaffold(
      backgroundColor: Theme.of(context).scaffoldBackgroundColor,
      body: SafeArea(
        child: Column(
          children: [
            const _QuizzesHeader(),
            Expanded(
              child: FutureBuilder<List<dynamic>>(
                future: quizzesFuture,
                builder: (context, snapshot) {
                  if (snapshot.connectionState == ConnectionState.waiting) {
                    return const Center(
                      child: CircularProgressIndicator(),
                    );
                  }

                  if (snapshot.hasError) {
                    return _StateMessage(
                      icon: Icons.error_outline,
                      color: AppColors.danger,
                      title: settings.tr('error'),
                      message: settings.tr('quiz_load_error'),
                      buttonText: settings.tr('retry'),
                      onPressed: refreshQuizzes,
                    );
                  }

                  final quizzes = snapshot.data ?? [];

                  if (quizzes.isEmpty) {
                    return _StateMessage(
                      icon: Icons.quiz_outlined,
                      color: Colors.purple,
                      title: settings.tr('quiz_empty_title'),
                      message: settings.tr('quiz_empty_message'),
                      buttonText: settings.tr('refresh'),
                      onPressed: refreshQuizzes,
                    );
                  }

                  return RefreshIndicator(
                    onRefresh: refreshQuizzes,
                    child: LayoutBuilder(
                      builder: (context, constraints) {
                        final bool smallPhone = constraints.maxWidth < 360;

                        return ListView.builder(
                          physics: const AlwaysScrollableScrollPhysics(),
                          padding: EdgeInsets.fromLTRB(
                            smallPhone ? 12 : 16,
                            16,
                            smallPhone ? 12 : 16,
                            24,
                          ),
                          itemCount: quizzes.length,
                          itemBuilder: (context, index) {
                            final quiz = quizzes[index];

                            return QuizCard(
                              quiz: quiz,
                              onTap: () {
                                Navigator.push(
                                  context,
                                  MaterialPageRoute(
                                    builder: (_) => QuizDetailScreen(
                                      quizId: quiz['id'],
                                    ),
                                  ),
                                );
                              },
                            );
                          },
                        );
                      },
                    ),
                  );
                },
              ),
            ),
          ],
        ),
      ),
    );
  }
}

class _QuizzesHeader extends StatelessWidget {
  const _QuizzesHeader();

  @override
  Widget build(BuildContext context) {
    final settings = AppSettingsService.instance;
    final bool smallPhone = MediaQuery.of(context).size.width < 360;

    return Container(
      width: double.infinity,
      padding: EdgeInsets.fromLTRB(
        smallPhone ? 14 : 20,
        18,
        smallPhone ? 14 : 20,
        24,
      ),
      decoration: const BoxDecoration(
        color: Colors.purple,
        borderRadius: BorderRadius.only(
          bottomLeft: Radius.circular(28),
          bottomRight: Radius.circular(28),
        ),
      ),
      child: Row(
        children: [
          IconButton(
            onPressed: () => Navigator.pop(context),
            icon: const Icon(
              Icons.arrow_back,
              color: Colors.white,
            ),
          ),
          const SizedBox(width: 6),
          CircleAvatar(
            radius: smallPhone ? 21 : 24,
            backgroundColor: Colors.white,
            child: Icon(
              Icons.quiz_outlined,
              color: Colors.purple,
              size: smallPhone ? 25 : 28,
            ),
          ),
          const SizedBox(width: 12),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  settings.tr('quiz_title'),
                  maxLines: 1,
                  overflow: TextOverflow.ellipsis,
                  style: TextStyle(
                    color: Colors.white,
                    fontSize: smallPhone ? 18 : 21,
                    fontWeight: FontWeight.bold,
                  ),
                ),
                const SizedBox(height: 4),
                Text(
                  settings.tr('quiz_header_subtitle'),
                  maxLines: 1,
                  overflow: TextOverflow.ellipsis,
                  style: const TextStyle(
                    color: Colors.white70,
                    fontSize: 14,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}

class QuizCard extends StatelessWidget {
  final Map<String, dynamic> quiz;
  final VoidCallback onTap;

  const QuizCard({
    super.key,
    required this.quiz,
    required this.onTap,
  });

  @override
  Widget build(BuildContext context) {
    final settings = AppSettingsService.instance;
    final module = quiz['module_educatif'];

    final bool smallPhone = MediaQuery.of(context).size.width < 360;
    final bool isDark = Theme.of(context).brightness == Brightness.dark;

    return Card(
      margin: const EdgeInsets.only(bottom: 14),
      elevation: 4,
      shadowColor: Colors.black.withOpacity(0.08),
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(20),
      ),
      child: InkWell(
        borderRadius: BorderRadius.circular(20),
        onTap: onTap,
        child: Padding(
          padding: EdgeInsets.all(smallPhone ? 14 : 16),
          child: Row(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Container(
                width: smallPhone ? 46 : 52,
                height: smallPhone ? 46 : 52,
                decoration: BoxDecoration(
                  color: Colors.purple.withOpacity(0.14),
                  borderRadius: BorderRadius.circular(16),
                ),
                child: Icon(
                  Icons.quiz_outlined,
                  color: Colors.purple,
                  size: smallPhone ? 26 : 30,
                ),
              ),
              const SizedBox(width: 14),
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      quiz['title'] ?? settings.tr('no_title'),
                      maxLines: 2,
                      overflow: TextOverflow.ellipsis,
                      style: TextStyle(
                        color:
                            isDark ? AppColors.textLight : AppColors.textDark,
                        fontSize: smallPhone ? 16 : 17,
                        fontWeight: FontWeight.bold,
                        height: 1.3,
                      ),
                    ),
                    const SizedBox(height: 8),
                    Container(
                      padding: const EdgeInsets.symmetric(
                        horizontal: 10,
                        vertical: 5,
                      ),
                      decoration: BoxDecoration(
                        color: Colors.purple.withOpacity(0.10),
                        borderRadius: BorderRadius.circular(20),
                      ),
                      child: Text(
                        module != null
                            ? '${settings.tr('module_label')} : ${module['title']}'
                            : settings.tr('educational_quiz'),
                        maxLines: 1,
                        overflow: TextOverflow.ellipsis,
                        style: const TextStyle(
                          color: Colors.purple,
                          fontSize: 12,
                          fontWeight: FontWeight.w600,
                        ),
                      ),
                    ),
                    const SizedBox(height: 10),
                    Text(
                      quiz['description'] ??
                          settings.tr('answer_quiz_questions'),
                      maxLines: 2,
                      overflow: TextOverflow.ellipsis,
                      style: TextStyle(
                        color: isDark
                            ? AppColors.textMutedDark
                            : AppColors.textMuted,
                        fontSize: 14,
                        height: 1.4,
                      ),
                    ),
                  ],
                ),
              ),
              const SizedBox(width: 8),
              Icon(
                Icons.arrow_forward_ios,
                size: 16,
                color: isDark ? AppColors.textMutedDark : AppColors.textMuted,
              ),
            ],
          ),
        ),
      ),
    );
  }
}

class _StateMessage extends StatelessWidget {
  final IconData icon;
  final Color color;
  final String title;
  final String message;
  final String buttonText;
  final VoidCallback onPressed;

  const _StateMessage({
    required this.icon,
    required this.color,
    required this.title,
    required this.message,
    required this.buttonText,
    required this.onPressed,
  });

  @override
  Widget build(BuildContext context) {
    final bool isDark = Theme.of(context).brightness == Brightness.dark;

    return Center(
      child: Padding(
        padding: const EdgeInsets.all(24),
        child: ConstrainedBox(
          constraints: const BoxConstraints(
            maxWidth: 420,
          ),
          child: Card(
            elevation: 3,
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(22),
            ),
            child: Padding(
              padding: const EdgeInsets.all(24),
              child: Column(
                mainAxisSize: MainAxisSize.min,
                children: [
                  Icon(
                    icon,
                    color: color,
                    size: 52,
                  ),
                  const SizedBox(height: 14),
                  Text(
                    title,
                    textAlign: TextAlign.center,
                    style: TextStyle(
                      color: isDark ? AppColors.textLight : AppColors.textDark,
                      fontSize: 20,
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                  const SizedBox(height: 8),
                  Text(
                    message,
                    textAlign: TextAlign.center,
                    style: TextStyle(
                      color: isDark
                          ? AppColors.textMutedDark
                          : AppColors.textMuted,
                      fontSize: 14,
                      height: 1.4,
                    ),
                  ),
                  const SizedBox(height: 18),
                  OutlinedButton(
                    onPressed: onPressed,
                    child: Text(buttonText),
                  ),
                ],
              ),
            ),
          ),
        ),
      ),
    );
  }
}