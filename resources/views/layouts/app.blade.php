<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestor de Proyectos')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('projects.index') }}">Gestor de Proyectos</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('projects.index') }}">
                            <i class="fas fa-home"></i> Inicio
                        </a>
                    </li>
                    @if(Auth::user()->isProjectLeader())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('projects.create') }}">
                            <i class="fas fa-plus"></i> Nuevo Proyecto
                        </a>
                    </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="reportsDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-chart-bar"></i> Reportes
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('reports.created') }}">
                                    <i class="fas fa-calendar-plus"></i> Proyectos Creados
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('reports.inProgress') }}">
                                    <i class="fas fa-tasks"></i> En Ejecución
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('reports.completed') }}">
                                    <i class="fas fa-check-circle"></i> Finalizados
                                </a>
                            </li>
                            @if(Auth::user()->isProjectLeader() || Auth::user()->isClient())
                            <li>
                                <a class="dropdown-item" href="{{ route('reports.byLeader') }}">
                                    <i class="fas fa-user-tie"></i> Por Líder
                                </a>
                            </li>
                            @endif
                            @if(Auth::user()->isProjectLeader())
                            <li>
                                <a class="dropdown-item" href="{{ route('reports.byClient') }}">
                                    <i class="fas fa-user"></i> Por Cliente
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @if(Auth::user()->isAdmin())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}">
                            <i class="fas fa-users"></i> Gestión de Usuarios
                        </a>
                    </li>
                    @endif
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html> 