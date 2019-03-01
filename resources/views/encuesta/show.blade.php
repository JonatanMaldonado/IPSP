@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header text-center">
            <h5>Editar Encuesta</h5>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Titulo</span>
                </div>
                <textarea class="form-control autoHeight" rows="1" aria-label="With textarea">{{ $encuesta->titulo }}</textarea>
            </div>
        </div>
        <div class="card-body">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Descripcion</span>
                </div>
                <textarea class="form-control autoHeight" rows="1" aria-label="With textarea">{{ $encuesta->descripcion }}</textarea>
            </div>
            <br>
            <h5>Opciones</h5>

            <div id="opcionesRow" class="row">
                @foreach ($encuesta_opciones as $opcion)
                    <button class="btn btn-success" style="margin:10px">{{ $opcion->opcion->opcion }}</button>
                @endforeach
            </div>
            <button class="btn btn-primary btn-block" style="margin:10px" data-toggle="modal" data-target="#crearOpcionModal">+</button>
        </div>
    </div>
    {{-- Modal para crear opciones en la encuesta --}}
    <div class="modal fade" id="crearOpcionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Opcion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
    
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputEmail4">Nombre</label>
                        <input type="text" class="form-control" id="input_opcion" name="opcion">
                        <div id="opcionAlertDanger" class="alert alert-danger" role="alert">
                            <span>¡La opcion debe tener un nombre!</span>
                        </div>
                        <div id="opcionAlertSuccess" class="alert alert-success" role="alert">
                            <span>¡La opcion se creo correctamente!</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button id="btnCrearOpcion" x-idencuesta="{{ $encuesta->idencuesta }}" class="btn btn-success">Crear</button>
                </div>
            </div>
        </div>
    </div>
    
    <script type="text/javascript">
        $(function(){
            $(".autoHeight").each(function(){;
			    $(this).height($(this).prop('scrollHeight'))
            });

            var input_vacio = $('#opcionAlertDanger');
            var opcion_creada = $('#opcionAlertSuccess');
            input_vacio.hide();
            opcion_creada.hide();

            $('#btnCrearOpcion').on('click', function(){
                var opcion = $('#input_opcion').val();
                var id = $(this).attr('x-idencuesta');
                if(opcion.length > 0){
                    $.ajax({
                        data: { _token: "{{ csrf_token() }}", id: id, opcion: opcion },
                        url:  "{{ route('opcion.fn.crear') }}",
                        type: 'POST',
                        dataType: "json",
                        success:  function (response) { 
                            if(response.response){
                                input_vacio.hide();
                                opcion_creada.show();
                                $('#input_opcion').val('');
                                $("#opcionesRow").load(" #opcionesRow");
                            }else{
                            console.log(response.message)
                            }
                        
                        },
                        error: function(xhr, testStatus, errorThrown){
                            console.log(xhr, testStatus, errorThrown);
                            console.log("Error al realizar la petición, favor comunicarse con su administrador")
                        }
                    });

                }else{
                    opcion_creada.hide();
                    input_vacio.show();
                }
            });


        });
    </script>
@endsection