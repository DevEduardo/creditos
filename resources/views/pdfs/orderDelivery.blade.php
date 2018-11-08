<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Orden de Despacho</title>
		<style>
		* {
				font-size: 12px;
				font-family: Arial, Helvetica, Verdana, Georgia, Cambria, Times, "Times New Roman";
			}
			table {
				border: 1px solid black;
			}
			.celdas{
				border: 1px solid black;
				text-align: center;
			}
			.celdas2{
				border: 1px solid black;
				text-align: center;
			}
			* {
				font-size: 14px;
			}

			.page-break {
			    page-break-after: always;
			}

			.text-left{text-align: right;}
		</style>
	</head>
	<body>
		<div style="font-size: 12.5px !important;">
			<table width="100%" cellspacing="0">
				<tr >
					<th width="10px" class="celdas">Nº {{$delivery->id}}</th>
					<th class="celdas">
						@switch ($delivery->type) 
						@case ('sing')
							Seña
							@break;

						@case ('simple')
							Venta directa
							@break;

						@case ('online')
							Venta online
							@break;

						@case ('others')
							Venta otras cuentas
							@break;
						
						@default
							Crédito
							@break;
					@endswitch
					</th>
					<th class="celdas2">Fecha y hora: {{$delivery->created_at}}</th>
				</tr>
				<tr>
					<td>APELLIDO Y NOMBRE:</td>
					<td>{{$delivery->client}}</td>
					<td></td>
				</tr>
				<tr>
					<td>BARRIO:</td>
					<td>{{$delivery->district}}</td>
					<td></td>
				</tr>
				<tr>
					<td>DIRECCION:</td>
					<td>{{$delivery->address}}</td>
					<td></td>
				</tr>
				<tr>
					<td>ENTRECALLES:</td>
					<td>{{$delivery->between_street}}</td>
					<td></td>
				</tr>
				<tr>
					<td><br><b>OBSERVACIONES:</b></td>
					<td colspan="2"><br><hr></td>
				</tr>
				<tr><td colspan="3"></td></tr>
				<tr>
					<td colspan="3"><br></td>
				</tr>
				@foreach($products as $product)
				<tr>
					<td>MARCA:</td>
					<td>{{$product->brand}}</td>
					<td></td>
				</tr>
				<tr>
					<td>CODIGO:</td>
					<td>{{$product->code}}</td>
					<td></td>
				</tr>
				<tr>
					<td>PRODUCTO:</td>
					<td>{{$product->name}}</td>
					<td></td>
				</tr>
				<tr>
					<td><b>DESCRIPCION</b>:</td>
					<td>{{$product->description}}</td>
					<td></td>
				</tr>
				<tr>
					<td>COLOR:</td>
					<td>{{$product->color}}</td>
					<td></td>
				</tr>
				<tr>
					<td>MODELO:</td>
					<td>{{$product->model}}</td>
					<td></td>
				</tr>
				<tr>
					<td><b>C.U.C:</b></td>
					<td>{{$product->id}}</td>
					<td></td>
				</tr>
				<tr>
					<td colspan="3"><br></td>
				</tr>
				@endforeach
				<tr><td colspan="3"></td></tr>
				<tr>
					<td><br><br><b>DNI:_______________________________</b></td>
					<td></td>
					<td><br><br><b>FIRMAS:_______________________________</b></td>
				</tr>
				<tr>
					<td></td>
					<td><br><br><b>ACLARACION:_______________________________</b></td>
					<td></td>
				</tr>
			</table>
		</div>
	</body>
</html>