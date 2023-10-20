@can('admin')
    <br />
    <div class="card">
        <div class="card-header font-weight-bold">
            Analisar
        </div>
        <div class="card-body">
            <form method="POST" action="/registros/{{ $registro->id }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-sm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                                <h5><span class="badge bg-success text-light"><i class="fa fa-thumbs-up"></i> Validar</span></h5>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                            <label class="form-check-label" for="flexRadioDefault2">
                                <h5><span class="badge bg-danger text-light"><i class="fa fa-thumbs-down"></i> Invalidar</span></h5>
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <a href="/pessoas/{{ $registro->codpes }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endcan
