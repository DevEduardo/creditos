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
					<td class="text-center">No {{$dataCoupon->coupon}}</td>
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
					<td class="text-uppercase">{{$dataCoupon->clientID}}-{{$dataCoupon->dni}}-{{$dataCoupon->name}}<span class="right">* PARCIAL *</span></td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-uppercase">{{$dataCoupon->between_street}}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-uppercase">({{$dataCoupon->postal_code}})-{{$dataCoupon->address}} - {{$dataCoupon->district}}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-uppercase">Crédito: {{$dataCoupon->creditID}}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-uppercase">Vencim: {{$dataCoupon->created_at->addDays(60)->format('d-m-Y')}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; F.Pago: {{$dataCoupon->fee_date->format('d-m-Y')}}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td><hr></td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-uppercase text-center">Cuota:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{$feeAmount}}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-uppercase text-center">Punitorios:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{$punitorios}}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-uppercase text-center">Total:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{$total}}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-uppercase text-center">Resta: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $resta }}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td><hr></td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td>Son $: {{$quantity}}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td><hr></td>
					<td class="text-center">*</td>
				</tr>
			</table>

			<table class="right" width="50%" cellspacing="0" cellpadding="0" >
				<tr>
					<td><span >FIEDBA S.A.S</span> <span class="right">* PARCIAL *</span></td>
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
					<td class="text-center">No {{$dataCoupon->coupon}}</td>
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
					<td class="text-uppercase">{{$dataCoupon->clientID}}-{{$dataCoupon->dni}}-{{$dataCoupon->name}}<span class="right">* PARCIAL *</span></td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-uppercase">{{$dataCoupon->between_street}}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-uppercase">({{$dataCoupon->postal_code}})-{{$dataCoupon->address}} - {{$dataCoupon->district}}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-uppercase">Crédito: {{$dataCoupon->creditID}}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-uppercase">Vencim: {{$dataCoupon->created_at->addDays(60)->format('d-m-Y')}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; F.Pago: {{$dataCoupon->fee_date->format('d-m-Y')}}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td><hr></td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-uppercase text-center">Cuota:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{$feeAmount}}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-uppercase text-center">Punitorios:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{$punitorios}}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-uppercase text-center">Total:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{$total}}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td class="text-uppercase text-center">Resta: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $resta }}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td><hr></td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td>Son $: {{$quantity}}</td>
					<td class="text-center">*</td>
				</tr>
				<tr>
					<td><hr></td>
					<td class="text-center">*</td>
				</tr>
			</table>
		</div>
	</body>
</html>