<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="{{ asset("assets/js/dist/image-uploader.min.css") }}">
    <script type="text/javascript" src="{{ asset("assets/js/dist/image-uploader.min.js") }}"></script>
</head>

<body>
    @include('app-layout.header')
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-3">
                @include('app-layout.left')
            </div>
            <div class="col-6 shadow-sm">
                @yield('main')
            </div>
            <div class="col-3">
                @include('app-layout.right')
            </div>
        </div>
    </div>
    <script src="{{asset('assets/js/ajax.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    @stack('scripts')
</body>
</html>
