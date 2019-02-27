@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header text-center">¡Binvenido {{ Auth::user()->name }}!</div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                
                <button type="button" class="btn btn-outline-secundary btn-block">Crear Encuesta</button>
                
            </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){  
        $('#alert').hide();
        $('.btn-delete').click(function(e){
            e.preventDefault();
            if( ! confirm("Estas seguro de eliminar este registro?")){
                return false;
            }
            var row = $(this).parents('tr');
            var form = $(this).parents('form');
            var url = form.attr('action');

            $('#alert').show();

            $.post(url, form.serialize(), function(result){
                row.fadeOut();
                $('#productos-total').html(result.total);
                $('#alert').html(result.message);
            }).fail(function(){
                $('#alert').html('Algo salio mal');
            });

        });
    });
</script>

@endsection
