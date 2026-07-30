import 'package:flutter/material.dart';

import '../services/api_service.dart';
import '../services/notification_service.dart';
import '../services/app_settings_service.dart';
import '../theme/app_theme.dart';

import 'login_screen.dart';
import 'modules_screen.dart';
import 'conseils_screen.dart';
import 'quizzes_screen.dart';
import 'progression_screen.dart';
import 'scores_screen.dart';

class HomeScreen extends StatefulWidget {
  const HomeScreen({super.key});

  @override
  State<HomeScreen> createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  Future<void> logout(BuildContext context) async {
    await ApiService.logout();

    if (!context.mounted) return;

    Navigator.pushReplacement(
      context,
      MaterialPageRoute(
        builder: (_) => const LoginScreen(),
      ),
    );
  }

  Future<void> activateNotifications(BuildContext context) async {
    final settings = AppSettingsService.instance;
    final firebaseToken = await NotificationService.getFirebaseToken();

    if (!context.mounted) return;

    if (firebaseToken == null) {
      _showMessageDialog(
        context: context,
        title: 'Notifications',
        message: settings.isMalagasy
            ? 'Tsy afaka mampandeha ny notifications amin’izao fotoana izao.'
            : 'Impossible d’activer les notifications pour le moment.',
      );
      return;
    }

    try {
      final response = await ApiService.saveDeviceToken(
        firebaseToken: firebaseToken,
        deviceType: 'android',
      );

      if (!context.mounted) return;

      _showMessageDialog(
        context: context,
        title: settings.isMalagasy
            ? 'Notifications mandeha'
            : 'Notifications activées',
        message: response['message'] ??
            (settings.isMalagasy
                ? 'Vita soa aman-tsara ny fampandehanana notifications.'
                : 'Notifications activées avec succès.'),
      );
    } catch (e) {
      if (!context.mounted) return;

      _showMessageDialog(
        context: context,
        title: settings.tr('error'),
        message: settings.isMalagasy
            ? 'Voaray ny token Firebase, fa tsy voatahiry tao amin’ny serveur.'
            : 'Le token Firebase a été récupéré, mais il n’a pas pu être enregistré.',
      );
    }
  }

