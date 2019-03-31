@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header text-center">
            <h5>{{ $encuesta->titulo }}</h5>
            
        </div>
        <div class="card-body">
            <p class="card-text">{{ $encuesta->descripcion }}</p>
            
            <hr><h5>Opciones</h5>

            <div class="accordion mb-3" id="accordionOpcion">
                @forelse ($encuesta_opciones as $opcion)
                    <button class="btn btn-primary btn-block" style="margin-bottom: 10px;">{{ $opcion->opcion->opcion }}</button>
                @empty
                    <span class="text-muted"><em>No hay opciones en esta encuesta.</em></span>
                @endforelse
            </div>
        </div>
        <div class="card-footer text-center">
            <a href="{{ route('encuesta.showEdit', $encuesta->idencuesta) }}" class="btn btn-outline-info">Editar Encuesta</a>
        </div>
    </div>
@endsection