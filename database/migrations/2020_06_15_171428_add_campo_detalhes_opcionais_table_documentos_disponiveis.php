<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCampoDetalhesOpcionaisTableDocumentosDisponiveis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documentos_disponiveis', function (Blueprint $table) {
            $table->boolean('detalhes_opcionais')->default(false)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documentos_disponiveis', function (Blueprint $table) {
            $table->dropColumn('detalhes_opcionais');
        });
    }
}
