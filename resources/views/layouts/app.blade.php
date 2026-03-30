<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion des Dépenses – @yield('title', 'BDA')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { background-color: #f4f6f9; }
        .navbar-brand { font-weight: 700; letter-spacing: 1px; }
        .sidebar { min-height: calc(100vh - 56px); background: #1e2d40; }
        .sidebar .nav-link { color: #adb5bd; padding: .6rem 1.2rem; border-radius: .4rem; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: #2d4a6a; color: #fff; }
        .sidebar .nav-link i { margin-right: 8px; }
        .card { border: none; box-shadow: 0 2px 8px rgba(0,0,0,.08); }
        .card-header { font-weight: 600; }
        .table thead th { background: #1e2d40; color: #fff; border: none; }
        .badge-ajout { background-color: #198754; }
        .badge-modif { background-color: #fd7e14; }
        .badge-suppr { background-color: #dc3545; }
        .stat-card { border-radius: .6rem; color: #fff; padding: 1.2rem 1.5rem; }
        .user-info { font-size: .85rem; }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-dark px-3 d-flex justify-content-between">
    <a class="navbar-brand" href="{{ route('depenses.index') }}">
        <i class="bi bi-bank2"></i> Gestion des Dépenses
    </a>
    <div class="d-flex align-items-center gap-2">

        {{-- Session Admin --}}
        @if(Auth::guard('admin')->check())
        <span class="text-secondary small user-info">
            <i class="bi bi-person-circle me-1"></i>
            {{ Auth::guard('admin')->user()->name }}
            <span class="badge bg-danger ms-1">Admin</span>
        </span>
        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <input type="hidden" name="guard" value="admin">
            <button type="submit" class="btn btn-outline-danger btn-sm">
                <i class="bi bi-box-arrow-right"></i> Déconnexion
            </button>
        </form>
        @endif

        {{-- Séparateur si les deux sessions sont actives --}}
        @if(Auth::guard('admin')->check() && Auth::guard('web')->check())
        <div class="vr bg-secondary mx-1" style="height:24px"></div>
        @endif

        {{-- Session Utilisateur --}}
        @if(Auth::guard('web')->check())
        <span class="text-secondary small user-info">
            <i class="bi bi-person-circle me-1"></i>
            {{ Auth::guard('web')->user()->name }}
            <span class="badge bg-primary ms-1">Utilisateur</span>
        </span>
        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <input type="hidden" name="guard" value="web">
            <button type="submit" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-box-arrow-right"></i> Déconnexion
            </button>
        </form>
        @endif

    </div>
</nav>

<div class="d-flex" style="min-height:calc(100vh - 56px)">
    <!-- Sidebar -->
    <nav class="sidebar col-auto p-3" style="width:220px">
        <ul class="nav flex-column gap-1">

            {{-- Établissements : admin uniquement --}}
            @if(Auth::guard('admin')->check())
            <li class="nav-item">
                <a href="{{ route('etablissements.index') }}"
                   class="nav-link {{ request()->routeIs('etablissements.*') ? 'active' : '' }}">
                    <i class="bi bi-building"></i> Établissements
                </a>
            </li>
            @endif

            <li class="nav-item">
                <a href="{{ route('depenses.index') }}"
                   class="nav-link {{ request()->routeIs('depenses.*') ? 'active' : '' }}">
                    <i class="bi bi-cash-coin"></i> Dépenses
                </a>
            </li>

            {{-- Audit : admin uniquement --}}
            @if(Auth::guard('admin')->check())
            <li class="nav-item">
                <a href="{{ route('audit.index') }}"
                   class="nav-link {{ request()->routeIs('audit.*') ? 'active' : '' }}">
                    <i class="bi bi-clipboard-data"></i> Audit
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('users.index') }}"
                   class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i> Comptes
                </a>
            </li>
            @endif

        </ul>
    </nav>

    <!-- Contenu -->
    <main class="flex-grow-1 p-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>
</div>

</body>
</html>
