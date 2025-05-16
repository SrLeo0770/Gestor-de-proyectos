@extends('layouts.base')

@section('body')
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('projects.index') }}">Gestor de Proyectos</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
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
                        <a class="nav-link dropdown-toggle" href="#" id="reportsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-chart-bar"></i> Reportes
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="reportsDropdown">
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
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="me-2">
                                <i class="fas fa-user-circle fa-lg"></i>
                            </div>
                            <div>
                                <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                            <li class="px-3 py-1 text-muted border-bottom">
                                <small>Sesión iniciada como</small><br>
                                <span class="fw-bold">{{ Auth::user()->name }}</span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-flex">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger d-flex align-items-center">
                                        <i class="fas fa-sign-out-alt fa-fw me-2"></i>
                                        Cerrar Sesión
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
@endsection 