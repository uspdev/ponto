<div class="form-group">

    <label for="name">Nome:</label>
    <input type="text" id="name" name="name" value="{{ old('name', $grupo->name) }}">

    <br> <br>
    <label for="codpes_autorizador">Número USP Autorizador:</label>
    <input type="number" id="codpes_autorizador" name="codpes_autorizador" value="{{ old('codpes_autorizador', $grupo->codpes_autorizador) }}">

    <br> <br>
    <label for="codpes_supervisor">Número USP Supervidor:</label>
    <input type="number" id="codpes_supervisor" name="codpes_supervisor" value="{{ old('codpes_supervisor', $grupo->codpes_supervisor) }}">

    <br> <br>
    <label for="query">Query:</label>
    <textarea class="form-control" id="query" rows="3" name="query" @if (!Gate::allows('admin')) readonly @endif>{{ old('query', $grupo->query) }}</textarea>
    <br>

    <label for="fim_folha">Dia que início da folha de pagamento:</label>
    <input type="number" id="inicio_folha" name="inicio_folha" value="{{ old('inicio_folha', $grupo->inicio_folha) }}">

    <br> <br>
    <label for="inicio_folha">Dia que fecha da folha de pagamento:</label>
    <input type="number" id="fim_folha" name="fim_folha" value="{{ old('fim_folha', $grupo->fim_folha) }}">
    
    <br> <br>
    <button type="submit" class="btn btn-primary">Enviar</button>

</div>