  void _showMessageDialog({
    required BuildContext context,
    required String title,
    required String message,
  }) {
    final isDark = Theme.of(context).brightness == Brightness.dark;

    showDialog(
      context: context,
      builder: (_) => AlertDialog(
        backgroundColor: isDark ? AppColors.darkCard : Colors.white,
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(22),
        ),
        title: Text(title),
        content: Text(message),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context),
            child: Text(
              AppSettingsService.instance.isMalagasy ? 'Hikatona' : 'Fermer',
            ),
          ),
        ],
      ),
    );
  }

  void openModules(BuildContext context) {
    Navigator.push(
      context,
      MaterialPageRoute(
        builder: (_) => const ModulesScreen(),
      ),
    );
  }

  void openConseils(BuildContext context) {
    Navigator.push(
      context,
      MaterialPageRoute(
        builder: (_) => const ConseilsScreen(),
      ),
    );
  }

  void openQuizzes(BuildContext context) {
    Navigator.push(
      context,
      MaterialPageRoute(
        builder: (_) => const QuizzesScreen(),
      ),
    );
  }

  void openProgression(BuildContext context) {
    Navigator.push(
      context,
      MaterialPageRoute(
        builder: (_) => const ProgressionScreen(),
      ),
    );
  }

  void openScores(BuildContext context) {
    Navigator.push(
      context,
      MaterialPageRoute(
        builder: (_) => const ScoresScreen(),
      ),
    );
  }

  void showSettingsBottomSheet(BuildContext context) {
    final settings = AppSettingsService.instance;

    showModalBottomSheet(
      context: context,
      backgroundColor: Colors.transparent,
      builder: (context) {
        return AnimatedBuilder(
          animation: settings,
          builder: (context, _) {
            final isDark = Theme.of(context).brightness == Brightness.dark;

            return Container(
              decoration: BoxDecoration(
                color: isDark ? AppColors.darkCard : Colors.white,
                borderRadius: const BorderRadius.vertical(
                  top: Radius.circular(28),
                ),
              ),
              padding: const EdgeInsets.fromLTRB(20, 12, 20, 24),
              child: Column(
                mainAxisSize: MainAxisSize.min,
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Center(
                    child: Container(
                      width: 44,
                      height: 5,
                      decoration: BoxDecoration(
                        color: isDark
                            ? AppColors.borderDark
                            : AppColors.borderLight,
                        borderRadius: BorderRadius.circular(999),
                      ),
                    ),
                  ),

                  const SizedBox(height: 18),

                  Row(
                    children: [
                      Container(
                        width: 44,
                        height: 44,
                        decoration: BoxDecoration(
                          gradient: AppGradients.primaryGradient,
                          borderRadius: BorderRadius.circular(15),
                        ),
                        child: const Icon(
                          Icons.tune,
                          color: Colors.white,
                          size: 22,
                        ),
                      ),

                      const SizedBox(width: 12),

                      Expanded(
                        child: Text(
                          settings.tr('settings'),
                          style: Theme.of(context).textTheme.titleLarge,
                        ),
                      ),
                    ],
                  ),

                  const SizedBox(height: 20),

                  _SettingSectionTitle(
                    title: settings.tr('language'),
                  ),

                  const SizedBox(height: 8),

                  Row(
                    children: [
                      Expanded(
                        child: _ChoiceButton(
                          label: settings.tr('french'),
                          selected: !settings.isMalagasy,
                          onTap: () async {
                            await settings.changeLanguage('fr');

                            if (context.mounted) {
                              Navigator.pop(context);
                            }
                          },
                        ),
                      ),

                      const SizedBox(width: 10),

                      Expanded(
                        child: _ChoiceButton(
                          label: settings.tr('malagasy'),
                          selected: settings.isMalagasy,
                          onTap: () async {
                            await settings.changeLanguage('mg');

                            if (context.mounted) {
                              Navigator.pop(context);
                            }
                          },
                        ),
                      ),
                    ],
                  ),

                  const SizedBox(height: 18),

                  _SettingSectionTitle(
                    title: settings.tr('theme'),
                  ),

                  const SizedBox(height: 8),

                  SizedBox(
                    width: double.infinity,
                    height: 44,
                    child: ElevatedButton.icon(
                      onPressed: () async {
                        await settings.toggleTheme();

                        if (context.mounted) {
                          Navigator.pop(context);
                        }
                      },
                      icon: Icon(
                        settings.isDarkMode
                            ? Icons.light_mode_rounded
                            : Icons.dark_mode_rounded,
                        size: 20,
                      ),
                      label: Text(
                        settings.isDarkMode
                            ? settings.tr('light_mode')
                            : settings.tr('dark_mode'),
                      ),
                    ),
                  ),
                ],
              ),
            );
          },
        );
      },
    );
  }

  @override
  Widget build(BuildContext context) {
    final settings = AppSettingsService.instance;

    return AnimatedBuilder(
      animation: settings,
      builder: (context, _) {
        final isDark = Theme.of(context).brightness == Brightness.dark;

        return Scaffold(
          backgroundColor: Theme.of(context).scaffoldBackgroundColor,
          body: SafeArea(
            child: LayoutBuilder(
              builder: (context, constraints) {
                final double width = constraints.maxWidth;

                final bool smallPhone = width < 380;
                final bool tabletOrWeb = width >= 760;

                final int crossAxisCount = tabletOrWeb
                    ? 3
                    : smallPhone
                        ? 1
                        : 2;

                // Une hauteur fixe est plus fiable qu'un childAspectRatio
                // pour éviter les débordements verticaux sur le Web, tablette
                // et téléphone, notamment avec les traductions.
                final double cardExtent = smallPhone
                    ? 82
                    : tabletOrWeb
                        ? 170
                        : 176;

                final double horizontalPadding = tabletOrWeb ? 22 : 12;

                return ScrollConfiguration(
                  behavior: ScrollConfiguration.of(context).copyWith(
                    scrollbars: false,
                  ),
                  child: CustomScrollView(
                    physics: const BouncingScrollPhysics(),
                    slivers: [
                      SliverToBoxAdapter(
                        child: _Header(
                          onNotificationTap: () =>
                              activateNotifications(context),
                          onSettingsTap: () =>
                              showSettingsBottomSheet(context),
                          onLogoutTap: () => logout(context),
                        ),
                      ),

                      SliverToBoxAdapter(
                        child: Padding(
                          padding: EdgeInsets.fromLTRB(
                            horizontalPadding,
                            12,
                            horizontalPadding,
                            2,
                          ),
                          child: _SectionHeader(
                            title: settings.tr('parent_space'),
                            subtitle: settings.isMalagasy
                                ? 'Safidio izay tianao hatao anio'
                                : 'Choisissez une action pour commencer',
                          ),
                        ),
                      ),

                      SliverPadding(
                        padding: EdgeInsets.fromLTRB(
                          horizontalPadding,
                          8,
                          horizontalPadding,
                          12,
                        ),
                        sliver: SliverGrid(
                          delegate: SliverChildListDelegate(
                            [
                              HomeCard(
                                icon: Icons.menu_book_rounded,
                                title: settings.tr('modules'),
                                subtitle: settings.tr('modules_subtitle'),
                                color: AppColors.primary,
                                gradient: AppGradients.blueGradient,
                                onTap: () => openModules(context),
                              ),
                              HomeCard(
                                icon: Icons.lightbulb_rounded,
                                title: settings.tr('conseils'),
                                subtitle: settings.tr('conseils_subtitle'),
                                color: AppColors.accent,
                                gradient: AppGradients.warmGradient,
                                onTap: () => openConseils(context),
                              ),
                              HomeCard(
                                icon: Icons.quiz_rounded,
                                title: settings.tr('quiz'),
                                subtitle: settings.tr('quiz_subtitle'),
                                color: const Color(0xFF9333EA),
                                gradient: AppGradients.purpleGradient,
                                onTap: () => openQuizzes(context),
                              ),
                              HomeCard(
                                icon: Icons.trending_up_rounded,
                                title: settings.tr('progression'),
                                subtitle:
                                    settings.tr('progression_subtitle'),
                                color: AppColors.success,
                                gradient: const LinearGradient(
                                  colors: [
                                    Color(0xFF22C55E),
                                    Color(0xFF14B8A6),
                                  ],
                                  begin: Alignment.topLeft,
                                  end: Alignment.bottomRight,
                                ),
                                onTap: () => openProgression(context),
                              ),
                              HomeCard(
                                icon: Icons.emoji_events_rounded,
                                title: settings.tr('scores'),
                                subtitle: settings.tr('scores_subtitle'),
                                color: const Color(0xFFF97316),
                                gradient: const LinearGradient(
                                  colors: [
                                    Color(0xFFF97316),
                                    Color(0xFFEF4444),
                                  ],
                                  begin: Alignment.topLeft,
                                  end: Alignment.bottomRight,
                                ),
                                onTap: () => openScores(context),
                              ),
                            ],
                          ),
                          gridDelegate:
                              SliverGridDelegateWithFixedCrossAxisCount(
                            crossAxisCount: crossAxisCount,
                            crossAxisSpacing: 8,
                            mainAxisSpacing: 8,
                            mainAxisExtent: cardExtent,
                          ),
                        ),
                      ),

                      SliverToBoxAdapter(
                        child: Padding(
                          padding: EdgeInsets.fromLTRB(
                            horizontalPadding,
                            0,
                            horizontalPadding,
                            20,
                          ),
                          child: _InfoBanner(
                            isDark: isDark,
                            title: settings.isMalagasy
                                ? 'Fanabeazana manomboka ao an-tokantrano'
                                : 'L’éducation commence à la maison',
                            subtitle: settings.isMalagasy
                                ? 'Araho tsikelikely ireo votoaty hanatsarana ny fifandraisana ao amin’ny fianakaviana.'
                                : 'Avancez progressivement avec des contenus simples pour renforcer la relation familiale.',
                          ),
                        ),
                      ),
                    ],
                  ),
                );
              },
            ),
          ),
        );
      },
    );
  }
}

