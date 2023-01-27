<div class="form-group">
    <label for="place_id"><b>Local</b></label>
    <select name="place_id">
        @if (count($places) > 1)
        <option value="" selected="">Selecione o local ...</option>
        @endif
        @foreach ($places as $place)
            @if(old('place_id') == '' and isset($ocorrencia->place_id))
                <option value="{{ $place->id }}"
                {{ ( $ocorrencia->place->id == $place->id ) ? 'selected' : ''}}>    
                {{ $place->name }}
                </option>
            @else
            <option value="{{ $place->id }}"
            {{ ( old('place_id') == $place->id ) ? 'selected' : '' }}> {{ $place->name }}
            </option>
            @endif
        @endforeach
    </select>
</div>
<b>Ocorrência: </b><br>
<textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="ocorrencia"
placeholder="Digite o ocorrido...">{{ old('ocorrencia', $ocorrencia->ocorrencia) }}</textarea>
<br>
<button type="submit" class="btn btn-primary">Enviar</button>
