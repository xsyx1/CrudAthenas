<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Minha Conta | {{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <style>
        :root {
            --input-padding-x: 1.5rem;
            --input-padding-y: 0.75rem;
        }

        body {
            font-family: "Poppins", sans-serif;
            font-size: 0.875rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            text-align: left;
        }

        .login,
        .image {
            min-height: 100vh;
        }

        .bg-image {
            background-image: url('{{ asset("img/FUNDO.jpg") }}');
            background-size: cover;
            background-position: center;
        }

        .login-heading {
            font-weight: 300;
        }

        .btn-login {
            font-size: 0.9rem;
            letter-spacing: 0.05rem;
            padding: 0.75rem 1rem;
            border-radius: 2rem;
            background: #003b19;
            border-color: #003b19;
        }

        .btn-login:hover {
            background: #04b61c;
            border-color: #04b61c;
        }
    </style>
</head>

<body>

    <form class="form" method="post" action="#">
        <input type="hidden" name="_token" value="#">

        <div class="container-fluid">
            <div class="row no-gutter">
                <div class="col-md-8 col-lg-6">
                    <div class="login d-flex align-items-center py-5">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-9 col-lg-8 mx-auto">
                                    <center><img src="{{ asset('img/logoAgua.png') }}" alt="Logo" class="img-fluid mb-5"
                                            width="250px">
                                    </center>
                                    <h5 class="login-heading mb-4">Informe seus dados abaixo</h5>
                                    <form class="form" method="post" action="{{ route('login') }}">
                                        @csrf
                                        <div class="form-label-group mb-3">
                                            <label for="inputEmail">Email</label>
                                            <input type="email" name="email"
                                                class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                required autofocus>

                                            @include('alerts.feedback', ['field' => 'email'])
                                        </div>
                                        <label for="inputEmail">Senha</label>
                                        <div class="input-group mb-3">

                                            <input type="password" id="pass" name="password"
                                                class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                                required>
                                            <div class="input-group-append">
                                                <span class="input-group-text olho btn btn-default" id="olho">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                        <path
                                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                                        <path
                                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                                    </svg>
                                                </span>
                                                @include('alerts.feedback', ['field' => 'password'])
                                            </div>
                                        </div>


                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1"
                                                name="remember">
                                            <label class="custom-control-label" for="customCheck1">Lembrar-me</label>
                                        </div>
                                        <button
                                            class="btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2"
                                            type="submit">Entrar</button>
                                        <div class="text-center">
                                            <a class="small" href="{{ route('password.request') }}">Esqueci minha
                                                senha</a></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>

            </div>
        </div>
    </form>
</body>

</html>