class _Header extends StatelessWidget {
  final VoidCallback onNotificationTap;
  final VoidCallback onSettingsTap;
  final VoidCallback onLogoutTap;

  const _Header({
    required this.onNotificationTap,
    required this.onSettingsTap,
    required this.onLogoutTap,
  });

  @override
  Widget build(BuildContext context) {
    final settings = AppSettingsService.instance;

    final double width = MediaQuery.of(context).size.width;
    final bool smallPhone = width < 380;

    return Container(
      width: double.infinity,
      padding: EdgeInsets.fromLTRB(
        smallPhone ? 12 : 18,
        12,
        smallPhone ? 12 : 18,
        smallPhone ? 16 : 20,
      ),
      decoration: const BoxDecoration(
        gradient: AppGradients.primaryGradient,
        borderRadius: BorderRadius.only(
          bottomLeft: Radius.circular(28),
          bottomRight: Radius.circular(28),
        ),
      ),
      child: Stack(
        children: [
          Positioned(
            right: -45,
            top: -45,
            child: _DecorativeCircle(
              size: 140,
              opacity: 0.13,
            ),
          ),

          Positioned(
            left: -55,
            bottom: -70,
            child: _DecorativeCircle(
              size: 155,
              opacity: 0.10,
            ),
          ),

          Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Row(
                children: [
                  Container(
                    width: smallPhone ? 40 : 46,
                    height: smallPhone ? 40 : 46,
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: BorderRadius.circular(16),
                      boxShadow: [
                        BoxShadow(
                          color: Colors.black.withOpacity(0.10),
                          blurRadius: 14,
                          offset: const Offset(0, 6),
                        ),
                      ],
                    ),
                    child: Icon(
                      Icons.family_restroom_rounded,
                      color: AppColors.primary,
                      size: smallPhone ? 23 : 26,
                    ),
                  ),

                  const SizedBox(width: 10),

                  Expanded(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          settings.tr('app_name'),
                          maxLines: 1,
                          overflow: TextOverflow.ellipsis,
                          style: TextStyle(
                            color: Colors.white,
                            fontSize: smallPhone ? 15.5 : 18,
                            fontWeight: FontWeight.w900,
                            letterSpacing: -0.2,
                          ),
                        ),

                        const SizedBox(height: 3),

                        Text(
                          settings.tr('parent_space'),
                          maxLines: 1,
                          overflow: TextOverflow.ellipsis,
                          style: const TextStyle(
                            color: Colors.white70,
                            fontSize: 12,
                            fontWeight: FontWeight.w600,
                          ),
                        ),
                      ],
                    ),
                  ),

                  _HeaderIconButton(
                    icon: Icons.notifications_none_rounded,
                    onTap: onNotificationTap,
                  ),

                  const SizedBox(width: 5),

                  _HeaderIconButton(
                    icon: Icons.settings_rounded,
                    onTap: onSettingsTap,
                  ),

                  const SizedBox(width: 5),

                  _HeaderIconButton(
                    icon: Icons.logout_rounded,
                    onTap: onLogoutTap,
                  ),
                ],
              ),

