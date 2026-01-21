<h1>Listado de frutas</h1>

<ul>
    @foreach ($frutas as $f)
        <li>{{ $f }}</li>
    @endforeach
</ul>

<br>
<br>

<a href="{{ route('frutas.naranjas') }}">Ir a naranjas</a>

<br>
<br>

<a href="{{ url('/frutas/peras') }}">Ir a peras</a>
