<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'White Dashboard') }}</title>
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('white') }}/img/apple-icon.png">
    <link rel="icon" type="image/png" href="{{ asset('white') }}/img/favicon.png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css' />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css' />
    <link rel='stylesheet'
        href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap4-duallistbox/4.0.1/bootstrap-duallistbox.min.css' />
    <!-- Icons -->
    <link href="{{ asset('white') }}/css/nucleo-icons.css" rel="stylesheet" />
    <!-- CSS -->
    <link href="{{ asset('white') }}/css/white-dashboard.css?v=1002" rel="stylesheet" />
    <link href="{{ asset('white') }}/css/theme.css" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}?version=1001" rel="stylesheet" />
</head>

<body class="white-content {{ $class ?? '' }}">
    <input type="hidden" id="baseurl" name="baseurl" value="{{ config('app.url') }}" />
    @auth()
    <div class="wrapper">
        @include('layouts.navbars.sidebar')
        <div class="main-panel">
            @include('layouts.navbars.navbar')

            <div class="content">
                @yield('content')
            </div>

            @include('layouts.footer')
        </div>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    @else
    @include('layouts.navbars.navbar')
    <div class="wrapper wrapper-full-page">
        <div class="full-page {{ $contentClass ?? '' }}">
            <div class="content">
                <div class="container">
                    @yield('content')
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>
    @endauth
    <div class="modal-loading"></div>
    <script src="{{ asset('white') }}/js/core/jquery.min.js"></script>
    <script src="{{ asset('white') }}/js/core/popper.min.js"></script>
    <script src="{{ asset('white') }}/js/core/bootstrap.min.js"></script>
    <script src="{{ asset('white') }}/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js'></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/i18n/pt-BR.js'></script>
    <script
        src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap4-duallistbox/4.0.1/jquery.bootstrap-duallistbox.min.js'>
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"
        integrity="sha512-Rdk63VC+1UYzGSgd3u2iadi0joUrcwX0IWp2rTh6KXFoAmgOjRS99Vynz1lJPT8dLjvo6JZOqpAHJyfCEZ5KoA=="
        crossorigin="anonymous"></script>
    <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
    <script src="{{ asset('white') }}/js/white-dashboard.min.js?v=1000"></script>
    <script src="{{ asset('white') }}/js/theme.js"></script>
    <script src="{{ asset('js/main.js') }}?v=1009"></script>
    @stack('js')
</body>

</html>
