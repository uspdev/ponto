@extends('main')

@section('content')

<div class="card">
    <div class="card-header font-weight-bold">
        Registros
    </div>
    <div class="card-body">
        @foreach($places as $place)
        <div class="card mb-3">
            <div class="card-header">
                {{ $place->name }}
            </div>
            <ul class="list-group list-group-flush">
                @php
                    // Se logado
                    if (Auth::check()) {
                        $registros = $place->registros->where('created_at', '>=', \Carbon\Carbon::today())->sortByDesc('id')->take(1);
                    }
                @endphp
                @forelse ($registros as $registro)
                    <li class="list-group-item">
                        {{-- Verifica se o registro é de entrada, do contrário no momento não tem monitor no local --}}
                        {{-- // TODO: Pode acontecer do monitor não ter esquecido de registrar a saída ou a entrada --}}
                        @if ($registro->type == 'in')
                            <i class="fas fa-sign-in-alt text-success"></i> {{ $registro->created_at->format('H:i') }} (Entrada)
                            - {{ \Uspdev\Replicado\Pessoa::obterNome($registro->codpes) }}
                        @elseif ($registro->type == 'out' && Auth::check())
                            <i class="fas fa-sign-in-alt text-danger"></i> {{ $registro->created_at->format('H:i') }} (Saída)
                            - {{ \Uspdev\Replicado\Pessoa::obterNome($registro->codpes) }}
                        @else
                            Não há monitor(a) no local
                        @endif

                        {{-- Se foi parametrizado para mostrar foto do monitor --}}
                        @if (config('ponto.fotoMonitor') == 1)
                            <a href="#" data-toggle="modal" data-target="#modalFotoMonitor" title="Mostrar foto do monitor"
                                data-whatever="{{ \Uspdev\Replicado\Pessoa::obterNome($registro->codpes) }}, {{ \Uspdev\Wsfoto::obter($registro->codpes) }}">
                                <i class="fa fa-user-circle fa-lg text-info ml-1"></i>
                            </a>
                        @endif
                        @auth
                            {{-- Se logado mostrar a foto do registro --}}
                            <a href="#" data-toggle="modal" data-target="#modalFotoRegistro" title="Mostrar foto do registro"
                                data-whatever="{{ \Uspdev\Replicado\Pessoa::obterNome($registro->codpes) }}, '/registros/{{ $registro->id }}/picture'">
                                <i class="fa fa-camera fa-lg text-info ml-1"></i>
                            </a>
                        @endauth
                    </li>
                @empty
                    <li class="list-group-item">
                        Não há monitor(a) no local
                    </li>
                @endforelse
            </ul>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal Foto Monitor -->
<div class="modal fade" id="modalFotoMonitor" tabindex="-1" role="dialog" aria-labelledby="Foto" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Foto</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">
            <img id="fotoMonitor" class="rounded img-thumbnail p-3" src="" alt="foto">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
</div>

<!-- Modal Foto Registro -->
<div class="modal fade" id="modalFotoRegistro" tabindex="-1" role="dialog" aria-labelledby="Foto" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Foto</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">
            <img id="fotoRegistro" class="rounded img-thumbnail p-3 mt-3" alt="Foto">
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
        // Modal Foto Monitor
        $('#modalFotoMonitor').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('whatever') // Extract info from data-* attributes
            var modal = $(this)
            var array = recipient.split(',')
            var nome = array[0]
            var foto = array[1]
            modal.find('.modal-title').text(nome)
            $("#fotoMonitor").attr("src", "data:image/png;base64, " + foto)
        });
        // Modal Foto Registro
        $('#modalFotoRegistro').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('whatever') // Extract info from data-* attributes
            var modal = $(this)
            var array = recipient.split(',')
            var nome = array[0]
            var foto = array[1]
            modal.find('.modal-title').text(nome)
            $("#fotoRegistro").attr("src", foto.trim().replace(/'/g, ""))
        });
    });
</script>
@endsection