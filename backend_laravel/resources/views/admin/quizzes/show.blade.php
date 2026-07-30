@php
    $locale = session('admin_locale', 'fr');
    $theme = session('admin_theme', 'light');

    $texts = [
        'fr' => [
            'page_title' => 'Détail du quiz - Administration',
            'header_subtitle' => 'Gestion des questions et réponses du quiz.',
            'back' => 'Retour',

            'quiz_info' => 'Informations du quiz',
            'no_description' => 'Aucune description.',
            'module' => 'Module',
            'no_module' => 'Non défini',

            'add_question' => 'Ajouter une question',
            'question' => 'Question',
            'points' => 'Points',
            'answer_1' => 'Réponse 1',
            'answer_2' => 'Réponse 2',
            'answer_3' => 'Réponse 3',
            'answer_4' => 'Réponse 4',
            'correct_answer' => 'Bonne réponse',
            'save_question' => 'Ajouter la question',

            'quiz_questions' => 'Questions du quiz',
            'good_answer' => 'Bonne réponse',
            'empty_title' => 'Aucune question ajoutée',
            'empty_text' => 'Ajoutez une première question pour compléter ce quiz.',
        ],
        'mg' => [
            'page_title' => 'Antsipirian’ny quiz - Administration',
            'header_subtitle' => 'Fitantanana ny fanontaniana sy valiny ao amin’ny quiz.',
            'back' => 'Hiverina',

            'quiz_info' => 'Mombamomba ny quiz',
            'no_description' => 'Tsy misy fanazavana.',
            'module' => 'Module',
            'no_module' => 'Tsy voafaritra',

            'add_question' => 'Hampiditra fanontaniana',
            'question' => 'Fanontaniana',
            'points' => 'Isa',
            'answer_1' => 'Valiny 1',
            'answer_2' => 'Valiny 2',
            'answer_3' => 'Valiny 3',
            'answer_4' => 'Valiny 4',
            'correct_answer' => 'Valiny marina',
            'save_question' => 'Hitahiry ny fanontaniana',

            'quiz_questions' => 'Fanontanian’ny quiz',
            'good_answer' => 'Valiny marina',
            'empty_title' => 'Tsy mbola misy fanontaniana',
            'empty_text' => 'Ampidiro ny fanontaniana voalohany hamenoana ity quiz ity.',
        ],
    ];

    $t = $texts[$locale] ?? $texts['fr'];
@endphp

