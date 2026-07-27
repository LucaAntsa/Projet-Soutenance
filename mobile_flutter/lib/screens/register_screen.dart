import 'package:flutter/material.dart';

import '../services/api_service.dart';
import '../services/app_settings_service.dart';
import '../theme/app_theme.dart';

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
  String? message;
  bool isSuccess = false;

  Future<void> register() async {
    final settings = AppSettingsService.instance;

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

  @override
  Widget build(BuildContext context) {
    final settings = AppSettingsService.instance;
    final bool isDark = Theme.of(context).brightness == Brightness.dark;

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
                    _RegisterHeader(smallPhone: smallPhone),

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
                                    settings.tr('account_info'),
                                    style: TextStyle(
                                      color: isDark
                                          ? AppColors.textLight
                                          : AppColors.textDark,
                                      fontSize: smallPhone ? 20 : 22,
                                      fontWeight: FontWeight.bold,
                                    ),
                                  ),

                                  const SizedBox(height: 6),

                                  Text(
                                    settings.tr('register_subtitle'),
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
                                    controller: nameController,
                                    textInputAction: TextInputAction.next,
                                    decoration: InputDecoration(
                                      labelText: settings.tr('full_name'),
                                      prefixIcon:
                                          const Icon(Icons.person_outline),
                                    ),
                                  ),

                                  const SizedBox(height: 16),

                                  TextField(
                                    controller: emailController,
                                    keyboardType: TextInputType.emailAddress,
                                    textInputAction: TextInputAction.next,
                                    decoration: InputDecoration(
                                      labelText: settings.tr('email_address'),
                                      prefixIcon:
                                          const Icon(Icons.email_outlined),
                                    ),
                                  ),

                                  const SizedBox(height: 16),

                                  TextField(
                                    controller: passwordController,
                                    obscureText: true,
                                    textInputAction: TextInputAction.done,
                                    onSubmitted: (_) {
                                      if (!isLoading) {
                                        register();
                                      }
                                    },
                                    decoration: InputDecoration(
                                      labelText: settings.tr('password'),
                                      prefixIcon:
                                          const Icon(Icons.lock_outline),
                                    ),
                                  ),

                                  const SizedBox(height: 22),

                                  SizedBox(
                                    width: double.infinity,
                                    child: ElevatedButton(
                                      onPressed: isLoading ? null : register,
                                      child: isLoading
                                          ? const SizedBox(
                                              width: 22,
                                              height: 22,
                                              child: CircularProgressIndicator(
                                                color: Colors.white,
                                                strokeWidth: 2,
                                              ),
                                            )
                                          : Text(settings.tr('register_button')),
                                    ),
                                  ),

                                  const SizedBox(height: 16),

                                  Center(
                                    child: TextButton(
                                      onPressed: () => Navigator.pop(context),
                                      child: Text(
                                        settings.tr('already_have_account'),
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

class _RegisterHeader extends StatelessWidget {
  final bool smallPhone;

  const _RegisterHeader({
    required this.smallPhone,
  });

  @override
  Widget build(BuildContext context) {
    final settings = AppSettingsService.instance;

    return Container(
      width: double.infinity,
      padding: EdgeInsets.fromLTRB(
        smallPhone ? 12 : 18,
        smallPhone ? 18 : 24,
        smallPhone ? 18 : 24,
        smallPhone ? 32 : 38,
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
            children: [
              IconButton(
                onPressed: () => Navigator.pop(context),
                icon: const Icon(
                  Icons.arrow_back,
                  color: Colors.white,
                ),
              ),

              const Spacer(),

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

          const SizedBox(height: 14),

          CircleAvatar(
            radius: smallPhone ? 36 : 42,
            backgroundColor: Colors.white,
            child: Icon(
              Icons.person_add_alt_1,
              size: smallPhone ? 40 : 46,
              color: AppColors.primary,
            ),
          ),

          const SizedBox(height: 18),

          Text(
            settings.tr('create_account'),
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
            settings.tr('parent_registration'),
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