              SizedBox(height: smallPhone ? 14 : 18),

              Container(
                padding: const EdgeInsets.symmetric(
                  horizontal: 10,
                  vertical: 6,
                ),
                decoration: BoxDecoration(
                  color: Colors.white.withOpacity(0.16),
                  borderRadius: BorderRadius.circular(999),
                  border: Border.all(
                    color: Colors.white.withOpacity(0.16),
                  ),
                ),
                child: Text(
                  settings.isMalagasy
                      ? 'Sehatra ho an’ny ray aman-dreny'
                      : 'Accompagnement parental',
                  style: const TextStyle(
                    color: Colors.white,
                    fontSize: 11,
                    fontWeight: FontWeight.w700,
                  ),
                ),
              ),

              const SizedBox(height: 10),

              Text(
                settings.tr('welcome'),
                maxLines: 1,
                overflow: TextOverflow.ellipsis,
                style: TextStyle(
                  color: Colors.white,
                  fontSize: smallPhone ? 21 : 24,
                  fontWeight: FontWeight.w900,
                  letterSpacing: -0.5,
                ),
              ),

              const SizedBox(height: 6),

              Text(
                settings.tr('home_description'),
                maxLines: 2,
                overflow: TextOverflow.ellipsis,
                style: TextStyle(
                  color: Colors.white.withOpacity(0.82),
                  fontSize: smallPhone ? 12.5 : 13,
                  height: 1.35,
                  fontWeight: FontWeight.w500,
                ),
              ),
            ],
          ),
        ],
      ),
    );
  }
}