<!DOCTYPE html>
<html lang="{{ $locale }}">
<head>
    <meta charset="UTF-8">
    <title>{{ $t['page_title'] }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #F3F6FB;
            font-family: Arial, sans-serif;
        }

        .admin-main {
            background: #F3F6FB;
            min-height: 100vh;
        }

        .page-header {
            background: linear-gradient(135deg, #7E22CE, #9333EA);
            border-radius: 22px;
            padding: 26px;
            color: white;
            margin-bottom: 24px;
            box-shadow: 0 12px 28px rgba(147, 51, 234, 0.22);
        }

        .page-title {
            font-size: 27px;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .page-subtitle {
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 0;
        }

        .content-card {
            border: 0;
            border-radius: 22px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
            overflow: hidden;
        }

        .form-label {
            font-weight: 700;
            color: #1E293B;
        }

        .form-control,
        .form-select {
            border-radius: 14px;
            padding: 13px 15px;
            border: 1px solid #CBD5E1;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #9333EA;
            box-shadow: 0 0 0 0.18rem rgba(147, 51, 234, 0.15);
        }

        .btn-save {
            background: #9333EA;
            border: 0;
            border-radius: 14px;
            padding: 12px 18px;
            font-weight: 700;
        }

        .btn-save:hover {
            background: #7E22CE;
        }

        .btn-back {
            background: #E2E8F0;
            color: #334155;
            border: 0;
            border-radius: 14px;
            padding: 12px 18px;
            font-weight: 700;
            text-decoration: none;
        }

        .btn-back:hover {
            background: #CBD5E1;
            color: #0F172A;
        }

        .module-badge {
            background: #F3E8FF;
            color: #7E22CE;
            border-radius: 999px;
            padding: 7px 12px;
            font-size: 13px;
            font-weight: 700;
            display: inline-block;
        }

        .question-box {
            border: 1px solid #E2E8F0;
            border-radius: 18px;
            padding: 18px;
            margin-bottom: 14px;
            background: #FFFFFF;
        }

        .answer-list {
            margin-bottom: 0;
            padding-left: 18px;
        }

        .answer-list li {
            margin-bottom: 6px;
            color: #334155;
        }

        .correct-badge {
            background: #DCFCE7;
            color: #16A34A;
            border-radius: 999px;
            padding: 5px 9px;
            font-size: 12px;
            font-weight: 700;
            margin-left: 6px;
        }

        .empty-box {
            padding: 34px 18px;
            text-align: center;
            color: #64748B;
        }

        @if($theme === 'dark')
            body,
            .admin-main {
                background: #0F172A !important;
                color: #F8FAFC !important;
            }

            .content-card,
            .question-box {
                background: #1E293B !important;
                color: #F8FAFC !important;
                box-shadow: none !important;
                border-color: #334155 !important;
            }

            .form-label {
                color: #F8FAFC !important;
            }

            .form-control,
            .form-select,
            textarea {
                background: #0F172A !important;
                color: #F8FAFC !important;
                border-color: #334155 !important;
            }

            .form-control::placeholder,
            textarea::placeholder {
                color: #94A3B8 !important;
            }

            .text-muted,
            .empty-box,
            .answer-list li {
                color: #CBD5E1 !important;
            }

            .btn-back {
                background: #334155 !important;
                color: #F8FAFC !important;
            }

            .btn-back:hover {
                background: #475569 !important;
                color: #ffffff !important;
            }

            .page-header {
                box-shadow: none !important;
            }
        @endif

        @media (max-width: 767px) {
            .page-header {
                padding: 22px;
                border-radius: 18px;
            }

            .page-title {
                font-size: 23px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .action-buttons .btn,
            .action-buttons a {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row">

        @include('admin.partials.sidebar')

        <main class="col-md-10 p-4 admin-main">

            <div class="admin-page-header">
                <div>
                    <h1>{{ $t['quiz_title'] ?? 'éducation familiale' }}</h1>
                    <p>{{ $t['quiz_subtitle'] ?? 'Gestion des questions et réponses du quiz.' }}</p>
                </div>

            @include('admin.partials.header-actions', [
                'backUrl' => route('admin.quizzes.index')
                ])
            </div>

            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="row g-4">

                <div class="col-12 col-xl-5">
                    <div class="card content-card mb-4">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-2">
                                {{ $t['quiz_info'] }}
                            </h4>

                            <p class="text-muted mb-3">
                                {{ $quiz->description ?? $t['no_description'] }}
                            </p>

                            <span class="module-badge">
                                {{ $t['module'] }} : {{ $quiz->moduleEducatif->title ?? $t['no_module'] }}
                            </span>
                        </div>
                    </div>

                    <div class="card content-card">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-3">
                                {{ $t['add_question'] }}
                            </h4>

                            @if($errors->any())
                                <div class="alert alert-danger border-0 rounded-4">
                                    <ul class="mb-0 ps-3">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('admin.quizzes.questions.store', $quiz->id) }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ $t['question'] }}
                                    </label>

                                    <textarea
                                        name="question_text"
                                        class="form-control"
                                        rows="3"
                                        required
                                    >{{ old('question_text') }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ $t['points'] }}
                                    </label>

                                    <input
                                        type="number"
                                        name="points"
                                        class="form-control"
                                        value="{{ old('points', 1) }}"
                                        min="1"
                                        required
                                    >
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ $t['answer_1'] }}
                                    </label>

                                    <input type="text" name="answer_1" class="form-control" value="{{ old('answer_1') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ $t['answer_2'] }}
                                    </label>

                                    <input type="text" name="answer_2" class="form-control" value="{{ old('answer_2') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ $t['answer_3'] }}
                                    </label>

                                    <input type="text" name="answer_3" class="form-control" value="{{ old('answer_3') }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ $t['answer_4'] }}
                                    </label>

                                    <input type="text" name="answer_4" class="form-control" value="{{ old('answer_4') }}">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">
                                        {{ $t['correct_answer'] }}
                                    </label>

                                    <select name="correct_answer" class="form-select" required>
                                        <option value="1" {{ old('correct_answer') == 1 ? 'selected' : '' }}>
                                            {{ $t['answer_1'] }}
                                        </option>

                                        <option value="2" {{ old('correct_answer') == 2 ? 'selected' : '' }}>
                                            {{ $t['answer_2'] }}
                                        </option>

                                        <option value="3" {{ old('correct_answer') == 3 ? 'selected' : '' }}>
                                            {{ $t['answer_3'] }}
                                        </option>

                                        <option value="4" {{ old('correct_answer') == 4 ? 'selected' : '' }}>
                                            {{ $t['answer_4'] }}
                                        </option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary btn-save w-100">
                                    {{ $t['save_question'] }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-7">
                    <div class="card content-card">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-3">
                                {{ $t['quiz_questions'] }}
                            </h4>

                            @forelse($quiz->questions as $question)
                                <div class="question-box">
                                    <h6 class="fw-bold mb-2">
                                        {{ $question->question_text }}
                                    </h6>

                                    <p class="text-muted small mb-2">
                                        {{ $t['points'] }} : {{ $question->points }}
                                    </p>

                                    <ul class="answer-list">
                                        @foreach($question->answers as $answer)
                                            <li>
                                                {{ $answer->answer_text }}

                                                @if($answer->is_correct)
                                                    <span class="correct-badge">
                                                        {{ $t['good_answer'] }}
                                                    </span>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @empty
                                <div class="empty-box">
                                    <div class="fs-1 mb-2">📝</div>

                                    <h5 class="fw-bold">
                                        {{ $t['empty_title'] }}
                                    </h5>

                                    <p class="mb-0">
                                        {{ $t['empty_text'] }}
                                    </p>
                                </div>
                            @endforelse

                        </div>
                    </div>
                </div>

            </div>

        </main>

    </div>
</div>

</body>
</html>
