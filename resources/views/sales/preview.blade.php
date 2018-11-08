@extends('adminlte::page')

@section('content')

	<div class="box box-solid">
		<div class="box-body">
			<div class="wrapper rtl rtl-inv" style="background: #FFF;">
			    <div class="row">
			        <div class="well col-xs-10 col-sm-10 col-md-8 col-xs-offset-1 col-sm-offset-1 col-md-offset-2">
			            <div class="row">
			                <div class="text-center">
			                    <h1>Calendario de pago</h1>
			                </div>
			                </span>
			                
			                @if($sale->credit->credit_details->count() > 0)
			                <table class="table table-hover">
			                    <thead>
			                        <tr>
			                            <th class="text-center" style="text-transform: uppercase;">Cuota</th>
			                            <th class="text-center" style="text-transform: uppercase;">Importe</th>
										<th class="text-center" style="text-transform: uppercase;">Vence</th>
										<th class="text-center" style="text-transform: uppercase;">Pago</th>
			                        </tr>
			                    </thead>
			                    <tbody>
			                    	<tr>
			                    		<td class="col-md-1 text-center"><em> 0 </em></h4></td>
			                            <td class="col-md-2 text-center"> {{ number_format($sale->credit->advance_I, 0, ',', '.') }} </td>
			                            <td class="col-md-2 text-center"> Anticipo </td>
			                            <td class="col-md-2 text-center">
			                            	{{ number_format($sale->credit->advance_I, 0, ',', '.') }}
			                            </td>
			                    	</tr>
			                    	@if($sale->credit->type == 'two_advance')
			                    		<tr>
				                    		<td class="col-md-1 text-center"><em> 00 </em></h4></td>
				                            <td class="col-md-2 text-center"> {{ number_format($sale->credit->advance_I, 0, ',', '.') }} </td>
				                            <td class="col-md-2 text-center">
				                            	{{ $sale->credit->date_advance_I->addDays(10)->format('d-m-Y') }}
				                            </td>
				                            <td class="col-md-2 text-center">
				                            	-
				                            </td>
				                    	</tr>
			                    	@endif
			                    	@foreach ($sale->credit->credit_details as $fees)
			                    			
		                    		<tr>
			                            <td class="col-md-1 text-center"><em>{{ $fees->fee_number }}</em></h4></td>
			                            <td class="col-md-2 text-center"> {{ number_format($fees->fee_amount, 0, ',', '.') }} </td>
			                            <td class="col-md-2 text-center">{{ date_format(date_create($fees->fee_date_expired), 'd-m-Y') }}</td>
			                            <td class="col-md-2 text-center">
			                            	@if ($fees->is_payed)
			                            		Pagado
		                            		@else
		                            			-
			                            	@endif
			                            </td>
			                        </tr>
			                    	@endforeach
			                        
			                        {{-- <tr>
			                            <td colspan="3" class="text-right">
			                                <strong>Monto a financiar: </strong>
			                            </td>
			                            <td colspan="1" class="text-left">
			                                <strong> {{ number_format($sale->credit->amount, 2, ',', '.') }} </strong>
			                            </td>
			                        </tr> --}}

			                        {{-- <tr>
			                            <td colspan="3" class="text-right">
			                                <strong>Intereses: </strong>
			                            </td>
			                            <td colspan="1" class="text-left">
			                                <strong> {{ number_format($sale->credit->final_amount - $sale->credit->amount, 2, ',', '.') }} </strong>
			                            </td>
			                        </tr> --}}

			                        {{-- <tr>
			                            <td colspan="3" class="text-right">
			                            	<h4><strong>Total a Pagar: </strong></h4>
			                            </td>
			                            <td colspan="1" class="text-left text-danger">
			                            	<h4><strong>{{ number_format($sale->credit->final_amount, 2, ',', '.') }} </strong></h4>
			                            </td>
			                        </tr> --}}
			                    </tbody>
			                </table>
			                @else
							
							<div class="col-md-12">
								<div class="alert alert-warning">
									Este credito no posee cuotas, es una venta por se&ntilde;a. Confirme para finalizar!
								</div>
							</div>
								
			                @endif
							
							<div class="col-md-6">
				                 {!! Form::open(['route' => ['sales.update', $sale->id], 'method' => 'PUT']) !!}
				                	<input type="hidden" name="process" value="0">
					                <button type="submit" class="btn btn-danger btn-lg btn-block">
					                    <span class="glyphicon glyphicon-chevron-left"></span> Regresar a la Venta
					                </button>
				                {!! Form::close() !!}
				            </div>

							<div class="col-md-6">
				                {!! Form::open(['route' => ['sales.update', $sale->id], 'method' => 'PUT']) !!}
				                	<input type="hidden" name="process" value="1">
					                <button type="submit" class="btn btn-success btn-lg btn-block">
					                    Confirmar y Finalizar   <span class="glyphicon glyphicon-chevron-right"></span>
					                </button>
				                {!! Form::close() !!}
				            </div>
			            </div>
			        </div>

		    </div>
		</div>
	</div>

	<style>
		.box-tools{
			display: none;
		}
	</style>
@stop