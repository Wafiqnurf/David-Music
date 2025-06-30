@extends('layouts.app')

@section('title', 'David Music Course - Hasil Test')

@section('content')
<!-- Score Section -->
<section class="score-section">
    <div class="container">
        <div class="score-card">
            <h2>Hasil Test Anda</h2>

            <div class="test-info">
                <h3>{{ $result->test->title }}</h3>
                <p><strong>Kelas:</strong> {{ $result->test->course->name }}</p>
                <p><strong>Tanggal:</strong> {{ $result->completed_at->format('d M Y H:i') }}</p>
            </div>

            <div class="score-display">
                @php
                $scoreColor = '';
                if($result->score < 40) {
                    $scoreColor='background: linear-gradient(135deg, #ff6b6b, #ff8e8e); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;'
                    ; } elseif($result->score >= 40 && $result->score <= 70) {
                        $scoreColor='background: linear-gradient(135deg, #4ecdc4, #45b7aa); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;'
                        ; } else {
                        $scoreColor='background: linear-gradient(135deg, #45b7d1, #96c93d); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;'
                        ; } @endphp <span class="score-number" style="{{ $scoreColor }}">{{ $result->score }}</span>
            </div>

            {{-- Level Classification --}}
            <div class="level-classification">
                @if($result->score < 40) <div class="level-badge beginner">
                    <i class="level-icon">🎵</i>
                    <span class="level-text">BEGINNER</span>
            </div>
            <p class="level-description">Anda baru memulai perjalanan musik Anda. Terus berlatih!</p>
            @elseif($result->score >= 40 && $result->score <= 70) <div class="level-badge intermediate">
                <i class="level-icon">🎼</i>
                <span class="level-text">INTERMEDIATE</span>
        </div>
        <p class="level-description">Kemampuan musik Anda berkembang dengan baik. Lanjutkan!</p>
        @else
        <div class="level-badge advanced">
            <i class="level-icon">🎹</i>
            <span class="level-text">ADVANCED</span>
        </div>
        <p class="level-description">Excellent! Anda memiliki pemahaman musik yang sangat baik!</p>
        @endif
    </div>

    <div class="score-details">
        <p><strong>Jawaban Benar:</strong> {{ $result->correct_answers }} dari {{ $result->total_questions }}
        </p>
        <p><strong>Persentase:</strong> {{ $result->score }}%</p>

        @if($result->admin_review)
        <div class="admin-review">
            <h4>Review dari Pengajar:</h4>
            <div class="review-content">
                {{ $result->admin_review }}
            </div>
        </div>
        @else
        <div class="review-pending">
            <p><em>Review dari pengajar akan muncul di sini setelah video Anda ditinjau.</em></p>
        </div>
        @endif
    </div>

    <div class="action-buttons">
        <button onclick="window.location.href='{{ route('profile.show') }}'" class="result-btn primary">Lihat
            Profil</button>
        <button onclick="window.location.href='{{ route('courses.index') }}'" class="result-btn secondary">Kembali ke
            Kelas</button>
    </div>
    </div>
    </div>
</section>
@endsection

@section('styles')
<style>
.test-info {
    margin-bottom: 20px;
    text-align: center;
}

.test-info h3 {
    color: #333;
    margin-bottom: 10px;
}

.score-details {
    margin-top: 20px;
    text-align: left;
}

/* Level Classification Styles */
.level-classification {
    margin: 25px 0;
    text-align: center;
}

.level-badge {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 15px 25px;
    border-radius: 25px;
    font-weight: 700;
    font-size: 18px;
    margin-bottom: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.level-badge:hover {
    transform: translateY(-2px);
}

.level-badge.beginner {
    background: linear-gradient(135deg, #ff6b6b, #ff8e8e);
    color: white;
}

.level-badge.intermediate {
    background: linear-gradient(135deg, #4ecdc4, #45b7aa);
    color: white;
}

.level-badge.advanced {
    background: linear-gradient(135deg, #45b7d1, #96c93d);
    color: white;
}

.level-icon {
    font-size: 24px;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
}

.level-description {
    color: #666;
    font-style: italic;
    margin-top: 8px;
    font-size: 14px;
}

.pass-status {
    padding: 15px;
    border-radius: 8px;
    margin: 15px 0;
    font-weight: bold;
    text-align: center;
}

.pass-status.success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.pass-status.failed {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.admin-review {
    background-color: #f8f9fa;
    border-left: 4px solid #007bff;
    padding: 15px;
    margin: 15px 0;
    border-radius: 4px;
}

.review-content {
    font-style: italic;
    margin-top: 10px;
}

.review-pending {
    background-color: #fff3cd;
    border: 1px solid #ffeaa7;
    padding: 10px;
    border-radius: 4px;
    margin: 15px 0;
    text-align: center;
}

.action-buttons {
    margin-top: 30px;
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
    position: relative;
    z-index: 999;
}

.result-btn {
    display: inline-block;
    padding: 12px 24px;
    text-decoration: none !important;
    border-radius: 8px;
    font-weight: 600;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer !important;
    border: none;
    min-width: 150px;
    pointer-events: auto !important;
    position: relative;
    z-index: 1000;
}

.result-btn.primary {
    background-color: #007bff;
    color: white;
}

.result-btn.primary:hover {
    background-color: #0056b3;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
}

.result-btn.secondary {
    background-color: #6c757d;
    color: white;
}

.result-btn.secondary:hover {
    background-color: #5a6268;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(108, 117, 125, 0.3);
}

.result-btn.retry {
    background-color: #fd7e14;
    color: white;
}

.result-btn.retry:hover {
    background-color: #e8681d;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(253, 126, 20, 0.3);
}

.score-number {
    font-size: 4rem;
    font-weight: 700;
    color: #333;
}

/* Responsive */
@media (max-width: 768px) {
    .score-card {
        padding: 20px;
    }

    .action-buttons {
        flex-direction: column;
        align-items: center;
    }

    .result-btn {
        width: 100%;
        max-width: 250px;
    }

    .level-badge {
        font-size: 16px;
        padding: 12px 20px;
    }

    .score-number {
        font-size: 3rem;
    }
}
</style>
@endsection

@section('scripts')
<script>
// Test route dan debug
document.addEventListener('DOMContentLoaded', function() {
    console.log('Page loaded');

    // Tambahkan event listener untuk button
    const buttons = document.querySelectorAll('.result-btn');
    buttons.forEach((btn, index) => {
        console.log(`Button ${index} found:`, btn);

        btn.addEventListener('click', function(e) {
            console.log('Button clicked!', this);
            console.log('onclick attribute:', this.getAttribute('onclick'));
        });

        // Force styling
        btn.style.cursor = 'pointer';
        btn.style.pointerEvents = 'auto';
        btn.style.zIndex = '1001';
        btn.style.position = 'relative';
    });

    // Test navigasi manual
    window.testNavigation = function() {
        try {
            window.location.href = '/profile';
        } catch (e) {
            console.error('Navigation error:', e);
            alert('Error navigating to profile: ' + e.message);
        }
    };

    console.log('Run testNavigation() in console to test manual navigation');

    // Level classification animation
    const levelBadge = document.querySelector('.level-badge');
    if (levelBadge) {
        setTimeout(() => {
            levelBadge.style.transform = 'scale(1.05)';
            setTimeout(() => {
                levelBadge.style.transform = 'scale(1)';
            }, 200);
        }, 500);
    }
});
</script>
@endsection
