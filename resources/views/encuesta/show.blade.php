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
            <div class="row">
                @foreach ($encuesta_opciones as $opcion)
                    <button class="col-md-4 btn btn-success" style="margin:10px">{{ $opcion->opcion }}</button>
                @endforeach
    
                <button class="btn btn-primary col-4" style="margin:10px">+</button>
            </div>
            
        </div>
    </div>
    <div class="modal fade" id="crearOpcionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button id="btnCrearEncuesta" class="btn btn-success">Crear</button>
                </div>
            </div>
        </div>
    </div>
    
    <script type="text/javascript">
    
		$(".autoHeight").each(function(){;
			$(this).height($(this).prop('scrollHeight'))
		});

    </script>
@endsection