@extends('layouts.app')

@section('title', 'David Music Course - Kelas ' . $course->name)

@section('content')
<!-- Hero Section -->
<section class="course-hero">
    <div class="hero-content">
        <h1>Courses</h1>
        <p>Detail kelas yang Anda pilih</p>
    </div>
</section>

<!-- Course Detail -->
<section class="class-detail">
    <div class="container">
        <div class="class-content">
            <div class="class-icon-section">
                <div class="class-icon-large">
                    @if($course->image)
                    <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->name }}">
                    @else
                    <img src="{{ asset('images/detail ' . strtolower($course->name) . '.png') }}"
                        alt="{{ $course->name }}">
                    @endif
                </div>
            </div>

            <div class="class-info-section">
                <h2>Kelas {{ $course->name }}</h2>
                <p class="class-description">
                    {{ $course->description }}
                </p>

                @auth
                @if($isEnrolled)
                <div class="enrolled-status">
                    @if($course->tests->count() > 0)
                    <div class="available-tests">
                        <h3>Test Tersedia:</h3>
                        @foreach($course->tests as $test)
                        <div class="test-item">
                            <h4>{{ $test->title }}</h4>
                            <p>{{ $test->description }}</p>
                            <a href="{{ route('tests.show', $test) }}" class="register-btn">Ikut Test</a>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p>Belum ada test yang tersedia untuk kelas ini.</p>
                    @endif
                </div>
                @else
                <form action="{{ route('courses.enroll', $course) }}" method="POST">
                    @csrf
                    <button type="submit" class="register-btn">
                        Daftar Kelas
                    </button>
                </form>
                @endif
                @else
                <a href="{{ route('login') }}" class="register-btn">
                    Login untuk Mendaftar
                </a>
                @endauth
            </div>
        </div>
    </div>
</section>
@endsection
