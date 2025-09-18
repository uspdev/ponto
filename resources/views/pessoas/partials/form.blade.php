@foreach ($registros as $registro)
  <tr @if ($registro->status == 'análise') class="table-warning" @elseif ($registro->status == 'inválido') class="table-danger" @endif>
    <td>
      @if($registro->type == 'in')
        <i class="fas fa-sign-in-alt text-success"></i>
          @can('boss') <a href="/registros/{{ $registro->id }}"> @endcan
          ({{ $registro->status }}) {{ $registro->created_at->format('d/m/Y - H:i') }} (Entrada) @can('boss') </a> @endcan
      @else
        <i class="fas fa-sign-out-alt text-danger"></i>
          @can('boss') <a href="/registros/{{ $registro->id }}"> @endcan
          ({{ $registro->status }}) {{ $registro->created_at->format('d/m/Y - H:i') }} (Saída) @can('boss') </a> @endcan
      @endif      
    </td>
  </tr>
@endforeach
