<div class="btn-group" role="group">
	<a href="{{ route('sales.show', $sale->id) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Ver"> 
		<i class="fa fa-eye"></i> 
	</a>
	@if($sale->remito)
        <a class="btn btn-primary btn-sm link-disabled" title="Ver Remito" data-toggle="tooltip" data-placement="top" target="_blank">
            <span class="fa fa-file-pdf-o"></span>
        </a>
    @else
        <a href="{{ route('credits.remit', $sale->id) }}" class="btn btn-primary btn-sm" title="Ver Remito" data-toggle="tooltip" data-placement="top" target="_blank">
            <span class="fa fa-file-pdf-o"></span>
        </a>
    @endif

    @if($sale->finished == 0)
        <button disabled="disabled" type="button" class="btn btn-danger btn-sm" title="Dar de baja la venta" data-sale="{{ $sale->id }}" onclick="modalSale(this);">
            <span class="fa fa-close"></span>
        </button>
    @else
        <button type="button" class="btn btn-danger btn-sm" title="Dar de baja la venta" data-sale="{{ $sale->id }}" onclick="modalSale(this);">
            <span class="fa fa-close"></span>
        </button>
    @endif
    {{--  
    <a href="'.route('credits.departure.order', $sale->credit->id).'" class="btn btn-primary btn-sm" title="Ver Orden de Salida" data-toggle="tooltip" data-placement="top" target="_blank">
                <span class="fa fa-file-pdf-o"></span>
    </a>
    --}}
</div>