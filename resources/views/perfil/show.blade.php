@extends('layouts.app')

@section('content')
    <style>
        .btn-circle.btn-lg {
            width: 56px;
            height: 56px;
            padding: 10px 16px;
            font-size: 18px;
            line-height: 1.33;
            border-radius: 28px;
        }
    </style>
    <ul class="list-unstyled">
        
        <li>
            <div class="row">
                <div class="col-2 d-flex justify-content-end align-items-center">
                    <i class="fas fa-user"></i> 
                </div>
                <div class="col-10">
                    <div class="card-body">
                        <h6 class="card-title">{{ Auth::user()->name }}</h6>
                        <p class="card-text">Nombre</p>
                    </div>
                </div>
            </div>
        </li>
        <div class="row">
            <div class="col-2 d-flex justify-content-end align-items-center">
                <i class="fas fa-at"></i> 
            </div>
            <div class="col-10">
                <div class="card-body">
                    <h6 class="card-title">{{ Auth::user()->email }}</h6>
                    <p class="card-text">Correo</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-2 d-flex justify-content-end align-items-center">
                <i class="fas fa-key"></i> 
            </div>
            <div class="col-10">
                <div class="card-body">
                    <h6 class="card-title">●●●●●●</h6>
                    <p class="card-text">Contraseña</p>
                </div>
            </div>
        </div>
    </ul>
    <a class="float-right btn-lg btn-circle btn-primary d-flex justify-content-center align-items-center text-white" href="{{ route('perfil.edit') }}"><i class="fas fa-pen"></i></a>
@endsection