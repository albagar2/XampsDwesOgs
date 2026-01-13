<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
</head>
<body>
    @section('header')
        ESTA ES LA CABECERA DE LA PLANTILLA MAESTRA
    @show

    <div>
        @yield('content')
    </div>

    @section('header')
        ESTO ES EL PIE DE LA PLANTILLA MAESTRA
    @show

</body>
</html>
