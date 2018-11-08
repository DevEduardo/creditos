@extends('adminlte::page')

@section('content')
	<div class="row">
	    <div class="col-md-12 col-sm-12 col-xs-12">
	        <div class="nav-tabs-custom">
	        	<ul class="nav nav-tabs">
	            	<li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Datos de la venta</a></li>
	          	</ul>
	          	<div class="tab-content">
		            <div class="tab-pane active" id="activity">
		              <!-- Datos Personales -->
		                <div class="row">
		                	<div class="col-md-12">
			                  	<ul class="timeline timeline-inverse">
			                      	<li>
				                        <i class="fa fa-list bg-blue"></i>
				                        <div class="timeline-item">
				                          	<h3 class="timeline-header"><a href="#">Compra </a> </h3>
				                        	<div class="timeline-body">
				                            	<div class="row">
				                              		<div class="col-md-12">
				                                		<!-- Sale Info-->
						                                <div class="row">
						                                  	<div class="col-sm-12 sol-md-6 col-lg-6">
						                                    	{{ Form::label('Empresa') }} <br>
						                                    	{{ $sale->company->name }} 
						                                  	</div>

						                                  	<div class="col-sm-12 sol-md-3 col-lg-3">
						                                    	{{ Form::label('Código') }} <br>
						                                    	{{ $sale->id }} 
						                                  	</div>

						                                  	<div class="col-sm-12 sol-md-3 col-lg-3">
						                                    	{{ Form::label('Fecha') }} <br>
						                                    	{{ $sale->date->format('d-m-Y') }} 
						                                  	</div>
						                                </div>

				                                		<br>

				                                		<div class="row">
				                                  			<div class="col-sm-12 sol-md-6 col-lg-6">
				                                    			{{ Form::label('Cliente') }} <br>
				                                    			{{ $sale->client->name }} 
				                                  			</div>

				                                  			<div class="col-sm-12 sol-md-6 col-lg-6">
				                                    			{{ Form::label('Vendedor') }} <br>
				                                    			{{ $sale->user->name }} 
				                                  			</div>
				                                		</div>

				                                		<br>

						                                <div class="table-responsive">
						                                    <table class="table table-hoover table-striped">
							                                    <tr>
							                                        <th colspan="5"> 
							                                          	<p class="text-center">
							                                            	Detalles de Compra
							                                          	</p>
							                                        </th>
							                                    </tr>
						                                      	<tr>
						                                        	<td>#</td>
						                                        	<td>Producto</td>
						                                        	<td>Cant.</td>
						                                        	<td>Precio Unit.</td>
						                                        	<td>Precio Total</td>
						                                      	</tr>
						                                      
						                                      	@foreach ($sale->sale_details as $key => $detail)
						                                        	<tr>
						                                          		<td>{{ $key+1 }}</td>
						                                          		<td>{{ $detail->product->name }}</td>
						                                          		<td>{{ $detail->qty }}</td>
						                                          		<td>{{ number_format($detail->price, 0, ',', '.') }}</td>
						                                          		<td>{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
						                                        	</tr>
						                                      	@endforeach
						                                    </table>
						                                </div>

						                                <div class="row">
							                                <div class="col-md-3 col-md-offset-9">
							                                	<b>Subtotal: </b> {{ number_format($sale->subtotal, 0, ',', '.') }} <br>

							                                    <b>Impuesto: </b> @if(empty($sale->tax)) No Tiene @else {{ $sale->tax }} @endif <br>
							                                        
							                                    <b>Descuento: </b> @if(empty($sale->discount)) No Tiene @else {{ $sale->discount }} @endif <br>
							                                        
							                                    <b>Total: </b> {{ number_format($sale->total, 0, ',', '.') }}
							                                </div>
							                           	</div>
						                           	</div>
				                            	</div>
				                        	</div>
				                        </div>	
			                     	</li>
			                    </ul>
		                  	</div>
		                </div>
		            	<!-- /.post -->
		            </div>
	          	</div>
	          	<!-- /.tab-content -->
	        </div>
	        <!-- /.nav-tabs-custom -->
	    </div>
	</div>
@stop