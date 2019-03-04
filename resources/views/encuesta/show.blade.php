@extends('layouts.app')

@section('content')
<style>
        .snackbar {
    visibility: hidden;
    min-width: 100px;
    /* Center align */
    margin-left: -50px; 
    border-radius: 5px;
    position: fixed;
    z-index: 10;
    /* Snackbar position */
    top: 10%;
    right: 1%;
}

.snackbar-show {
    visibility: visible;

/* Animacion: fade in y out de 0.5s de duracion.
En el fade out hay un retraso de 2.5 segundos */
    -webkit-animation: fadein 0.5s, fadeout 0.5s 4.5s;
    animation: fadein 0.5s, fadeout 0.5s 4.5s;
}

/* Animaciones para hacer fade in y out.
Puedes usar jQuery si te sientes mas comodo
y asi eliminas  las animaciones*/
@-webkit-keyframes fadein {
    from {opacity: 0;}
    to {opacity: 1;}
}

@keyframes fadein {
    from {opacity: 0;}
    to {opacity: 1;}
}

@-webkit-keyframes fadeout {
    from {opacity: 1;}
    to {opacity: 0;}
}

@keyframes fadeout {
    from {opacity: 1;}
    to {opacity: 0;}
}
        </style>
    <div class="card">
        <div class="card-header text-center">
            <h5>Editar Encuesta</h5>
            
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
                    <span class="input-group-text">Descripcion</span>
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
                                El {{ $opcion->opcion->opcion }} es el mejor perro de todos debido a esto y esto otro, por eso y por mas, llego a la conclusion de que es el mejor perro.
                            </div>
                        </div>
                    </div>
                @empty
                    <span class="text-muted"><em>No hay opciones en esta encuesta.</em></span>
                @endforelse
            </div>
            
            <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#crearOpcionModal">+</button>
        </div>
        <div class="card-footer text-center">
            <button id="btnActualizarEncuesta" x-idencuesta="{{ $encuesta->idencuesta }}" class="btn btn-outline-info">Actualizar</button>
            <div id="actualizarAlertDanger" class="alert alert-danger" role="alert">
                <span>¡Edite el titulo o la descripcion!</span>
            </div>
            <div id="actualizarAlertSuccess" class="alert alert-success" role="alert">
                <span>¡Actualizado!</span>
            </div>
        </div>
    </div>
    <div id="toast" class="snackbar btn-dark px-3 py-3"></div>
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
            //Funcion para ajustar el tamaño del textbox
            $(".autoHeight").each(function(){;
			    $(this).height($(this).prop('scrollHeight'));
            });


            //Alertas de bootstrap
            var input_vacio = $('#opcionAlertDanger');
            var opcion_creada = $('#opcionAlertSuccess');
            var actualizarAlertDanger = $('#actualizarAlertDanger');
            var actualizarAlertSuccess = $('#actualizarAlertSuccess');

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

                }else{
                    opcion_creada.hide();
                    input_vacio.show();
                }
            });


            //Funcion para editar una encuesta
            $('#btnActualizarEncuesta').on('click', function(){
                var titulo_db = '{{ $encuesta->titulo }}';
                var descripcion_db = '{{ $encuesta->descripcion }}';
                var titulo_actual = $('#txtTitulo').val();
                var descripcion_actual = $('#txtDescripcion').val();
                var idencuesta = $(this).attr('x-idencuesta');

                if(titulo_actual.trim() != titulo_db || descripcion_actual.trim() != descripcion_db){
                    $.ajax({
                        data: { _token: "{{ csrf_token() }}", id: idencuesta, titulo: titulo_actual.trim(), descripcion: descripcion_actual.trim() },
                        url:  "{{ route('encuesta.fn.editar') }}",
                        type: 'PUT',
                        dataType: "json",
                        success:  function (response) { 
                            if(response.response){
                                location.reload();
                                actualizarAlertDanger.hide();
                                actualizarAlertSuccess.show();
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
                    $('#toast').text('Debes editar algo.');
                    showToast();
                }
            });

            //Funcion para mostrar toast
            function showToast(param) {
                var snackbarHTML = document.querySelectorAll(".snackbar"),
                    element;
                for (element of snackbarHTML) {
                    // Check if param is an Event or string
                    if (param instanceof Event && param.currentTarget.hasAttribute("data-text")) {
                        element.innerHTML = param.currentTarget.getAttribute("data-text");
                    } else if (typeof param == "string" && !Utils.is_empty(param)) {
                        element.innerHTML = param;
                    }

                    element.classList.add("snackbar-show");

                    setTimeout(function() {
                        element.classList.remove("snackbar-show");
                    }, 5000);
                }
            }

        });
    </script>
@endsection