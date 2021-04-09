@component('mail::message')
## {{ $pedido->resposta_inicial($pedido)->cabecalho }}

@php $linhas_corpo = (explode("\n", $pedido->resposta_inicial($pedido)->corpo)) @endphp
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

@php $linhas_assinatura = (explode("\n", $pedido->resposta_inicial($pedido)->rodape)) @endphp
```
@foreach ($linhas_assinatura as $linha)
@if ((strlen($linha)) > 1)
{{ $linha }}
@endif
@endforeach
```
@endcomponent
