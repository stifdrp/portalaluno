<?php

namespace Database\Seeders;

use App\Formulario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormularioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $solicitacao_documentos = ['id' => 1, 'nome' => 'Solicitação de Documentos', 'inicio' => now(), 'created_at' => now(), 'updated_at' => now()];
        $ae_brasil = ['id' => 2, 'nome' => 'Aproveitamento de Estudos no Brasil', 'inicio' => now(), 'created_at' => now(), 'updated_at' => now()];
        $ae_exterior = ['id' => 3, 'nome' => 'Aproveitamento de Estudos no Exterior', 'inicio' => now(), 'created_at' => now(), 'updated_at' => now()];
        $contagem_credito = ['id' => 4, 'nome' => 'Contagem de Créditos', 'inicio' => now(), 'created_at' => now(), 'updated_at' => now()];
        $correcao_matricula = ['id' => 5, 'nome' => 'Correção de Matrícula', 'inicio' => now(), 'created_at' => now(), 'updated_at' => now()];
        DB::table('formularios')->insert([
            $solicitacao_documentos,
            $ae_brasil,
            $ae_exterior,
            $contagem_credito,
            $correcao_matricula
        ]);
    }
}
