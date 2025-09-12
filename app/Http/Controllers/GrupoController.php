<?php

namespace App\Http\Controllers;

use App\Http\Requests\GrupoRequest;
use App\Models\Grupo;
use App\Models\User;
use Spatie\Permission\Models\Permission;

class GrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('boss');

        $grupos = Grupo::all();

        return view('grupos.index', [
            'grupos' => $grupos,
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
        return view('grupos.create', [
            'grupo' => new Grupo,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGrupoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GrupoRequest $request)
    {
        $this->authorize('admin');

        $validated = $request->validated();

        // Identifica os chefes, cria os usuários caso não existam, busca o usuário e adiciona permissão hierárquica boss
        $bosses = [$validated['codpes_supervisor'], $validated['codpes_autorizador']];
        foreach ($bosses as $boss) {
            User::findOrCreateFromReplicado($boss);
            $user = User::where('codpes', $boss)->first();
            $user->givePermissionTo(Permission::where('guard_name', User::$hierarquiaNs)->where('name', 'boss')->first());
        }

        $grupo = Grupo::create($validated);
        request()->session()->flash('alert-info','Grupo cadastrado com sucesso!');
        return redirect("/grupos");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function show(Grupo $grupo)
    {
        $this->authorize('boss');
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function edit(Grupo $grupo)
    {
        $this->authorize('boss');
        return view('grupos.edit', [
                'grupo' => $grupo,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGrupoRequest  $request
     * @param  \App\Models\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function update(GrupoRequest $request, Grupo $grupo)
    {
        $this->authorize('boss');
        $validated = $request->validated();

        // Identifica os chefes, cria os usuários caso não existam, busca o usuário e adiciona permissão hierárquica boss
        $bosses = [$validated['codpes_supervisor'], $validated['codpes_autorizador']];
        foreach ($bosses as $boss) {
            User::findOrCreateFromReplicado($boss);
            $user = User::where('codpes', $boss)->first();
            $user->givePermissionTo(Permission::where('guard_name', User::$hierarquiaNs)->where('name', 'boss')->first());
        }
        
        $grupo->update($validated);
        request()->session()->flash('alert-info','Grupo atualizado com sucesso');
        return redirect("/grupos");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grupo $grupo)
    {
        $this->authorize('admin');
        $grupo->delete();
        return redirect('/grupos');
    }
}
