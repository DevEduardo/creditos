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
			.pagare{font-size: 20!important;}
			.name{text-transform: uppercase;}
			.page-break {
			    page-break-after: always;
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
		<div style="font-size: 12px !important;">
			<table class="left" width="50%" cellspacing="0" cellpadding="0" >
				<tr>
					<td class="">BEMUEBLES</td>
					<td></td>
					<td class="text-center">{{$date}}</td>
					<td>*</td>
				</tr>
				<tr>
					<td></td>
					<td>RESERVA</td>
					<td></td>
					<td>*</td>
				</tr>
				<tr>
					<td><br><br></td>
					<td></td>
					<td></td>
					<td>*</td>
				</tr>
				<tr>
					<td>NOMBRES Y APELLIDOS</td>
					<td colspan="2">{{$sale->client->name}}</td>
					<td>*</td>
				</tr>
				<tr>
					<td>DNI</td>
					<td colspan="2">{{$sale->client->dni}}</td>
					<td>*</td>
				</tr>
				<tr>
					<td>DIRECCION</td>
					<td colspan="2">{{$sale->client->profile->address}} {{$sale->client->profile->between_street}}</td>
					<td>*</td>
				</tr>
				<tr>
					<td>TELEFONOS</td>
					<td colspan="2">
					@foreach($sale->client->phone1 as $phone)
					    {{ $phone['phone'] }}
                    @endforeach
					</td>
					<td>*</td>
				</tr>
				<tr><td colspan="3"><hr></td><td>*</td></tr>
				<tr>
					<td>PRESIO DE LISA</td>
					<td colspan="2">{{$sale->total}}</td>
					<td>*</td>
				</tr>
				<tr>
					<td>RESERBA</td>
					<td colspan="2">{{$sale->credit->advance_I}}</td>
					<td>*</td>
				</tr>
				<tr>
					<td>SALDO RESTANTE</td>
					<td colspan="2">{{$sale->total - $sale->credit->advance_I}}</td>
					<td>*</td>
				</tr>
				<tr><td colspan="3"><hr></td><td>*</td></tr>
				@foreach($sale->sale_details as $product)
				<tr>
					<td>CODIGO</td>
					<td colspan="2">{{$product->product->code}}</td>
					<td>*</td>
				</tr>
				<tr>
					<td>MODELO</td>
					<td colspan="2">{{$product->product->model}}</td>
					<td>*</td>
				</tr>
				<tr>
					<td>PRODUCTO</td>
					<td colspan="2">{{$product->product->name}}</td>
					<td>*</td>
				</tr>
				<tr>
					<td>DESCRIPCION</td>
					<td colspan="2">{{$product->product->description}}</td>
					<td>*</td>
				</tr>
				<tr>
					<td colspan="3"><br></td>
					<td>*</td>
				</tr>
				@endforeach
				<tr>
					<td colspan="3" style="font-size: 11px !important;">EL PRODUCO A ADQUIRIR TEDNDRA UNA RESERVA DE 60 DIAS</td>
					<td>*</td>
				</tr>
				<tr>
					<td colspan="3" style="font-size: 11px !important;">(SESENTA) A PARIR DE LA FECHA PARA LA CANSELACION DE LO</td>
					<td>*</td>
				</tr>
				<tr>
					<td colspan="3" style="font-size: 11px !important;">CONTRARIO PODRA SUFRIR MODIFICASIONES EN EL VALOR SIN</td>
					<td>*</td>
				</tr>
				<tr>
					<td colspan="3" style="font-size: 11px !important;">PREVIO AVISO I UNA DEMORA DE 30 DIAS (TREINTA) PARA SU </td>
					<td>*</td>
				</tr>
				<tr>
					<td colspan="3" style="font-size: 11px !important;">ENREGA</td>
					<td>*</td>
				</tr>
				<tr>
					<td colspan="3"><br><br></td>
					<td>*</td>
				</tr>
				<tr>
					<td class="text-center">FIRMA</td>
					<td class="text-center">ACLARACION</td>
					<td class="text-center">DNI</td>
					<td>*</td>
				</tr>
				<tr>
					<td colspan="3"><br></td>
					<td>*</td>
				</tr>
				<tr>
					<td class="text-center">_________________</td>
					<td class="text-center">_________________</td>
					<td class="text-center">_________________</td>
					<td>*</td>
				</tr>
			</table>
			<table class="right" width="50%" cellspacing="0" cellpadding="0" >
				<tr>
					<td class="">BEMUEBLES</td>
					<td></td>
					<td class="text-center">{{$date}}</td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td>RESERVA</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td><br><br></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>NOMBRES Y APELLIDOS</td>
					<td colspan="2">{{$sale->client->name}}</td>
					<td></td>
				</tr>
				<tr>
					<td>DNI</td>
					<td colspan="2">{{$sale->client->dni}}</td>
					<td></td>
				</tr>
				<tr>
					<td>DIRECCION</td>
					<td colspan="2">{{$sale->client->profile->address}} {{$sale->client->profile->between_street}}</td>
					<td></td>
				</tr>
				<tr>
					<td>TELEFONOS</td>
					<td colspan="2">
					@foreach($sale->client->phone1 as $phone)
					    {{ $phone['phone'] }}
                    @endforeach
					</td>
					<td></td>
				</tr>
				<tr><td colspan="3"><hr></td><td>*</td></tr>
				<tr>
					<td>PRESIO DE LISA</td>
					<td colspan="2">{{$sale->total}}</td>
					<td></td>
				</tr>
				<tr>
					<td>RESERBA</td>
					<td colspan="2">{{$sale->credit->advance_I}}</td>
					<td></td>
				</tr>
				<tr>
					<td>SALDO RESTANTE</td>
					<td colspan="2">{{$sale->total - $sale->credit->advance_I}}</td>
					<td></td>
				</tr>
				<tr><td colspan="3"><hr></td><td>*</td></tr>
				@foreach($sale->sale_details as $product)
				<tr>
					<td>CODIGO</td>
					<td colspan="2">{{$product->product->code}}</td>
					<td></td>
				</tr>
				<tr>
					<td>MODELO</td>
					<td colspan="2">{{$product->product->model}}</td>
					<td></td>
				</tr>
				<tr>
					<td>PRODUCTO</td>
					<td colspan="2">{{$product->product->name}}</td>
					<td></td>
				</tr>
				<tr>
					<td>DESCRIPCION</td>
					<td colspan="2">{{$product->product->description}}</td>
					<td></td>
				</tr>
				<tr>
					<td colspan="3"><br></td>
					<td></td>
				</tr>
				@endforeach
				<tr>
					<td colspan="3" style="font-size: 11px !important;">EL PRODUCO A ADQUIRIR TEDNDRA UNA RESERVA DE 60 DIAS</td>
					<td></td>
				</tr>
				<tr>
					<td colspan="3" style="font-size: 11px !important;">(SESENTA) A PARIR DE LA FECHA PARA LA CANSELACION DE LO</td>
					<td></td>
				</tr>
				<tr>
					<td colspan="3" style="font-size: 11px !important;">CONTRARIO PODRA SUFRIR MODIFICASIONES EN EL VALOR SIN</td>
					<td></td>
				</tr>
				<tr>
					<td colspan="3" style="font-size: 11px !important;">PREVIO AVISO I UNA DEMORA DE 30 DIAS (TREINTA) PARA SU </td>
					<td></td>
				</tr>
				<tr>
					<td colspan="3" style="font-size: 11px !important;">ENREGA</td>
					<td></td>
				</tr>
				<tr>
					<td colspan="3"><br><br></td>
					<td></td>
				</tr>
				<tr>
					<td class="text-center">FIRMA</td>
					<td class="text-center">ACLARACION</td>
					<td class="text-center">DNI</td>
					<td></td>
				</tr>
				<tr>
					<td colspan="3"><br></td>
					<td></td>
				</tr>
				<tr>
					<td class="text-center">_________________</td>
					<td class="text-center">_________________</td>
					<td class="text-center">_________________</td>
					<td></td>
				</tr>
			</table>
		</div>
	</body>
</html>