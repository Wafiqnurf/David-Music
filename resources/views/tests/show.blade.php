@extends('layouts.app')

@section('title', 'David Music Course - ' . $test->title)

@section('content')
<!-- Quiz Section -->
<section class="quiz-section">
    <div class="container">
        <div class="quiz-container">
            <h1 class="quiz-title">{{ $test->title }}</h1>

            <div class="test-info">
                <p><strong>Kelas:</strong> {{ $test->course->name }}</p>
                @if($test->description)
                <p><strong>Deskripsi:</strong> {{ $test->description }}</p>
                @endif
            </div>



            <form id="testForm" action="{{ route('tests.submit', $test) }}" method="POST">
                @csrf

                @foreach($questions as $index => $question)
                <!-- Question {{ $index + 1 }} -->
                <div class="question">
                    <div class="question-number">
                        {{ $index + 1 }}. {{ $question->question }}
                    </div>
                    <div class="options">
                        @foreach($question->options as $optionKey => $optionValue)
                        <div class="option">
                            <input type="radio" name="q{{ $question->id }}" value="{{ $optionKey }}"
                                id="q{{ $question->id }}_{{ $optionKey }}" required>
                            <label for="q{{ $question->id }}_{{ $optionKey }}">{{ $optionValue }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach

                <!-- Video Upload -->
                <div class="video-upload">
                    <div class="question-number">
                        {{ $questions->count() + 1 }}. Unggah video kamu memainkan lagu pendek sebagai ujian skill
                    </div>
                    <input type="text" class="video-input" name="video_link" placeholder="Upload file/link video"
                        required />
                    <small>*Masukkan link video (YouTube, Google Drive, dll) atau link file video Anda</small>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-btn">Submit Test</button>
            </form>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
// Add some interactivity to options
document.querySelectorAll('.option').forEach(option => {
    option.addEventListener('click', function() {
        const radio = this.querySelector('input[type="radio"]');
        if (radio) {
            radio.checked = true;
        }
    });
});

// Confirm before submit
document.getElementById('testForm').addEventListener('submit', function(e) {
    if (!confirm('Apakah Anda yakin ingin mengirim jawaban? Anda tidak dapat mengubahnya setelah di-submit.')) {
        e.preventDefault();
    }
});
</script>
@endsection
