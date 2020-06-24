<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCampoDetalhesOpcionaisTableDocumentosSolicitados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documentos_solicitados', function (Blueprint $table) {
            $table->longText('detalhes_opcionais')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documentos_solicitados', function (Blueprint $table) {
            $table->dropColumn('detalhes_opcionais');
        });
    }
}
