@foreach ($registros as $registro)
  <br>
  @if($registro->type == 'in')
    <i class="fas fa-sign-in-alt text-success"></i>
      <a href="/registros/{{ $registro->id }}">
      ({{ $registro->status }}) {{ $registro->created_at->format('d/m/Y - H:i') }} (Entrada)</a>
  @else
    <i class="fas fa-sign-out-alt text-danger"></i>
      <a href="/registros/{{ $registro->id }}">
      ({{ $registro->status }}) {{ $registro->created_at->format('d/m/Y - H:i') }} (Saída)</a>
  @endif

  @can('admin')
    @if($registro->status == 'válido')
      <form style="display: inline;" method="POST" action="registros/{{ $registro->id }}/invalidate">
        @csrf
        @method('PATCH')
        <button type="submit" class="btn btn-danger btn-sm mb-1" title="Invalidar registro"><i class="fa fa-thumbs-down"></i> Invalidar</button>
      </form>
    @else
      {{ $registro->analise }}
    @endif
  @endcan

@endforeach
