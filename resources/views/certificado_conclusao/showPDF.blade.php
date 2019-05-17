<style>
    @page {
        /* margin: 2cm; */
        margin-top: 1cm;
        margin-left: 2.5cm;
        margin-right: 2.5cm;
        margin-bottom: 1cm;
    }

    .page-break {
        page-break-after: always;
    }

    hr {
        border: 0;
        border-top: 2px solid #A0A0A0;
        width: 600px;
        text-align: center;
    }

    h4 {
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
        font-size: 18pt;
        font-weight: bold;
    }

    #texto {
        font-family: "Tajawal", sans-serif;
        text-align: justify;
        font-size: 11pt;
        /* font-family: "Tajawal"; */
    }

    .texto-fundo {
        font-family: "Tajawal", sans-serif;
        font-size: 11pt;
        /* line-height: 1em; */
    }
    }

    /* https://ourcodeworld.com/articles/read/688/how-to-configure-a-watermark-in-dompdf */
    #watermark {
        position: fixed;
        top: 300px;
        left: 80px;
        /** The width and height may change 
                    according to the dimensions of your letterhead
                **/
        width: 12cm;
        height: 8cm;

        /** Your watermark should be behind every content**/
        z-index: -1000;
        /* opacity: 0.5; */
    }

    .texto-pequeno {
        font-family: "Tajawal";
        font-size: 8pt;
        text-align: justify;
        line-height: 0.7em;
    }

    .texto-assinatura {
        position: fixed;
        top: 650px;
        /* left: 80px; */
         line-height: 0.8em;
    }

    .texto-pequeno-footer {
        font-family: "Tajawal";
        font-size: 8pt;
        text-align: center;
        line-height: 0.7em;
    }

    .texto-pequeno-header {
        font-family: "Tajawal", sans-serif;
        font-size: 11pt;
        text-align: center;
        line-height: 1em;
    }

    .texto-direita {
        font-family: "Tajawal", sans-serif;
        font-size: 11pt;
        text-align: right;
    }

    .traco {
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        font-size: 11pt;
        /* text-align: right; */
    }

    #texto p::first-line {
        text-indent: 100px;
    }

    .texto-centralizado {
        text-align: center;
    }

    footer {
        position: absolute;
        top: 850px;
        left: 0px;
    }
</style>
<header>
    <div class="row">
        <div class="col-md-10 col-md-offset-8">
            <img src="img/logo_cabecalho.jpg" height="120px" width="600px" />
        </div>
    </div>
    <p class="texto-pequeno-header">CNPJ: 63.025.530/0094-03<br>
        Serviço de Graduação</p>
    <hr>
     <center>
        <br><br>
        <h4>CERTIFICADO DE CONCLUSÃO DE CURSO</h4>
    </center>
    <br><br>
</header>

<body>
    <div id="texto">
        <div id="watermark"><img src="img/logo_fearp_pb.jpg" height="100%" width="100%"></div>
        <p class="texto-fundo">C E R T I F I C A M O S que <b>{{ strtoupper($nome) }}</b>, n° USP {{ $aluno->codpes }},
            @if ($aluno->codcurgrd == '81200')
            filha(o) de {{ "{$nommae} e {$nompai}" }}, natural de {{ $cidade }}, no Estado de {{ $estado }}, nascido(a) aos {{ $data_nascimento }},  
            @endif
            @if(strlen($aluno->numdocidf) == 9) 
                portador(a) do RG 
                {{ @vsprintf('%s%s.%s%s%s.%s%s%s-%s', str_split($aluno->numdocidf)) . "/{$aluno->sglorgexdidf}-{$aluno->sglest}," }}
            @elseif(strlen($aluno->numdocidf) == 8)
                portador(a) do RG 
                {{ @vsprintf('%s.%s%s%s.%s%s%s-%s', str_split($aluno->numdocidf)) . "/{$aluno->sglorgexdidf}-{$aluno->sglest}," }}
            @endif
            expedido em {{ $data_expedicao }}, concluiu o curso de {{ $cursos[$aluno->codcurgrd] }} desta Faculdade em 8 de dezembro de 2018
            @if ($aluno->codcurgrd == '81200')
            , com carga horária total de 3030 horas.
            @else
            .
            @endif
        </p>
        <p>
            Certificamos, ainda, que colou grau em {{ $data_colacao }} e que a expedição e o registro do diploma encontram-se em processamento.
        </p>

        <br>
        <p class="texto-direita">
            Ribeirão Preto, {{ \Carbon\Carbon::now()->formatLocalized('%d de %B de %Y') }}.
        </p>

        <!-- <br><br> -->
        <div class="row texto-assinatura">
            <div class="col-xs-5"><p class="traco">___________________________________</p><center>Prof. Dr. André Lucirton Costa<br>Diretor</p></center></div>
            <div class="col-xs-5 pull-right"><p class="traco">___________________________________</p><center>Cristina Bernardi Lima<br>Assistente Acadêmica</p></center></div>
        </div>
    </div>
    <br><br>
</body>
<footer>
    <p class="texto-pequeno">
        A Universidade de São Paulo foi reconhecida pelo Decreto 6.283, de 25/01/1934.<br>
        @if ($aluno->codcurgrd == '81200')
        A renovação do reconhecimento do curso de Ciências Contábeis foi feita pela Portaria CEE-GP-11, de 02/02/2018, publicada no Diário Oficial do Estado de São Paulo em 03/02/2018.</p>
        @elseif (($aluno->codcurgrd == '81003') || ($aluno->codcurgrd == '81002'))
        A renovação do reconhecimento do curso de Administração foi feita pela Portaria CEE-GP-655, de 19/12/2017, publicada no Diário Oficial do Estado de São Paulo em 21/12/2017.
        @elseif (($aluno->codcurgrd == '81300') || ($aluno->codcurgrd == '81301'))
        A renovação do reconhecimento do curso de Economia Empresarial e Controladoria foi feita pela Portaria CEE-GP-657, de 19/12/2017, publicada no Diário Oficial do Estado de São Paulo em 21/12/2017.
        @elseif (($aluno->codcurgrd == '81100') || ($aluno->codcurgrd == '81101'))
        A renovação do reconhecimento do curso de Ciências Econômicas foi feita pela Portaria CEE/GP 86, de 10/03/2015, publicada no Diário Oficial do Estado de São Paulo em 11/03/2015.
        @endif
        </p>
    <hr>
    <p class="texto-pequeno-footer">
        Avenida Bandeirantes, 3.900 - Monte Alegre - CEP 14040-905 - Ribeirão Preto-SP - Brasil<br>
        Fone 16 3315-3888 | E-mail atendimentosg@fearp.usp.br| www.fearp.usp.br | <img src="img/logo_facebook.jpg" height="11px" width="11px" /> fearpusp | <img src="img/logo_twitter.jpg" height="11px" width="11px" /> @fearp_usp
    </p>
</footer>