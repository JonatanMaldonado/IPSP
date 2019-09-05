@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header text-center">
            <h5>{{ $votacion->titulo }}</h5>
        </div>
        <div class="card-body">
            <p class="card-text">{{ $votacion->descripcion }}</p>

            @foreach ($votacion->encuesta_opciones as $key => $encuesta_opcion)
                <div class="list-group">
                    <a class="list-group-item {{ $color[$key] }} text-center">
                      {{ $encuesta_opcion->opcion->opcion }}
                    </a>
                    
                    @foreach ($encuesta_opcion->opcion->votos as $voto)
                        <a class="list-group-item">{{ $voto->usuario->name }}</a>
                    @endforeach

                </div><br>
            @endforeach
            <hr>
            <div class="list-group">
                <a class="list-group-item text-center" style="background-color: cadetblue;">
                    No votaron
                </a>
                @forelse ($no_votaron as $item)
                    @if ($item->usuario->user_type == 'Member')
                        <a class="list-group-item">{{ $item->usuario->name }}</a>
                    @endif
                @empty
                    <a class="list-group-item text-muted">Ya todos votaron</a>
                @endforelse
            </div>
        </div>
    </div>
@endsection