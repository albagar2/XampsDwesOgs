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
<br>
<br>
<form action=" " method="POST">
    @csrf
    Nombre fruta: <input type="text" name="fruta" value="{{ old('fruta') }}"><br>
    Descripcion: <textarea name="descripcion" id="" cols="30" rows="10">{{ old('descripcion') }}</textarea><br>
    Pais: <input type="checkbox" name="pais[]" value="españa">españa
    <input type="checkbox" name="pais[]" value="francia">francia
    <input type="checkbox" name="pais[]" value="alemania">alemania<br>
    <input type="submit" value="Enviar">
</form>

<br>
<br>
@if (session('mensaje'))
    {{ session('mensaje') }}
@endif
