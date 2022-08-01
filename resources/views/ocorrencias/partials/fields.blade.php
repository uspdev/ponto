<ul>
  <b>Por:</b><a href="/ocorrencias/{{$ocorrencia->id}}"> {{ $ocorrencia->user->name }}</a><br>
  <b>Local:</b> {{ $ocorrencia->place->name }}<br>
  <b>Ocorrido:</b> {{ $ocorrencia->ocorrencia }}<br>
    <form method="POST" action="/ocorrencias/{{$ocorrencia->id}}/edit">
   @csrf
    @method('get')
   <button type="submit" class="btn btn-primary"> Editar </button>
</form>
<form action=" /ocorrencias/{{ $ocorrencia->id }}" method="post">
      @csrf
      @method('delete')
      <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza?');">Ocorrência resolvida - deletar</button> 
    </form>
</ul>