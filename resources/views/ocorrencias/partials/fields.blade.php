<div class="card">
    <div class="card-header font-weight-bold">
        Ocorrências
    </div>
    <table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">Registrada por:</th>
      <th scope="col">Local:</th>
      <th scope="col">Ocorrido:</th>
      <th scope="col">Ações</th>
    </tr>
  </thead>
  <tbody>
    @foreach($ocorrencias as $ocorrencia)
    <tr>
      <td><a href="ocorrencias/{{$ocorrencia->id}}">{{ $ocorrencia->user->name }}</a></td>
      <td>{{ $ocorrencia->place->name }}</td>
      <td>{{ $ocorrencia->ocorrencia }}</td>
      <td align="center">
        <a href="/ocorrencias/{{$ocorrencia->id}}/edit"><i class="fas fa-pencil-alt" color="#007bff"></i></a>
      <form method="POST" action="/ocorrencias/{{$ocorrencia->id}}/">
        @csrf
        @method('delete')
          <button type="submit" onclick="return confirm('Tem certeza que deseja excluir essa ocorrência?');" style="background-color: transparent;border: none;"><i class="far fa-trash-alt" color="#007bff"></i></button>
      </form></td>
    </tr>
  @endforeach
  </tbody>
</table>  
</div>

{{ $ocorrencias->appends(request()->query())->links() }}
