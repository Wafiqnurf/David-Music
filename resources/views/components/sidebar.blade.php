{{-- resources/views/components/sidebar.blade.php --}}
<aside class="admin-sidebar">
    <div class="sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <i class="fas fa-graduation-cap"></i>
            LMS Admin
        </a>
    </div>

    <nav class="sidebar-nav">
        <ul class="nav-list">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.courses.index') }}"
                    class="nav-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                    <i class="fas fa-book"></i>
                    Kelola Kelas
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.tests.index') }}"
                    class="nav-link {{ request()->routeIs('admin.tests.*') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-check"></i>
                    Kelola Test
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}"
                    class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    Kelola User
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.test-results.index') }}"
                    class="nav-link {{ request()->routeIs('admin.test-results.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i>
                    Hasil Test
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link">
                    <i class="fas fa-home"></i>
                    Kembali ke Site
                </a>
            </li>
        </ul>
    </nav>
</aside>
