import 'package:flutter/material.dart';

import '../services/api_service.dart';
import '../services/app_settings_service.dart';
import '../theme/app_theme.dart';

class ProgressionScreen extends StatefulWidget {
  const ProgressionScreen({super.key});

  @override
  State<ProgressionScreen> createState() => _ProgressionScreenState();
}

class _ProgressionScreenState extends State<ProgressionScreen> {
  late Future<List<dynamic>> progressionsFuture;

  @override
  void initState() {
    super.initState();
    progressionsFuture = ApiService.getProgressions();
  }

  Future<void> refreshProgressions() async {
    setState(() {
      progressionsFuture = ApiService.getProgressions();
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
            const _ProgressionHeader(),

            Expanded(
              child: FutureBuilder<List<dynamic>>(
                future: progressionsFuture,
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
                      message: settings.tr('progression_load_error'),
                      buttonText: settings.tr('retry'),
                      onPressed: refreshProgressions,
                    );
                  }

                  final progressions = snapshot.data ?? [];

                  if (progressions.isEmpty) {
                    return _StateMessage(
                      icon: Icons.trending_up,
                      color: AppColors.success,
                      title: settings.tr('progression_empty_title'),
                      message: settings.tr('progression_empty_message'),
                      buttonText: settings.tr('refresh'),
                      onPressed: refreshProgressions,
                    );
                  }

                  return RefreshIndicator(
                    onRefresh: refreshProgressions,
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
                          itemCount: progressions.length,
                          itemBuilder: (context, index) {
                            return ProgressionCard(
                              progression: progressions[index],
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

class _ProgressionHeader extends StatelessWidget {
  const _ProgressionHeader();

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
        color: AppColors.success,
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
              Icons.trending_up,
              color: AppColors.success,
              size: smallPhone ? 25 : 28,
            ),
          ),

          const SizedBox(width: 12),

          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  settings.tr('progression_title'),
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
                  settings.tr('progression_header_subtitle'),
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

class ProgressionCard extends StatelessWidget {
  final Map<String, dynamic> progression;

  const ProgressionCard({
    super.key,
    required this.progression,
  });

  @override
  Widget build(BuildContext context) {
    final settings = AppSettingsService.instance;

    final module = progression['module_educatif'];
    final int percentage = progression['progress_percentage'] ?? 0;

    final bool isCompleted =
        progression['is_completed'] == true || progression['is_completed'] == 1;

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
                color: AppColors.success.withOpacity(0.14),
                borderRadius: BorderRadius.circular(16),
              ),
              child: Icon(
                isCompleted ? Icons.check_circle_outline : Icons.timelapse,
                color: AppColors.success,
                size: smallPhone ? 26 : 30,
              ),
            ),

            const SizedBox(width: 14),

            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    module?['title'] ?? settings.tr('unknown_module'),
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
                    isCompleted
                        ? settings.tr('completed')
                        : settings.tr('in_progress'),
                    style: TextStyle(
                      color: isCompleted ? AppColors.success : AppColors.accent,
                      fontWeight: FontWeight.w600,
                    ),
                  ),

                  const SizedBox(height: 12),

                  ClipRRect(
                    borderRadius: BorderRadius.circular(10),
                    child: LinearProgressIndicator(
                      value: percentage / 100,
                      minHeight: 8,
                      backgroundColor:
                          isDark ? Colors.white12 : Colors.grey.shade200,
                      color: AppColors.success,
                    ),
                  ),

                  const SizedBox(height: 8),

                  Text(
                    '$percentage ${settings.tr('completed_percent')}',
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