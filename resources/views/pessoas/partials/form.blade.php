@foreach ($registros as $registro)
    @if($registro->status == 'valido')
        <form method="POST" action="registros/{{ $registro->id }}/invalidate">
            @csrf
            @method('PATCH')
            @if($registro->type == 'in')
            <i class="fas fa-sign-in-alt text-success"></i> 
                <a href="/registros/{{ $registro->id }}">
                    {{ $registro->created_at->format('d/m/Y - H:i') }} (Entrada)</a>
                <button type="submit" class="btn btn-danger">Invalidar registro</button>
            @else
            <i class="fas fa-sign-out-alt text-danger"></i> 
                <a href="/registros/{{ $registro->id }}">
                    {{ $registro->created_at->format('d/m/Y - H:i') }} (Saída)</a>
                <button type="submit" class="btn btn-danger">Invalidar registro</button>
            @endif
        </form>          
    @endif
    <br>
    @if($registro->status == 'invalido')
        @if($registro->type == 'in')
        <i class="fas fa-sign-in-alt text-success"></i> 
            <a href="/registros/{{ $registro->id }}">
                {{ $registro->created_at->format('d/m/Y - H:i') }} (Entrada) - Registro invalidado pelo responśavel</a>
        @else
        <i class="fas fa-sign-out-alt text-danger"></i> 
            <a href="/registros/{{ $registro->id }}">
                {{ $registro->created_at->format('d/m/Y - H:i') }} (Saída) - Registro invalidado pelo responsável</a>
        @endif
    @endif
@endforeach
