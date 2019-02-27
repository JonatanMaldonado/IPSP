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
                        @forelse ($encuestas as $encuesta)
                            <p>Encuesta No. {{ $encuesta->id }}</p>
                        @empty
                            <span class="text-muted"><em>No se encontraron registros.</em></span>
                        @endforelse
                        
                        {{ $encuestas->links() }}
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
                                ...
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="button" class="btn btn-success">Crear</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    </script>
@endsection