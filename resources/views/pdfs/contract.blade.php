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
		<title>Contrato</title>
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
		</style>
	</head>
	<body>
		<table width="100%">
			<tr>
				<td>NCLI</td>
				<td>{{ $credit->sale->client->id }}</td>
				<td>P/C</td>
				<td>{{ $credit->sale->sale_details->count() }}</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>N/Credito</td>
				<td>{{ $credit->id }}</td>
				<td>Anticipo</td>
				<td>$ {{ number_format(($credit->advance_I + $credit->advance_II), 0, ',', '.') }}</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>PLAN</td>
				<td></td>
				<td>CUOTAS</td>
				<td>{{ $credit->credit_details->count() }}</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>C/Cuota</td>
				<td>$ {{ number_format($credit->credit_details->first()->fee_amount, 0, ',', '.') }}</td>
				<td>GASTOS</td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>TOTAL</td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</table>
		<hr>
		<h4>DATOS PERSONALES</h4>
		<table width="100%">
			<tr>
				<td width="20%">DOCUMENTO:</td>
				<td>{{ $credit->sale->client->dni }}</td>
			</tr>
			<tr>
				<td width="20%">NOMBRE Y APELLIDO:</td>
				<td>{{ $credit->sale->client->name }}</td>
			</tr>
			<tr>
				<td>DIRECION:</td>
				<td>{{ $credit->sale->client->profile->address }}</td>
			</tr>
			<tr>
				<td>E. CALLES:</td>
				<td>
					{{ $credit->sale->client->profile->between_street }}</td>	
				</td>
			</tr>
			<tr>
				<td>LOCALIDAD:</td>
				<td>{{ $credit->sale->client->profile->location }}</td>
			</tr>
			<tr>
				<td>BARRIO:</td>
				<td>
					{{ $credit->sale->client->profile->district }}	
				</td>
			</tr>
			<tr>
				<td>TELEFONOS:</td>
				<td>
					@foreach($credit->sale->client->phone1 as $phone)
						{{ $phone['phone'] }} - 
					@endforeach
				</td>
			</tr>
			<tr>
				<td>FEC.NACIM:</td>
				<td></td>
			</tr>
			<tr>
				<td>OBCERVACIONES:</td>
				<td></td>
			</tr>
		</table>	
		<hr>
		@if($credit->sale->client->client_type->code == '010')
			<h4>DATOS LABORALES</h4>
			<p style="text-align: justify;font-size: 12px;">
				@php
					$enterprise = json_decode($credit->sale->client->enterprise, true);
				@endphp

				<strong>Nombre:</strong> {{ $enterprise['name'] }} - <strong>CUIT:</strong> {{ $enterprise['cuit'] }} <br>
				<strong>E-mail:</strong> {{ $enterprise['email'] }} - <strong>Telefonos: </strong> {{ $enterprise['phone1'] .' / '. $enterprise['phone2'] }}<br>
				<strong>Localidad:</strong> {{ $enterprise['location'] }} - <strong>Codigo Postal:</strong> {{ $enterprise['postal_code'] }}<br>
				<strong>Barrio:</strong> {{ $enterprise['district'] }} - <strong>Entre Calles:</strong> {{ $enterprise['between_street'] }}<br>
				<strong>Dirección:</strong> {{ $enterprise['address'] }}<br>
				<strong>Coordenadas:</strong> {{ $enterprise['coordinates'] }}
			</p>
			<hr>
		@endif
		<h4>LOS CONSIGNADOS EN LA PRSENTE REVISTEN EL CARECTER DE DECLARACON JURADA      CONDICION GENERAL DE ADHECION AL SISTEMA DE CREDITOS.</h4>
		<p style="text-align: justify; font-size: 12px;">
			<ol>
				<li>
					No se responsabiliza por inconvenientes de ingun indole con articulos adquiridos en los respectivos comercios adheridos.
				</li>
				<li>
					El solicitante debera abonar sus creditos en la cantidad de cuotas indicadas en este comprovante emitido en el comercio en los vencimientos indicados.</li>
				<li>
					Una vez vencido el plazo de cualquiera de las cuotas pactadas, el credito sera conciderado el lazo vencido, haciendoce exigible en su totalidadmas los intereses compensatorios y punitorios vigentes, junto con los gastos ocacionados por gestiones extrajudiciales y/o judiciales.
				</li>
				<li>
					Una vez transcurrido los 30 dias a contar desde la fecha de cancelacion de los sucesivos creditos autoriza a :var1 a la destruccion del documento que lo avalada como asi tambien la documentacion presentada para tal fin.
				</li>
				<li>
					Los pagos de la cuota se acreditaran como tales en la fecha que	ingresan en <b>{{ $date_credit }}</b>., los intereses devengados se liquidaran en el momento de la cancelacion de cada credito.
				</li>
				<li>
					Autorizo a :var3 a que incluya mi apellido, nombre y número de documento de identidad en la base de datos  de clientes MOROSOS,	existentes o a crearce a en el futuro,una vez transcurido 30 dias corridos desde la fecha de vencimiento de cualquiera de las cuotas pactadas como asi tambien hasta el cumplimiento total de su eventual renovacion o refinanciacion.	
				</li>
				<li>
					Me notifico que en caso de ser incluido en base de datos de MOROSOS mis datos no seran actualizados en la misma hasta transcurridos 30 dias corridos de la fecha efectiva de cancelacion de la deuda por la cual se me afecto.	
				</li>
			</ol>
		</p>
		<p style="text-align: justify; font-size: 12px;">
			En conformidad por las antes anunciadas y reconociendo haberme notificado de todas y cada uno los puntos precedentes,firmo al pie de la precente. 			
		</p>
		<p style="text-align: right; font-size: 12px;">
			FIRMA DEL CLIENTE:__________________________.
		</p>

		<div class="page-break"></div>

		<!-- PAGARE -->
		<table width="100%">
			<tr><td>BEMUEBLES</td></tr>
			<tr><td class="pagare" style="text-align: center; ">PAGARE</td>
			</tr>
		</table>
		<br>
		<p style="text-align: right;">Capital Federal, {{ $credit->created_at->format('d-m-Y') }}</p>
		<br>
		<p style="text-align: justify;">
			<b>Por: PESOS {{ \NumeroALetras::convertir($credit->final_amount, '', 'CENTIMOS') }} ({{ number_format($credit->final_amount, 0, ',', '.') }})</b>		<br><br>
			Por Valor Recibido <b class="name">{{ $credit->sale->client->name }}</b> con domicilio en {{ $credit->sale->client->profile->location }}, {{ $credit->sale->client->profile->between_street }}
			{{ $credit->sale->client->profile->district }} {{ $credit->sale->client->profile->address }}, pagará incondicionalmente A LA VISTA Y SIN PROTESTO,
			a la orden del Sr. MIRANDA JUAN DANIEL, DNI: 27503603 la suma de <b>PESOS {{ \NumeroALetras::convertir($credit->final_amount, '', 'CENTIMOS') }}.- ($ {{ number_format($credit->final_amount, 0, ',', '.') }}.-).</b><br><br>

			Se deja ampliado el plazo para la presentacion de este PAGARÉ para su pago a un año (1) 
			años desde la fecha de su liberamiento (Artículo 36, Decreto-Ley N° 5965/63 de la República Argentina). <br><br><br>

			Las sumas de capital a ser por el Deudor bajo el presente Pagaré devengarán
			intereses conpensatorios en forma mensual a una tasa de interés del QUINCE POR CIENTO 
			(15.00%) nominal anual sobre saldos desde la fecha de liberamiento del presente Pagaré y
			hasta la fecha de su efectivo pago. En caso de falta de pago, el día de su presentación al
			cobro, de cualquier suma adeudada bajo el presente Pagaré, tanto sea de capital como de 
			intereses compensatorios, se devengaran, adicionalmente a los intereses conpensatorios,
			intereses punitorios (i) a una tasa equivalente al cincuenta por ciento (50%) de la tasa de
			interés utilizada para calcular los intereses compensatorios, y (ii) desde la fecha de 
			presentación al cobro y hasta la de efectivo pago de todas las sumas adeudadas bajo el
			presente Pagaré.<br><br>

			Todos los montos adeudados ajo el presente, serán pagados libres de deducciones por
			impuestos, tasas, gastos, derechos o retenciones, presentes o futuros, de cualquier naturaleza
			o tipo, e impuestos por cualquier autoridad impositiva de la República Argentina o por cualquier
			otro pais o jurisdicción a través de la cual se efectuaren pagos bajo el presente, con excepción
			del impuesto a las Ganacias (o el impuesto equivalente que pueda establecerse en el futuro)
			sobre los ingresos netos glovales del tenedor. Dichos impuestos, tasas, gastos,
			derechos o retenciones, en caso de ser aplicables, deberan ser pagados por, y seran a cargo
			del Librador.<br><br>

			La validez del presente pagaré y de las obligaciones emanadas del mismo será regida e
			interpretadas por las leyes de la Rpública Argentina. Para cualquier controversia que se
			sucite con relación al presente pagaré, el Liberador y el tenedor se sujetan a la jurisdiccion y
			competencia de los tribunales Ordinarios de Capital Federal, renunciando a cualquier otro fuero
			o jurisdicción que pudiera corresponer.<br><br><br><br>
		</p>
		<p style="text-align: justify;">
			.......................................<br>
			(Firma Liberador)<br><br>
			Aclaración.............................<br><br>

			D.N.I..................................<br><br><br>
	 		<br>
	 		<br>
	 		<br>								
		</p>
		<div class="page-break"></div>
		<!-- FIN PAGARE -->
		<hr>

		<h4>Calendario de pagos</h4>
		<hr>

		<table width="100%">
			<tr>
				<td>DNI:</td>
				<td colspan="3">{{ $credit->sale->client->dni }}</td>
			</tr>
			<tr>
				<td>NOMBRE:</td>
				<td colspan="3">{{ $credit->sale->client->name }}</td>
			</tr>
			<tr>
				<td>CREDITO:</td>
				<td colspan="3">{{ $credit->id }}</td>
			</tr>
			<tr>
				<td>N° CLIENTE:</td>
				<td colspan="3">{{ $credit->sale->client->id }}</td>
			</tr>
			<tr>
				<td>FIRMA:</td>
				<td></td>
				<td>DNI:</td>
				<td>{{ $credit->sale->client->dni }}</td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td valign="top">
					<table width="70%">
						<tr>
							<td>CUOTA</td>
							<td>IMPORTE</td>
							<td>VENCIMIENTO</td>
							<td>PAGO</td>
						</tr>
						<tr>
							<td>ANTICIPO 1</td>
							<td>$ {{ number_format(($credit->advance_I), 0, ',', '.') }}</td>
							<td></td>
							<td></td>
						</tr>
						@if($credit->type == 'two_advance')
							<tr>
								<td>ANTICIPO 2</td>
								<td>$ {{ number_format(($credit->advance_II), 0, ',', '.') }}</td>
								<td>{{ $credit->date_advance_I->addDays(10)->format('d-m-Y') }}</td>
								<td>$ {{ number_format(($credit->advance_II), 0, ',', '.') }}</td>
							</tr>
						@endif
						@foreach($credit->credit_details as $key => $detail)
							<tr>
								<td>{{ $detail->fee_number }}</td>
								<td>$ {{ number_format($detail->fee_amount, 0, ',', '.') }}</td>
								<td>{{ $detail->fee_date_expired->format('d-m-Y') }}</td>
								<td></td>
							</tr>
						@endforeach
					</table>
				</td>
				<td valign="top">
					<table width="20%">
						<tr>
							<td>N/C</td>
							<td>{{ $credit->id }}</td>
						</tr>
						<tr>
							<td>NCLI</td>
							<td>{{ $credit->sale->client->id }}</td>
						</tr>
						<tr>
							<td>DNI</td>
							<td>{{ $credit->sale->client->dni }}</td>
						</tr>
						<tr>
							<td>PLA</td>
							<td></td>
						</tr>
						<tr>
							<td>ANTICIPO</td>
							<td>$ {{ number_format(($credit->advance_I + $credit->advance_II), 0, ',', '.') }}</td>
						</tr>
						<tr>
							<td>P/C</td>
							<td></td>
						</tr>
						<tr>
							<td>FECHA</td>
							<td>{{ $date_credit }}</td>
						</tr>
						<tr>
							<td>NOM</td>
							<td>{{ $credit->sale->client->name }}</td>
						</tr>
						<tr>
							<td>CCU</td>
							<td></td>
						</tr>
						<tr>
							<td>PL</td>
							<td></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
			<!-- PAGARE -->
			{{--  
			<div class="page-break"></div>

			<table width="100%">
				<tr>
					<td>BEMUEBLES</td>
					<td style="text-align: right;">{{ $date_credit }}</td>
				</tr>
				<tr>
					<td colspan="2">
						LOCALIDAD:	TRISTAN SUAREZ					
					</td>
				</tr>
				<tr>
					<td colspan="2">
						CODIGO POSTAL:  1806
					</td>
				</tr>
				<tr>
					<td colspan="2">
						DIRECCION:	ROQUE SAENZ PEÑA 198
					</td>
				</tr>
			</table>

			<p style="text-align: justify;">
				Pagaremos a la vista a ____________________. o a su orden sin protesto (art 5 D.ley 5965/63) la cantidad en PESOS {{ \NumeroALetras::convertir($credit->final_amount, '', 'CENTIMOS') }} ({{ number_format($credit->final_amount, 0, ',', '.') }})		<br><br>		
				 									
				Por igual valor recivido a nuestra entera satisfaccion dejamos expresamente aclarado en nuestro concepto de libradores ley 5965/63,	ampliamos el plazo de presentaciòn hasta un màximo de 10 años, a contar	desde la fecha del libramiento del presente. <br><br>

				Pagador en___________________________<br><br>

				Firma del deudor_______________________
			</p>
			<p style="text-align: justify;">
				NOMBRE Y APELLIDO:	{{ $credit->sale->client->name }}<br>
				Tipo nºde Documento: {{ $credit->sale->client->dni }}	<br>												
				Producto/s
				@foreach($credit->sale->sale_details as $item)
					{{ $item->product->name }}, 
				@endforeach
		 		<br>
		 		<br>
				CRED S.R.L									
			</p>
			--}}
			<br><br><br><!-- FIN PAGARE -->
		<hr>
		<h4>Calendario de pagos</h4>
		<hr>

		<table width="100%">
			<tr>
				<td>DNI:</td>
				<td colspan="3">{{ $credit->sale->client->dni }}</td>
			</tr>
			<tr>
				<td>NOMBRE:</td>
				<td colspan="3">{{ $credit->sale->client->name }}</td>
			</tr>
			<tr>
				<td>CREDITO:</td>
				<td colspan="3">{{ $credit->id }}</td>
			</tr>
			<tr>
				<td>N° CLIENTE:</td>
				<td colspan="3">{{ $credit->sale->client->id }}</td>
			</tr>
			<tr>
				<td>FIRMA:</td>
				<td></td>
				<td>DNI:</td>
				<td>{{ $credit->sale->client->dni }}</td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td valign="top">
					<table width="70%">
						<tr>
							<td>CUOTA</td>
							<td>IMPORTE</td>
							<td>VENCIMIENTO</td>
							<td>PAGO</td>
						</tr>
						<tr>
							<td>ANTICIPO 1</td>
							<td>$ {{ number_format(($credit->advance_I), 0, ',', '.') }}</td>
							<td></td>
							<td></td>
						</tr>
						@if($credit->type == 'two_advance')
							<tr>
								<td>ANTICIPO 2</td>
								<td>$ {{ number_format(($credit->advance_II), 0, ',', '.') }}</td>
								<td>{{ $credit->date_advance_I->addDays(10)->format('d-m-Y') }}</td>
								<td>$ {{ number_format(($credit->advance_II), 0, ',', '.') }}</td>
							</tr>
						@endif
						@foreach($credit->credit_details as $key => $detail)
							<tr>
								<td>{{ $detail->fee_number }}</td>
								<td>$ {{ number_format($detail->fee_amount, 0, ',', '.') }}</td>
								<td>{{ $detail->fee_date_expired->format('d-m-Y') }}</td>
								<td></td>
							</tr>
						@endforeach
					</table>
				</td>
				<td valign="top">
					<table width="20%">
						<tr>
							<td>N/C</td>
							<td>{{ $credit->id }}</td>
						</tr>
						<tr>
							<td>NCLI</td>
							<td>{{ $credit->sale->client->id }}</td>
						</tr>
						<tr>
							<td>DNI</td>
							<td>{{ $credit->sale->client->dni }}</td>
						</tr>
						<tr>
							<td>PLA</td>
							<td></td>
						</tr>
						<tr>
							<td>ANTICIPO</td>
							<td>$ {{ number_format(($credit->advance_I + $credit->advance_II), 0, ',', '.') }}</td>
						</tr>
						<tr>
							<td>P/C</td>
							<td></td>
						</tr>
						<tr>
							<td>FECHA</td>
							<td>{{ $date_credit }}</td>
						</tr>
						<tr>
							<td>NOM</td>
							<td>{{ $credit->sale->client->name }}</td>
						</tr>
						<tr>
							<td>CCU</td>
							<td></td>
						</tr>
						<tr>
							<td>PL</td>
							<td></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>

		{{--  	
		<div class="page-break"></div>
		@php
			$i = 0;
		@endphp
		<div style="font-size: 12.5px !important;">
			@foreach($credit->sale->sale_details as $item)
				<table width="100%">
					<tr>
						<td width="20%">{{ $item->product->code }}</td>
						<td>PRODUCTO DE SALIDA COMERCIAL</td>
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
						<td></td>
						<td>CREDITO:</td>
						<td></td>
					</tr>
					<tr>
						<td>DIRECCION:</td>
						<td colspan="3">{{ $credit->sale->client->address }}</td>
					</tr>
					<tr>
						<td>ENTRECALLES:</td>
						<td colspan="3"></td>
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
							<div style="background-color: {{ $item->product->color }}; height: 20px; width: 120px;"></div>
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
		--}}
	</body>
</html>