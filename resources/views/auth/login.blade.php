@extends('layouts.site.layout')

@section('content')

<div class="login-box">
  <div class="login-logo">
    <a href="{{ route('login') }}">Iniciar Sesión</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    

    <form action="{{ route('login') }}" method="post" id="form_login">
       @csrf
      <div class="form-group has-feedback">
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" placeholder="Correo"  autofocus>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        
        <div id="error_email"></div>
      </div>
      <div class="form-group has-feedback">
         <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="current-password" placeholder="Contraseña">
        <span class="glyphicon glyphicon-eye-close form-control-feedback eyes" style="pointer-events: auto; cursor: pointer;"></span>
        
        <div id="error_pass"></div>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Recordarme
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat" id="btn_ingresar">Ingresar</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <a href="{{ route('password.request') }}">Olvidé mi contraseña</a><br>
    <a href="{{ route('register') }}">Registrarme</a><br>

  </div>
  <!-- /.login-box-body -->
</div>

<div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
               
              </div>
              <div class="modal-body">
              <div class="row">
               <div class="col-md-10 col-md-offset-2">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror 
                @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                @enderror
                </div>
              </div>
              </div>
              <div class="modal-footer">
                
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

@stop
@section('js')

<script> 
  $( document ).ready(function() {
   @if(count($errors)>0)
    $('#modal-default').modal('show');
   
  @endif
  });
 </script>
 @stop