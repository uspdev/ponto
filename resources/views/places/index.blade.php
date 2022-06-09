@extends('main')

@section('content')

<div class="card">
  <div class="card-header font-weight-bold">
    Locais
  </div>
  <div class="card-body">
    <a class="btn btn-success" href="/places/create"><i class="fa fa-plus"></i> Cadastrar novo local</a>
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
  </div>
</div>

@endsection