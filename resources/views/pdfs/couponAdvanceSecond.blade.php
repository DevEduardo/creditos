<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Cupon de pago</title>
		<style>
			* {
				font-size: 12px;
				font-family: Arial, Helvetica, Verdana, Georgia, Cambria, Times, "Times New Roman";
			}
			.celdas{
				border: 1px solid black;
				text-align: center;
			}
			.celdas2{
				border: 1px solid black;
				text-align: center;
			}
			.page-break {
			    page-break-after: always;
			}

			.left{float: left;}
			.right{float: right;}

			.mr-5{margin-right: 5%}
			.mr-10{margin-right: 10%}
			.mr-15{margin-right: 15%}
			.mr-20{margin-right: 20%}

			.text-uppercase{text-transform: uppercase;}
			.text-left{text-align: left;}
			.text-right{text-align: right;}
			.text-center{text-align: center;}
		</style>
	</head>
	<body>
		<div style="font-size: 12.5px !important;">
			<table class="left" width="50%" cellspacing="0" cellpadding="0" >
				<tr>
					<td><span class="left">FIEDBA S.A.S</span> <span class="right">* PARCIAL *</span></td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-center">Cupon de Pago</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td><hr></td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-center">No {{ $code }}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-center">777-1 - BE-MUEBLERIA</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td><hr></td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-uppercase">{{ $data->sale->client->dni }}-{{ $data->sale->client->name }}<span class="right">* PARCIAL *</span></td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-uppercase">{{$data->sale->client->profile->between_street}}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-uppercase">({{$data->sale->client->profile->postal_code}})-{{$data->sale->client->profile->address}} - {{$data->sale->client->profile->district}}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-uppercase">Crédito: {{ $data->id }}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-uppercase">Vencim: {{ $data->date_advance_II->addDays(60)->format('d-m-Y') }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; F.Pago: {{ $data->date_advance_II->format('d-m-Y') }}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td><hr></td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-uppercase text-center">Cuota:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $data->advance_II }}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-uppercase text-center">Punitorios:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $punitorios }}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-uppercase text-center">Total:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $total }}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-uppercase text-center">Resta: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $data->sale->total - ($data->advance_II + $data->advance_I ) }}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td><hr></td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td>Son $: {{ $quantity }}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td><hr></td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td><b><br>ATENCION:</b><br> Su pago en termino evita la adicion de intereses punitorios y gastos a la/s cuota/s.</td>
				</tr>
			</table>

			<table class="right" width="50%" cellspacing="0" cellpadding="0" >
				<tr>
					<td><span class="left">FIEDBA S.A.S</span> <span class="right">* PARCIAL *</span></td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-center">Cupon de Pago</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td><hr></td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-center">No {{ $code }}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-center">777-1 - BE-MUEBLERIA</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td><hr></td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-uppercase">{{ $data->sale->client->dni }}-{{ $data->sale->client->name }}<span class="right">* PARCIAL *</span></td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-uppercase">{{$data->sale->client->profile->between_street}}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-uppercase">({{$data->sale->client->profile->postal_code}})-{{$data->sale->client->profile->address}} - {{$data->sale->client->profile->district}}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-uppercase">Crédito: {{ $data->id }}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-uppercase">Vencim: {{ $data->date_advance_II->addDays(60)->format('d-m-Y') }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; F.Pago: {{ $data->date_advance_II->format('d-m-Y') }}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td><hr></td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-uppercase text-center">Cuota:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $data->advance_II }}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-uppercase text-center">Punitorios:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $punitorios }}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-uppercase text-center">Total:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $total }}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-uppercase text-center">Resta: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $data->sale->total - ($data->advance_II + $data->advance_I ) }}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td><hr></td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td>Son $: {{ $quantity }}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td><hr></td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td><b><br>ATENCION:</b><br> Su pago en termino evita la adicion de intereses punitorios y gastos a la/s cuota/s.</td>
				</tr>
			</table>
		</div>
	</body>
</html>