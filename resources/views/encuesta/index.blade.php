@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header text-center"><h5>IPSP - Votaciones</h5></div>
    <div class="card-body">
        @if (auth()->user()->user_type == 'Admin')
            {{-- Boton para activar el modal de encuestas --}}
            <button type="button" class="btn btn-outline-primary btn-block" data-toggle="modal" data-target="#crearEncuestaModal">Crear Votación</button>
            <br>
        @endif        

        <div class="" id="encuestaList">
            @forelse ($encuestas as $encuesta)
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $encuesta->titulo }}</h5>
                        <p class="card-text">{{ $encuesta->descripcion }}</p>
                        <div class="row justify-content-end text-muted">{{ $encuesta->created_at->format('d/m/Y') }}</div>
                    </div>
                    <div class="card-footer text-center">
                        
                        <a href="{{ route('encuesta.show', $encuesta->idencuesta) }}" class="btn btn-success col-5" disabled>Votar</a>
                        
                        @if (auth()->user()->user_type == 'Admin')
                            <a href="{{ route('encuesta.showEdit', $encuesta->idencuesta) }}" class="btn btn-success col-5">Editar</a>
                        @endif
                    </div>
                </div> <br>
            @empty
                <span class="text-muted"><em>No se encontro ninguna votación.</em></span>
            @endforelse

            <div class="row justify-content-center">{{ $encuestas->links() }}</div>

        </div>
    </div>
</div>

{{-- Modal para crear encuestas --}}
<div class="modal fade" id="crearEncuestaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Crear Votación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="inputEmail4">Titulo</label>
                    <input type="text" class="form-control" id="input_titulo" name="titulo">
                    <div id="tituloAlert" class="alert alert-danger" role="alert">
                        <span>La votación debe tener un titulo</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword4">Descripción</label>
                    <input type="text" class="form-control" id="input_descripcion" name="descripcion">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button id="btnCrearEncuesta" data-dismiss="modal" class="btn btn-success">Crear</button>
            </div>
        </div>
    </div>
</div>
    <script type="text/javascript">
        $(function(){

            $('#tituloAlert').hide();

            $('#btnCrearEncuesta').on('click', function(){
                var titulo = $('#input_titulo').val();
                var descripcion = $('#input_descripcion').val();

                if(titulo.length == 0){
                    $('#tituloAlert').show();
                }else{
                    $.ajax({
                        data: { _token: "{{ csrf_token() }}", titulo: titulo, descripcion: descripcion },
                        url:  "{{ route('encuesta.fn.crear') }}",
                        type: 'POST',
                        dataType: "json",
                        beforeSend: () => {
                            $('.btn').attr('disabled', true);
                            $('.btn').addClass('disabled');
                        },
                        success:  function (response) { 
                            if(response.response){
                                $("#encuestaList").load(" #encuestaList");
                                $(location).attr('href', 'encuesta/editar/'+ response.encuesta +'')
                            }else{
                            console.log(response.message)
                            }
                        
                        },
                        error: function(xhr, testStatus, errorThrown){
                            $('button').attr('disabled', false);
                            console.log(xhr, testStatus, errorThrown);
                            //Materialize.toast("Error al realizar la petición, favor comunicarse con su administrador", 4000)
                        }
                    });
                }
                
            });

            $('#input_titulo').keyup(function(event){
                if(event.which == 13){
                    $('#input_descripcion').focus();
                }
            });

            $('#input_descripcion').keyup(function(event){
                if(event.which == 13){
                    $('#btnCrearEncuesta').click();
                }
            });
        });
    </script>
@endsection