@extends('layouts.app')
@section('content')
    <div style="position: relative; ">
    
            <h5>{{ Auth::user()->name }}</h5>
            
            <form id="form">
                {{ csrf_field() }}
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ Auth::user()->email }}">
                    </div>
                </div>
                <div class="form-group row">
                        <label for="inputOldPassword" class="col-sm-2 col-form-label">Contraseña Actual</label>
                        <div class="col-sm-10">
                            <input type="password" name="inputOldPassword" class="form-control" id="inputOldPassword">
                        </div>
                    </div>
                <div class="form-group row">
                    <label for="inputNewPassword" class="col-sm-2 col-form-label">Nueva Contraseña</label>
                    <div class="col-sm-10">
                        <input type="password" name="inputNewPassword" class="form-control" id="inputNewPassword">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputConfirmPassword" class="col-sm-2 col-form-label">Confirmar Contraseña</label>
                    <div class="col-sm-10">
                        <input type="password" name="inputConfirmPassword" class="form-control" id="inputConfirmPassword">
                    </div>
                </div>
            </form>
            <button type="button" class="btn btn-primary" id="guardar">Guardar</button>
        
            <div class="toast" style="position: absolute; top: 0; right: 0;">
                <div class="toast-body" style="background-color:#2E2E2E; color:white;">
                    <span id="toast">Notificación</span>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
    </div>

    <script type="text/javascript">
        $(function() {
            $('#guardar').on('click', function() {
                var form = $('#form').serialize();
                
                if($('#inputNewPassword').val() === $('#inputConfirmPassword').val()) {
                    $.ajax({
                        data: form,
                        url:  "{{ route('perfil.update') }}",
                        type: "POST",
                        dataType: "json",
                        success:  function (response) {
                            if(response.response) {
                                if(response.validar) {
                                    toast(response.validar, 4000);
                                }else {
                                    toast(response.message, 5000);
                                    
                                }

                            }
                        },
                        error: function(xhr, testStatus, errorThrown){
                            console.log(xhr, testStatus, errorThrown);
                        }
                    });
                }else {
                    toast('Las contraseñas no coinsiden.', 4000);
                }

            });

            function toast(texto, tiempo) {
                $('.toast').toast({
                    delay: tiempo,
                });
                $('#toast').text(texto);
                $('.toast').toast('show');
            }
        });
    </script>

@endsection