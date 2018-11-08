@extends('adminlte::page')

@section('content')
	{!! Form::open(['route' => ['deliveries.send', $delivery], 'method' => 'PUT']) !!}
		@foreach($delivery->sale->sale_details as $detail)
			<div class="form-group">
				<div class="row">
					<div class="col-md-12">
						<h4>{{ $detail->product->name }}</h4>
						<p>Cantidad en esta venta: {{ $detail->qty }}<br>
							<strong>Disponible en:</strong>
						</p>	
					</div>
				</div>
				<div class="row">
					@foreach($detail->product->store_inventories as $inventory)
						<div class="col-md-3">
							<h4 class="text-center">{{ $inventory->store->name }}</h4>
							<p>
								Cantidad Disponible: {{ $inventory->qty }}
							</p>
							{!! Form::text('inventory'.$inventory->id.'-'.$inventory->product_id, old('inventory'.$inventory->id.'-'.$inventory->product_id), ['class' => 'form-control', 'placeholder' => 'Cantidad a despachar', 'pattern' => '[0-9]{1,2}']) !!}	
						</div>
					@endforeach	
				</div>
			</div>
			<hr>
		@endforeach
		<div class="form-group">
			<button type="submit" class="btn btn-success">
				Despachar
			</button>
			<button type="reset" class="btn btn-warning">
				Limpiar
			</button>
		</div>
	{!! Form::close() !!}
@stop