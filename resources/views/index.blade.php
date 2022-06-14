@extends('main')

@section('content')

<div class="card">
    <div class="card-header font-weight-bold">
        Registros
    </div>
    <div class="card-body">
        @foreach($places as $place)
        <div class="card">
            <div class="card-header">
                {{ $place->name }}
            </div>
            <ul class="list-group list-group-flush">
                @forelse($place->registros->where('created_at', '>=', \Carbon\Carbon::today()) as $registro)
                    <li class="list-group-item">
                        @if($registro->type == 'in')
                            <i class="fas fa-sign-in-alt text-success"></i> {{ $registro->created_at->format('H:i') }} (Entrada)
                        @endif
                        @if($registro->type == 'out')
                            <i class="fas fa-sign-out-alt text-danger"></i> {{ $registro->created_at->format('H:i') }} (Saída)
                        @endif
                        - {{ \Uspdev\Replicado\Pessoa::obterNome($registro->codpes) }}
                        @if (config('ponto.fotoMonitor') == 1 or Auth::check())
                            <a href="" data-toggle="modal" data-target="#modalFoto"
                                data-whatever="{{ \Uspdev\Replicado\Pessoa::obterNome($registro->codpes) }}, {{ \Uspdev\Wsfoto::obter($registro->codpes) }}">
                                <i class="fas fa-portrait fa-lg text-info"></i>
                            </a>
                        @endif
                    </li>
                @empty
                    <li class="list-group-item">Não há monitor(a) no local</li>
                @endforelse
            </ul>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalFoto" tabindex="-1" role="dialog" aria-labelledby="Foto" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Foto</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">
            <img id="foto" class="rounded img-thumbnail p-3" src="" alt="foto">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
</div>

@endsection

@section('javascripts_bottom')
@parent
<script>
    $(document).ready(function() {
        // Modal
        $('#modalFoto').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('whatever') // Extract info from data-* attributes
            var modal = $(this)
            var array = recipient.split(',')
            var nome = array[0]
            var foto = array[1]
            modal.find('.modal-title').text(nome)
            $("#foto").attr("src", "data:image/png;base64, " + foto)
        });
    });
</script>
@endsection