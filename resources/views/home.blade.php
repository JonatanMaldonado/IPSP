@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Panel Administrativo</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>
                        <span id="productos-total">{{ $productos->total() }}</span> registros |
                        pagina {{ $productos->currentPage() }}
                        de {{ $productos->lastPage() }}
                    </p>

                    <div id="alert" class="alert alert-info"></div>

                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="20px">ID</th>
                                <th>Nombre del producto</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productos as $item)
                                <tr>
                                    <td width="20px">{{ $item->id }}</td>
                                    <td>{{ $item->nombre }}</td>
                                    <td width="20px">
                                        {!! Form::open(['route' => ['destroyProduct', $item->id], 'method' => 'DELETE']) !!}
                                            <a href="#" class="btn-delete">Eliminar</a>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $productos->render() !!}
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
