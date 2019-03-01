@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header text-center">¡Bienvenido {{ Auth::user()->name }}!</div>
    <div class="card-body">
        {{-- Boton para activar el modal de encuestas --}}
        <button type="button" class="btn btn-outline-primary btn-block" data-toggle="modal" data-target="#crearEncuestaModal">Crear Encuesta</button>
        <br>
        <div id="encuestasList">
            @forelse ($encuestas as $encuesta)
                <a href="/encuesta/{{ $encuesta->idencuesta }}" class="btn btn-sm btn-outline-secondary">{{ $encuesta->idencuesta }}. {{ $encuesta->titulo }}</a><br><br>
            @empty
                <span class="text-muted"><em>No se encontraron registros.</em></span>
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
                <h5 class="modal-title" id="exampleModalLabel">Crear Encuesta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="inputEmail4">Titulo</label>
                    <input type="text" class="form-control" id="input_titulo" name="titulo">
                    <div id="tituloAlert" class="alert alert-danger" role="alert">
                        <span>La encuesta debe tener un titulo</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword4">Descripcion</label>
                    <input type="text" class="form-control" id="input_descripcion" name="descripcion">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button id="btnCrearEncuesta" class="btn btn-success">Crear</button>
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
                        success:  function (response) { 
                            if(response.response){
                                $('#input_titulo').val('');
                                $('#input_descripcion').val('');
                                $("#encuestasList").load(" #encuestasList");
                                $('#tituloAlert').hide();
                            }else{
                            console.log(response.message)
                            }
                        
                        },
                        error: function(xhr, testStatus, errorThrown){
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