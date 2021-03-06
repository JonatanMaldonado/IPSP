@extends('layouts.app')

@section('content')
    @if(auth()->user()->user_type == 'Admin')
    <div class="card">
        <div class="card-header text-center">
            <h5>Editar Votación</h5>
            
        </div>
        <div class="card-body">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Titulo</span>
                </div>
                <textarea class="form-control autoHeight" id="txtTitulo" rows="1" aria-label="With textarea">{{ $encuesta->titulo }}</textarea>
            </div>

            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Descripción</span>
                </div>
                <textarea class="form-control autoHeight" id="txtDescripcion" rows="1" aria-label="With textarea">{{ $encuesta->descripcion }}</textarea>
            </div>
            
            <hr><h5>Opciones</h5>

            <div class="accordion mb-3" id="accordionOpcion">
                @forelse ($encuesta_opciones as $opcion)
                    <div class="card">
                        <div class="card-header alert-info" id="card{{ $opcion->opcion->idopcion }}" data-toggle="collapse" data-target="#collapse{{ $opcion->opcion->idopcion }}" aria-expanded="true" aria-controls="collapseOne">
                            <i class="far fa-edit"> </i> {{ $opcion->opcion->opcion }} 
                        </div>

                        <div id="collapse{{ $opcion->opcion->idopcion }}" class="collapse" aria-labelledby="card{{ $opcion->opcion->idopcion }}" data-parent="#accordionOpcion">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="opcion_nombre">Nombre</label>
                                    <input type="text" class="form-control" id="opcion_nombre{{ $opcion->opcion->idopcion }}" value="{{ $opcion->opcion->opcion }}">
                                </div>
                                <div class="text-center">
                                    <button class="btn btn-outline-secondary btn_opcion" x-idopcion="{{ $opcion->opcion->idopcion }}" x-accion="editar">Actualizar</button>
                                    <button class="btn btn-outline-danger btn_opcion" x-idopcion="{{ $opcion->opcion->idopcion }}" x-accion="eliminar">Eliminar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <span class="text-muted"><em>No hay opciones en esta votación.</em></span>
                @endforelse
            </div>
            
            <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#crearOpcionModal">+</button>
        </div>
        <div class="card-footer text-center">
            <button id="btnActualizarEncuesta" class="btn btn-outline-success">Actualizar</button>
            <a class="btn btn-outline-success" href="{{ route('encuesta.show', $encuesta->idencuesta) }}">Votar</a>
            <div id="actualizarAlertDanger" class="alert alert-danger" role="alert">
                <span>¡Edite el titulo o la descripción!</span>
            </div>
            <div id="actualizarAlertSuccess" class="alert alert-success" role="alert">
                <span>¡Actualizado!</span>
            </div>
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
                    <button id="btnCrearOpcion" class="btn btn-success">Crear</button>
                </div>
            </div>
        </div>
    </div>
    @else
    <span class="text-muted"><em>No tienes los permisos para editar votaciones.</em></span>
    @endif
    
    <script type="text/javascript">
        $(function(){
            //Funcion para ajustar el tamaño del textbox
            $(".autoHeight").each(function(){;
			    $(this).height($(this).prop('scrollHeight'));
            });


            //Alertas de bootstrap
            let input_vacio = $('#opcionAlertDanger');
            let opcion_creada = $('#opcionAlertSuccess');
            let actualizarAlertDanger = $('#actualizarAlertDanger');
            let actualizarAlertSuccess = $('#actualizarAlertSuccess');

            input_vacio.hide();
            opcion_creada.hide();
            actualizarAlertDanger.hide();
            actualizarAlertSuccess.hide();


            //Funcion para crear una opcion en una encuesta
            $('#input_opcion').on('keyup', function(event){
                if(event.which == 13){
                    $('#btnCrearOpcion').click();
                }
            });

            $('#btnCrearOpcion').on('click', function(){
                var opcion = $('#input_opcion').val();
                if(opcion.length > 0){
                    $.ajax({
                        data: { _token: "{{ csrf_token() }}", id: "{{ $encuesta->idencuesta }}", opcion: opcion },
                        url:  "{{ route('opcion.fn.crear') }}",
                        type: 'POST',
                        dataType: "json",
                        success:  function (response) { 
                            if(response.response){
                                input_vacio.hide();
                                opcion_creada.show();
                                $('#input_opcion').val('');
                                $("#accordionOpcion").load(" #accordionOpcion");
                            }else{
                                console.log(response.message)
                            }
                        
                        },
                        error: function(xhr, testStatus, errorThrown){
                            console.log(xhr, testStatus, errorThrown);
                            console.log("Error al realizar la petición, favor comunicarse con su administrador");
                        }
                    });

                }else{
                    opcion_creada.hide();
                    input_vacio.show();
                }
            });


            //Funcion para editar una encuesta
            $('#btnActualizarEncuesta').on('click', function(){
                let titulo_db = '{{ $encuesta->titulo }}';
                let descripcion_db = '{{ $encuesta->descripcion }}';
                let titulo_actual = $('#txtTitulo').val();
                let descripcion_actual = $('#txtDescripcion').val();

                if(titulo_actual.trim() != titulo_db || descripcion_actual.trim() != descripcion_db){
                    $.ajax({
                        data: { _token: "{{ csrf_token() }}", id: "{{ $encuesta->idencuesta }}", titulo: titulo_actual.trim(), descripcion: descripcion_actual.trim() },
                        url:  "{{ route('encuesta.fn.editar') }}",
                        type: 'PUT',
                        dataType: "json",
                        success:  function (response) { 
                            if(response.response){
                                location.reload();
                                actualizarAlertDanger.hide();
                                actualizarAlertSuccess.show();
                            }else{
                                console.log(response.message);
                            }
                        
                        },
                        error: function(xhr, testStatus, errorThrown){
                            console.log(xhr, testStatus, errorThrown);
                            console.log("Error al realizar la petición, favor comunicarse con su administrador");
                        }
                    });
                    
                }else{
                    actualizarAlertDanger.show("slow");
                    actualizarAlertSuccess.hide();
                }
            });

            $(document).on('click', '.btn_opcion', function() {
                let accion = $(this).attr('x-accion');
                let idopcion = $(this).attr('x-idopcion');
                let opcion = $('#opcion_nombre' + idopcion).val();
                let token = '{{ csrf_token() }}';
                let url = '';
                let data = {};

                switch (accion) {
                    case 'editar':
                        url = '{{ route("opcion.fn.editar") }}';
                        data = { _token: token, id: idopcion, opcion: opcion }
                        break;

                    case 'eliminar':
                        url = '{{ route("opcion.fn.eliminar") }}';
                        data = { _token: token, id: idopcion }
                        break;
                }

                $.ajax({
                    data: data,
                    url: url,
                    type: "PUT",
                    dataType: "json",
                    success:  function (response) { 
                        if(response.response){
                            alert(response.message);
                            $("#accordionOpcion").load(" #accordionOpcion");
                        }else{
                            console.log(response.message)
                        }
                    
                    },
                    error: function(xhr, testStatus, errorThrown){
                        console.log(xhr, testStatus, errorThrown);
                        console.log("Error al realizar la petición, favor comunicarse con su administrador")
                    }
                });
            });

        });
    </script>
@endsection