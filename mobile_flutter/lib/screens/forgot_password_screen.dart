import 'package:flutter/material.dart';

import '../services/api_service.dart';
import '../services/app_settings_service.dart';
import '../theme/app_theme.dart';

const Color _secondaryColor = Color(0xFF14B8A6);
const Color _darkCardColor = Color(0xFF1E293B);
const Color _darkBackgroundColor = Color(0xFF0F172A);

class ForgotPasswordScreen extends StatefulWidget {
  final String initialEmail;

  const ForgotPasswordScreen({
    super.key,
    this.initialEmail = '',
  });

  @override
  State<ForgotPasswordScreen> createState() =>
      _ForgotPasswordScreenState();
}

class _ForgotPasswordScreenState extends State<ForgotPasswordScreen> {
  late final TextEditingController emailController;
  final TextEditingController codeController = TextEditingController();
  final TextEditingController passwordController = TextEditingController();
  final TextEditingController confirmationController = TextEditingController();

  bool codeSent = false;
  bool isLoading = false;
  bool hidePassword = true;
  bool hideConfirmation = true;
  bool isSuccess = false;
  String? message;

  @override
  void initState() {
    super.initState();
    emailController = TextEditingController(text: widget.initialEmail);
  }

  bool _isEmailValid(String value) {
    return RegExp(r'^[^\s@]+@[^\s@]+\.[^\s@]+$').hasMatch(value);
  }

  Future<void> sendCode() async {
    final settings = AppSettingsService.instance;
    final email = emailController.text.trim().toLowerCase();

    if (!_isEmailValid(email)) {
      setState(() {
        isSuccess = false;
        message = settings.isMalagasy
            ? 'Ampidiro tsara ny adiresy email.'
            : 'Veuillez saisir une adresse e-mail valide.';
      });
      return;
    }

    setState(() {
      isLoading = true;
      isSuccess = false;
      message = null;
    });

    try {
      final data = await ApiService.requestPasswordReset(email: email);

      if (!mounted) return;

      final success = data['success'] == true;

      setState(() {
        isSuccess = success;
        message = data['message']?.toString() ??
            (success
                ? (settings.isMalagasy
                    ? 'Nalefa tamin’ny email ny kaody.'
                    : 'Le code a été envoyé par e-mail.')
                : (settings.isMalagasy
                    ? 'Tsy afaka mandefa ny kaody.'
                    : 'Impossible d’envoyer le code.'));

        if (success) {
          codeSent = true;
        }
      });
    } catch (_) {
      if (!mounted) return;

      setState(() {
        isSuccess = false;
        message = settings.isMalagasy
            ? 'Tsy afaka mifandray amin’ny serveur.'
            : 'Impossible de contacter le serveur.';
      });
    } finally {
      if (mounted) {
        setState(() {
          isLoading = false;
        });
      }
    }
  }

