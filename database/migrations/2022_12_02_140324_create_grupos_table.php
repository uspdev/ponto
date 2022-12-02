<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGruposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grupos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->text('name');
            $table->text('query');
            $table->integer('codpes_supervisor');
            $table->text('codpes_autorizador');

            $table->integer('inicio_folha')->default('21');
            $table->integer('fim_folha')->default('20');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grupos');
    }
}
