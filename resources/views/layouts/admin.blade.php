{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Panel') - {{ config('app.name', 'Learning Management System') }}</title>

    <!-- CSS -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    @stack('styles')
</head>

<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Main Content -->
        <div class="admin-content">
            <!-- Header -->
            <header class="admin-header">
                <div class="header-content">
                    <div class="header-left">
                        <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
                        @yield('breadcrumb')
                    </div>
                    <div class="header-right">
                        <div class="user-info">
                            <span class="welcome-text">Selamat datang, {{ auth()->user()->name }}</span>
                        </div>
                        <div class="logout-section">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm logout-btn">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="admin-main">
                @include('components.alert')
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Additional CSS for header styling -->
    <style>
    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        padding: 1rem 1.5rem;
    }

    .header-left {
        flex: 1;
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-left: auto;
    }

    .user-info {
        display: flex;
        align-items: center;
    }

    .welcome-text {
        color: #6c757d;
        font-size: 0.9rem;
        white-space: nowrap;
    }

    .logout-section {
        display: flex;
        align-items: center;
    }

    .logout-btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 4px;
        background-color: #6c757d;
        color: white;
        font-size: 0.875rem;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .logout-btn:hover {
        background-color: #5a6268;
    }

    .page-title {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 600;
        color: #495057;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .header-content {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem;
        }

        .header-right {
            width: 100%;
            justify-content: space-between;
            margin-left: 0;
        }

        .welcome-text {
            font-size: 0.8rem;
        }

        .logout-btn {
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
        }
    }

    @media (max-width: 480px) {
        .header-right {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .logout-section {
            align-self: flex-end;
        }
    }
    </style>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
    // Delete confirmation
    function confirmDelete(message = 'Apakah Anda yakin ingin menghapus data ini?') {
        return confirm(message);
    }

    // Auto hide alerts
    $(document).ready(function() {
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    });

    // File upload preview
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#' + previewId).attr('src', e.target.result).show();
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>

    @stack('scripts')
</body>

</html>
