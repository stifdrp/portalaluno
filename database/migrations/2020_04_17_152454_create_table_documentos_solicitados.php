<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDocumentosSolicitados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos_solicitados', function (Blueprint $table) {
            // Documentos solicitados
            $table->unsignedInteger('documento_disponivel_id');
            $table->unsignedInteger('pedido_id');
            $table->primary(['documento_disponivel_id', 'pedido_id']);
            $table->foreign('pedido_id')->references('id')->on('pedidos');
            $table->foreign('documento_disponivel_id')->references('id')->on('documentos_disponiveis');
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
        Schema::dropIfExists('documentos_solicitados');
    }
}
