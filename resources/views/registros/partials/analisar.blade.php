@can('admin')
    <br />
    <div class="card">
        <div class="card-header font-weight-bold">
            Analisar
        </div>
        <div class="card-body">
            <form method="POST" action="/registros" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="analise"><strong>Análise</strong></label>
                            <input type="hidden" class="form-control" name="status" value="{{ $registro->status }}">
                            <input type="text" class="form-control" name="analise" placeholder="Comente se necessário" value="{{ old('analise') }}">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" @if ($registro->status == 'válido') disabled @endif>
                                <i class="fa fa-thumbs-up"></i> Validar</button>
                                {{-- Mudar o campo status para válido e salvar --}}
                            <button class="btn btn-danger" @if ($registro->status == 'inválido') disabled @endif>
                                <i class="fa fa-thumbs-down"></i> Invalidar</button>
                                {{-- Mudar o campo status para inválido e salvar --}}
                            <a href="/pessoas/{{ $registro->codpes }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endcan
