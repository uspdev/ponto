@can('boss')
    <br />
    <div class="card">
        <div class="card-header font-weight-bold">
            Analisar
        </div>
        <div class="card-body">
            <form id="form_analise" method="POST" action="/registros/{{ $registro->id }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-sm">
                        <div class="form-check d-inline mr-2">
                            <input class="form-check-input" type="radio" name="status" value="válido" required>
                            <label class="form-check-label" for="flexRadioDefault1">
                                <h5><span class="badge bg-success text-light p-2"><i class="fa fa-thumbs-up"></i> Validar</span></h5>
                            </label>
                        </div>
                        <div class="form-check d-inline">
                            <input class="form-check-input" type="radio" name="status" value="inválido" required>
                            <label class="form-check-label" for="flexRadioDefault2">
                                <h5><span class="badge bg-danger text-light p-2"><i class="fa fa-thumbs-down"></i> Invalidar</span></h5>
                            </label>
                        </div>
                        <div id="div_analise" class="form-group" style="display: none;">
                            <label for="analise">Motivo</label>
                            <input type="text" class="form-control" name="analise" placeholder="Qual o motivo de invalidar?">
                        </div>
                        <button type="submit" class="btn btn-primary d-block mt-2">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endcan

@section('javascripts_bottom')
    <script>
        $(document).ready(function(){
            $('#form_analise').change(function(){
                status = $("input[name='status']:checked").val();
                if (status == "inválido") {
                    $("#div_analise").attr("style", "display:block");
                    $("input[name='analise']").prop('required', true);
                } else {
                    $("#div_analise").attr("style", "display:none");
                    $("input[name='analise']").prop('required', false);
                }
                $("input[name='status']:checked").val(status);
            });
        });
    </script>
@endsection('javascripts_bottom')
