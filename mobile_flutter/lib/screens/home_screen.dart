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

class HomeScreen extends StatelessWidget {
  const HomeScreen({super.key});

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
    final isDark = Theme.of(context).brightness == Brightness.dark;

    showModalBottomSheet(
      context: context,
      backgroundColor: Colors.transparent,
      builder: (context) {
        return AnimatedBuilder(
          animation: settings,
          builder: (context, _) {
            return Container(
              decoration: BoxDecoration(
                color: isDark ? AppColors.darkCard : Colors.white,
                borderRadius: const BorderRadius.vertical(
                  top: Radius.circular(30),
                ),
              ),
              padding: const EdgeInsets.fromLTRB(22, 14, 22, 30),
              child: Column(
                mainAxisSize: MainAxisSize.min,
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Center(
                    child: Container(
                      width: 46,
                      height: 5,
                      decoration: BoxDecoration(
                        color: isDark
                            ? AppColors.borderDark
                            : AppColors.borderLight,
                        borderRadius: BorderRadius.circular(999),
                      ),
                    ),
                  ),

                  const SizedBox(height: 22),

                  Row(
                    children: [
                      Container(
                        width: 48,
                        height: 48,
                        decoration: BoxDecoration(
                          gradient: AppGradients.primaryGradient,
                          borderRadius: BorderRadius.circular(16),
                        ),
                        child: const Icon(
                          Icons.tune,
                          color: Colors.white,
                        ),
                      ),

                      const SizedBox(width: 14),

                      Expanded(
                        child: Text(
                          settings.tr('settings'),
                          style: Theme.of(context).textTheme.titleLarge,
                        ),
                      ),
                    ],
                  ),

                  const SizedBox(height: 24),

                  _SettingSectionTitle(
                    title: settings.tr('language'),
                  ),

                  const SizedBox(height: 10),

                  Row(
                    children: [
                      Expanded(
                        child: _ChoiceButton(
                          label: settings.tr('french'),
                          selected: !settings.isMalagasy,
                          onTap: () async {
                            final navigator = Navigator.of(context);
                            await settings.changeLanguage('fr');
                            navigator.pop();
                          },
                        ),
                      ),
                      const SizedBox(width: 10),
                      Expanded(
                        child: _ChoiceButton(
                          label: settings.tr('malagasy'),
                          selected: settings.isMalagasy,
                          onTap: () async {
                            final navigator = Navigator.of(context);
                            await settings.changeLanguage('mg');
                            navigator.pop();
                          },
                        ),
                      ),
                    ],
                  ),

                  const SizedBox(height: 22),

                  _SettingSectionTitle(
                    title: settings.tr('theme'),
                  ),

                  const SizedBox(height: 10),

                  SizedBox(
                    width: double.infinity,
                    child: ElevatedButton.icon(
                      onPressed: () async {
                        final navigator = Navigator.of(context);
                        await settings.toggleTheme();
                        navigator.pop();
                      },
                      icon: Icon(
                        settings.isDarkMode
                            ? Icons.light_mode_rounded
                            : Icons.dark_mode_rounded,
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

            final double childAspectRatio = tabletOrWeb
                ? 1.18
                : smallPhone
                    ? 3.25
                    : 1.05;

            final double horizontalPadding = tabletOrWeb ? 28 : 16;

            return CustomScrollView(
              physics: const BouncingScrollPhysics(),
              slivers: [
                SliverToBoxAdapter(
                  child: _Header(
                    onNotificationTap: () => activateNotifications(context),
                    onSettingsTap: () => showSettingsBottomSheet(context),
                    onLogoutTap: () => logout(context),
                  ),
                ),

                SliverToBoxAdapter(
                  child: Padding(
                    padding: EdgeInsets.fromLTRB(
                      horizontalPadding,
                      18,
                      horizontalPadding,
                      4,
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
                    12,
                    horizontalPadding,
                    18,
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
                          subtitle: settings.tr('progression_subtitle'),
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
                    gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
                      crossAxisCount: crossAxisCount,
                      crossAxisSpacing: 14,
                      mainAxisSpacing: 14,
                      childAspectRatio: childAspectRatio,
                    ),
                  ),
                ),

                SliverToBoxAdapter(
                  child: Padding(
                    padding: EdgeInsets.fromLTRB(
                      horizontalPadding,
                      0,
                      horizontalPadding,
                      26,
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
            );
          },
        ),
      ),
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
        smallPhone ? 16 : 22,
        18,
        smallPhone ? 16 : 22,
        smallPhone ? 24 : 30,
      ),
      decoration: const BoxDecoration(
        gradient: AppGradients.primaryGradient,
        borderRadius: BorderRadius.only(
          bottomLeft: Radius.circular(34),
          bottomRight: Radius.circular(34),
        ),
      ),
      child: Stack(
        children: [
          Positioned(
            right: -45,
            top: -45,
            child: _DecorativeCircle(
              size: 150,
              opacity: 0.13,
            ),
          ),
          Positioned(
            left: -55,
            bottom: -70,
            child: _DecorativeCircle(
              size: 170,
              opacity: 0.10,
            ),
          ),

          Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Row(
                children: [
                  Container(
                    width: smallPhone ? 48 : 54,
                    height: smallPhone ? 48 : 54,
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: BorderRadius.circular(19),
                      boxShadow: [
                        BoxShadow(
                          color: Colors.black.withOpacity(0.10),
                          blurRadius: 18,
                          offset: const Offset(0, 8),
                        ),
                      ],
                    ),
                    child: Icon(
                      Icons.family_restroom_rounded,
                      color: AppColors.primary,
                      size: smallPhone ? 28 : 32,
                    ),
                  ),

                  const SizedBox(width: 13),

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
                            fontSize: smallPhone ? 17 : 20,
                            fontWeight: FontWeight.w900,
                            letterSpacing: -0.2,
                          ),
                        ),
                        const SizedBox(height: 4),
                        Text(
                          settings.tr('parent_space'),
                          style: const TextStyle(
                            color: Colors.white70,
                            fontSize: 13,
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

                  const SizedBox(width: 6),

                  _HeaderIconButton(
                    icon: Icons.settings_rounded,
                    onTap: onSettingsTap,
                  ),

                  const SizedBox(width: 6),

                  _HeaderIconButton(
                    icon: Icons.logout_rounded,
                    onTap: onLogoutTap,
                  ),
                ],
              ),

              SizedBox(height: smallPhone ? 22 : 28),

              Container(
                padding: const EdgeInsets.symmetric(
                  horizontal: 12,
                  vertical: 7,
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
                    fontSize: 12,
                    fontWeight: FontWeight.w700,
                  ),
                ),
              ),

              const SizedBox(height: 14),

              Text(
                settings.tr('welcome'),
                style: TextStyle(
                  color: Colors.white,
                  fontSize: smallPhone ? 25 : 29,
                  fontWeight: FontWeight.w900,
                  letterSpacing: -0.5,
                ),
              ),

              const SizedBox(height: 8),

              Text(
                settings.tr('home_description'),
                style: TextStyle(
                  color: Colors.white.withOpacity(0.82),
                  fontSize: smallPhone ? 13.5 : 14.5,
                  height: 1.45,
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
      borderRadius: BorderRadius.circular(15),
      child: InkWell(
        borderRadius: BorderRadius.circular(15),
        onTap: onTap,
        child: SizedBox(
          width: 39,
          height: 39,
          child: Icon(
            icon,
            color: Colors.white,
            size: 21,
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
          width: 5,
          height: 38,
          decoration: BoxDecoration(
            gradient: AppGradients.primaryGradient,
            borderRadius: BorderRadius.circular(999),
          ),
        ),

        const SizedBox(width: 12),

        Expanded(
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                title,
                style: Theme.of(context).textTheme.titleMedium,
              ),
              const SizedBox(height: 3),
              Text(
                subtitle,
                style: TextStyle(
                  color: isDark
                      ? AppColors.textMutedDark
                      : AppColors.textMuted,
                  fontSize: 13,
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
      elevation: isDark ? 1 : 5,
      shadowColor: Colors.black.withOpacity(isDark ? 0.18 : 0.08),
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(24),
      ),
      child: InkWell(
        borderRadius: BorderRadius.circular(24),
        onTap: onTap,
        child: Container(
          padding: EdgeInsets.all(smallPhone ? 14 : 17),
          decoration: BoxDecoration(
            borderRadius: BorderRadius.circular(24),
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
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Container(
          width: 54,
          height: 54,
          decoration: BoxDecoration(
            gradient: gradient,
            borderRadius: BorderRadius.circular(18),
            boxShadow: [
              BoxShadow(
                color: color.withOpacity(0.24),
                blurRadius: 14,
                offset: const Offset(0, 7),
              ),
            ],
          ),
          child: Icon(
            icon,
            color: Colors.white,
            size: 29,
          ),
        ),

        const Spacer(),

        Text(
          title,
          maxLines: 1,
          overflow: TextOverflow.ellipsis,
          style: TextStyle(
            color: isDark ? AppColors.textLight : AppColors.textDark,
            fontSize: 17,
            fontWeight: FontWeight.w900,
            letterSpacing: -0.2,
          ),
        ),

        const SizedBox(height: 5),

        Text(
          subtitle,
          maxLines: 2,
          overflow: TextOverflow.ellipsis,
          style: TextStyle(
            color: isDark ? AppColors.textMutedDark : AppColors.textMuted,
            fontSize: 13,
            height: 1.35,
            fontWeight: FontWeight.w500,
          ),
        ),

        const SizedBox(height: 10),

        Row(
          children: [
            Text(
              AppSettingsService.instance.isMalagasy ? 'Hijery' : 'Ouvrir',
              style: TextStyle(
                color: color,
                fontSize: 13,
                fontWeight: FontWeight.w900,
              ),
            ),
            const SizedBox(width: 4),
            Icon(
              Icons.arrow_forward_rounded,
              color: color,
              size: 16,
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
          width: 52,
          height: 52,
          decoration: BoxDecoration(
            gradient: gradient,
            borderRadius: BorderRadius.circular(18),
          ),
          child: Icon(
            icon,
            color: Colors.white,
            size: 28,
          ),
        ),

        const SizedBox(width: 13),

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
                  fontSize: 16.5,
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
                  fontSize: 12.5,
                  height: 1.3,
                ),
              ),
            ],
          ),
        ),

        Icon(
          Icons.arrow_forward_ios_rounded,
          color: color,
          size: 15,
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
      padding: const EdgeInsets.all(18),
      decoration: BoxDecoration(
        color: isDark ? AppColors.darkCard : Colors.white,
        borderRadius: BorderRadius.circular(24),
        border: Border.all(
          color: isDark ? AppColors.borderDark : AppColors.borderLight,
        ),
        boxShadow: [
          if (!isDark)
            BoxShadow(
              color: Colors.black.withOpacity(0.05),
              blurRadius: 18,
              offset: const Offset(0, 8),
            ),
        ],
      ),
      child: Row(
        children: [
          Container(
            width: 52,
            height: 52,
            decoration: BoxDecoration(
              color: AppColors.secondary.withOpacity(0.12),
              borderRadius: BorderRadius.circular(18),
            ),
            child: const Icon(
              Icons.favorite_rounded,
              color: AppColors.secondary,
              size: 28,
            ),
          ),

          const SizedBox(width: 14),

          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  title,
                  style: TextStyle(
                    color: isDark ? AppColors.textLight : AppColors.textDark,
                    fontSize: 15.5,
                    fontWeight: FontWeight.w900,
                  ),
                ),
                const SizedBox(height: 5),
                Text(
                  subtitle,
                  style: TextStyle(
                    color:
                        isDark ? AppColors.textMutedDark : AppColors.textMuted,
                    fontSize: 13,
                    height: 1.4,
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
      borderRadius: BorderRadius.circular(16),
      onTap: onTap,
      child: Container(
        padding: const EdgeInsets.symmetric(
          horizontal: 14,
          vertical: 13,
        ),
        decoration: BoxDecoration(
          color: selected
              ? AppColors.primary
              : isDark
                  ? AppColors.darkBackground
                  : AppColors.background,
          borderRadius: BorderRadius.circular(16),
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
            ),
          ),
        ),
      ),
    );
  }
}