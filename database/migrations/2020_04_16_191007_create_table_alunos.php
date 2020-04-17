<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAlunos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alunos', function (Blueprint $table) {
            $table->string('codpes', 20);
            $table->string('nompes', 255);
            $table->string('codigo_curso', 10);
            $table->string('codigo_habilitacao', 100);
            $table->integer('semestre_atual');
            $table->string('email_administrativo', 255);
            $table->string('email_alternativo', 255);
            $table->string('telefone', 45);
            $table->date('data_ingresso');
            $table->primary('codpes');
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
        Schema::dropIfExists('alunos');
    }
}
