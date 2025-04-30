@extends('main')

@section('content')

    <div class="card">
      <div class="card-header font-weight-bold">
      Monitores da sala Pró-Aluno
      </div>
      <div class="card-body">
        <table class="table table-sm table-striped table-hover datatable-pessoas">
          <thead>
            <tr>
              <th scope="col">Nº USP</th>
              <th scope="col">Nome</th>
            </tr>
          </thead>
          <tbody>
            @foreach($pessoas as $pessoa)
            <tr>
                <td>{{ $pessoa["codpes"] }}</td>
                <td>{{ \Uspdev\Replicado\Pessoa::obterNome($pessoa["codpes"]) }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

@endsection

@section('javascripts_bottom')
@parent
<script>
    $(document).ready(function() {
        // DataTables
        var table = $('.datatable-pessoas').DataTable({
            dom: '<t>'
            , ordering: true
            , order: ['1', 'asc'] /* ordenando por nome asc */
            , language: {
                url: 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json'
            }
            , paging: true
            , lengthChange: true
            , searching: true
            , info: true
            , autoWidth: true
            , lengthMenu: [
                [10, 25, 50, 100, -1]
                , ['10 linhas', '25 linhas', '50 linhas', '100 linhas', 'Mostar todos']
            ]
            , pageLength: -1
            , buttons: [
                'excelHtml5'
                , 'csvHtml5'
            ]
        });
        // Na lista de monitores da sala pró-Aluno
        // não é necessário mostrar o item "Registrar ponto"
        $("#menu").hide();
    });
</script>
@endsection
