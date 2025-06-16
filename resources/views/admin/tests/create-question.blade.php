@extends('layouts.admin')

@section('title', 'Tambah Soal')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Tambah Soal</h1>
        <p class="text-muted mb-0">{{ $test->title }} - {{ $test->course->name }}</p>
    </div>
    <a href="{{ route('admin.tests.questions', $test) }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Form Tambah Soal</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.tests.questions.store', $test) }}" method="POST" id="questionForm">
            @csrf

            <div class="form-group mb-3">
                <label for="question" class="form-label">Pertanyaan <span class="text-danger">*</span></label>
                <textarea name="question" id="question" rows="3"
                    class="form-control @error('question') is-invalid @enderror" placeholder="Masukkan pertanyaan"
                    required>{{ old('question') }}</textarea>
                @error('question')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label class="form-label">Pilihan Jawaban <span class="text-danger">*</span></label>
                <div id="optionsContainer">
                    @for($i = 0; $i < 4; $i++) <div class="option-input mb-2">
                        <div class="d-flex align-items-center">
                            <span class="me-2" style="min-width: 30px; font-weight: bold;">{{ chr(65 + $i) }}.</span>
                            <input type="text" name="options[]"
                                class="form-control @error('options.'.$i) is-invalid @enderror"
                                placeholder="Masukkan pilihan {{ chr(65 + $i) }}" value="{{ old('options.'.$i) }}"
                                required>
                            @if($i >= 2)
                            <button type="button" class="btn btn-sm btn-danger ms-2 remove-option"
                                onclick="removeOption(this)">
                                <i class="fas fa-times"></i>
                            </button>
                            @endif
                        </div>
                        @error('options.'.$i)
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                </div>
                @endfor
            </div>
            <button type="button" class="btn btn-sm btn-success mt-2" onclick="addOption()">
                <i class="fas fa-plus"></i> Tambah Pilihan
            </button>
    </div>

    <div class="form-group mb-3">
        <label for="correct_answer" class="form-label">Jawaban Benar <span class="text-danger">*</span></label>
        <select name="correct_answer" id="correct_answer"
            class="form-control form-select @error('correct_answer') is-invalid @enderror" required>
            <option value="">Pilih jawaban yang benar</option>
        </select>
        @error('correct_answer')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="explanation" class="form-label">Penjelasan (Opsional)</label>
        <textarea name="explanation" id="explanation" rows="2"
            class="form-control @error('explanation') is-invalid @enderror"
            placeholder="Masukkan penjelasan jawaban (opsional)">{{ old('explanation') }}</textarea>
        @error('explanation')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Simpan Soal
        </button>
        <a href="{{ route('admin.tests.questions', $test) }}" class="btn btn-secondary ms-2">
            <i class="fas fa-times"></i> Batal
        </a>
    </div>
    </form>
</div>
</div>

<script>
let optionCount = 4;

function updateCorrectAnswerOptions() {
    const correctAnswerSelect = document.getElementById('correct_answer');
    const currentValue = correctAnswerSelect.value;
    correctAnswerSelect.innerHTML = '<option value="">Pilih jawaban yang benar</option>';

    const options = document.querySelectorAll('input[name="options[]"]');
    options.forEach((option, index) => {
        if (option.value.trim() !== '') {
            const optionElement = document.createElement('option');
            optionElement.value = index;
            optionElement.textContent = `${String.fromCharCode(65 + index)}. ${option.value}`;
            correctAnswerSelect.appendChild(optionElement);
        }
    });

    // Restore previously selected value if still valid
    if (currentValue !== '' && currentValue < options.length) {
        correctAnswerSelect.value = currentValue;
    }
}

function addOption() {
    if (optionCount >= 6) {
        alert('Maksimal 6 pilihan jawaban');
        return;
    }

    const container = document.getElementById('optionsContainer');
    const optionDiv = document.createElement('div');
    optionDiv.className = 'option-input mb-2';

    optionDiv.innerHTML = `
        <div class="d-flex align-items-center">
            <span class="me-2" style="min-width: 30px; font-weight: bold;">${String.fromCharCode(65 + optionCount)}.</span>
            <input type="text" name="options[]" class="form-control"
                placeholder="Masukkan pilihan ${String.fromCharCode(65 + optionCount)}" required>
            <button type="button" class="btn btn-sm btn-danger ms-2 remove-option" onclick="removeOption(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;

    container.appendChild(optionDiv);
    optionCount++;

    // Add event listener to new input
    const newInput = optionDiv.querySelector('input[name="options[]"]');
    newInput.addEventListener('input', updateCorrectAnswerOptions);

    updateCorrectAnswerOptions();
}

function removeOption(button) {
    if (document.querySelectorAll('.option-input').length <= 2) {
        alert('Minimal 2 pilihan jawaban');
        return;
    }

    const optionDiv = button.closest('.option-input');
    optionDiv.remove();

    // Update option labels
    const options = document.querySelectorAll('.option-input');
    options.forEach((option, index) => {
        const label = option.querySelector('span');
        const input = option.querySelector('input');
        const placeholder = input.getAttribute('placeholder');

        label.textContent = `${String.fromCharCode(65 + index)}.`;
        input.setAttribute('placeholder', `Masukkan pilihan ${String.fromCharCode(65 + index)}`);
    });

    optionCount = options.length;
    updateCorrectAnswerOptions();
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners to existing inputs
    document.querySelectorAll('input[name="options[]"]').forEach(input => {
        input.addEventListener('input', updateCorrectAnswerOptions);
    });

    // Update correct answer options on page load
    updateCorrectAnswerOptions();

    // Form validation
    document.getElementById('questionForm').addEventListener('submit', function(e) {
        const options = document.querySelectorAll('input[name="options[]"]');
        const correctAnswer = document.getElementById('correct_answer').value;

        // Check if all options are filled
        let emptyOptions = 0;
        options.forEach(option => {
            if (option.value.trim() === '') {
                emptyOptions++;
            }
        });

        if (emptyOptions > 0) {
            e.preventDefault();
            alert('Semua pilihan jawaban harus diisi');
            return;
        }

        // Check if correct answer is selected
        if (correctAnswer === '') {
            e.preventDefault();
            alert('Silakan pilih jawaban yang benar');
            return;
        }
    });
});
</script>
@endsection
