@extends('main')

@section('content')

<table class="table">

  <thead>
    <tr>
      <th scope="col">Nome</th>
    </tr>
  </thead>

  <tbody>
    @foreach($monitores as $monitor)
    <tr>
        <td>{{ $monitor->codpes }}</td>
    </tr>
    @endforeach
  </tbody>

</table>

@endsection