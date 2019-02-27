@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">¡Bienvenido {{ Auth::user()->name }}!</div>
                    <div class="card-body">
                        {{-- Boton para activar el modal de encuestas --}}
                        <button type="button" class="btn btn-outline-primary btn-block" data-toggle="modal" data-target="#crearEncuestaModal">Crear Encuesta</button>
                        <br>
                        <div id="encuestasList">
                            @forelse ($encuestas as $encuesta)
                                <p>{{ $encuesta->id }}. {{ $encuesta->titulo }}</p>
                            @empty
                                <span class="text-muted"><em>No se encontraron registros.</em></span>
                            @endforelse
                            
                            {{ $encuestas->links() }}
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
                                {{-- Form::open([ 'route'=>'encuesta.crear', 'method'=>'POST', 'enctype'=>'multipart/form-data' ]) --}}
                                <div class="form-group">
                                    <label for="inputEmail4">Titulo</label>
                                    <input type="text" class="form-control" id="titulo" name="titulo">
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword4">Descripcion</label>
                                    <input type="text" class="form-control" id="descripcion" name="descripcion">
                                </div>

                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="button" id="crearEncuesta" class="btn btn-success">Crear</button>
                                {{-- Form::close() --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#crearEncuesta').on('click', function(){
                var titulo = $('#titulo').val();
                var descripcion = $('#descripcion').val();

                if(titulo.length == 0){
                    alert('Escriba el titulo de la encuesta.')
                }else{
                    $.ajax({
                        data: { _token: "{{ csrf_token() }}", titulo: titulo, descripcion: descripcion },
                        url:  "{{ route('encuesta.fn.crear') }}",
                        type: 'POST',
                        dataType: "json",
                        success:  function (response) { 
                            if(response.response){
                                $('#titulo').val('');
                                $('#descripcion').val('');
                                $("#encuestasList").load(" #encuestasList");
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
        });
    </script>
@endsection