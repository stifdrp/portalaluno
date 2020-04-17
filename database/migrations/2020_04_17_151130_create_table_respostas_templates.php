<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRespostasTemplates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respostas_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('tipo'); //`` TINYINT NOT NULL DEFAULT 1 COMMENT '0 = INICIAL\n1 = FINAL_SIM\n2 = FINAL_NAO',
            $table->longText('cabecalho')->nullable();
            $table->longText('corpo')->nullable();
            $table->longText('rodape')->nullable();
            $table->unsignedInteger('formulario_id');
            $table->foreign('formulario_id')->references('id')->on('formularios');
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
        Schema::dropIfExists('respostas_templates');
    }
}
