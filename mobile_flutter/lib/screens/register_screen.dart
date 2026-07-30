import 'package:flutter/material.dart';

import '../services/api_service.dart';
import '../services/app_settings_service.dart';
import '../theme/app_theme.dart';

const Color _secondaryColor = Color(0xFF14B8A6);
const Color _accentColor = Color(0xFFF59E0B);
const Color _darkCardColor = Color(0xFF1E293B);
const Color _darkBackgroundColor = Color(0xFF0F172A);

class RegisterScreen extends StatefulWidget {
  const RegisterScreen({super.key});

  @override
  State<RegisterScreen> createState() => _RegisterScreenState();
}

class _RegisterScreenState extends State<RegisterScreen> {
  final TextEditingController nameController = TextEditingController();
  final TextEditingController emailController = TextEditingController();
  final TextEditingController passwordController = TextEditingController();

  bool isLoading = false;
  bool hidePassword = true;
  String? message;
  bool isSuccess = false;

  Future<void> register() async {
    final settings = AppSettingsService.instance;

    if (nameController.text.trim().isEmpty ||
        emailController.text.trim().isEmpty ||
        passwordController.text.trim().isEmpty) {
      setState(() {
        isSuccess = false;
        message = settings.isMalagasy
            ? 'Fenoy tsara ny anarana, email ary tenimiafina.'
            : 'Veuillez remplir le nom, l’email et le mot de passe.';
      });
      return;
    }

    setState(() {
      isLoading = true;
      message = null;
      isSuccess = false;
    });

    try {
      final data = await ApiService.register(
        name: nameController.text.trim(),
        email: emailController.text.trim(),
        password: passwordController.text.trim(),
      );

      if (data['token'] != null ||
          data['message'] == 'Compte créé avec succès.') {
        setState(() {
          isSuccess = true;
          message = settings.tr('register_success');
        });
      } else {
        setState(() {
          message = data['message'] ?? settings.tr('register_failed');
        });
      }
    } catch (e) {
      setState(() {
        message = settings.tr('server_error');
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
  void dispose() {
    nameController.dispose();
    emailController.dispose();
    passwordController.dispose();
    super.dispose();
  }

  InputDecoration _inputDecoration({
    required BuildContext context,
    required String label,
    required IconData icon,
    Widget? suffixIcon,
  }) {
    final bool isDark = Theme.of(context).brightness == Brightness.dark;

    return InputDecoration(
      labelText: label,
      prefixIcon: Icon(icon, size: 20),
      suffixIcon: suffixIcon,
      isDense: true,
      filled: true,
      fillColor: isDark ? _darkBackgroundColor : const Color(0xFFF8FAFC),
      contentPadding: const EdgeInsets.symmetric(
        horizontal: 12,
        vertical: 10,
      ),
      border: OutlineInputBorder(
        borderRadius: BorderRadius.circular(14),
        borderSide: BorderSide(
          color: isDark ? const Color(0xFF334155) : const Color(0xFFE2E8F0),
        ),
      ),
      enabledBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(14),
        borderSide: BorderSide(
          color: isDark ? const Color(0xFF334155) : const Color(0xFFE2E8F0),
        ),
      ),
      focusedBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(14),
        borderSide: const BorderSide(
          color: AppColors.primary,
          width: 1.4,
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    final settings = AppSettingsService.instance;
    final bool isDark = Theme.of(context).brightness == Brightness.dark;

    return Scaffold(
      body: SafeArea(
        child: LayoutBuilder(
          builder: (context, constraints) {
            final bool smallPhone = constraints.maxWidth < 360;

            return Stack(
              children: [
                const _AuthBackground(),

                ScrollConfiguration(
                  behavior: ScrollConfiguration.of(context).copyWith(
                    scrollbars: false,
                  ),
                  child: SingleChildScrollView(
                    keyboardDismissBehavior:
                        ScrollViewKeyboardDismissBehavior.onDrag,
                    child: ConstrainedBox(
                      constraints: BoxConstraints(
                        minHeight: constraints.maxHeight,
                      ),
                      child: Padding(
                        padding: EdgeInsets.fromLTRB(
                          smallPhone ? 10 : 14,
                          8,
                          smallPhone ? 10 : 14,
                          10,
                        ),
                        child: Column(
                          children: [
                            _TopActions(
                              isDarkMode: settings.isDarkMode,
                              isMalagasy: settings.isMalagasy,
                              onBack: () => Navigator.pop(context),
                              onFrench: () {
                                settings.changeLanguage('fr');
                                setState(() {});
                              },
                              onMalagasy: () {
                                settings.changeLanguage('mg');
                                setState(() {});
                              },
                              onTheme: () {
                                settings.toggleTheme();
                                setState(() {});
                              },
                            ),

                            const SizedBox(height: 8),

                            _RegisterHero(smallPhone: smallPhone),

                            const SizedBox(height: 10),

                            ConstrainedBox(
                              constraints: const BoxConstraints(
                                maxWidth: 420,
                              ),
                              child: Container(
                                decoration: BoxDecoration(
                                  color:
                                      isDark ? _darkCardColor : Colors.white,
                                  borderRadius: BorderRadius.circular(24),
                                  boxShadow: [
                                    BoxShadow(
                                      color: Colors.black.withOpacity(0.14),
                                      blurRadius: 26,
                                      offset: const Offset(0, 12),
                                    ),
                                  ],
                                ),
                                child: Padding(
                                  padding: EdgeInsets.all(
                                    smallPhone ? 14 : 16,
                                  ),
                                  child: Column(
                                    crossAxisAlignment:
                                        CrossAxisAlignment.start,
                                    children: [
                                      Row(
                                        children: [
                                          Container(
                                            width: 40,
                                            height: 40,
                                            decoration: BoxDecoration(
                                              gradient: const LinearGradient(
                                                colors: [
                                                  AppColors.primary,
                                                  _secondaryColor,
                                                ],
                                              ),
                                              borderRadius:
                                                  BorderRadius.circular(14),
                                            ),
                                            child: const Icon(
                                              Icons.person_add_alt_1,
                                              color: Colors.white,
                                              size: 22,
                                            ),
                                          ),

                                          const SizedBox(width: 10),

                                          Expanded(
                                            child: Column(
                                              crossAxisAlignment:
                                                  CrossAxisAlignment.start,
                                              children: [
                                                Text(
                                                  settings.tr('account_info'),
                                                  maxLines: 1,
                                                  overflow:
                                                      TextOverflow.ellipsis,
                                                  style: TextStyle(
                                                    color: isDark
                                                        ? AppColors.textLight
                                                        : AppColors.textDark,
                                                    fontSize:
                                                        smallPhone ? 18 : 20,
                                                    fontWeight:
                                                        FontWeight.w900,
                                                  ),
                                                ),

                                                const SizedBox(height: 2),

                                                Text(
                                                  settings.tr(
                                                    'register_subtitle',
                                                  ),
                                                  maxLines: 2,
                                                  overflow:
                                                      TextOverflow.ellipsis,
                                                  style: TextStyle(
                                                    color: isDark
                                                        ? AppColors
                                                            .textMutedDark
                                                        : AppColors.textMuted,
                                                    fontSize: 12,
                                                    height: 1.25,
                                                  ),
                                                ),
                                              ],
                                            ),
                                          ),
                                        ],
                                      ),

                                      const SizedBox(height: 12),

                                      if (message != null)
                                        _MessageBox(
                                          message: message!,
                                          isSuccess: isSuccess,
                                        ),

                                      TextField(
                                        controller: nameController,
                                        textInputAction: TextInputAction.next,
                                        style: const TextStyle(fontSize: 14),
                                        decoration: _inputDecoration(
                                          context: context,
                                          label: settings.tr('full_name'),
                                          icon: Icons.person_outline,
                                        ),
                                      ),

                                      const SizedBox(height: 8),

                                      TextField(
                                        controller: emailController,
                                        keyboardType:
                                            TextInputType.emailAddress,
                                        textInputAction: TextInputAction.next,
                                        autofillHints: const [
                                          AutofillHints.email,
                                        ],
                                        style: const TextStyle(fontSize: 14),
                                        decoration: _inputDecoration(
                                          context: context,
                                          label: settings.tr('email_address'),
                                          icon: Icons.email_outlined,
                                        ),
                                      ),

                                      const SizedBox(height: 8),

                                      TextField(
                                        controller: passwordController,
                                        obscureText: hidePassword,
                                        textInputAction: TextInputAction.done,
                                        autofillHints: const [
                                          AutofillHints.newPassword,
                                        ],
                                        style: const TextStyle(fontSize: 14),
                                        onSubmitted: (_) {
                                          if (!isLoading) {
                                            register();
                                          }
                                        },
                                        decoration: _inputDecoration(
                                          context: context,
                                          label: settings.tr('password'),
                                          icon: Icons.lock_outline,
                                          suffixIcon: IconButton(
                                            onPressed: () {
                                              setState(() {
                                                hidePassword = !hidePassword;
                                              });
                                            },
                                            icon: Icon(
                                              hidePassword
                                                  ? Icons
                                                      .visibility_off_outlined
                                                  : Icons.visibility_outlined,
                                              size: 20,
                                            ),
                                          ),
                                        ),
                                      ),

                                      const SizedBox(height: 12),

                                      SizedBox(
                                        width: double.infinity,
                                        height: 44,
                                        child: ElevatedButton(
                                          style: ElevatedButton.styleFrom(
                                            backgroundColor:
                                                AppColors.primary,
                                            foregroundColor: Colors.white,
                                            elevation: 0,
                                            shape: RoundedRectangleBorder(
                                              borderRadius:
                                                  BorderRadius.circular(14),
                                            ),
                                          ),
                                          onPressed:
                                              isLoading ? null : register,
                                          child: isLoading
                                              ? const SizedBox(
                                                  width: 20,
                                                  height: 20,
                                                  child:
                                                      CircularProgressIndicator(
                                                    color: Colors.white,
                                                    strokeWidth: 2,
                                                  ),
                                                )
                                              : Text(
                                                  settings.tr(
                                                    'register_button',
                                                  ),
                                                  style: const TextStyle(
                                                    fontWeight:
                                                        FontWeight.w800,
                                                    fontSize: 14,
                                                  ),
                                                ),
                                        ),
                                      ),

                                      const SizedBox(height: 8),

                                      Center(
                                        child: TextButton.icon(
                                          onPressed: () =>
                                              Navigator.pop(context),
                                          icon: const Icon(
                                            Icons.arrow_back,
                                            size: 16,
                                          ),
                                          label: Text(
                                            settings.tr(
                                              'already_have_account',
                                            ),
                                            style: const TextStyle(
                                              fontWeight: FontWeight.w800,
                                              fontSize: 13,
                                            ),
                                          ),
                                        ),
                                      ),
                                    ],
                                  ),
                                ),
                              ),
                            ),
                          ],
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

class _AuthBackground extends StatelessWidget {
  const _AuthBackground();

  @override
  Widget build(BuildContext context) {
    final bool isDark = Theme.of(context).brightness == Brightness.dark;

    return Stack(
      children: [
        Positioned.fill(
          child: Image.asset(
            'assets/images/auth-family-bg.png',
            fit: BoxFit.cover,
            alignment: Alignment.center,
          ),
        ),

        Positioned.fill(
          child: Container(
            decoration: BoxDecoration(
              gradient: LinearGradient(
                begin: Alignment.topCenter,
                end: Alignment.bottomCenter,
                colors: isDark
                    ? [
                        const Color(0xFF0F172A).withOpacity(0.88),
                        const Color(0xFF0F172A).withOpacity(0.82),
                        const Color(0xFF0F766E).withOpacity(0.70),
                      ]
                    : [
                        const Color(0xFF0F172A).withOpacity(0.58),
                        const Color(0xFF2563EB).withOpacity(0.38),
                        const Color(0xFF14B8A6).withOpacity(0.42),
                      ],
              ),
            ),
          ),
        ),

        Positioned(
          top: -80,
          right: -70,
          child: _DecorCircle(
            size: 190,
            color: AppColors.primary.withOpacity(0.18),
          ),
        ),

        Positioned(
          bottom: -90,
          left: -70,
          child: _DecorCircle(
            size: 210,
            color: _secondaryColor.withOpacity(0.18),
          ),
        ),

        Positioned(
          top: 230,
          left: 30,
          child: _DecorCircle(
            size: 70,
            color: _accentColor.withOpacity(0.16),
          ),
        ),
      ],
    );
  }
}

class _DecorCircle extends StatelessWidget {
  final double size;
  final Color color;

  const _DecorCircle({
    required this.size,
    required this.color,
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      width: size,
      height: size,
      decoration: BoxDecoration(
        color: color,
        shape: BoxShape.circle,
      ),
    );
  }
}

class _TopActions extends StatelessWidget {
  final bool isDarkMode;
  final bool isMalagasy;
  final VoidCallback onBack;
  final VoidCallback onFrench;
  final VoidCallback onMalagasy;
  final VoidCallback onTheme;

  const _TopActions({
    required this.isDarkMode,
    required this.isMalagasy,
    required this.onBack,
    required this.onFrench,
    required this.onMalagasy,
    required this.onTheme,
  });

  @override
  Widget build(BuildContext context) {
    return Row(
      children: [
        _IconPill(
          icon: Icons.arrow_back,
          onTap: onBack,
        ),

        const Spacer(),

        _SmallPill(
          text: 'FR',
          icon: '🇫🇷',
          isActive: !isMalagasy,
          onTap: onFrench,
        ),

        const SizedBox(width: 6),

        _SmallPill(
          text: 'MG',
          icon: '🇲🇬',
          isActive: isMalagasy,
          onTap: onMalagasy,
        ),

        const SizedBox(width: 6),

        _IconPill(
          icon: isDarkMode ? Icons.light_mode : Icons.dark_mode,
          onTap: onTheme,
        ),
      ],
    );
  }
}

class _SmallPill extends StatelessWidget {
  final String text;
  final String icon;
  final bool isActive;
  final VoidCallback onTap;

  const _SmallPill({
    required this.text,
    required this.icon,
    required this.isActive,
    required this.onTap,
  });

  @override
  Widget build(BuildContext context) {
    return Material(
      color: isActive ? AppColors.primary : Colors.white.withOpacity(0.78),
      borderRadius: BorderRadius.circular(999),
      child: InkWell(
        borderRadius: BorderRadius.circular(999),
        onTap: onTap,
        child: Padding(
          padding: const EdgeInsets.symmetric(
            horizontal: 9,
            vertical: 6,
          ),
          child: Text(
            '$icon $text',
            style: TextStyle(
              color: isActive ? Colors.white : AppColors.primary,
              fontSize: 11,
              fontWeight: FontWeight.w900,
            ),
          ),
        ),
      ),
    );
  }
}

class _IconPill extends StatelessWidget {
  final IconData icon;
  final VoidCallback onTap;

  const _IconPill({
    required this.icon,
    required this.onTap,
  });

  @override
  Widget build(BuildContext context) {
    return Material(
      color: Colors.white.withOpacity(0.78),
      borderRadius: BorderRadius.circular(999),
      child: InkWell(
        borderRadius: BorderRadius.circular(999),
        onTap: onTap,
        child: Padding(
          padding: const EdgeInsets.all(7),
          child: Icon(
            icon,
            size: 17,
            color: AppColors.primary,
          ),
        ),
      ),
    );
  }
}

class _RegisterHero extends StatelessWidget {
  final bool smallPhone;

  const _RegisterHero({
    required this.smallPhone,
  });

  @override
  Widget build(BuildContext context) {
    final settings = AppSettingsService.instance;

    return Container(
      width: double.infinity,
      constraints: const BoxConstraints(
        maxWidth: 420,
      ),
      padding: EdgeInsets.all(
        smallPhone ? 14 : 16,
      ),
      decoration: BoxDecoration(
        gradient: const LinearGradient(
          colors: [
            AppColors.primary,
            _secondaryColor,
          ],
        ),
        borderRadius: BorderRadius.circular(26),
        boxShadow: [
          BoxShadow(
            color: AppColors.primary.withOpacity(0.24),
            blurRadius: 22,
            offset: const Offset(0, 12),
          ),
        ],
      ),
      child: Column(
        children: [
          Container(
            width: smallPhone ? 54 : 60,
            height: smallPhone ? 54 : 60,
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(20),
            ),
            child: Icon(
              Icons.person_add_alt_1,
              size: smallPhone ? 30 : 34,
              color: AppColors.primary,
            ),
          ),

          const SizedBox(height: 8),

          Text(
            settings.tr('create_account'),
            textAlign: TextAlign.center,
            maxLines: 1,
            overflow: TextOverflow.ellipsis,
            style: TextStyle(
              color: Colors.white,
              fontSize: smallPhone ? 19 : 21,
              fontWeight: FontWeight.w900,
            ),
          ),

          const SizedBox(height: 4),

          Text(
            settings.tr('parent_registration'),
            textAlign: TextAlign.center,
            maxLines: 2,
            overflow: TextOverflow.ellipsis,
            style: const TextStyle(
              color: Colors.white70,
              fontSize: 12,
              height: 1.25,
            ),
          ),

          const SizedBox(height: 8),

          Wrap(
            alignment: WrapAlignment.center,
            spacing: 6,
            runSpacing: 6,
            children: [
              _FeatureChip(
                icon: Icons.family_restroom,
                text: settings.isMalagasy ? 'Ray aman-dreny' : 'Parent',
              ),
              _FeatureChip(
                icon: Icons.menu_book_outlined,
                text: settings.isMalagasy ? 'Fianarana' : 'Apprentissage',
              ),
              _FeatureChip(
                icon: Icons.verified_user_outlined,
                text: settings.isMalagasy ? 'Azo antoka' : 'Sécurisé',
              ),
            ],
          ),
        ],
      ),
    );
  }
}

class _FeatureChip extends StatelessWidget {
  final IconData icon;
  final String text;

  const _FeatureChip({
    required this.icon,
    required this.text,
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(
        horizontal: 8,
        vertical: 5,
      ),
      decoration: BoxDecoration(
        color: Colors.white.withOpacity(0.18),
        borderRadius: BorderRadius.circular(999),
        border: Border.all(
          color: Colors.white.withOpacity(0.22),
        ),
      ),
      child: Row(
        mainAxisSize: MainAxisSize.min,
        children: [
          Icon(
            icon,
            size: 13,
            color: Colors.white,
          ),

          const SizedBox(width: 5),

          Text(
            text,
            style: const TextStyle(
              color: Colors.white,
              fontSize: 10,
              fontWeight: FontWeight.w800,
            ),
          ),
        ],
      ),
    );
  }
}

class _MessageBox extends StatelessWidget {
  final String message;
  final bool isSuccess;

  const _MessageBox({
    required this.message,
    required this.isSuccess,
  });

  @override
  Widget build(BuildContext context) {
    final Color color = isSuccess ? AppColors.success : AppColors.danger;

    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(10),
      margin: const EdgeInsets.only(bottom: 10),
      decoration: BoxDecoration(
        color: color.withOpacity(0.09),
        borderRadius: BorderRadius.circular(12),
        border: Border.all(
          color: color.withOpacity(0.20),
        ),
      ),
      child: Text(
        message,
        style: TextStyle(
          color: color,
          fontSize: 12,
          fontWeight: FontWeight.w700,
        ),
      ),
    );
  }
}