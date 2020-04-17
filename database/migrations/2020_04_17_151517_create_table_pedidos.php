<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePedidos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            // Pedidos
            $table->increments('id');
            $table->longText('justificativa')->nullable();
            $table->dateTime('data_hora_abertura')->nullable();
            $table->dateTime('data_hora_resposta')->nullable();
            $table->boolean('status')->default(1);
            $table->string('codpes_func', 20);
            $table->longText('corpo_resposta_finalizacao')->nullable();
            $table->integer('aluno_id');
            $table->integer('formulario_id');
            $table->string('aluno_codpes', 20);
            $table->foreign('aluno_codpes')->references('codpes')->on('alunos');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}
