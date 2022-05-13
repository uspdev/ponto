@extends('main')

@section('content') 

<a class="btn btn-success" href="/places/create">Cadastrar novo local</a>
<br><br>

<table class="table">

  <thead>
    <tr>
      <th scope="col">Nome</th>
    </tr>
  </thead>

  <tbody>
    @foreach($places as $place)
    <tr>
        <td>{{ $place->name }}</td>
    </tr>
    @endforeach
  </tbody>

</table>

@endsection