<div class="project-video real-video-box">

    <video
        class="project-real-video"
        autoplay
        muted
        loop
        playsinline
        preload="metadata"
        poster="{{ asset('images/auth-family-bg.png') }}"
    >
        <source src="{{ asset('videos/project-presentation.mp4') }}" type="video/mp4">
    </video>

    <div class="real-video-overlay">
        <div class="real-video-top">
            <div>
                <div class="video-title">
                    {{ $t['video_label'] ?? 'Présentation du projet' }}
                </div>

                <div class="video-mini-text">
                    Éducation familiale • Madagascar
                </div>
            </div>

            <div class="video-play">
                ▶
            </div>
        </div>

        <div class="real-video-bottom">
            <span>📘 {{ $t['video_module'] ?? 'Modules' }}</span>
            <span>📝 {{ $t['video_quiz'] ?? 'Quiz' }}</span>
            <span>📈 {{ $t['video_follow'] ?? 'Suivi' }}</span>
        </div>
    </div>

</div>
