<div class="row">
	<div class="col-md-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Compra </a></li>
            <!--<li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false"><span class="badge"> 2</span> Datos de Contacto</a></li>-->
          </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="activity">
              <!-- Datos Personales -->
            <div class="post">
                <div class="user-block">
                  <!--<img class="img-circle img-bordered-sm" src="{{asset('img/avatar.png')}}" alt="user image">-->
                      
                    <ul class="timeline timeline-inverse">
						<li>
		               	<i class="fa fa-user bg-blue"></i>
		                <div class="timeline-item">
		                    <h3 class="timeline-header"><a href="#">Datos de la Compra </a> </h3>
		                    	<div class="timeline-body">

			                    	<div class="row">
										
										{{Form::hidden('sale_id', $sale->id)}}

										<div class="col-sm-12 col-md-8 col-lg-8">
											<!-- Sale Info-->

											<div class="row">
												<div class="col-sm-12 sol-md-6 col-lg-6">
													{{Form::label('Empresa')}} <br>
													{{$sale->company->name}} 
												</div>

												<div class="col-sm-12 sol-md-3 col-lg-3">
													{{Form::label('Código')}} <br>
													{{$sale->code}} 
												</div>

												<div class="col-sm-12 sol-md-3 col-lg-3">
													{{Form::label('Fecha')}} <br>
													{{$sale->date}} 
												</div>
											</div>
											
											<br>

											<div class="row">
												<div class="col-sm-12 sol-md-6 col-lg-6">
													{{Form::label('Cliente')}} <br>
													{{$sale->client->name}} 
												</div>

												<div class="col-sm-12 sol-md-6 col-lg-6">
													{{Form::label('Vendedor')}} <br>
													{{$sale->user->name}} 
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
														
														@foreach ($sale->sale_details as $key => $sale_detail)
														
															<tr>
																<td>{{$key+1}}</td>
																<td>{{$sale_detail->product->name}}</td>
																<td>{{$sale_detail->price}}</td>
																<td>{{$sale_detail->qty}}</td>
																<td>{{$sale_detail->subtotal}}</td>
															</tr>
															
														@endforeach
														
													</table>
											</div>

											<div class="row">
												<div class="pull-right">
													<b>Subtotal: </b> {{ $sale->subtotal }} <br>

													<b>Impuesto: </b> {{ $sale->tax }} <br>
															
													<b>Descuento: </b> {{ $sale->discount }}<br>
															
													<b>Total: </b> {{ $sale->total }}
												</div>
											</div>
										</div>

										<div class="col-sm-12 col-md-4 col-lg-4">
											<!--  Credit Info -->

											<div class="row">

												<div class="col-md-12 @if($errors->has('advance')) has-error @endif">
													<div class="form-group">
														{{ Form::label('Anticipo') }}
														
														{{ Form::text('advance', null, ['class' => 'form-control', 'id' => 'advance','placeholder' => 
															$credit_advance . ' Mínimo de Anticipo'
														]) }}

														@if($errors->has('advance'))
															<span class="help-block">(*) {{$errors->first('advance')}}</span>
														@endif

														<span class="help-block advance" style="display: none">(*) El avance debe ser mayor o igual a: {{$credit_advance}}</span>
													</div>
												</div>
											</div>
											
											<div class="row">

												<div class="col-md-12 @if($errors->has('fees')) has-error @endif">
													<div class="form-group">
														{{ Form::label('Cuotas') }}
														
														{{ Form::text('fees', null, ['class' => 'form-control', 'id' =>'fees' ,'placeholder' => $max_fees.' Cuotas Máximas' ]) }}

														@if($errors->has('fees'))
															<span class="help-block">(*) {{$errors->first('fees')}}</span>
														@endif

														<span class="help-block fees" style="display: none">(*) La cantidad máxima de cuotas es de: {{$max_fees}}</span>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-md-12 @if($errors->has('interest')) has-error @endif">
													<div class="form-group">
														{{ Form::label('Interes') }}
														
														
														{{ Form::text('interest', null, ['class' => 'form-control', 'id' => 'interest','placeholder' => $interest.' % Mínimo de Interes']) }}

														@if($errors->has('interest'))
															<span class="help-block">(*) {{$errors->first('interest')}}</span>
														@endif

														<span class="help-block interest">(*) El interes debe ser igual al: {{$interest}} %</span>
													</div>
												</div>
											</div>


											<div class="row">
												<div class="col-md-12 @if($errors->has('amount')) has-error @endif">
													<div class="form-group">
														{{ Form::label('Total a Pagar') }}
														
														
														{{ Form::text('amount', null, ['class' => 'form-control', 'id' => 'amount']) }}

														@if($errors->has('amount'))
															<span class="help-block">(*) {{$errors->first('amount')}}</span>
														@endif

														
													</div>
												</div>
											</div>


											<div class="row">
												<div class="col-md-12 @if($errors->has('interest_expired')) has-error @endif">
													<div class="form-group">
														{{ Form::label('Interes por cuotas vencidas') }}
														
														
														{{ Form::text('interest_expired', null, ['class' => 'form-control','placeholder' => ' %']) }}

														@if($errors->has('interest_expired'))
															<span class="help-block">(*) {{$errors->first('interest_expired')}}</span>
														@endif

														
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
						</div>
						</li>
					</ul>
		       	</div> <!-- timeline-body -->
		            
		    </div>
			</div> <!-- user-block-->
        </div>
                <!-- /.post -->
            </div>
              <!-- /.Datos Personales -->
			          
            
            <!-- /.tab-pane -->

        </div>
	</div> <!-- nav-tabs-->


	<div class="row">
		<div class="col-md-2">					
			<div class="form-group">
				{{ Form::submit('Guardar', ['class' => 'btn btn-success']) }}
			</div>

		</div>
	</div>

</div>

@section('js')

	<script>

		var	advance = {!! json_encode($credit_advance) !!}
		var fees 	= {!! json_encode($max_fees) !!}
		var interest 	= {!! json_encode($interest) !!}
		var total = {!! json_encode($sale->total) !!}

		var amount = 0;

		$(document).ready(function(){

			$('#advance').keyup(function(event) {
				
				event.preventDefault();
				$('span.advance').css('display', 'none');;
				
				if ($('#advance').val() < advance) {
					$('span.advance').css('display', 'block');
				}
			});


			$('#fees').keyup(function(event) {
				
				event.preventDefault();
				$('span.fees').css('display', 'none');;
				
				if ($('#fees').val() > fees) {
					$('span.fees').css('display', 'block');
				}
			});


			$('#interest').keyup(function(event) {
				
				event.preventDefault();
				$('span.interest').css('display', 'none');;
				
				if ($('#interest').val() < interest) {
					$('span.interest').css('display', 'block');
				}
			});

			$('#interest').keyup(function(event) {
				amount = parseFloat(total)  + parseFloat((total * $('#interest').val())/100);
				$('#amount').attr({
					value: amount,
					default: amount
				});
				
				
			});

				



		});

	</script>

@stop