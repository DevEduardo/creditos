@extends('adminlte::page')

@section('content')
    
	<div class="table-responsive">

	    <table class="table table-striped table-hover" id="data" class="display" cellspacing="0" width="100%">
	    	
			<thead>
				<th>#</th>
				<th>CUIT</th>
				<th>Nombre</th>
				<th>Fecha</th>
				<th> <i class="fa fa-cogs fa-2x"></i> </th>
			</thead>

			<tbody>

				@foreach ($invoices as $invoice)

				<tr>
					<td>{{ $invoice->code }}</td>
					<td>{{ $invoice->provider->cuit }}</td>
					<td>{{ $invoice->provider->name }}</td>
					<td>{{  \Carbon\Carbon::parse($invoice->date)->format('d-m-Y') }}</td>
					<td>
						{{--  <a href="{{ route('invoices.show', $invoice->id) }}" title="Ver Factura" class="btn btn-primary">
							<span class="fa fa-eye"></span>
						</a> --}}
					</td>
				</tr>

				
				@endforeach

			</tbody>

	    </table>

	</div>
		
@stop