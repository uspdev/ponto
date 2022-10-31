<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">Registrada por:</th>
      <th scope="col">Local:</th>
      <th scope="col">Ocorrido:</th>
    </tr>
  </thead>
  <tbody>
    @foreach($ocorrencias as $ocorrencia)
    <tr>
      <td><a href="ocorrencias/{{$ocorrencia->id}}">{{ $ocorrencia->user->name }}</a></td>
      <td>{{ $ocorrencia->place->name }}</td>
      <td>{{ $ocorrencia->ocorrencia }}</td>   
    </tr>
  @endforeach
  </tbody>
</table>  
{{ $ocorrencias->appends(request()->query())->links() }}