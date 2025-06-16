@extends('layouts.app')

@section('title', 'David Music Course - Home')

@section('content')
<!-- Hero Section -->
<section class="hero">
    <img src="{{ asset('images/bg1.jpg') }}" alt="">
    <div class="hero-content">
        <h1>Menghidupkan Musik, Menginspirasi Jiwa</h1>
        <p>
            Menginspirasi dan mendapatkan bakat musik dengan dasar pengajaran yang
            penuh kasih
        </p>
        @auth
        <a href="{{ route('courses.index') }}" class="cta-btn">Lihat Kelas</a>
        @else
        <a href="{{ route('register') }}" class="cta-btn">Daftar</a>
        @endauth
    </div>
    <div class="hero-bg"></div>
</section>

<!-- Courses Section -->
<section class="courses-section">
    <div class="container">
        <h2>COURSES</h2>
        <div class="courses-grid">
            @if($courses && $courses->count() > 0)
            @foreach($courses as $course)
            <div class="course-item">
                <div class="course-icon">
                    @if(isset($course->icon) && $course->icon)
                    <img src="{{ asset('storage/' . $course->icon) }}" alt="{{ $course->name }}">
                    @else
                    <!-- Fallback image jika icon tidak ada -->
                    <img src="{{ asset('images/default-course.png') }}" alt="{{ $course->name }}"
                        onerror="this.src='{{ asset('images/music-note.svg') }}'; this.onerror=null;">
                    @endif
                </div>
                <h3>{{ strtoupper($course->name) }}</h3>
                @auth
                @else
                @endauth
            </div>
            @endforeach
            @else
            <div class="no-courses">
                <p>Belum ada kelas yang tersedia saat ini.</p>
                @if(auth()->check() && auth()->user()->isAdmin())
                <a href="{{ route('admin.courses.create') }}" class="admin-link">Tambah Kelas Baru</a>
                @endif
            </div>
            @endif
        </div>
    </div>
</section>
@endsection
