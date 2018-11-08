@extends('adminlte::page')

@section('css')
	<style type="text/css">
		#multi-pay-btn {
			position: absolute;
			top: 6.5%;
			right: 40%;
		}
	</style>
@endsection


@section('content')
	<div class="row">
		<div class="col-md-12">
			<h4>Datos del Cliente</h4>
		</div>
	</div>
    <div class="row">
    	<div class="col-md-6">
    		<p class="text-justify">
    			<strong>DNI: </strong> {{ $client->dni }}<br>
    			<strong>Nombre:</strong> {{ $client->name }}<br>
    			<strong>E-mail:</strong> {{ $client->profile->email }}
    		</p>
    	</div>
    </div>
    <hr>
    <div class="row">
		<div class="col-md-12">
			<h4>Creditos del Cliente</h4>
		</div>
	</div>
	@foreach($credits as $credit)
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-5">
						<h4 class="text-justify">
							<strong>N° de credito: </strong> {{ $credit->id }} <br>
							<strong>Productos: </strong>
							@foreach($credit->sale->sale_details as $detail)
								{{ $detail->product->name }} -
							@endforeach
						</h4>
					</div>
					<div class="col-md-4">
						@if(! $credit->is_payed)
							<div class="form-group">
								{!! Form::label('amount['.$credit->id.']', 'Monto a pagar:') !!}
								{!! Form::text('amount['.$credit->id.']', null, ['class' => 'form-control input-amount', 'multiple', 'pattern' => '[0-9]{1,999999}']) !!}
							</div>
						@else
							<p class="text-center">
								<strong>Credito Pagado</strong>
							</p>
						@endif
					</div>
					<div class="col-md-3">
						<a href="{{ route("credits.show", $credit->id) }}" class="btn btn-primary btn-sm">
							Ver Detalles
						</a>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
						    <table class="table table-striped table-hover datatable" class="display" cellspacing="0" width="100%">
						    	<thead>
						    		<tr>
										<th>N° Cuota</th>
										<th>Fecha de pago</th>
										<th>Monto de la cuota</th>
										<th>Monto pagado</th>
										<th>Por pagar</th>
										<th>Fecha de expiración</th>
										<th>Días de retraso</th>
										<th>Interest a la fecha</th>
										<th>Pagada</th>
										<th>Vencida</th>
										<th></th>
						    		</tr>
						    	</thead>
						    	<tbody>
									@php
										$preview = true;
									@endphp

									@if($credit->type == 'two_advance')
									    <tr>
									        <td> 00 </td>
									        <td>
									            @empty ($credit->date_advance_II)
									                -
									            @else
									                {{ $credit->date_advance_II->format('d-m-Y') }}
									            @endempty
									        </td>
									        <td>{{ number_format($credit->advance_I, 0, ',', '.') }}</td>
									        <td>{{ number_format($credit->advance_II, 0, ',', '.') }}</td>
									        <td>
									            {{ number_format(($credit->advance_I - $credit->advance_II), 0, ',', '.') }} 
									        </td>
									        <td>{{ $credit->date_advance_I->addDays(10)->format('d-m-Y') }}</td>
									        @if(\Carbon\Carbon::now() > $credit->date_advance_I->addDays(10))
									            <td>{{ \Carbon\Carbon::now()->diffInDays($credit->date_advance_I->addDays(10)) }}</td>
									        @else
									            <td> 0 </td>
									        @endif
									        <td>
									        	-
									        </td>
									        <td> 
									            @if(($credit->advance_I - $credit->advance_II) == 0) Si @else No @endif
									        </td>
									        <td> @if(\Carbon\Carbon::now() > $credit->date_advance_I->addDays(10)) Si @else No @endif </td>
									        <td>
									            @if(($credit->advance_I - $credit->advance_II) == 0) <center>-</center> @else <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#secondModal" data-placement="top" title="Pagar segundo avance" @if(($credit->advance_I - $credit->advance_II) == 0) disabled @endif> <i class="fa fa-usd"></i></a> @endif
									        </td>
									    </tr>
									    @php
								            if (($credit->advance_I - $credit->advance_II) != 0) {
								                $preview = false;
								            }
									    @endphp
									@endif

									@foreach ($credit->credit_details as $credit_detail)
										<tr>
											<td>{{$credit_detail->fee_number}}</td>
											<td>@if(!empty($credit_detail->fee_date)) {{ $credit_detail->fee_date->format('d-m-Y') }} @endif </td>
											<td>{{ number_format($credit_detail->fee_amount, 0,',','.') }}</td>
											<td>{{ number_format($credit_detail->payment, 0,',','.') }}</td>
											<td>{{ number_format($credit_detail->fee_amount - $credit_detail->payment, 0,',','.') }}</td>
											<td>{{ $credit_detail->fee_date_expired->format('d-m-Y') }}</td>
											<td>{{$credit_detail->days_expired}}</td>
											<td>{{ number_format($credit_detail->interest, 2, ',', '.') }}</td>
											<td @if($credit_detail->is_payed) class="bg-green" @endif>
												@if($credit_detail->is_payed)
													Si
												@else
													No
												@endif
											</td>
											<td @if(!$credit_detail->is_payed && $credit_detail->is_expired) class="bg-red" @endif>
												@if($credit_detail->is_expired)
													Si
												@else
													No
												@endif
											</td>
											<td> 
												@if($preview)
													@if($credit_detail->is_payed == 1)
														<center><a href="{{route('coupon', $credit_detail->id)}}" target="blanck" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Cupon de pago" > <i class="fa fa-file-pdf-o"></i></a></center>
													@else  
														@if($credit_detail->payment > 0)
														<a href="{{route('coupon', $credit_detail->id)}}" target="blanck" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Cupon de pago" > <i class="fa fa-file-pdf-o"></i></a>
														@endif
														<a href="{{route('findFee', $credit_detail->id)}}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Pagar" @if($credit_detail->is_payed == 1) disabled @endif> <i class="fa fa-usd"></i></a>
													@endif 
												@else
													<center>-</center>
												@endif

												@if($credit_detail->is_payed == 1)
													@php
														$preview = true;
													@endphp
												@else
													@php
														$preview = false;
													@endphp
												@endif
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>	
					</div>
				</div>
			</div>
		</div>
		<hr>
	@endforeach
	
	<button id="multi-pay-btn" type="button" class="btn btn-success">
		Pagar
	</button>