  Future<void> resetPassword() async {
    final settings = AppSettingsService.instance;
    final email = emailController.text.trim().toLowerCase();
    final code = codeController.text.trim();
    final password = passwordController.text;
    final confirmation = confirmationController.text;

    if (!_isEmailValid(email)) {
      setState(() {
        isSuccess = false;
        message = settings.isMalagasy
            ? 'Ampidiro tsara ny adiresy email.'
            : 'Veuillez saisir une adresse e-mail valide.';
      });
      return;
    }

    if (code.length != 6 || int.tryParse(code) == null) {
      setState(() {
        isSuccess = false;
        message = settings.isMalagasy
            ? 'Ampidiro ny kaody 6 isa.'
            : 'Saisissez le code à 6 chiffres.';
      });
      return;
    }

    if (password.length < 6) {
      setState(() {
        isSuccess = false;
        message = settings.isMalagasy
            ? 'Ny tenimiafina dia tokony hisy tarehintsoratra 6 farafahakeliny.'
            : 'Le mot de passe doit contenir au moins 6 caractères.';
      });
      return;
    }

    if (password != confirmation) {
      setState(() {
        isSuccess = false;
        message = settings.isMalagasy
            ? 'Tsy mitovy ny tenimiafina roa.'
            : 'Les deux mots de passe ne correspondent pas.';
      });
      return;
    }

    setState(() {
      isLoading = true;
      isSuccess = false;
      message = null;
    });

    try {
      final data = await ApiService.resetPassword(
        email: email,
        code: code,
        password: password,
        passwordConfirmation: confirmation,
      );

      if (!mounted) return;

      final success = data['success'] == true;

      setState(() {
        isSuccess = success;
        message = data['message']?.toString() ??
            (success
                ? (settings.isMalagasy
                    ? 'Vita ny fanovana tenimiafina.'
                    : 'Mot de passe modifié avec succès.')
                : (settings.isMalagasy
                    ? 'Tsy afaka manova ny tenimiafina.'
                    : 'Impossible de modifier le mot de passe.'));
      });

      if (success) {
        passwordController.clear();
        confirmationController.clear();
        codeController.clear();
      }
    } catch (_) {
      if (!mounted) return;

      setState(() {
        isSuccess = false;
        message = settings.isMalagasy
            ? 'Tsy afaka mifandray amin’ny serveur.'
            : 'Impossible de contacter le serveur.';
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
    codeController.dispose();
    passwordController.dispose();
    confirmationController.dispose();
    super.dispose();
  }

  InputDecoration _inputDecoration({
    required BuildContext context,
    required String label,
    required IconData icon,
    Widget? suffixIcon,
  }) {
    final isDark = Theme.of(context).brightness == Brightness.dark;

    return InputDecoration(
      labelText: label,
      prefixIcon: Icon(icon, size: 20),
      suffixIcon: suffixIcon,
      isDense: true,
      filled: true,
      fillColor: isDark ? _darkBackgroundColor : const Color(0xFFF8FAFC),
      contentPadding: const EdgeInsets.symmetric(
        horizontal: 12,
        vertical: 11,
      ),
      border: OutlineInputBorder(
        borderRadius: BorderRadius.circular(14),
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
    final isDark = Theme.of(context).brightness == Brightness.dark;

    return Scaffold(
      body: SafeArea(
        child: LayoutBuilder(
          builder: (context, constraints) {
            final smallPhone = constraints.maxWidth < 360;

            return Stack(
              children: [
                const _PasswordBackground(),
                SingleChildScrollView(
                  keyboardDismissBehavior:
                      ScrollViewKeyboardDismissBehavior.onDrag,
                  child: ConstrainedBox(
                    constraints: BoxConstraints(
                      minHeight: constraints.maxHeight,
                    ),
                    child: Padding(
                      padding: EdgeInsets.fromLTRB(
                        smallPhone ? 10 : 14,
                        10,
                        smallPhone ? 10 : 14,
                        18,
                      ),
                      child: Column(
                        children: [
                          Row(
                            children: [
                              Material(
                                color: Colors.white.withOpacity(0.86),
                                borderRadius: BorderRadius.circular(999),
                                child: IconButton(
                                  tooltip: settings.isMalagasy
                                      ? 'Hiverina'
                                      : 'Retour',
                                  onPressed: () => Navigator.pop(context),
                                  icon: const Icon(
                                    Icons.arrow_back_rounded,
                                    color: AppColors.primary,
                                  ),
                                ),
                              ),
                              const Spacer(),
                              _LanguageButton(
                                label: 'FR',
                                active: !settings.isMalagasy,
                                onTap: () {
                                  settings.changeLanguage('fr');
                                  setState(() {});
                                },
                              ),
                              const SizedBox(width: 6),
                              _LanguageButton(
                                label: 'MG',
                                active: settings.isMalagasy,
                                onTap: () {
                                  settings.changeLanguage('mg');
                                  setState(() {});
                                },
                              ),
                              const SizedBox(width: 6),
                              Material(
                                color: Colors.white.withOpacity(0.86),
                                borderRadius: BorderRadius.circular(999),
                                child: IconButton(
                                  tooltip: 'Thème',
                                  onPressed: () {
                                    settings.toggleTheme();
                                    setState(() {});
                                  },
                                  icon: Icon(
                                    settings.isDarkMode
                                        ? Icons.light_mode_rounded
                                        : Icons.dark_mode_rounded,
                                    size: 19,
                                    color: AppColors.primary,
                                  ),
                                ),
                              ),
                            ],
                          ),
                          const SizedBox(height: 22),
                          ConstrainedBox(
                            constraints: const BoxConstraints(maxWidth: 430),
                            child: Container(
                              padding: EdgeInsets.all(smallPhone ? 15 : 19),
                              decoration: BoxDecoration(
                                color: isDark ? _darkCardColor : Colors.white,
                                borderRadius: BorderRadius.circular(26),
                                boxShadow: [
                                  BoxShadow(
                                    color: Colors.black.withOpacity(0.16),
                                    blurRadius: 28,
                                    offset: const Offset(0, 14),
                                  ),
                                ],
                              ),
                              child: Column(
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: [
                                  Center(
                                    child: Container(
                                      width: 62,
                                      height: 62,
                                      decoration: BoxDecoration(
                                        gradient: const LinearGradient(
                                          colors: [
                                            AppColors.primary,
                                            _secondaryColor,
                                          ],
                                        ),
                                        borderRadius: BorderRadius.circular(20),
                                      ),
                                      child: Icon(
                                        codeSent
                                            ? Icons.password_rounded
                                            : Icons.mark_email_read_outlined,
                                        color: Colors.white,
                                        size: 31,
                                      ),
                                    ),
                                  ),
                                  const SizedBox(height: 13),
                                  Center(
                                    child: Text(
                                      settings.isMalagasy
                                          ? 'Adino ny tenimiafina'
                                          : 'Mot de passe oublié',
                                      textAlign: TextAlign.center,
                                      style: TextStyle(
                                        color: isDark
                                            ? AppColors.textLight
                                            : AppColors.textDark,
                                        fontSize: smallPhone ? 20 : 23,
                                        fontWeight: FontWeight.w900,
                                      ),
                                    ),
                                  ),
                                  const SizedBox(height: 6),
                                  Center(
                                    child: Text(
                                      codeSent
                                          ? (settings.isMalagasy
                                              ? 'Ampidiro ny kaody voaray sy ny tenimiafina vaovao.'
                                              : 'Saisissez le code reçu et votre nouveau mot de passe.')
                                          : (settings.isMalagasy
                                              ? 'Ampidiro ny email-nao handefasana kaody fanovana.'
                                              : 'Saisissez votre e-mail pour recevoir un code de réinitialisation.'),
                                      textAlign: TextAlign.center,
                                      style: TextStyle(
                                        color: isDark
                                            ? AppColors.textMutedDark
                                            : AppColors.textMuted,
                                        fontSize: 12.5,
                                        height: 1.35,
                                      ),
                                    ),
                                  ),
                                  const SizedBox(height: 16),
                                  if (message != null)
                                    _PasswordMessageBox(
                                      message: message!,
                                      success: isSuccess,
                                    ),
                                  TextField(
                                    controller: emailController,
                                    enabled: !isLoading && !codeSent,
                                    keyboardType: TextInputType.emailAddress,
                                    textInputAction: codeSent
                                        ? TextInputAction.next
                                        : TextInputAction.done,
                                    autofillHints: const [AutofillHints.email],
                                    decoration: _inputDecoration(
                                      context: context,
                                      label: settings.isMalagasy
                                          ? 'Adiresy email'
                                          : 'Adresse e-mail',
                                      icon: Icons.email_outlined,
                                    ),
                                    onSubmitted: (_) {
                                      if (!isLoading && !codeSent) {
                                        sendCode();
                                      }
                                    },
                                  ),
                                  if (codeSent) ...[
                                    const SizedBox(height: 10),
                                    TextField(
                                      controller: codeController,
                                      keyboardType: TextInputType.number,
                                      textInputAction: TextInputAction.next,
                                      maxLength: 6,
                                      decoration: _inputDecoration(
                                        context: context,
                                        label: settings.isMalagasy
                                            ? 'Kaody 6 isa'
                                            : 'Code à 6 chiffres',
                                        icon: Icons.pin_outlined,
                                      ).copyWith(counterText: ''),
                                    ),
                                    const SizedBox(height: 10),
                                    TextField(
                                      controller: passwordController,
                                      obscureText: hidePassword,
                                      textInputAction: TextInputAction.next,
                                      autofillHints: const [
                                        AutofillHints.newPassword,
                                      ],
                                      decoration: _inputDecoration(
                                        context: context,
                                        label: settings.isMalagasy
                                            ? 'Tenimiafina vaovao'
                                            : 'Nouveau mot de passe',
                                        icon: Icons.lock_outline_rounded,
                                        suffixIcon: IconButton(
                                          onPressed: () {
                                            setState(() {
                                              hidePassword = !hidePassword;
                                            });
                                          },
                                          icon: Icon(
                                            hidePassword
                                                ? Icons.visibility_off_outlined
                                                : Icons.visibility_outlined,
                                            size: 20,
                                          ),
                                        ),
                                      ),
                                    ),
                                    const SizedBox(height: 10),
                                    TextField(
                                      controller: confirmationController,
                                      obscureText: hideConfirmation,
                                      textInputAction: TextInputAction.done,
                                      autofillHints: const [
                                        AutofillHints.newPassword,
                                      ],
                                      onSubmitted: (_) {
                                        if (!isLoading) {
                                          resetPassword();
                                        }
                                      },
                                      decoration: _inputDecoration(
                                        context: context,
                                        label: settings.isMalagasy
                                            ? 'Avereno ny tenimiafina'
                                            : 'Confirmer le mot de passe',
                                        icon: Icons.lock_reset_rounded,
                                        suffixIcon: IconButton(
                                          onPressed: () {
                                            setState(() {
                                              hideConfirmation =
                                                  !hideConfirmation;
                                            });
                                          },
                                          icon: Icon(
                                            hideConfirmation
                                                ? Icons.visibility_off_outlined
                                                : Icons.visibility_outlined,
                                            size: 20,
                                          ),
                                        ),
                                      ),
                                    ),
                                  ],
                                  const SizedBox(height: 16),
                                  SizedBox(
                                    width: double.infinity,
                                    height: 46,
                                    child: ElevatedButton.icon(
                                      onPressed: isLoading
                                          ? null
                                          : codeSent
                                              ? resetPassword
                                              : sendCode,
                                      style: ElevatedButton.styleFrom(
                                        backgroundColor: AppColors.primary,
                                        foregroundColor: Colors.white,
                                        elevation: 0,
                                        shape: RoundedRectangleBorder(
                                          borderRadius:
                                              BorderRadius.circular(14),
                                        ),
                                      ),
                                      icon: isLoading
                                          ? const SizedBox(
                                              width: 18,
                                              height: 18,
                                              child: CircularProgressIndicator(
                                                color: Colors.white,
                                                strokeWidth: 2,
                                              ),
                                            )
                                          : Icon(
                                              codeSent
                                                  ? Icons.check_circle_outline
                                                  : Icons.send_rounded,
                                              size: 19,
                                            ),
                                      label: Text(
                                        codeSent
                                            ? (settings.isMalagasy
                                                ? 'Hanova tenimiafina'
                                                : 'Modifier le mot de passe')
                                            : (settings.isMalagasy
                                                ? 'Handefa kaody'
                                                : 'Envoyer le code'),
                                        style: const TextStyle(
                                          fontWeight: FontWeight.w900,
                                        ),
                                      ),
                                    ),
                                  ),
                                  if (codeSent) ...[
                                    const SizedBox(height: 7),
                                    Row(
                                      mainAxisAlignment:
                                          MainAxisAlignment.spaceBetween,
                                      children: [
                                        TextButton(
                                          onPressed: isLoading
                                              ? null
                                              : () {
                                                  setState(() {
                                                    codeSent = false;
                                                    isSuccess = false;
                                                    message = null;
                                                    codeController.clear();
                                                  });
                                                },
                                          child: Text(
                                            settings.isMalagasy
                                                ? 'Hanova email'
                                                : 'Changer l’e-mail',
                                          ),
                                        ),
                                        TextButton(
                                          onPressed:
                                              isLoading ? null : sendCode,
                                          child: Text(
                                            settings.isMalagasy
                                                ? 'Handefa indray'
                                                : 'Renvoyer le code',
                                          ),
                                        ),
                                      ],
                                    ),
                                  ],
                                  if (isSuccess && codeSent) ...[
                                    const SizedBox(height: 4),
                                    SizedBox(
                                      width: double.infinity,
                                      child: OutlinedButton.icon(
                                        onPressed: () => Navigator.pop(context),
                                        icon: const Icon(Icons.login_rounded),
                                        label: Text(
                                          settings.isMalagasy
                                              ? 'Hiverina amin’ny fidirana'
                                              : 'Retour à la connexion',
                                        ),
                                      ),
                                    ),
                                  ],
                                ],
                              ),
                            ),
                          ),
                        ],
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

class _PasswordBackground extends StatelessWidget {
  const _PasswordBackground();

  @override
  Widget build(BuildContext context) {
    final isDark = Theme.of(context).brightness == Brightness.dark;

    return Stack(
      children: [
        Positioned.fill(
          child: Image.asset(
            'assets/images/auth-family-bg.png',
            fit: BoxFit.cover,
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
                        const Color(0xFF0F172A).withOpacity(0.91),
                        const Color(0xFF0F172A).withOpacity(0.84),
                        const Color(0xFF0F766E).withOpacity(0.72),
                      ]
                    : [
                        const Color(0xFF0F172A).withOpacity(0.65),
                        const Color(0xFF2563EB).withOpacity(0.42),
                        const Color(0xFF14B8A6).withOpacity(0.45),
                      ],
              ),
            ),
          ),
        ),
      ],
    );
  }
}

class _LanguageButton extends StatelessWidget {
  final String label;
  final bool active;
  final VoidCallback onTap;

  const _LanguageButton({
    required this.label,
    required this.active,
    required this.onTap,
  });

  @override
  Widget build(BuildContext context) {
    return Material(
      color: active ? AppColors.primary : Colors.white.withOpacity(0.86),
      borderRadius: BorderRadius.circular(999),
      child: InkWell(
        onTap: onTap,
        borderRadius: BorderRadius.circular(999),
        child: Padding(
          padding: const EdgeInsets.symmetric(horizontal: 11, vertical: 8),
          child: Text(
            label,
            style: TextStyle(
              color: active ? Colors.white : AppColors.primary,
              fontSize: 11,
              fontWeight: FontWeight.w900,
            ),
          ),
        ),
      ),
    );
  }
}

class _PasswordMessageBox extends StatelessWidget {
  final String message;
  final bool success;

  const _PasswordMessageBox({
    required this.message,
    required this.success,
  });

  @override
  Widget build(BuildContext context) {
    final color = success ? AppColors.success : AppColors.danger;

    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(11),
      margin: const EdgeInsets.only(bottom: 11),
      decoration: BoxDecoration(
        color: color.withOpacity(0.09),
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: color.withOpacity(0.22)),
      ),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Icon(
            success ? Icons.check_circle_outline : Icons.error_outline,
            color: color,
            size: 19,
          ),
          const SizedBox(width: 8),
          Expanded(
            child: Text(
              message,
              style: TextStyle(
                color: color,
                fontSize: 12,
                fontWeight: FontWeight.w700,
                height: 1.3,
              ),
            ),
          ),
        ],
      ),
    );
  }
}
