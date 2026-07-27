import 'package:flutter/material.dart';

import '../services/api_service.dart';
import '../services/app_settings_service.dart';
import '../theme/app_theme.dart';

class ScoresScreen extends StatefulWidget {
  const ScoresScreen({super.key});

  @override
  State<ScoresScreen> createState() => _ScoresScreenState();
}

class _ScoresScreenState extends State<ScoresScreen> {
  late Future<List<dynamic>> scoresFuture;

  @override
  void initState() {
    super.initState();
    scoresFuture = ApiService.getMyScores();
  }

  Future<void> refreshScores() async {
    setState(() {
      scoresFuture = ApiService.getMyScores();
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
            const _ScoresHeader(),

            Expanded(
              child: FutureBuilder<List<dynamic>>(
                future: scoresFuture,
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
                      message: settings.tr('scores_load_error'),
                      buttonText: settings.tr('retry'),
                      onPressed: refreshScores,
                    );
                  }

                  final scores = snapshot.data ?? [];

                  if (scores.isEmpty) {
                    return _StateMessage(
                      icon: Icons.emoji_events_outlined,
                      color: Colors.deepOrange,
                      title: settings.tr('scores_empty_title'),
                      message: settings.tr('scores_empty_message'),
                      buttonText: settings.tr('refresh'),
                      onPressed: refreshScores,
                    );
                  }

                  return RefreshIndicator(
                    onRefresh: refreshScores,
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
                          itemCount: scores.length,
                          itemBuilder: (context, index) {
                            return ScoreCard(
                              score: scores[index],
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

class _ScoresHeader extends StatelessWidget {
  const _ScoresHeader();

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
        color: Colors.deepOrange,
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
              Icons.emoji_events_outlined,
              color: Colors.deepOrange,
              size: smallPhone ? 25 : 28,
            ),
          ),

          const SizedBox(width: 12),

          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  settings.tr('scores_title'),
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
                  settings.tr('scores_header_subtitle'),
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

class ScoreCard extends StatelessWidget {
  final Map<String, dynamic> score;

  const ScoreCard({
    super.key,
    required this.score,
  });

  @override
  Widget build(BuildContext context) {
    final settings = AppSettingsService.instance;

    final quiz = score['quiz'];

    final int scoreValue = score['score'] ?? 0;
    final int total = score['total'] ?? 0;

    final double percentage = total > 0 ? scoreValue / total : 0;
    final int percentText = (percentage * 100).round();

    final bool smallPhone = MediaQuery.of(context).size.width < 360;
    final bool isDark = Theme.of(context).brightness == Brightness.dark;

    return Card(
      margin: const EdgeInsets.only(bottom: 14),
      elevation: 4,
      shadowColor: Colors.black.withOpacity(0.08),
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(20),
      ),
      child: Padding(
        padding: EdgeInsets.all(smallPhone ? 14 : 16),
        child: Row(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Container(
              width: smallPhone ? 46 : 52,
              height: smallPhone ? 46 : 52,
              decoration: BoxDecoration(
                color: Colors.deepOrange.withOpacity(0.14),
                borderRadius: BorderRadius.circular(16),
              ),
              child: Icon(
                Icons.emoji_events_outlined,
                color: Colors.deepOrange,
                size: smallPhone ? 26 : 30,
              ),
            ),

            const SizedBox(width: 14),

            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    quiz?['title'] ?? settings.tr('unknown_quiz'),
                    maxLines: 2,
                    overflow: TextOverflow.ellipsis,
                    style: TextStyle(
                      color: isDark ? AppColors.textLight : AppColors.textDark,
                      fontSize: smallPhone ? 16 : 17,
                      fontWeight: FontWeight.bold,
                      height: 1.3,
                    ),
                  ),

                  const SizedBox(height: 8),

                  Text(
                    '${settings.tr('score_label')} : $scoreValue / $total',
                    style: const TextStyle(
                      color: Colors.deepOrange,
                      fontWeight: FontWeight.w600,
                    ),
                  ),

                  const SizedBox(height: 12),

                  ClipRRect(
                    borderRadius: BorderRadius.circular(10),
                    child: LinearProgressIndicator(
                      value: percentage,
                      minHeight: 8,
                      backgroundColor:
                          isDark ? Colors.white12 : Colors.grey.shade200,
                      color: Colors.deepOrange,
                    ),
                  ),

                  const SizedBox(height: 8),

                  Text(
                    '$percentText ${settings.tr('success_percent')}',
                    style: TextStyle(
                      color: isDark
                          ? AppColors.textMutedDark
                          : AppColors.textMuted,
                      fontSize: 13,
                    ),
                  ),
                ],
              ),
            ),
          ],
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
          constraints: const BoxConstraints(maxWidth: 420),
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