<div class="modal fade" id="multiPayFormModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			{!! Form::open(['route' => 'credit.multi.pay','method' => 'POST']) !!}
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Preview del Pago</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					{!! Form::label('preview', 'Monto Total a Pagar:') !!}
					{!! Form::text('preview', null, ['class' => 'form-control', 'readonly']) !!}
				</div>
				<div class="form-group">
					{!! Form::label('way_to_pay', 'Seleccione forma de pago') !!}
					{!! Form::select('way_to_pay', [
					    'cash' => 'Efectivo', 
					    'card' => 'Tarjeta'
					], null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opción', 'required']) !!}
				</div>
				<div class="hide"></div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success">Pagar</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@stop

@section('js')
    @parent
	
    <script type="text/javascript">
        $(document).ready(function() {
        	check_input_amount();

            $('.datatable').DataTable({
                "language": {
					"lengthMenu": "Ver _MENU_ registros por página",
					"zeroRecords": "No se encontraron resultados",
					"info": "Viendo la página _PAGE_ de _PAGES_",
					"infoEmpty": "No hay información",
					"search": " Buscar: ",
					"paginate": {
						"previous": "Anterior",
						"next": "Proximo"
					},
                },
                "pageLength": 50
            });

            $('input.input-amount').on('keyup', function() {
            	check_input_amount();
            });

            $('#multi-pay-btn').on('click', function() {
            	clone_inputs();
            	$('#multiPayFormModal').modal('show');
            });

            /**
             * Chequea el monto en los campos de pago de cada credito
             * 
             * @return void
             */
            function check_input_amount() {
            	var sum = 0;
            	var inputs = $('div.row').find('input.input-amount');

            	inputs.each(function(index, el) {
            		
            		if(! isNaN(el.value) && el.value.length > 0){
            			sum += parseInt(el.value);
            		}
            	});

            	if (sum > 0) {
            		$('#multi-pay-btn').removeClass('hide');

            		$('input[name="preview"]').val(sum);
            	} else {
            		$('#multi-pay-btn').addClass('hide');
            	}
            }

            $('#multiPayFormModal').on('hide.bs.modal', function(e){
            	check_input_amount();

            	$(this).find('form div.hide').html('');
            });

            /**
             * Clona los inputs con montos y los inserta dentro del fromulario del modal
             * 
             * @return void
             */
            function clone_inputs() {
            	var modalForm = $('#multiPayFormModal form');
            	var inputs = $('div.row').find('input.input-amount');

            	inputs.each(function(index, el) {
            		if (parseInt(el.value) > 0) {
            			$(modalForm).find('div.hide').append($(el).clone());
            		}
            	});
            }
        });
    </script>
@endsection