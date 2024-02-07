@extends('main')

@section('content')

  <form enctype="multipart/form-data" method="POST">
    @csrf
    <div class="form-group">
        <label for="place_id"><b>Local:</b></label>
        <select name="place_id">
            @if (count($places) > 1)
                <option value="" selected="">Selecione o local ...</option>
            @endif
            @foreach ($places as $place)
                <option value="{{ $place->id }}"
                {{ ( old('place_id') == $place->id ) ? 'selected' : '' }}> {{ $place->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="motivo"><b>Motivo:</b></label>
        <select name="motivo" class="motivo">
            @if (count($motivos) > 1)
                <option value="" selected="">Selecione o motivo ...</option>
            @endif
            @foreach ($motivos as $motivo)
                <option value="{{ $motivo }}"
                {{ ( old('motivo') == $motivo) ? 'selected' : '' }}> {{ $motivo }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group tipo hidden">
        <label for="tipo"><b>Tipo:</b></label>
        <select name="tipo" class="selecttipo">
            <option value="" selected="">Selecione o tipo ...</option>
            @foreach (['Entrada','Saída'] as $tipo)
                <option value="{{ $tipo }}"
                {{ ( old('tipo') == $tipo) ? 'selected' : '' }}> {{ $tipo }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <b>Dia: </b> <input class="dia" name="dia" value="{{ old('dia') }}" placeholder="{{ date('d/m/Y') }}">
    </div>

    <div class="form-group entrada">
        <b>Horário Entrada: </b> <input name="in" value="{{ old('in') }}" placeholder="{{ date('H:i') }}">
    </div>

    <div class="form-group saida">
        <b>Horário Saída: </b> <input name="out" value="{{ old('out') }}" placeholder="{{ date('H:i') }}">
    </div>


    <b>Justificativa: </b><br>
        <textarea class="form-control" id="" rows="3" name="justificativa">{{ old('justificativa') }}</textarea>
    <br>

    <b>Comprovante: </b><br>
        <input type="file" name="file">
    <br>
    <small>Requerido para caso de Consulta Médica, Licença Médica e Doação de Sangue </small>
    <br>
    
    <br>
    <button type="submit" class="btn btn-primary">Enviar</button>
  </form>
@endsection

@section('styles')
    <style>
        .hidden {
            display: none;
        }
    </style>
@endsection('styles')

@section('javascripts_bottom')
    <script>
        jQuery(function ($) {
            $(".dia").mask('00/00/0000');
            $(".in").mask('00:00');
            $(".out").mask('00:00');

            $('.motivo').change(function(){
                var motivo = $( '.motivo' ).val();
                if(motivo == 'Esquecimento'){
                    $( '.tipo' ).removeClass('hidden');  

                    $( '.entrada' ).addClass('hidden');  
                    $( '.saida' ).addClass('hidden');  

                    $('.selecttipo').change(function(){
                        var tipo = $( '.selecttipo' ).val();
                        console.log(tipo);

                        if(tipo == 'Entrada'){
                            $( '.entrada' ).removeClass('hidden');
                            $( '.saida' ).addClass('hidden');  
                        } 

                        if(tipo == 'Saída'){
                            $( '.saida' ).removeClass('hidden');
                            $( '.entrada' ).addClass('hidden');  
                        }
                        
                    });

                } else {
                    $( '.tipo' ).addClass('hidden');
                    $( '.entrada' ).removeClass('hidden');  
                    $( '.saida' ).removeClass('hidden');  
                }
            });


        });
        
    </script>
@endsection('javascripts_bottom')