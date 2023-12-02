@extends('main')
@section('content')

<a class="btn btn-success" href="/grupos/create">Novo Grupo</a>
<br><br>
<div class="card">
    <div class="card-header font-weight-bold">
        Grupos
    </div>
    
    <br>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col">Nome</th>
          <th scope="col">Supervisor</th>
          <th scope="col">Autorizador</th>
          <th scope="col">Operações</th>
        </tr>
      </thead>
      <tbody>
      @foreach($grupos as $grupo)

        {{-- Se o usuário logado é supervisor, autorizador ou admin, lista o grupo --}}
        @if (App\Models\Grupo::find($grupo->id)->codpes_supervisor == Auth::user()->codpes || App\Models\Grupo::find($grupo->id)->codpes_autorizador == Auth::user()->codpes || Gate::allows('admin')) 

        <tr>
          <td>{{ $grupo->name }}</td>
          <td>{{ $grupo->codpes_supervisor }}</td>
          <td>{{ $grupo->codpes_autorizador }}</td>
          <td align="center">
            <a href="/grupos/{{$grupo->id}}/edit"><i class="fas fa-pencil-alt" color="#007bff"></i></a>
              @can ('admin')
              <form method="POST" action="/grupos/{{$grupo->id}}/">
                @csrf
                @method('delete')
                <button type="submit" onclick="return confirm('Tem certeza que deseja excluir esse grupo?');" style="background-color: transparent;border: none;"><i class="far fa-trash-alt" color="#007bff"></i></button>
              </form>
              @endcan
          </td>   
        </tr>
        
        @endif
        
      @endforeach

      </tbody>
    </table>  
</div>

@endsection