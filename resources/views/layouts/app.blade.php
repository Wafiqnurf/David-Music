<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'David Music Course')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- ICON -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-info">
                    <h3>David Music Course</h3>
                    <p>Menghidupkan Musik, Menginspirasi Jiwa</p>
                    <p>Pusat pendidikan musik terpercaya di Grand Vista Cikarang</p>
                    <div class="contact-links">
                        <a href="https://wa.me/6281392626543" class="wa-link" target="_blank">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="https://wa.me/6281210086130" class="wa-link" target="_blank">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <div class="address">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Grand Vista Cikarang</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 David Music Course. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
    @yield('scripts')
</body>

</html>
