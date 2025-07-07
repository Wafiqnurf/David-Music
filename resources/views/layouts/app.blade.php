<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'David Music Course')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('styles')
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="logo">David Music Course</div>
            <nav class="nav">
                <ul>
                    <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                    </li>
                    <li><a href="{{ route('courses.index') }}"
                            class="{{ request()->routeIs('courses.*') ? 'active' : '' }}">Course</a></li>
                    @auth
                    <li><a href="{{ route('profile.show') }}"
                            class="profile-btn {{ request()->routeIs('profile.*') ? 'active' : '' }}">👤</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit"
                                style="background: none; border: none; color: white; cursor: pointer;">Logout</button>
                        </form>
                    </li>
                    @else
                    <li><a href="{{ route('login') }}" class="login-btn">Login</a></li>
                    @endauth
                </ul>
            </nav>
        </div>
    </header>


    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error">
        {{ session('error') }}
    </div>
    @endif

    <!-- Main Content -->
    @yield('content')

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <h2>KONTAK</h2>
            <div class="contact-content">
                <div class="contact-info">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-details">
                            <h3>Hotma</h3>
                            <p>081392626543</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-details">
                            <h3>David</h3>
                            <p>081210086130</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-details">
                            <h3>Alamat</h3>
                            <p>Grand Vista Cikarang</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('js/script.js') }}"></script>
    @yield('scripts')
</body>

</html>
