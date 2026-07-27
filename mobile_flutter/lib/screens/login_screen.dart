import 'package:flutter/material.dart';

import '../services/api_service.dart';
import '../services/notification_service.dart';
import '../services/app_settings_service.dart';
import '../theme/app_theme.dart';

import 'home_screen.dart';
import 'register_screen.dart';

class LoginScreen extends StatefulWidget {
  const LoginScreen({super.key});

  @override
  State<LoginScreen> createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  final TextEditingController emailController = TextEditingController();
  final TextEditingController passwordController = TextEditingController();

  bool isLoading = false;
  String? message;

  Future<void> login() async {
    final settings = AppSettingsService.instance;

    setState(() {
      isLoading = true;
      message = null;
    });

    try {
      final data = await ApiService.login(
        email: emailController.text.trim(),
        password: passwordController.text.trim(),
      );

      if (data['token'] != null) {
        try {
          final firebaseToken = await NotificationService.getFirebaseToken();

          if (firebaseToken != null) {
            await ApiService.saveDeviceToken(
              firebaseToken: firebaseToken,
              deviceType: 'android',
            );
          }
        } catch (e) {
          // La connexion continue même si Firebase échoue.
        }

        if (!mounted) return;

        Navigator.pushReplacement(
          context,
          MaterialPageRoute(
            builder: (_) => const HomeScreen(),
          ),
        );
      } else {
        setState(() {
          message = data['message'] ?? settings.tr('login_failed');
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
    emailController.dispose();
    passwordController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    final settings = AppSettingsService.instance;
    final bool isDark = Theme.of(context).brightness == Brightness.dark;
    const bool isSuccess = false;

    return Scaffold(
      backgroundColor: Theme.of(context).scaffoldBackgroundColor,
      body: SafeArea(
        child: LayoutBuilder(
          builder: (context, constraints) {
            final double width = constraints.maxWidth;
            final bool smallPhone = width < 360;

            return SingleChildScrollView(
              keyboardDismissBehavior: ScrollViewKeyboardDismissBehavior.onDrag,
              child: ConstrainedBox(
                constraints: BoxConstraints(
                  minHeight: constraints.maxHeight,
                ),
                child: Column(
                  children: [
                    _LoginHeader(smallPhone: smallPhone),

                    Padding(
                      padding: EdgeInsets.all(smallPhone ? 14 : 20),
                      child: Center(
                        child: ConstrainedBox(
                          constraints: const BoxConstraints(
                            maxWidth: 480,
                          ),
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
                                  Text(
                                    settings.tr('login'),
                                    style: TextStyle(
                                      color: isDark
                                          ? AppColors.textLight
                                          : AppColors.textDark,
                                      fontSize: smallPhone ? 22 : 24,
                                      fontWeight: FontWeight.bold,
                                    ),
                                  ),

                                  const SizedBox(height: 6),

                                  Text(
                                    settings.tr('login_subtitle'),
                                    style: TextStyle(
                                      color: isDark
                                          ? AppColors.textMutedDark
                                          : AppColors.textMuted,
                                      fontSize: 14,
                                      height: 1.4,
                                    ),
                                  ),

                                  const SizedBox(height: 22),

                                  if (message != null)
                                    Container(
                                      width: double.infinity,
                                      padding: const EdgeInsets.all(12),
                                      margin: const EdgeInsets.only(bottom: 16),
                                      decoration: BoxDecoration(
                                        color: isSuccess
                                            ? AppColors.success.withOpacity(0.08)
                                            : AppColors.danger.withOpacity(0.08),
                                        borderRadius: BorderRadius.circular(12),
                                      ),
                                      child: Text(
                                        message!,
                                        style: TextStyle(
                                          color: isSuccess
                                              ? AppColors.success
                                              : AppColors.danger,
                                          fontWeight: FontWeight.w500,
                                        ),
                                      ),
                                    ),

                                  TextField(
                                    controller: emailController,
                                    keyboardType: TextInputType.emailAddress,
                                    textInputAction: TextInputAction.next,
                                    decoration: InputDecoration(
                                      labelText: settings.tr('email_address'),
                                      prefixIcon: const Icon(Icons.email_outlined),
                                    ),
                                  ),

                                  const SizedBox(height: 16),

                                  TextField(
                                    controller: passwordController,
                                    obscureText: true,
                                    textInputAction: TextInputAction.done,
                                    onSubmitted: (_) {
                                      if (!isLoading) {
                                        login();
                                      }
                                    },
                                    decoration: InputDecoration(
                                      labelText: settings.tr('password'),
                                      prefixIcon: const Icon(Icons.lock_outline),
                                    ),
                                  ),

                                  const SizedBox(height: 22),

                                  SizedBox(
                                    width: double.infinity,
                                    child: ElevatedButton(
                                      onPressed: isLoading ? null : login,
                                      child: isLoading
                                          ? const SizedBox(
                                              width: 22,
                                              height: 22,
                                              child: CircularProgressIndicator(
                                                color: Colors.white,
                                                strokeWidth: 2,
                                              ),
                                            )
                                          : Text(settings.tr('login_button')),
                                    ),
                                  ),

                                  const SizedBox(height: 16),

                                  Wrap(
                                    alignment: WrapAlignment.center,
                                    crossAxisAlignment:
                                        WrapCrossAlignment.center,
                                    children: [
                                      Text(
                                        settings.tr('no_account'),
                                        style: TextStyle(
                                          color: isDark
                                              ? AppColors.textMutedDark
                                              : AppColors.textMuted,
                                        ),
                                      ),
                                      TextButton(
                                        onPressed: () {
                                          Navigator.push(
                                            context,
                                            MaterialPageRoute(
                                              builder: (_) =>
                                                  const RegisterScreen(),
                                            ),
                                          );
                                        },
                                        child: Text(
                                          settings.tr('create_account'),
                                        ),
                                      ),
                                    ],
                                  ),
                                ],
                              ),
                            ),
                          ),
                        ),
                      ),
                    ),
                  ],
                ),
              ),
            );
          },
        ),
      ),
    );
  }
}

