<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OcorrenciaRequest;
use App\Models\Ocorrencia;
use App\Models\Place;

class OcorrenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ocorrencias = Ocorrencia::all();
        return view('ocorrencias.index', [
            'ocorrencias' => $ocorrencias,
            'places' => Place::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('admin');

        return view('ocorrencias.create', [
            'ocorrencia' => new Ocorrencia, 
            'places' => Place::all(),
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOcorrenciaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OcorrenciaRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->user()->id;
        $ocorrencia = Ocorrencia::create($validated);
        request()->session()->flash('alert-info','Ocorrência cadastrada com sucesso!');
        return redirect("/ocorrencias/{$ocorrencia->id}");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ocorrencia  $ocorrencia
     * @return \Illuminate\Http\Response
     */
    public function show(Ocorrencia $ocorrencia)
    {
        return view('ocorrencias.show',[
            'ocorrencia' => $ocorrencia,
            'places' => Place::all(),
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ocorrencia  $ocorrencia
     * @return \Illuminate\Http\Response
     */
    public function edit(Ocorrencia $ocorrencia)
    {
        $this->authorize('admin');

        return view('ocorrencias.edit',[
            'ocorrencia' => $ocorrencia,
            'places' => Place::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOcorrenciaRequest  $request
     * @param  \App\Models\Ocorrencia  $ocorrencia
     * @return \Illuminate\Http\Response
     */
    public function update(OcorrenciaRequest $request, Ocorrencia $ocorrencia)
    {
        $validated = $request->validated();
        $ocorrencia->update($validated);
        request()->session()->flash('alert-info','Ocorrência atualizada com sucesso');
        return redirect("/ocorrencias/{$ocorrencia->id}");
    }

    public function destroy(Ocorrencia $ocorrencia)
    {
    $ocorrencia->delete();
    return redirect('/ocorrencias');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ocorrencia  $ocorrencia
     * @return \Illuminate\Http\Response
     */
}
