@foreach ($registros as $registro)
    @if($registro->type == 'in' && $registro->status == 'valido')
        <form method="POST" action="registros/{{ $registro->id }}/invalidate">
            @csrf
            @method('PATCH')
            <i class="fas fa-sign-in-alt text-success"></i> 
                <a href="/registros/{{ $registro->id }}">
                    {{ $registro->created_at->format('d/m/Y - H:i') }} (Entrada)</a>
            <button type="submit" class="btn btn-danger">Invalidar registro</button>
        </form>
    @elseif($registro->type == 'out' && $registro->status == 'valido')
        <form method="POST" action="registros/{{ $registro->id }}/invalidate">
            @csrf
            @method('PATCH')
            <i class="fas fa-sign-out-alt text-danger"></i> 
                <a href="/registros/{{ $registro->id }}">
                    {{ $registro->created_at->format('d/m/Y - H:i') }} (Saída)</a>
            <button type="submit" class="btn btn-danger">Invalidar registro</button>
        </form>
    @endif
    <br>
    @if($registro->type == 'in' && $registro->status == 'invalido')
        <i class="fas fa-sign-in-alt text-success"></i> 
            <a href="/registros/{{ $registro->id }}">
                {{ $registro->created_at->format('d/m/Y - H:i') }} (Entrada) - Registro invalidado pelo responśavel</a>
    @elseif($registro->type == 'out' && $registro->status == 'invalido')
        <i class="fas fa-sign-out-alt text-danger"></i> 
            <a href="/registros/{{ $registro->id }}">
                {{ $registro->created_at->format('d/m/Y - H:i') }} (Saída) - Registro invalidado pelo responsável</a>
    @endif
@endforeach
