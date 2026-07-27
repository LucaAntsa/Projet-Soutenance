import 'package:flutter/material.dart';

import '../services/app_settings_service.dart';
import '../theme/app_theme.dart';

class ConseilDetailScreen extends StatelessWidget {
  final Map<String, dynamic> conseil;

  const ConseilDetailScreen({
    super.key,
    required this.conseil,
  });

  @override
  Widget build(BuildContext context) {
    final settings = AppSettingsService.instance;
    final bool isDark = Theme.of(context).brightness == Brightness.dark;

    return Scaffold(
      backgroundColor: Theme.of(context).scaffoldBackgroundColor,
      body: SafeArea(
        child: LayoutBuilder(
          builder: (context, constraints) {
            final bool smallPhone = constraints.maxWidth < 360;

            return Column(
              children: [
                _Header(smallPhone: smallPhone),

                Expanded(
                  child: SingleChildScrollView(
                    padding: EdgeInsets.fromLTRB(
                      smallPhone ? 12 : 16,
                      16,
                      smallPhone ? 12 : 16,
                      24,
                    ),
                    child: Center(
                      child: ConstrainedBox(
                        constraints: const BoxConstraints(maxWidth: 620),
                        child: Card(
                          elevation: 4,
                          shadowColor: Colors.black.withOpacity(0.08),
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(22),
                          ),
                          child: Padding(
                            padding: EdgeInsets.all(smallPhone ? 18 : 22),
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                Row(
                                  crossAxisAlignment: CrossAxisAlignment.start,
                                  children: [
                                    Container(
                                      width: smallPhone ? 48 : 56,
                                      height: smallPhone ? 48 : 56,
                                      decoration: BoxDecoration(
                                        color:
                                            AppColors.accent.withOpacity(0.14),
                                        borderRadius: BorderRadius.circular(18),
                                      ),
                                      child: Icon(
                                        Icons.lightbulb_outline,
                                        color: AppColors.accent,
                                        size: smallPhone ? 28 : 32,
                                      ),
                                    ),

                                    const SizedBox(width: 14),

                                    Expanded(
                                      child: Column(
                                        crossAxisAlignment:
                                            CrossAxisAlignment.start,
                                        children: [
                                          Text(
                                            conseil['title'] ??
                                                settings.tr('no_title'),
                                            style: TextStyle(
                                              color: isDark
                                                  ? AppColors.textLight
                                                  : AppColors.textDark,
                                              fontSize: smallPhone ? 21 : 24,
                                              fontWeight: FontWeight.bold,
                                              height: 1.25,
                                            ),
                                          ),

                                          const SizedBox(height: 10),

                                          Container(
                                            padding: const EdgeInsets.symmetric(
                                              horizontal: 11,
                                              vertical: 6,
                                            ),
                                            decoration: BoxDecoration(
                                              color: AppColors.accent
                                                  .withOpacity(0.10),
                                              borderRadius:
                                                  BorderRadius.circular(20),
                                            ),
                                            child: Text(
                                              conseil['theme'] ??
                                                  settings.tr('conseil_parental'),
                                              maxLines: 1,
                                              overflow: TextOverflow.ellipsis,
                                              style: const TextStyle(
                                                color: AppColors.accent,
                                                fontSize: 12,
                                                fontWeight: FontWeight.w700,
                                              ),
                                            ),
                                          ),
                                        ],
                                      ),
                                    ),
                                  ],
                                ),

                                const SizedBox(height: 26),

                                _SectionTitle(
                                  icon: Icons.article_outlined,
                                  title: settings.tr('conseil_content'),
                                ),

                                const SizedBox(height: 10),

                                Text(
                                  conseil['content'] ??
                                      settings.tr('no_content'),
                                  style: TextStyle(
                                    color: isDark
                                        ? AppColors.textLight
                                        : AppColors.textDark,
                                    fontSize: 15,
                                    height: 1.7,
                                  ),
                                ),
                              ],
                            ),
                          ),
                        ),
                      ),
                    ),
                  ),
                ),
              ],
            );
          },
        ),
      ),
    );
  }
}

class _Header extends StatelessWidget {
  final bool smallPhone;

  const _Header({
    required this.smallPhone,
  });

  @override
  Widget build(BuildContext context) {
    final settings = AppSettingsService.instance;

    return Container(
      width: double.infinity,
      padding: EdgeInsets.fromLTRB(
        smallPhone ? 14 : 20,
        18,
        smallPhone ? 14 : 20,
        24,
      ),
      decoration: const BoxDecoration(
        color: AppColors.accent,
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
              Icons.lightbulb_outline,
              color: AppColors.accent,
              size: smallPhone ? 25 : 28,
            ),
          ),

          const SizedBox(width: 12),

          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  settings.tr('conseil_detail_title'),
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
                  settings.tr('conseils_header_subtitle'),
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

class _SectionTitle extends StatelessWidget {
  final IconData icon;
  final String title;

  const _SectionTitle({
    required this.icon,
    required this.title,
  });

  @override
  Widget build(BuildContext context) {
    final bool isDark = Theme.of(context).brightness == Brightness.dark;

    return Row(
      children: [
        Icon(
          icon,
          color: AppColors.accent,
          size: 22,
        ),
        const SizedBox(width: 8),
        Text(
          title,
          style: TextStyle(
            color: isDark ? AppColors.textLight : AppColors.textDark,
            fontSize: 18,
            fontWeight: FontWeight.bold,
          ),
        ),
      ],
    );
  }
}