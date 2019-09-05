@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header text-center">
            <h5>{{ $encuesta->titulo }}</h5>
            
        </div>
        <div class="card-body">
            <p class="card-text">{{ $encuesta->descripcion }}</p>
            
            @if ($validacion && Auth::user()->user_type == 'Member')
                <hr>

                @if ($validacion->voto == 'No')
                <h5>Opciones</h5>
                    <div class="mb-3">
                        @forelse ($encuesta_opciones as $key => $opcion)
                            <button class="btn {{ $color[$key] }} btn-block votar" style="margin-bottom: 10px;" x-idopcion="{{ $opcion->opcion->idopcion }}">{{ $opcion->opcion->opcion }}</button>    
                        @empty
                            <span class="text-muted"><em>No hay opciones en esta votación.</em></span>
                        @endforelse
                        <a class="btn btn-outline-dark btn-block resultados" data-toggle="modal" data-target="#exampleModal">Resultados</a>
                    </div>  
                @else
                <h5>Opciones<span class="text-muted"><em>(Ya votaste)</em></span></h5>
                    <div class="mb-3">
                        @forelse ($encuesta_opciones as $key => $opcion)
                            <button class="btn {{ $color[$key] }} btn-block disabled" style="margin-bottom: 10px;">{{ $opcion->opcion->opcion }}</button>
                        @empty
                            <span class="text-muted"><em>No hay opciones en esta votación.</em></span>
                        @endforelse
                        <a class="btn btn-outline-dark btn-block resultados" data-toggle="modal" data-target="#exampleModal">Resultados</a>
                    </div>
                @endif
            @else
                <hr>
                <h5>Opciones</h5>

                <div class="mb-3">
                    <span class="text-muted"><em>No puedes votar.</em></span>
                    @forelse ($encuesta_opciones as $key => $opcion)
                        <button class="btn {{ $color[$key] }} btn-block disabled" style="margin-bottom: 10px;">{{ $opcion->opcion->opcion }}</button>
                    @empty
                        <span class="text-muted"><em>No hay opciones en esta votación.</em></span>
                    @endforelse
                    <a class="btn btn-outline-dark btn-block resultados" data-toggle="modal" data-target="#exampleModal">Resultados</a>
                </div>
            @endif
            
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Resultados</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="resultados">
                            @forelse ($encuesta_opciones as $key => $item)
                                @php
                                    $valor = $item->opcion->num_votos / $total * 100;
                                    $valor = round($valor);
                                @endphp

                                {{ $item->opcion->opcion }} <span class="text-muted">({{ $item->opcion->num_votos }})</span>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated {{ $color[$key] }} text-dark font-weight-bold" role="progressbar" style="width: {{ $valor }}%">{{ $valor }}%</div>
                                </div><hr>
                            @empty
                                <span class="text-muted"><em>No hay opciones en esta votación.</em></span>
                            @endforelse
                                
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('resultado.show', $encuesta->idencuesta) }}" class="btn btn-primary">Datos</a>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        @if (auth()->user()->user_type == 'Admin')
            <div class="card-footer text-center">
                <a href="{{ route('encuesta.showEdit', $encuesta->idencuesta) }}" class="btn btn-success">Editar Votación</a>
            </div>             
        @endif
        
    </div>

    <script>
        $(function(){

            $('.votar').on('click', function(){
                var opcion = $(this).text();
                var idopcion = $(this).attr('x-idopcion');
                var idencuesta = '{{ $encuesta->idencuesta }}';
                var confirmacion = confirm(`¿Seguro que quiere votar por: ${opcion}?`);

                if (confirmacion == true) {
                    $.ajax({
                        data: { _token: "{{ csrf_token() }}", idopcion: idopcion, idencuesta: idencuesta },
                        url:  "{{ route('encuesta.fn.voto_user') }}",
                        type: 'PUT',
                        dataType: "json",
                        success:  function (response) { 
                            if(response.response){
                                $('.votar').attr("disabled", true);
                            }else{
                            //Materialize.toast(response.message, 4000)
                            }
                        
                        },
                        error: function(xhr, testStatus, errorThrown){
                            console.log(xhr, testStatus, errorThrown);
                            //Materialize.toast("Error al realizar la petición, favor comunicarse con su administrador", 4000)
                        }
                    });
                }
                
            });

            $('.resultados').on('click', function(){
                $('#resultados').load(' #resultados');
            });
        });
    </script>
@endsection