class _HeaderIconButton extends StatelessWidget {
  final IconData icon;
  final VoidCallback onTap;

  const _HeaderIconButton({
    required this.icon,
    required this.onTap,
  });

  @override
  Widget build(BuildContext context) {
    return Material(
      color: Colors.white.withOpacity(0.16),
      borderRadius: BorderRadius.circular(13),
      child: InkWell(
        borderRadius: BorderRadius.circular(13),
        onTap: onTap,
        child: SizedBox(
          width: 34,
          height: 34,
          child: Icon(
            icon,
            color: Colors.white,
            size: 18,
          ),
        ),
      ),
    );
  }
}

class _DecorativeCircle extends StatelessWidget {
  final double size;
  final double opacity;

  const _DecorativeCircle({
    required this.size,
    required this.opacity,
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      width: size,
      height: size,
      decoration: BoxDecoration(
        color: Colors.white.withOpacity(opacity),
        shape: BoxShape.circle,
      ),
    );
  }
}

class _SectionHeader extends StatelessWidget {
  final String title;
  final String subtitle;

  const _SectionHeader({
    required this.title,
    required this.subtitle,
  });

  @override
  Widget build(BuildContext context) {
    final isDark = Theme.of(context).brightness == Brightness.dark;

    return Row(
      children: [
        Container(
          width: 4,
          height: 32,
          decoration: BoxDecoration(
            gradient: AppGradients.primaryGradient,
            borderRadius: BorderRadius.circular(999),
          ),
        ),

        const SizedBox(width: 10),

        Expanded(
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                title,
                style: Theme.of(context).textTheme.titleMedium,
              ),

              const SizedBox(height: 2),

              Text(
                subtitle,
                style: TextStyle(
                  color: isDark
                      ? AppColors.textMutedDark
                      : AppColors.textMuted,
                  fontSize: 12,
                  fontWeight: FontWeight.w500,
                ),
              ),
            ],
          ),
        ),
      ],
    );
  }
}

class HomeCard extends StatelessWidget {
  final IconData icon;
  final String title;
  final String subtitle;
  final Color color;
  final LinearGradient gradient;
  final VoidCallback? onTap;

  const HomeCard({
    super.key,
    required this.icon,
    required this.title,
    required this.subtitle,
    required this.color,
    required this.gradient,
    this.onTap,
  });

