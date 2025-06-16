@extends('layouts.app')

@section('title', 'David Music Course - Courses')

@section('content')
<!-- Hero Section -->
<section class="course-hero">
    <img src="{{ asset('images/bg2.jpg') }}" alt="">
    <div class="hero-content">
        <h1>Courses</h1>
        <p>Silahkan pilih kelas anda</p>
    </div>
</section>

<!-- Course Categories -->
<section class="course-categories">
    <div class="container">
        <div class="category-header">
            <h2>Kelas Musik Tersedia</h2>
            <p>Pilih kelas yang sesuai dengan minat Anda</p>
        </div>

        <div class="courses-grid-detailed">
            @foreach($courses as $course)
            <div class="course-card">
                <div class="course-icon-large">
                    @if($course->icon)
                    <img src="{{ asset('storage/' . $course->icon) }}" alt="{{ $course->name }}">
                    @else
                    <img src="{{ asset('images/' . strtolower($course->name) . '.png') }}" alt="{{ $course->name }}">
                    @endif
                </div>
                <div class="course-info">
                    <h3>{{ $course->name }}</h3>
                    <p>{{ $course->description }}</p>
                    <a href="{{ route('courses.show', $course) }}" class="course-link">Lihat Detail</a>
                </div>
            </div>
            @endforeach
        </div>

        @if($courses->isEmpty())
        <div class="no-courses">
            <p>Belum ada kelas yang tersedia saat ini.</p>
            <p>Silahkan kembali lagi nanti.</p>
        </div>
        @endif
    </div>
</section>
@endsection
