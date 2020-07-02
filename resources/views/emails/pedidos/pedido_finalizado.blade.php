@component('mail::message')
## {{ $pedido->resposta_final($pedido)->cabecalho }} (RESPOSTA)

**Pedido: #{{ $pedido->id }}**

@php $linhas_corpo = (explode("\n", $pedido->corpo_resposta_finalizacao)) @endphp
@foreach ($linhas_corpo as $linha)
{{ $linha }}
@endforeach
@component('mail::panel')
@foreach ($pedido->documentos_solicitados as $documento)
@if (!empty($documento->detalhes_opcionais))
- {{ $documento->documento_disponivel->documento }}: {{ $documento->detalhes_opcionais }}
@else
- {{ $documento->documento_disponivel->documento }}
@endif
@endforeach

**Justificativa**:
{{ $pedido->justificativa }}
@endcomponent

@php $linhas_assinatura = (explode("\n", $pedido->resposta_final($pedido)->rodape)) @endphp
```
@foreach ($linhas_assinatura as $linha)
@if ((strlen($linha)) > 1)
{{ $linha }}
@endif
@endforeach
```
@endcomponent
