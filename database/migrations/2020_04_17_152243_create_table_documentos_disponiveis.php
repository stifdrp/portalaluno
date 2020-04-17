<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDocumentosDisponiveis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos_disponiveis', function (Blueprint $table) {
            // Documentos Disponíveis
            $table->increments('id');
            $table->string('documento', 45);
            $table->string('descricao', 45);
            $table->boolean('status')->default(1);
            $table->unsignedInteger('formulario_id');
            $table->foreign('formulario_id')->references('id')->on('formularios');
            $table->softDeletes();
            $table->timestamps();
           //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documentos_disponiveis');
    }
}
