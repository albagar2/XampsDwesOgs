@include('cabecera')
Hola soy el contacto {{ $nombre }} y tengo {{ $edad }}
@if ($edad >= 18)
    <p>Es mayor de edad</p>
@else
    <p>Es menor de edad</p>

@endif
@foreach ($frutas as $f)
    <p>{{ $f }}</p>

@endforeach
