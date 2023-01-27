<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Registro;

class ChangeRegistrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('registros', function (Blueprint $table) {
            $table->string('status')->default('válido')->change();
            $table->string('motivo')->nullable();
            $table->text('justificativa')->nullable();
            $table->text('analise')->nullable();
            $table->string('codpes_analise')->nullable();
        });
        
        foreach(Registro::all() as $registro){
            $registro->status = 'válido';
            $registro->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('registros', function (Blueprint $table) {
            //
        });
    }
}
