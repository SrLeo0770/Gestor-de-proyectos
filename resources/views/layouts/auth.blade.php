@extends('layouts.base')

@section('body')
    <div class="container">
        <div class="row justify-content-center min-vh-100 align-items-center">
            <div class="col-md-6">
                <div class="text-center mb-4">
                    <h1 class="text-primary fw-bold">Gestor de Proyectos</h1>
                    <p class="text-dark">Sistema de Gestión de Proyectos Profesional</p>
                </div>
                
                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">@yield('auth-title')</h2>
                        
                        @if(session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @yield('auth-content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 