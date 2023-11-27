<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistroRequest;
use App\Models\Registro;
use App\Models\Place;
use Illuminate\Support\Facades\Storage;
use \Datetime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegistroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('registros.create',[
            'places' => Place::all(),
        ]);
    }

    public function store(RegistroRequest $request)
    {
        $validated = $request->validated();

        # salvando imagem
        $image = str_replace('data:image/png;base64,', '', $validated['foto']);
        $image = str_replace(' ', '+', $image);
        $now = new DateTime();
        $image_name = $validated['codpes'] . '_' . $now->getTimestamp(). '.png';
        Storage::put(config('ponto.pathPictures') . '/' . $image_name, base64_decode($image));

        $registro = new Registro;
        $registro->codpes = $validated['codpes'];
        $registro->place_id = $validated['place_id'];
        $registro->image = $image_name;

        # verifica se é entrada ou saída
        $registros = Registro::where('created_at', '>=', Carbon::today())
            ->where('codpes',$validated['codpes'])
            ->orderBy('created_at', 'desc')
            ->get();

        if($registros->isEmpty()){
            $registro->type = 'in';
        } else {
            $last = $registros->first();
            if($last->type == 'in') $registro->type = 'out';
            if($last->type == 'out') $registro->type = 'in';
        }

        $registro->save();

        return redirect('/');
    }

    public function show(Registro $registro)
    {
        $this->authorize('boss',$registro->codpes);

        return view('registros.show', [
            'registro' => $registro
        ]);
    }

    public function picture()
    {
        $this->authorize('boss');
        $registroId = explode('/', url()->current())[4];
        $registro = Registro::find($registroId);
        $path = (config('ponto.pathPictures') == 'pictures') ? '/pictures/' : '/';
        return Storage::download($path . $registro->image);
    }

    public function invalidate(Registro $registro)
    {
        $this->authorize('boss');

        $registro->fill([
            'status' => 'inválido'
        ]);
        $registro->save();

        return back();
    }

    public function update(Request $request, Registro $registro)
    {
        $this->authorize('boss');

        $registro->status = $request->status;
        $registro->analise = $request->analise;
        $registro->codpes_analise = auth()->user()->codpes;

        $registro->save();

        return redirect("/pessoas/{$registro->codpes}?in={$request->in}&out={$request->out}");
    }

    public function justificar()
    {
        $this->authorize('logado');
        return view('registros.justificar',[
            'places' => Place::all(),
            'motivos' => Registro::$motivos,
        ]);
    }

    public function justificar_store(Request $request)
    {
        $this->authorize('logado');
        $request->validate([
            'justificativa' => 'required',
            'motivo' => ['required', Rule::in(Registro::$motivos)],
            'place_id' => ['required','integer',Rule::in(Place::pluck('id')->toArray())],
            'dia' => 'required|date_format:d/m/Y',
        ]);

        $registro = new Registro;
        $registro->codpes = auth()->user()->codpes;
        $registro->place_id = $request->place_id;
        $registro->motivo = $request->motivo;
        $registro->justificativa = $request->justificativa;
        $registro->status = 'análise';

        $casos_arquivo = [
            'Consulta Médica',
            'Licença Médica',
            'Doação de Sangue'
        ];

        if(in_array($request->motivo,$casos_arquivo)) {
            $request->validate([
                'file'     => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $orig = $request->file('file')->getClientOriginalName();
            $orig_array = explode('.',$orig);
            $extensao = array_pop($orig_array);

            $now = new DateTime();
            $image_name = $registro->codpes . '_' . $now->getTimestamp(). ".{$extensao}";

            $request->file('file')->storeAs(config('ponto.pathPictures'),$image_name);
            $registro->image = $image_name;
        } else {
            $registro->image =  'undefined';
        }

        // Somente se tem esquecimento
        if($request->motivo == 'Esquecimento') {
            $request->validate([
                'tipo' => ['required', Rule::in(['Entrada','Saída'])],
            ]);
            if($request->tipo == 'Entrada') {
                $request->validate([
                    'in' => 'required|date_format:H:i',
                ]);
                $registro->type = 'in';
                $registro->created_at = Carbon::createFromFormat('d/m/Y H:i', "$request->dia $request->in");
                $registro->updated_at = Carbon::createFromFormat('d/m/Y H:i', "$request->dia $request->in");
                $registro->save();
            }
            if($request->tipo == 'Saída') {
                $request->validate([
                    'out' => 'required|date_format:H:i'
                ]);
                $registro->type = 'out';
                $registro->created_at = Carbon::createFromFormat('d/m/Y H:i', "$request->dia $request->out");
                $registro->updated_at = Carbon::createFromFormat('d/m/Y H:i', "$request->dia $request->out");
                $registro->save();
            }
        } else {
            $request->validate([
                'in' => 'required|date_format:H:i',
                'out' => 'required|date_format:H:i'
            ]);
            $in = $registro;
            $out = $in->replicate();

            $in->type = 'in';
            $in->created_at = Carbon::createFromFormat('d/m/Y H:i', "$request->dia $request->in");
            $in->updated_at = Carbon::createFromFormat('d/m/Y H:i', "$request->dia $request->in");
            $in->save();

            $out->type = 'out';
            $out->created_at = Carbon::createFromFormat('d/m/Y H:i', "$request->dia $request->out");
            $out->updated_at = Carbon::createFromFormat('d/m/Y H:i', "$request->dia $request->out");
            $out->save();
        }

        $request->session()->flash('alert-success','Justificativa enviada com sucesso');
        return back();
    }

 }
