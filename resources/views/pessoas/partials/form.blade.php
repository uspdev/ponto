@foreach ($registros as $registro)
  <br>
  @if($registro->type == 'in')
    <i class="fas fa-sign-in-alt text-success"></i>
      @can('boss') <a href="/registros/{{ $registro->id }}"> @endcan
      ({{ $registro->status }}) {{ $registro->created_at->format('d/m/Y - H:i') }} (Entrada) @can('boss') </a> @endcan
  @else
    <i class="fas fa-sign-out-alt text-danger"></i>
      @can('boss') <a href="/registros/{{ $registro->id }}"> @endcan
      ({{ $registro->status }}) {{ $registro->created_at->format('d/m/Y - H:i') }} (Saída) @can('boss') </a> @endcan
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
