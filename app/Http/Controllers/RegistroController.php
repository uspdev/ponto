<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistroRequest;
use App\Models\Registro;
use App\Models\Place;
use Illuminate\Support\Facades\Storage;
use \Datetime;
use Carbon\Carbon;

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

        //Usuario::create($validated);
        return redirect('/');
    }

    public function show()
    {
        $this->authorize('admin');
        $registroId = explode('/', url()->current())[4];
        $registro = Registro::find($registroId);
        return view('registros.show', [
            'registro' => $registro
        ]);
    }

    public function picture()
    {
        $this->authorize('admin');
        $registroId = explode('/', url()->current())[4];
        $registro = Registro::find($registroId);
        $path = (config('ponto.pathPictures') == 'pictures') ? '/pictures/' : '/';
        return Storage::download($path . $registro->image);
    }

 }