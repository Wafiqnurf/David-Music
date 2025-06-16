<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - David Music Course</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}" />
</head>

<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h2>Masuk Akun</h2>
                <p>Selamat datang kembali di David Music Course</p>
            </div>

            <form class="auth-form" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required />
                    @error('email')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required />
                    @error('password')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-options">
                    <label class="checkbox-container">
                        <input type="checkbox" id="remember" name="remember" />
                        <span class="checkmark"></span>
                        Ingat saya
                    </label>
                    <a href="#" class="forgot-password">Lupa password?</a>
                </div>

                <button type="submit" class="auth-btn">Masuk</button>

                <div class="auth-divider">
                    <span>atau</span>
                </div>

                <div class="auth-switch">
                    <p>Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></p>
                </div>
            </form>
        </div>

        <div class="auth-bg">
            <div class="music-notes">
                <div class="note note-1">♪</div>
                <div class="note note-2">♫</div>
                <div class="note note-3">♪</div>
                <div class="note note-4">♫</div>
                <div class="note note-5">♪</div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <script>
    showNotification("{{ session('success') }}", "success");
    </script>
    @endif

    @if(session('error'))
    <script>
    showNotification("{{ session('error') }}", "error");
    </script>
    @endif

    <script>
    function showNotification(message, type) {
        const notification = document.createElement("div");
        notification.className = `notification notification-${type}`;
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.opacity = "1";
            notification.style.transform = "translateX(0)";
        }, 100);

        setTimeout(() => {
            notification.style.opacity = "0";
            notification.style.transform = "translateX(100px)";
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }
    </script>
</body>

</html>
