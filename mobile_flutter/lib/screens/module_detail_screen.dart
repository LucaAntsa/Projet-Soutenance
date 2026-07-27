import 'package:flutter/material.dart';

import '../services/api_service.dart';
import '../services/app_settings_service.dart';
import '../theme/app_theme.dart';

class ModuleDetailScreen extends StatefulWidget {
  final Map<String, dynamic> module;

  const ModuleDetailScreen({
    super.key,
    required this.module,
  });

  @override
  State<ModuleDetailScreen> createState() => _ModuleDetailScreenState();
}

class _ModuleDetailScreenState extends State<ModuleDetailScreen> {
  bool isLoading = false;
  String? message;
  bool isSuccess = false;

  Future<void> completeModule() async {
    final settings = AppSettingsService.instance;

    setState(() {
      isLoading = true;
      message = null;
      isSuccess = false;
    });

    try {
      final moduleId = widget.module['id'];
      final data = await ApiService.completeModule(moduleId);

      setState(() {
        isSuccess = true;
        message = data['message'] ?? settings.tr('module_completed_success');
      });
    } catch (e) {
      setState(() {
        isSuccess = false;
        message = settings.tr('module_completed_error');
      });
    } finally {
      if (mounted) {
        setState(() {
          isLoading = false;
        });
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    final settings = AppSettingsService.instance;
    final category = widget.module['category'];

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
                                            AppColors.primary.withOpacity(0.12),
                                        borderRadius: BorderRadius.circular(18),
                                      ),
                                      child: Icon(
                                        Icons.menu_book,
                                        color: AppColors.primary,
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
                                            widget.module['title'] ??
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

                                          if (category != null)
                                            Container(
                                              padding:
                                                  const EdgeInsets.symmetric(
                                                horizontal: 11,
                                                vertical: 6,
                                              ),
                                              decoration: BoxDecoration(
                                                color: AppColors.primary
                                                    .withOpacity(0.08),
                                                borderRadius:
                                                    BorderRadius.circular(20),
                                              ),
                                              child: Text(
                                                category['name'] ??
                                                    settings.tr('no_category'),
                                                maxLines: 1,
                                                overflow: TextOverflow.ellipsis,
                                                style: const TextStyle(
                                                  color: AppColors.primary,
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

                                const SizedBox(height: 24),

                                _SectionTitle(
                                  icon: Icons.description_outlined,
                                  title: settings.tr('description'),
                                ),

                                const SizedBox(height: 8),

                                Text(
                                  widget.module['description'] ??
                                      settings.tr('no_description_short'),
                                  style: TextStyle(
                                    color: isDark
                                        ? AppColors.textMutedDark
                                        : AppColors.textMuted,
                                    fontSize: 15,
                                    height: 1.6,
                                  ),
                                ),

                                const SizedBox(height: 24),

                                _SectionTitle(
                                  icon: Icons.article_outlined,
                                  title: settings.tr('module_content'),
                                ),

                                const SizedBox(height: 8),

                                Text(
                                  widget.module['content'] ??
                                      settings.tr('no_content'),
                                  style: TextStyle(
                                    color: isDark
                                        ? AppColors.textLight
                                        : AppColors.textDark,
                                    fontSize: 15,
                                    height: 1.7,
                                  ),
                                ),

                                const SizedBox(height: 26),

                                if (message != null)
                                  Container(
                                    width: double.infinity,
                                    padding: const EdgeInsets.all(13),
                                    margin: const EdgeInsets.only(bottom: 16),
                                    decoration: BoxDecoration(
                                      color: isSuccess
                                          ? AppColors.success.withOpacity(0.08)
                                          : AppColors.danger.withOpacity(0.08),
                                      borderRadius: BorderRadius.circular(14),
                                    ),
                                    child: Text(
                                      message!,
                                      style: TextStyle(
                                        color: isSuccess
                                            ? AppColors.success
                                            : AppColors.danger,
                                        fontWeight: FontWeight.w600,
                                      ),
                                    ),
                                  ),

                                SizedBox(
                                  width: double.infinity,
                                  child: ElevatedButton.icon(
                                    onPressed: isLoading ? null : completeModule,
                                    icon: isLoading
                                        ? const SizedBox(
                                            width: 18,
                                            height: 18,
                                            child: CircularProgressIndicator(
                                              color: Colors.white,
                                              strokeWidth: 2,
                                            ),
                                          )
                                        : const Icon(Icons.check_circle_outline),
                                    label: Text(
                                      isLoading
                                          ? settings.tr('saving')
                                          : settings.tr('mark_as_completed'),
                                    ),
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
        color: AppColors.primary,
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
              Icons.menu_book,
              color: AppColors.primary,
              size: smallPhone ? 25 : 28,
            ),
          ),

          const SizedBox(width: 12),

          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  settings.tr('module_detail_title'),
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
                  settings.tr('module_detail_subtitle'),
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
          color: AppColors.primary,
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