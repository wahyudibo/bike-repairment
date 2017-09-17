<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistem Pelaporan Layanan Bengkel Sepeda UGM</title>

    @include('shared.styles')
    @yield('styles')
</head>

<body>
    @yield('navbar')
    @yield('content')
    @include('shared.scripts')
    @yield('scripts')
</body>
</html>