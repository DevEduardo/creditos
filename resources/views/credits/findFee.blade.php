@extends('adminlte::page')

@section('content')

	{{ Form::open(['route' => ['payFee']]) }}

		{{ Form::token() }}

		<div class="container-fluid">
			<h4 class="text-center text-bold"> Detalles de la Cuota </h4>
			
			<div class="row">
				
				<div class="col-md-4">
					<h5>
						<a href="{{route('credits.show', $fee->credit->sale->id)}}">
							<b> Número de Crédito: </b>  <br>
							{{$fee->credit->sale->id}} 
						</a>
					</h5>
				</div>

				<div class="col-md-4">
					<h5>
						<b>Número de Cuota:</b>  <br> {{$fee->fee_number}}
					</h5>
				</div>

				<div class="col-md-4">
					<h5>
						<b>Monto de Cuota:</b> <br> {{number_format($fee->fee_amount,2,',','.')}}
					</h5>
				</div>
					
			</div>
						
			
			<div class="row">
				
				<div class="col-md-4">
					<h5>
						<b>Fecha de Pago de Cuota:</b> <br> {{$fee->fee_date}}
					</h5>
				</div>
				
				<div class="col-md-4">
					<h5>
						<b>Fecha de Vencimiento de Cuota:</b> <br> {{$fee->fee_date_expired}}
					</h5>
				</div>

				<div class="col-md-4">
					<h5>
						<b>Días de atraso en pago:</b> {{$fee->days_expired}}
					</h5>
				</div>	
			</div>


			<div class="row">
				
				<div class="col-md-4">
					<h5>
						<b>Porcentaje Interes cuota atrasada:</b> <br> {{$fee->credit->interest_expired}} %
					</h5>
				</div>
				
				
			</div>
		
			<div class="row">
				
				<div class="col-md-4 @if($errors->has('name')) has-error @endif">

					<div class="form-group">
					
						{{ Form::label('Monto a Pagar') }}
						@if($fee->is_expired == 1)
							{{ Form::text('payment', round($amount), ['class' => 'form-control', 'id' => 'payment']) }}
						@else
							{{ Form::text('payment', round(($fee->real_amount - $fee->payment)), ['class' => 'form-control', 'id' => 'payment']) }}
						@endif
				
                        {!! Form::label('way_to_pay', 'Seleccione forma de pago de la cuota:') !!}
                        {!! Form::select('way_to_pay', [
                            'cash' => 'Efectivo', 
                            'card' => 'Tarjeta'
                        ], null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opción', 'required']) !!}

						{{Form::hidden('fee_id', $fee->id)}}

						@if($errors->has('name'))
							<span class="help-block">(*) {{$errors->first('name')}}</span>
						@endif
						
						<span class="help-block payment" style="display: none">(*) El monto a cancelar debe ser mayor o igual a: {{ ($fee->real_amount - $fee->payment) }} </span>

					</div>

				</div>

				{{--<div class="col-md-4 @if($errors->has('payment_method')) has-error @endif">

					<div class="form-group">
					
						{{ Form::label('Método de Pago') }}

						{{ Form::select('payment_method_id', $payment_methods, null, ['class' => 'form-control']) }}

						
						@if($errors->has('payment_method'))
							<span class="help-block">(*) {{$errors->first('payment_method')}}</span>
						@endif

					</div>

				</div>--}}
			</div>

			<div class="row">
					
				<div class="col-md-2">
					<div class="form-group">

						{{ Form::submit('Registrar pago', ['class' => 'btn btn-success']) }}
				
					</div>
				</div>

			</div>
		</div>

	{{ Form::close() }}
	
@stop


@section('js')
	
	<script>

		var payment = {!! json_encode(($fee->real_amount - $fee->payment)) !!}
		
		/*$(document).ready(function(){

			$('#payment').keyup(function(event) {

				event.preventDefault();

				$('span.payment').css('display', 'none');
				
				if ($('#payment').val() < payment) {
					$('span.payment').css('display', 'block');
				}

			});
		});*/

	</script>

@stop