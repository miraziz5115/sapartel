<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title></title>

    <!-- Bootstrap -->
    <link href="{{ asset('public/site/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('public/site/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('public/site/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- bootstrap-wysiwyg -->
    <link href="{{ asset('public/site/vendors/google-code-prettify/bin/prettify.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/site/vendors/animate.css/animate.min.css') }}" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="{{ asset('public/site/build/css/custom.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/style.css') }}" rel="stylesheet">
    <style type="text/css">
      body{
        /*background: #26272d;*/
        background: #fff;
      }
    </style>
  </head>

  <body style="background: #00284a!important;">
    <div>
      <div class="login_wrapper" style="max-width: 400px!important;">
        <div class="animate form login_form" style=" background: #f0f0f0!important; padding: 0 20px;border: 2px solid #13a246; border-radius:5px;border-bottom-right-radius: 30px;border-top-left-radius: 30px">
          <section class="login_content">
            <form method="POST" action="{{ route('login') }}">
            @csrf
              <!-- <h1>&nbsp;&nbsp;&nbsp;<img src="{{ asset('public/images/logo.png') }}" width="200" style="margin-top:-10px ">&nbsp;&nbsp;&nbsp;</h1> -->
              <h1>Вход</h1>
              <div class="form-group row">
                  <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-mail') }}</label>

                  <div class="col-md-6">
                      <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="off" autofocus>

                      @error('login')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
              </div>

              <div class="form-group row">
                  <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Пароль') }}</label>

                  <div class="col-md-6">
                      <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                      @error('password')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
              </div>
             
              <div>
                <input type="submit" value="Вход" class="form-control btn btn-primary" style="margin: 0">
              </div>
              <div>
                <a href="{{ route('register')}}" class="btn btn-primary">Регистрация</a>
                <a href="{{ url('auth/google') }}" class="btn btn-danger">Вход с Google</a>
              </div>
          </section>
        </div>

      </div>
    </div>
  </body>
</html>