  @override
  Widget build(BuildContext context) {
    final double width = MediaQuery.of(context).size.width;
    final bool smallPhone = width < 380;
    final bool isDark = Theme.of(context).brightness == Brightness.dark;

    return Card(
      margin: EdgeInsets.zero,
      elevation: isDark ? 1 : 4,
      shadowColor: Colors.black.withOpacity(isDark ? 0.16 : 0.07),
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(18),
      ),
      child: InkWell(
        borderRadius: BorderRadius.circular(18),
        onTap: onTap,
        child: Container(
          padding: EdgeInsets.all(smallPhone ? 10 : 12),
          decoration: BoxDecoration(
            borderRadius: BorderRadius.circular(18),
            border: Border.all(
              color: isDark ? AppColors.borderDark : AppColors.borderLight,
              width: 0.7,
            ),
          ),
          child: smallPhone
              ? _HorizontalCardContent(
                  icon: icon,
                  title: title,
                  subtitle: subtitle,
                  color: color,
                  gradient: gradient,
                  isDark: isDark,
                )
              : _VerticalCardContent(
                  icon: icon,
                  title: title,
                  subtitle: subtitle,
                  color: color,
                  gradient: gradient,
                  isDark: isDark,
                ),
        ),
      ),
    );
  }
}

class _VerticalCardContent extends StatelessWidget {
  final IconData icon;
  final String title;
  final String subtitle;
  final Color color;
  final LinearGradient gradient;
  final bool isDark;

  const _VerticalCardContent({
    required this.icon,
    required this.title,
    required this.subtitle,
    required this.color,
    required this.gradient,
    required this.isDark,
  });

  @override
  Widget build(BuildContext context) {
    final settings = AppSettingsService.instance;

    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Container(
          width: 38,
          height: 38,
          decoration: BoxDecoration(
            gradient: gradient,
            borderRadius: BorderRadius.circular(13),
            boxShadow: [
              BoxShadow(
                color: color.withOpacity(0.18),
                blurRadius: 10,
                offset: const Offset(0, 5),
              ),
            ],
          ),
          child: Icon(
            icon,
            color: Colors.white,
            size: 21,
          ),
        ),

        const SizedBox(height: 10),

        Text(
          title,
          maxLines: 1,
          overflow: TextOverflow.ellipsis,
          style: TextStyle(
            color: isDark ? AppColors.textLight : AppColors.textDark,
            fontSize: 15,
            fontWeight: FontWeight.w900,
            letterSpacing: -0.2,
          ),
        ),

        const SizedBox(height: 3),

        Expanded(
          child: Align(
            alignment: Alignment.topLeft,
            child: Text(
              subtitle,
              maxLines: 2,
              overflow: TextOverflow.ellipsis,
              style: TextStyle(
                color:
                    isDark ? AppColors.textMutedDark : AppColors.textMuted,
                fontSize: 11.5,
                height: 1.25,
                fontWeight: FontWeight.w500,
              ),
            ),
          ),
        ),

        const SizedBox(height: 6),

        Row(
          mainAxisSize: MainAxisSize.min,
          children: [
            Flexible(
              child: Text(
                settings.isMalagasy ? 'Hijery' : 'Ouvrir',
                maxLines: 1,
                overflow: TextOverflow.ellipsis,
                style: TextStyle(
                  color: color,
                  fontSize: 12,
                  fontWeight: FontWeight.w900,
                ),
              ),
            ),

            const SizedBox(width: 4),

            Icon(
              Icons.arrow_forward_rounded,
              color: color,
              size: 15,
            ),
          ],
        ),
      ],
    );
  }
}

class _HorizontalCardContent extends StatelessWidget {
  final IconData icon;
  final String title;
  final String subtitle;
  final Color color;
  final LinearGradient gradient;
  final bool isDark;

  const _HorizontalCardContent({
    required this.icon,
    required this.title,
    required this.subtitle,
    required this.color,
    required this.gradient,
    required this.isDark,
  });