class _LoginHeader extends StatelessWidget {
  final bool smallPhone;

  const _LoginHeader({
    required this.smallPhone,
  });

  @override
  Widget build(BuildContext context) {
    final settings = AppSettingsService.instance;

    return Container(
      width: double.infinity,
      padding: EdgeInsets.fromLTRB(
        smallPhone ? 18 : 24,
        smallPhone ? 18 : 24,
        smallPhone ? 18 : 24,
        smallPhone ? 34 : 42,
      ),
      decoration: const BoxDecoration(
        color: AppColors.primary,
        borderRadius: BorderRadius.only(
          bottomLeft: Radius.circular(32),
          bottomRight: Radius.circular(32),
        ),
      ),
      child: Column(
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.end,
            children: [
              _HeaderButton(
                text: 'FR',
                isActive: !settings.isMalagasy,
                onTap: () {
                  settings.changeLanguage('fr');
                },
              ),

              const SizedBox(width: 8),

              _HeaderButton(
                text: 'MG',
                isActive: settings.isMalagasy,
                onTap: () {
                  settings.changeLanguage('mg');
                },
              ),

              const SizedBox(width: 8),

              _ThemeButton(
                isDarkMode: settings.isDarkMode,
                onTap: () {
                  settings.toggleTheme();
                },
              ),
            ],
          ),

          const SizedBox(height: 18),

          CircleAvatar(
            radius: smallPhone ? 36 : 42,
            backgroundColor: Colors.white,
            child: Icon(
              Icons.family_restroom,
              size: smallPhone ? 42 : 48,
              color: AppColors.primary,
            ),
          ),

          const SizedBox(height: 18),

          Text(
            settings.tr('app_name'),
            textAlign: TextAlign.center,
            maxLines: 2,
            overflow: TextOverflow.ellipsis,
            style: TextStyle(
              color: Colors.white,
              fontSize: smallPhone ? 23 : 26,
              fontWeight: FontWeight.bold,
            ),
          ),

          const SizedBox(height: 8),

          Text(
            settings.tr('platform_subtitle'),
            textAlign: TextAlign.center,
            style: const TextStyle(
              color: Colors.white70,
              fontSize: 14,
              height: 1.4,
            ),
          ),
        ],
      ),
    );
  }
}

class _HeaderButton extends StatelessWidget {
  final String text;
  final bool isActive;
  final VoidCallback onTap;

  const _HeaderButton({
    required this.text,
    required this.isActive,
    required this.onTap,
  });

  @override
  Widget build(BuildContext context) {
    return InkWell(
      borderRadius: BorderRadius.circular(20),
      onTap: onTap,
      child: Container(
        padding: const EdgeInsets.symmetric(
          horizontal: 12,
          vertical: 7,
        ),
        decoration: BoxDecoration(
          color: isActive ? Colors.white : Colors.white.withOpacity(0.16),
          borderRadius: BorderRadius.circular(20),
        ),
        child: Text(
          text,
          style: TextStyle(
            color: isActive ? AppColors.primary : Colors.white,
            fontSize: 12,
            fontWeight: FontWeight.bold,
          ),
        ),
      ),
    );
  }
}

class _ThemeButton extends StatelessWidget {
  final bool isDarkMode;
  final VoidCallback onTap;

  const _ThemeButton({
    required this.isDarkMode,
    required this.onTap,
  });

  @override
  Widget build(BuildContext context) {
    return InkWell(
      borderRadius: BorderRadius.circular(20),
      onTap: onTap,
      child: Container(
        padding: const EdgeInsets.all(7),
        decoration: BoxDecoration(
          color: Colors.white.withOpacity(0.16),
          borderRadius: BorderRadius.circular(20),
        ),
        child: Icon(
          isDarkMode ? Icons.light_mode : Icons.dark_mode,
          color: Colors.white,
          size: 18,
        ),
      ),
    );
  }
}