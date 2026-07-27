import 'package:flutter/material.dart';

import '../services/api_service.dart';
import '../services/app_settings_service.dart';
import '../theme/app_theme.dart';

class QuizDetailScreen extends StatefulWidget {
  final int quizId;

  const QuizDetailScreen({
    super.key,
    required this.quizId,
  });

  @override
  State<QuizDetailScreen> createState() => _QuizDetailScreenState();
}

class _QuizDetailScreenState extends State<QuizDetailScreen> {
  late Future<Map<String, dynamic>> quizFuture;

  final Map<int, int> selectedAnswers = {};

  bool isSubmitting = false;
  String? message;
  String? scoreText;

  @override
  void initState() {
    super.initState();
    quizFuture = ApiService.getQuizDetail(widget.quizId);
  }

  Future<void> submitQuiz(Map<String, dynamic> quiz) async {
    final settings = AppSettingsService.instance;
    final questions = quiz['questions'] ?? [];

    if (selectedAnswers.length != questions.length) {
      setState(() {
        message = settings.tr('must_answer_all');
        scoreText = null;
      });
      return;
    }

    setState(() {
      isSubmitting = true;
      message = null;
      scoreText = null;
    });

    try {
      final answers = selectedAnswers.entries.map((entry) {
        return {
          'question_id': entry.key,
          'answer_id': entry.value,
        };
      }).toList();

      final data = await ApiService.submitQuiz(
        quizId: widget.quizId,
        answers: answers,
      );

      final score = data['score'];

      setState(() {
        message = data['message'] ?? settings.tr('quiz_submit_success');

        if (score != null) {
          scoreText =
              '${settings.tr('score_label')} : ${score['score']} / ${score['total']}';
        }
      });
    } catch (e) {
      setState(() {
        message = settings.tr('quiz_submit_error');
        scoreText = null;
      });
    } finally {
      if (mounted) {
        setState(() {
          isSubmitting = false;
        });
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    final settings = AppSettingsService.instance;

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
                  child: FutureBuilder<Map<String, dynamic>>(
                    future: quizFuture,
                    builder: (context, snapshot) {
                      if (snapshot.connectionState == ConnectionState.waiting) {
                        return const Center(
                          child: CircularProgressIndicator(),
                        );
                      }

                      if (snapshot.hasError) {
                        return const _ErrorState();
                      }

                      final quiz = snapshot.data!;
                      final questions = quiz['questions'] ?? [];

                      return SingleChildScrollView(
                        padding: EdgeInsets.fromLTRB(
                          smallPhone ? 12 : 16,
                          16,
                          smallPhone ? 12 : 16,
                          24,
                        ),
                        child: Center(
                          child: ConstrainedBox(
                            constraints: const BoxConstraints(maxWidth: 680),
                            child: Column(
                              children: [
                                _QuizIntroCard(
                                  quiz: quiz,
                                  smallPhone: smallPhone,
                                ),

                                const SizedBox(height: 16),

                                if (questions.isEmpty)
                                  const _EmptyQuestionCard(),

                                ...questions.asMap().entries.map<Widget>((entry) {
                                  final index = entry.key;
                                  final question = entry.value;
                                  final answers = question['answers'] ?? [];
                                  final int questionId = question['id'];

                                  return _QuestionCard(
                                    index: index,
                                    question: question,
                                    answers: answers,
                                    questionId: questionId,
                                    selectedAnswerId:
                                        selectedAnswers[questionId],
                                    onChanged: (value) {
                                      if (value == null) return;

                                      setState(() {
                                        selectedAnswers[questionId] = value;
                                      });
                                    },
                                    smallPhone: smallPhone,
                                  );
                                }).toList(),

                                const SizedBox(height: 12),

                                if (message != null)
                                  _MessageBox(
                                    message: message!,
                                    isSuccess: scoreText != null,
                                  ),

                                if (scoreText != null)
                                  _ScoreBox(scoreText: scoreText!),

                                if (questions.isNotEmpty)
                                  SizedBox(
                                    width: double.infinity,
                                    child: ElevatedButton.icon(
                                      onPressed: isSubmitting
                                          ? null
                                          : () => submitQuiz(quiz),
                                      icon: isSubmitting
                                          ? const SizedBox(
                                              width: 18,
                                              height: 18,
                                              child: CircularProgressIndicator(
                                                color: Colors.white,
                                                strokeWidth: 2,
                                              ),
                                            )
                                          : const Icon(Icons.send_outlined),
                                      label: Text(
                                        isSubmitting
                                            ? settings.tr('submitting')
                                            : settings.tr('submit_quiz'),
                                      ),
                                    ),
                                  ),
                              ],
                            ),
                          ),
                        ),
                      );
                    },
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
        color: Colors.purple,
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
              Icons.quiz_outlined,
              color: Colors.purple,
              size: smallPhone ? 25 : 28,
            ),
          ),

          const SizedBox(width: 12),

          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  settings.tr('quiz_detail_title'),
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
                  settings.tr('quiz_detail_subtitle'),
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

class _QuizIntroCard extends StatelessWidget {
  final Map<String, dynamic> quiz;
  final bool smallPhone;

  const _QuizIntroCard({
    required this.quiz,
    required this.smallPhone,
  });

  @override
  Widget build(BuildContext context) {
    final settings = AppSettingsService.instance;
    final bool isDark = Theme.of(context).brightness == Brightness.dark;

    return Card(
      elevation: 4,
      shadowColor: Colors.black.withOpacity(0.08),
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(22),
      ),
      child: Padding(
        padding: EdgeInsets.all(smallPhone ? 18 : 22),
        child: Row(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Container(
              width: smallPhone ? 48 : 56,
              height: smallPhone ? 48 : 56,
              decoration: BoxDecoration(
                color: Colors.purple.withOpacity(0.14),
                borderRadius: BorderRadius.circular(18),
              ),
              child: Icon(
                Icons.quiz_outlined,
                color: Colors.purple,
                size: smallPhone ? 28 : 32,
              ),
            ),

            const SizedBox(width: 14),

            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    quiz['title'] ?? settings.tr('no_title'),
                    style: TextStyle(
                      color: isDark ? AppColors.textLight : AppColors.textDark,
                      fontSize: smallPhone ? 21 : 24,
                      fontWeight: FontWeight.bold,
                      height: 1.25,
                    ),
                  ),

                  const SizedBox(height: 8),

                  Text(
                    quiz['description'] ??
                        settings.tr('no_description_short'),
                    style: TextStyle(
                      color: isDark
                          ? AppColors.textMutedDark
                          : AppColors.textMuted,
                      fontSize: 15,
                      height: 1.6,
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

class _QuestionCard extends StatelessWidget {
  final int index;
  final Map<String, dynamic> question;
  final List<dynamic> answers;
  final int questionId;
  final int? selectedAnswerId;
  final ValueChanged<int?> onChanged;
  final bool smallPhone;

  const _QuestionCard({
    required this.index,
    required this.question,
    required this.answers,
    required this.questionId,
    required this.selectedAnswerId,
    required this.onChanged,
    required this.smallPhone,
  });

  @override
  Widget build(BuildContext context) {
    final settings = AppSettingsService.instance;
    final bool isDark = Theme.of(context).brightness == Brightness.dark;

    return Card(
      margin: const EdgeInsets.only(bottom: 14),
      elevation: 4,
      shadowColor: Colors.black.withOpacity(0.08),
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(22),
      ),
      child: Padding(
        padding: EdgeInsets.all(smallPhone ? 16 : 18),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Container(
              padding: const EdgeInsets.symmetric(
                horizontal: 11,
                vertical: 6,
              ),
              decoration: BoxDecoration(
                color: Colors.purple.withOpacity(0.10),
                borderRadius: BorderRadius.circular(20),
              ),
              child: Text(
                '${settings.tr('question_label')} ${index + 1}',
                style: const TextStyle(
                  color: Colors.purple,
                  fontSize: 12,
                  fontWeight: FontWeight.w700,
                ),
              ),
            ),

            const SizedBox(height: 12),

            Text(
              question['question_text'] ?? settings.tr('question_label'),
              style: TextStyle(
                color: isDark ? AppColors.textLight : AppColors.textDark,
                fontSize: smallPhone ? 16 : 17,
                fontWeight: FontWeight.bold,
                height: 1.4,
              ),
            ),

            const SizedBox(height: 12),

            ...answers.map<Widget>((answer) {
              final int answerId = answer['id'];
              final bool isSelected = selectedAnswerId == answerId;

              return Container(
                margin: const EdgeInsets.only(bottom: 8),
                decoration: BoxDecoration(
                  color: isSelected
                      ? Colors.purple.withOpacity(0.08)
                      : isDark
                          ? Colors.white10
                          : Colors.grey.shade50,
                  borderRadius: BorderRadius.circular(14),
                  border: Border.all(
                    color: isSelected
                        ? Colors.purple
                        : isDark
                            ? Colors.white24
                            : Colors.grey.shade200,
                  ),
                ),
                child: RadioListTile<int>(
                  value: answerId,
                  groupValue: selectedAnswerId,
                  activeColor: Colors.purple,
                  title: Text(
                    answer['answer_text'] ?? '',
                    style: TextStyle(
                      color:
                          isDark ? AppColors.textLight : AppColors.textDark,
                      fontSize: 14,
                      height: 1.4,
                    ),
                  ),
                  onChanged: onChanged,
                  contentPadding: const EdgeInsets.symmetric(
                    horizontal: 8,
                    vertical: 2,
                  ),
                ),
              );
            }).toList(),
          ],
        ),
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
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(13),
      margin: const EdgeInsets.only(bottom: 12),
      decoration: BoxDecoration(
        color: isSuccess
            ? AppColors.success.withOpacity(0.08)
            : AppColors.danger.withOpacity(0.08),
        borderRadius: BorderRadius.circular(14),
      ),
      child: Text(
        message,
        style: TextStyle(
          color: isSuccess ? AppColors.success : AppColors.danger,
          fontWeight: FontWeight.w600,
        ),
      ),
    );
  }
}

class _ScoreBox extends StatelessWidget {
  final String scoreText;

  const _ScoreBox({
    required this.scoreText,
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(16),
      margin: const EdgeInsets.only(bottom: 16),
      decoration: BoxDecoration(
        color: Colors.purple.withOpacity(0.08),
        borderRadius: BorderRadius.circular(16),
      ),
      child: Text(
        scoreText,
        textAlign: TextAlign.center,
        style: const TextStyle(
          color: Colors.purple,
          fontSize: 19,
          fontWeight: FontWeight.bold,
        ),
      ),
    );
  }
}

class _EmptyQuestionCard extends StatelessWidget {
  const _EmptyQuestionCard();

  @override
  Widget build(BuildContext context) {
    final settings = AppSettingsService.instance;
    final bool isDark = Theme.of(context).brightness == Brightness.dark;

    return Card(
      elevation: 3,
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(22),
      ),
      child: Padding(
        padding: const EdgeInsets.all(22),
        child: Center(
          child: Text(
            settings.tr('no_question_available'),
            textAlign: TextAlign.center,
            style: TextStyle(
              color: isDark
                  ? AppColors.textMutedDark
                  : AppColors.textMuted,
              fontSize: 15,
            ),
          ),
        ),
      ),
    );
  }
}

class _ErrorState extends StatelessWidget {
  const _ErrorState();

  @override
  Widget build(BuildContext context) {
    final settings = AppSettingsService.instance;

    return Center(
      child: Padding(
        padding: const EdgeInsets.all(24),
        child: Text(
          settings.tr('quiz_load_detail_error'),
          textAlign: TextAlign.center,
          style: const TextStyle(
            color: AppColors.danger,
            fontWeight: FontWeight.w600,
          ),
        ),
      ),
    );
  }
}