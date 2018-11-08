@php
	$subtotal = 0;

	$sale->sale_details->each(function ($detail) use (&$subtotal) {
		$subtotal += $detail->subtotal;
	});
@endphp
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Remito</title>
		<style type="text/css">
			* {
				font-size: 12px;
				font-family: Arial, Helvetica, Verdana, Georgia, Cambria, Times, "Times New Roman";
			}
			table {
				border: 1px solid black;
			}

			.celdas td {
				border: 1px solid black;
				text-align: center;
			}

			small {
				font-size: 12px;
			}

			img {
				width: 150px;
			}
		</style>
	</head>
	<body>
		<table width="100%">
			<tr>
				<td rowspan="5" style="width: 20%;">
					<img src="../public/img/logo_verde.png">
				</td>
				<td rowspan="2">
					<h3>Be.Muebles</h3>
				</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Fecha de Emision:</td>
				<td>{{ Carbon\Carbon::now()->format('d/m/Y H:i') }}</td>
			</tr>
			<tr>
				<td>Roque Seaz Peña 198</td>
				<td>CUIT:</td>
				<td>23311913689</td>
			</tr>
			<tr>
				<td>Bs. As. Ezeiza Tristan Suarez</td>
				<td>IIBB:</td>
				<td>23311913689</td>
			</tr>
			<tr>
				<td>Tel: 4880-1079/1528786438 <br> WWW.BE-MUEBLES.COM</td>
				<td>Fecha de inicio de actividad:</td>
				<td>20/02/2010</td>
			</tr>
		</table>
		<br>
		<table width="100%">
			<tr>
				<td>DNI:</td>
				<td colspan="2">{{ $sale->client->dni }}</td>
				<td>Nombre y Apellido:</td>
				<td colspan="2">{{ $sale->client->name }}</td>
			</tr>
			<tr>
				<td>Condicion de venta:</td>
				<td colspan="2" >{{ $payment->way_to_pay_string }}</td>
				<td></td>
				<td colspan="2"></td>
			</tr>
			<tr>
				<td></td>
				<td>Direccion:</td>
				<td colspan="2">{{ $sale->client->profile->address }}</td>
			</tr>
		</table>
		<table class="celdas" width="100%" cellspacing="0" style="margin-top: -1px;">
			<tr>
				<td>Código</td>
				<td>Producto</td>
				<td>Cantidad</td>
				<td>P. Unidad</td>
				<td></td>
				<td>Bonif.</td>
				<td>Subtotal</td>
			</tr>
			@foreach ($sale->sale_details as $detail)
				<tr>
					<td>{{ $detail->product->reference }}</td>
					<td>{{ $detail->product->name }}</td>
					<td>{{ $detail->qty }}</td>
					<td>{{ number_format($detail->price, 0, ',', '.') }}</td>
					<td></td>
					<td>{{ number_format($detail->amount_discount, 0, ',', '.') }}</td>
					<td>{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
				</tr>
			@endforeach
			<tr>
				<td>Observacion:</td>
				<td colspan="6">
					{{ $sale->observations }}
				</td>
			</tr>
			<tr>
				<td colspan="6" style="text-align: right;">
					SUBTOTAL:
				</td>
				<td>{{ number_format($subtotal, 0, ',', '.') }}</td>
			</tr>
			<tr>
				<td colspan="6" style="text-align: right;">
					IMPORTE TOTAL:
				</td>
				<td>{{ number_format($sale->total, 0, ',', '.') }}</td>
			</tr>
		</table>
		<br>
		<table width="100%">
			<tr>
				<td>
					<small>
						Presupuesto Autorizado Por BEMUEBLES. Valido como comprobante de compra para el establecimiento.<br>
						Todo los productos tienen cambio a las 72Hs de aver emitido dicho comprobante. Los plazos de grantia pasada las 72Hs tiene un plazo de 90 dias. Daños realizados por mal uso quedan fuera de garantia oficial. (Comprobante NO valido como factura).
					</small>
				</td>
			</tr>
		</table>
	</body>
</html>