  @override
  Widget build(BuildContext context) {
    return Row(
      children: [
        Container(
          width: 40,
          height: 40,
          decoration: BoxDecoration(
            gradient: gradient,
            borderRadius: BorderRadius.circular(13),
          ),
          child: Icon(
            icon,
            color: Colors.white,
            size: 22,
          ),
        ),

        const SizedBox(width: 10),

        Expanded(
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                title,
                maxLines: 1,
                overflow: TextOverflow.ellipsis,
                style: TextStyle(
                  color: isDark ? AppColors.textLight : AppColors.textDark,
                  fontSize: 14.5,
                  fontWeight: FontWeight.w900,
                ),
              ),

              const SizedBox(height: 2),

              Text(
                subtitle,
                maxLines: 1,
                overflow: TextOverflow.ellipsis,
                style: TextStyle(
                  color:
                      isDark ? AppColors.textMutedDark : AppColors.textMuted,
                  fontSize: 11.5,
                  height: 1.2,
                ),
              ),
            ],
          ),
        ),

        Icon(
          Icons.arrow_forward_ios_rounded,
          color: color,
          size: 13,
        ),
      ],
    );
  }
}

class _InfoBanner extends StatelessWidget {
  final bool isDark;
  final String title;
  final String subtitle;

  const _InfoBanner({
    required this.isDark,
    required this.title,
    required this.subtitle,
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(14),
      decoration: BoxDecoration(
        color: isDark ? AppColors.darkCard : Colors.white,
        borderRadius: BorderRadius.circular(18),
        border: Border.all(
          color: isDark ? AppColors.borderDark : AppColors.borderLight,
        ),
        boxShadow: [
          if (!isDark)
            BoxShadow(
              color: Colors.black.withOpacity(0.04),
              blurRadius: 14,
              offset: const Offset(0, 6),
            ),
        ],
      ),
      child: Row(
        children: [
          Container(
            width: 42,
            height: 42,
            decoration: BoxDecoration(
              color: AppColors.secondary.withOpacity(0.12),
              borderRadius: BorderRadius.circular(14),
            ),
            child: const Icon(
              Icons.favorite_rounded,
              color: AppColors.secondary,
              size: 23,
            ),
          ),

          const SizedBox(width: 12),

          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  title,
                  maxLines: 1,
                  overflow: TextOverflow.ellipsis,
                  style: TextStyle(
                    color: isDark ? AppColors.textLight : AppColors.textDark,
                    fontSize: 14,
                    fontWeight: FontWeight.w900,
                  ),
                ),

                const SizedBox(height: 4),

                Text(
                  subtitle,
                  maxLines: 2,
                  overflow: TextOverflow.ellipsis,
                  style: TextStyle(
                    color:
                        isDark ? AppColors.textMutedDark : AppColors.textMuted,
                    fontSize: 12,
                    height: 1.3,
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

class _SettingSectionTitle extends StatelessWidget {
  final String title;

  const _SettingSectionTitle({
    required this.title,
  });

  @override
  Widget build(BuildContext context) {
    return Text(
      title,
      style: Theme.of(context).textTheme.titleSmall,
    );
  }
}

class _ChoiceButton extends StatelessWidget {
  final String label;
  final bool selected;
  final VoidCallback onTap;

  const _ChoiceButton({
    required this.label,
    required this.selected,
    required this.onTap,
  });

  @override
  Widget build(BuildContext context) {
    final isDark = Theme.of(context).brightness == Brightness.dark;

    return InkWell(
      borderRadius: BorderRadius.circular(15),
      onTap: onTap,
      child: Container(
        padding: const EdgeInsets.symmetric(
          horizontal: 12,
          vertical: 11,
        ),
        decoration: BoxDecoration(
          color: selected
              ? AppColors.primary
              : isDark
                  ? AppColors.darkBackground
                  : AppColors.background,
          borderRadius: BorderRadius.circular(15),
          border: Border.all(
            color: selected
                ? AppColors.primary
                : isDark
                    ? AppColors.borderDark
                    : AppColors.borderLight,
          ),
        ),
        child: Center(
          child: Text(
            label,
            style: TextStyle(
              color: selected
                  ? Colors.white
                  : isDark
                      ? AppColors.textLight
                      : AppColors.textDark,
              fontWeight: FontWeight.w800,
              fontSize: 13,
            ),
          ),
        ),
      ),
    );
  }
}