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
                <span class="score-number">{{ $result->score }}</span>
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
                <button onclick="window.location.href='{{ route('courses.index') }}'"
                    class="result-btn secondary">Kembali ke Kelas</button>
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
}

/* Debug styles - remove after testing */
.result-btn:active {
    transform: translateY(0);
    background-color: #28a745 !important;
}
</style>
@endsection

@section('scripts')
<script>
// Test route dan debug
document.addEventListener('DOMContentLoaded', function() {
    console.log('Page loaded');

    // Test dengan URL langsung terlebih dahulu
    const testUrls = [
        '/profile',
        '{{ url("/profile") }}',
        '{{ route("profile.show") }}'
    ];

    console.log('Testing URLs:', testUrls);

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
});
</script>
@endsection
