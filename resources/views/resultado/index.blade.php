@extends('layouts.app')

@section('content')

    @forelse ($votaciones as $votacion)

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $votacion->titulo }}</h5>
                <p class="card-text">{{ $votacion->descripcion }}</p>
            </div>
            <div class="card-footer text-center">
                
                <a href="{{ route('resultado.show', $votacion->idencuesta) }}" class="btn btn-secondary col-5" disabled>Resultados</a>
                
            </div>
        </div> <br>
    @empty
        <span class="text-muted"><em>No se encontro ninguna votación.</em></span>
    @endforelse

    <div class="row justify-content-center">{{ $votaciones->links() }}</div>
    
@endsection