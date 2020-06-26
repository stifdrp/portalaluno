@component('mail::message')
### {{ $pedido->resposta_inicial($pedido->id)->cabecalho }}

# dados do pedido
{{ $pedido->documentos_solicitados->first()->documento_disponivel()->documento }}
{{ $pedido->resposta_inicial($pedido->id)->corpo }}

{{ $pedido->resposta_inicial($pedido->id)->rodape }}
@endcomponent
