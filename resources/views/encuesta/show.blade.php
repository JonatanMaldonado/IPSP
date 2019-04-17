@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header text-center">
            <h5>{{ $encuesta->titulo }}</h5>
            
        </div>
        <div class="card-body">
            <p class="card-text">{{ $encuesta->descripcion }}</p>
            
            @if ($validacion)

                <hr>
                @if ($validacion->voto == 'Si')
                    <h5>Opciones<span class="text-muted"><em>(Ya votaste)</em></span></h5>
                @else
                    <h5>Opciones</h5>
                @endif

                @if ($validacion->voto == 'No')
                    <div class="mb-3">
                        @forelse ($encuesta_opciones as $opcion)
                            <button class="btn btn-primary btn-block votar" style="margin-bottom: 10px;" x-idopcion="{{ $opcion->opcion->idopcion }}">{{ $opcion->opcion->opcion }}</button>
                        @empty
                            <span class="text-muted"><em>No hay opciones en esta encuesta.</em></span>
                        @endforelse
                    </div>  
                @else
                    <div class="mb-3">
                        @forelse ($encuesta_opciones as $opcion)
                            <button class="btn btn-primary btn-block disabled" style="margin-bottom: 10px;">{{ $opcion->opcion->opcion }}</button>
                        @empty
                            <span class="text-muted"><em>No hay opciones en esta encuesta.</em></span>
                        @endforelse
                    </div>
                @endif
            @else
                <hr>
                <h5>Opciones</h5>

                <div class="mb-3">
                    <span class="text-muted"><em>Esta encuesta ya termino.</em></span>
                    @forelse ($encuesta_opciones as $opcion)
                        <button class="btn btn-primary btn-block disabled" style="margin-bottom: 10px;">{{ $opcion->opcion->opcion }}</button>
                    @empty
                        <span class="text-muted"><em>No hay opciones en esta encuesta.</em></span>
                    @endforelse
                </div>
            @endif
            
            
        </div>

        @if (auth()->user()->user_type == 'Admin')
            <div class="card-footer text-center">
                <a href="{{ route('encuesta.showEdit', $encuesta->idencuesta) }}" class="btn btn-success">Editar Encuesta</a>
            </div>             
        @endif
        
    </div>

    <script>
        $(function(){

            $('.votar').on('click', function(){
                var idopcion = $(this).attr('x-idopcion');
                var idencuesta = {{ $encuesta->idencuesta }};

                alert('Voto listo ' + idopcion)
            });
        });
    </script>
@endsection