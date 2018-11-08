{!! Form::open(['route' => ['credits.destroy', $sale->credit->id], 'method' => 'DELETE']) !!}
<div class="btn-group" role="group">
	<a href="{{  route('credits.show', $sale->credit->id) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Ver"> 
		<i class="fa fa-eye"></i> 
	</a>
	@if ($sale->credit->type != 'sing')
	    <a href="{{ route('credits.contract', $sale->credit->id) }}" class="btn btn-primary btn-sm" title="Ver Contrato" data-toggle="tooltip" data-placement="top" target="_blank">
	        <span class="fa fa-file-pdf-o"></span>
	    </a> 
	@endif

    @if($sale->type == 'sing')
        <a href="{{ route('sales.contract', $sale->id) }}" target="_blank"  class="btn btn-primary btn-sm" title="Imprimir contrato">
            <span class="fa fa-file-pdf-o"></span>
        </a>
    @endif  
	<button type="button" class="btn btn-danger btn-sm" title="Dar de baja crédito" data-credit="{{ $sale->credit->id }}" onclick="modalAuthorization(this);" @if($sale->credit->is_payed || $sale->credit->status == 'unsubscribe') disabled @endif>
		<span class="fa fa-close"></span>
	</button>
</div>
{!! Form::close() !!}