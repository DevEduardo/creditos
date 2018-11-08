@php
	$date_credit = null;

	if(!empty($credit->date_advance_I)){
		$date_credit = $credit->date_advance_I->format('d-m-Y');
	} else {
		$date_credit = $credit->credit_details->first()->fee_date_expired->format('d-m-Y');
	}
@endphp
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Orden de Salida</title>
		<style>
			* {
				font-size: 12px;
				font-family: Arial, Helvetica, Verdana, Georgia, Cambria, Times, "Times New Roman";
			}

			.page-break {
			    page-break-after: always;
			}
		</style>
	</head>
	<body>
		@php
			$i = 0;
		@endphp
		<div style="font-size: 12.5px !important;">
			@foreach($credit->sale->sale_details as $item)
				<table width="100%">
					<tr>
						<td width="20%">{{ $item->product->code }}</td>
						<td>{{ $credit->string_way_to_pay }}</td>
					</tr>
				</table>
				<p style="text-align: right;">
					{{ $date_credit }}
				</p>
				<table width="100%">
					<tr>
						<td>NOMBRE Y APELLIDO:</td>
						<td colspan="3">{{ $credit->sale->client->name }}</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td>CUENTA N°:</td>
						<td></td>
					</tr>
					<tr>
						<td>BARRIO:</td>
						<td>{{ $credit->sale->client->profile->district }}</td>
						<td>CREDITO:</td>
						<td></td>
					</tr>
					<tr>
						<td>DIRECCION:</td>
						<td colspan="3">{{ $credit->sale->client->profile->address }}</td>
					</tr>
					<tr>
						<td>ENTRECALLES:</td>
						<td colspan="3">{{ $credit->sale->client->profile->between_street }}</td>
					</tr>
				</table>
				<p style="text-align: right;">
					ORDEN<br>
					<b>00-00</b>
				</p>
				<table width="100%">
					<tr>
						<td>MARCA:</td>
						<td></td>
						<td>TALON:</td>
						<td></td>
					</tr>
					<tr>
						<td>CODIGO:</td>
						<td colspan="3">{{ $item->product->reference }}</td>
					</tr>
					<tr>
						<td>PRODUCTO:</td>
						<td>{{ $item->product->name }}</td>
						<td>CANTIDAD:</td>
						<td>{{ $item->qty }}</td>
					</tr>
					<tr>
						<td>DESCRIPCIÓN:</td>
						<td colspan="3">{{ $item->product->description }}</td>
					</tr>
					<tr>
						<td>COLOR:</td>
						<td>
							{{ $item->product->color }}
						</td>
						<td>STOCK:</td>
						<td></td>
					</tr>
					<tr>
						<td>MODELO:</td>
						<td colspan="3"></td>
					</tr>
				</table>
				<p style="text-align: center;">
					<b>CODIGO UNICO COMERCIAL</b> {{ $item->product->code }}
				</p>
				<p style="text-align: justify;">
					DNI:____________________<br><br>
					FIRMAS:____________________<br><br>
					ACLARACIÓN:____________________
				</p>

				@php
					$i ++;
				@endphp
				@if(($i%2) == 0 && ($credit->sale->sale_details->last()->id != $item->id))
					<div class="page-break"></div>
				@endif
			@endforeach
		</div>
	</body>
</html>