@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if(Auth::check())
                        @if(Auth::user()->role === 'admin')
                            <p>Bienvenido Administrador, {{ Auth::user()->name }}!</p>
                            <a href="{{ url('/users') }}" class="btn btn-primary mt-3">Ver usuarios</a>

                        @else
                            <p>Bienvenido Usuario, {{ Auth::user()->name }}!</p>
                            <p>Pronto abran opciones para ti mientras solo un admin puede usar este software.</p>

                        @endif
                    @endif
                 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

