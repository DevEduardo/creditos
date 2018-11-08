
@section('css')
@parent
	<style type="text/css">
		.input-group { margin-bottom: 5px; }
		.box { border-radius: 0px !important; }
		.well { border-radius: 0px !important; }
		[created], [notcreated]{ display: none;  }

	</style>
@endsection

<div class="row">
	<div class="col-sm-12 col-md-12 col-lg-12"><h4>Datos de la factura</h4></div>
</div>

<div class="row"><hr style="margin-top: 0px;" /></div>

	{{ Form::open(['route' => ['invoices.store'], 'class'=>'invoice-open','notcreated']) }}

		<div class="row">
			<div class="form-group col-sm-12 col-md-12 col-lg-12">
				{{ Form::label('provider_id', 'Proveedor (CUIT):') }}
				{{ Form::select('provider_id', $providers, old('provider_id'), ['class' => 'form-control select2',  'style' => 'width: 100%']) }}

			</div>

			<div class="form-group col-sm-12 col-md-4 col-lg-4">
				{{ Form::label('code', 'Factura #:') }}
				<div class="input-group">
					<div class="input-group-addon"><i class="fa fa-file-text"></i></div>
					{{ Form::text('code', old('code'), ['class' => 'form-control']) }}
				</div>
			</div>

			<div class="form-group col-sm-12 col-md-4 col-lg-4">
				{{ Form::label('date', 'Fecha:') }}
				<div class="input-group">
					<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
					{{ Form::text('date', old('date'), ['class' => 'form-control date']) }}
				</div>
			</div>

			<div class="form-group col-sm-12 col-md-4 col-lg-4" style="margin-top: 25px;">
				{{ Form::submit('Aperturar Factura', ['class' => 'btn btn-primary pull-right']) }}
			</div>
		</div>
	{{ Form::close() }}


	<div class="row" created>
		<div class="form-group col-sm-12 col-md-6 col-lg-6">
			<span>
				<b>Factura #: </b>
				@if($created)
					<span invoice-number>{{ str_pad($invoice->id, 6, "0", STR_PAD_LEFT) }}</span>
				@else
					<span invoice-number></span>
				@endif

			</span>
		</div>
		<div class="form-group col-sm-12 col-md-6 col-lg-6">
			<span>
				<b>Estado: </b>
				<span class="text-success">Aperturada.</span>
			</span>
		</div>
	</div>

	<div class="row" created><hr style="margin-top: 0px;" /></div>

	{{ Form::open(['route' => ['invoices.store'], 'class'=>'invoice-add-item', 'created']) }}
		<div class="row">

			<div class="col-sm-12 col-md-7 col-lg-7">
				<div class="form-group">
					{{ Form::label('product_id', 'Producto') }}
					<div class="input-group">
						{{ Form::select('product_id', $products, old('product_id'), ['class' => 'form-control select2-product',  'style' => 'width: 100%']) }}
					</div>
				</div>
			</div>

			<div class="col-sm-12 col-md-5 col-lg-5">
				<div class="form-group">
					{{ Form::label('qyt', 'Cantidad') }}
					<div class="input-group">
						<div class="input-group-addon"><i class="fa  fa-cart-plus"></i></div>
						{{ Form::text('qty', old('qty'), ['class' => 'form-control']) }}
						<div class="input-group-addon">
							<input type="checkbox" name="distribuir" title="Distribuir entre los almacenes">
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-12 col-md-12 col-lg-12">
				<div class="row">
					<div class="col-sm-12 col-md-12 col-lg-12">
						<b><i class="fa fa-angle-double-down"></i> Almacenes disponiles: {{ count($stores) }}</b>
					</div>

					<div class="col-sm-12 col-md-12 col-lg-12 collapse" id="divCollapse">
						<div class="row">

							<div class="col-sm-12 col-md-12 col-lg-12 collapse in countMessage" id="calloutCollapse">
								<div class="callout callout-danger">
									<p>
										Los items de los almacenes, debe coincidir con la cantidad en la factura
									</p>
								</div>
							</div>

							@foreach($stores as $store)

								<div class="col-sm-12 col-md-4 col-lg-4">

									<div class="input-group" title="{{ $store->name }}">
										<div class="input-group-addon"><i class="fa fa-building"></i></div>
										{{ Form::text('stores[' .$store->id. ']', old('stores[]'), ['class' => 'form-control qty-store', 'placeholder' => $store->name]) }}
									</div>

								</div>

							@endforeach

							<div class="clearfix"></div>

							<div class="col-sm-6 col-md-6 col-lg-6 pull-right">
								<a class="btn btn-block btn-social btn-google clearCount">
									<i class="fa fa-trash"></i>
									Limpiar
								</a>
							</div>

							<div class="clearfix"></div>
						</div>
					</div>

				</div>
			</div>

			<div class="col-sm-12 col-md-6 col-lg-6">
				<div class="form-group">
					{{ Form::label('price', 'Precio') }}
					<div class="input-group">
						<div class="input-group-addon"><i class="fa  fa-money"></i></div>
						{{ Form::text('price', old('price'), ['class' => 'form-control']) }}
						<div class="input-group-addon">ARS</i></div>
					</div>
				</div>
			</div>

			<div class="col-sm-12 col-md-6 col-lg-6">
				<div class="form-group">
					{{ Form::label('subtotal', 'Importe (*)') }}
					<div class="input-group">
						<div class="input-group-addon"><i class="fa  fa-money"></i></div>
						{{ Form::text('subtotal', old('subtotal'), ['class' => 'form-control', 'readonly']) }}
						<div class="input-group-addon">ARS</i></div>
					</div>
				</div>
			</div>

			<div class="col-sm-12 col-md-3 col-lg-3">
				<div class="form-group">
					{{ Form::label('discount1', 'Descuento') }}
					<div class="input-group">
						<div class="input-group-addon"><b>%</b></div>
						{{ Form::text('discount1', old('discount1'), ['class' => 'form-control discount']) }}
					</div>
				</div>
			</div>

			<div class="col-sm-12 col-md-3 col-lg-3">
				<div class="form-group">
					{{ Form::label('discount2', 'Descuento') }}
					<div class="input-group">
						<div class="input-group-addon"><b>%</b></div>
						{{ Form::text('discount2', old('discount2'), ['class' => 'form-control discount']) }}
					</div>
				</div>
			</div>

			<div class="col-sm-12 col-md-3 col-lg-3">
				<div class="form-group">
					{{ Form::label('discount3', 'Descuento') }}
					<div class="input-group">
						<div class="input-group-addon"><b>%</b></div>
						{{ Form::text('discount3', old('discount3'), ['class' => 'form-control discount']) }}
					</div>
				</div>
			</div>

			<div class="col-sm-12 col-md-3 col-lg-3">
				<div class="form-group">
					{{ Form::label('discount4', 'Descuento') }}
					<div class="input-group">
						<div class="input-group-addon"><b>%</b></div>
						{{ Form::text('discount4', old('discount4'), ['class' => 'form-control discount']) }}
					</div>
				</div>
			</div>

			<div class="col-sm-12 col-md-6 col-lg-6">
				<div class="form-group">
					{{ Form::label('total_discount', 'Total Descuentos') }}
					<div class="input-group">
						<div class="input-group-addon"><i class="fa  fa-money"></i></div>
						{{ Form::text('total_discount', old('total_discount'), ['class' => 'form-control', 'readonly']) }}
						<div class="input-group-addon">ARS</div>
					</div>
				</div>
			</div>

			<div class="col-sm-12 col-md-6 col-lg-6">
				<div class="form-group">
					{{ Form::label('amount_discount', 'Importe (**)') }}
					<div class="input-group">
						<div class="input-group-addon"><i class="fa  fa-money"></i></div>
						{{ Form::text('amount_discount', old('amount_discount'), ['class' => 'form-control', 'readonly']) }}
						<div class="input-group-addon">ARS</div>
					</div>
				</div>
			</div>

			<div class="col-sm-12 col-md-12 col-lg-12">
				<div class="form-group">
					{{ Form::label('tax_id', 'Impuestos') }}
					<div class="input-group">
						{{ Form::select('taxes[]', $taxes, old('tax_id'), ['class' => 'form-control select2-taxes', 'style' => 'width: 100%', 'multiple' => 'multiple']) }}
					</div>
				</div>
			</div>

			<div class="col-sm-12 col-md-6 col-lg-6">
				<div class="form-group">
					{{ Form::label('total_taxes', 'Total Impuestos') }}
					<div class="input-group">
						<div class="input-group-addon"><i class="fa  fa-money"></i></div>
						{{ Form::text('total_taxes', old('total_taxes'), ['class' => 'form-control', 'readonly']) }}
						<div class="input-group-addon">ARS</div>
					</div>
				</div>
			</div>

			<div class="col-sm-12 col-md-6 col-lg-6">
				<div class="form-group">
					{{ Form::label('amount_taxes', 'Importe (***)') }}
					<div class="input-group">
						<div class="input-group-addon"><i class="fa  fa-money"></i></div>
						{{ Form::text('amount_taxes', old('amount_taxes'), ['class' => 'form-control', 'readonly']) }}
						<div class="input-group-addon">ARS</div>
					</div>
				</div>
			</div>

			<div class="clearfix"></div>

			<div class="col-sm-12 col-md-6 col-lg-6">
				<div class="form-group">
					{{ Form::label('pvp', 'PVP') }}
					<div class="input-group">
						<div class="input-group-addon"><i class="fa  fa-money"></i></div>
						{{ Form::text('pvp', old('pvp'), ['class' => 'form-control']) }}
						<div class="input-group-addon">ARS</div>
					</div>
				</div>
			</div>

			<div class="col-sm-12 col-md-6 col-lg-6">
				<div class="form-group">
					{{ Form::label('benefit', 'Beneficio') }}
					<div class="input-group">
						<div class="input-group-addon"><b>%</b></div>
						{{ Form::text('benefit', old('benefit'), ['class' => 'form-control']) }}
					</div>
				</div>
			</div>

			<div class="col-sm-12 col-md-6 col-lg-6">
				<div class="form-group">
					{{ Form::label('sale_price', 'Precio Venta (Por unidad)') }}
					<div class="input-group">
						<div class="input-group-addon"><i class="fa  fa-money"></i></div>
						{{ Form::text('sale_price', old('sale_price'), ['class' => 'form-control', 'readonly', 'title' => 'Haga doble clic sobre este campo para activar la edición del mismo.']) }}
						<div class="input-group-addon">ARS</div>
					</div>
				</div>
			</div>

			<!-- <div class="col-sm-12 col-md-6 col-lg-6">
				<div class="form-group">
					{{ Form::label('amount_subtotal', 'Sub-Total') }}
					<div class="input-group">
						<div class="input-group-addon"><i class="fa  fa-money"></i></div>
						{{ Form::text('amount_subtotal', old('amount_subtotal'), ['class' => 'form-control', 'readonly']) }}
						<div class="input-group-addon">ARS</div>
					</div>
				</div>
			</div> -->

			<div class="col-sm-12 col-md-6 col-lg-6" style="margin-top: 25px;">
				<button class="btn btn-block btn-social bg-primary" add-product>
					<i class="fa fa-plus"></i>
					Agregar
				</buttom>
			</div>

		</div>
	{{ Form::close() }}



@section('js')
@parent
<script src="{{ asset('js/jquery.inputmask.bundle.min.js') }}"></script>

<script type="text/javascript">

(function($) {

	/*$('aside.main-sidebar').hide().promise().done( ev => {
		$('a[data-toggle="push-menu"]').pushMenu('toggle').promise().done( () => {
			$('aside.main-sidebar').show()
		});
	})*/

})(jQuery);

$(document).ready( () => {
	//Inicialisamos campoe en cero 
	$('#discount1').val(0);
	$('#discount2').val(0);
	$('#discount3').val(0);
	$('#discount4').val(0);
	/**
	 * Obtenemos el Invoice si existe
	 */
	let invoice = '<?php echo $invoice; ?>' || null;
	let taxes = JSON.parse('<?php echo $taxesj; ?>');
	var currentTaxes = {};
	/**
	 * Mostramos las partes del formulario segun esté o no aperturada la factura
	 */
	@if($created)
		$('[created]').show();
	@else
		$('[notcreated]').show();
	@endif

	/**
	 * Inicilizamos los select's
	 */
	$.fn.select2.defaults.set( "theme", "bootstrap" );

	$('select.select2, select.select2-product, select.select2-taxes').select2({
		placeholder: "Seleccione",
    	allowClear: true,
    	theme: "bootstrap"
	});

	$('select.select2, select.select2-product, select.select2-taxes').val(null).trigger('change');

	/**
	 * Inicializamos los datepicker's
	 */
	$.fn.datepicker.dates['en'] = {
	    days: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
	    daysShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
	    daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
	    months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
	    monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
	    today: "Hoy",
	    clear: "Limpiar",
	    format: "mm/dd/yyyy",
	    titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
	    weekStart: 0
	};

	$('input.date').datepicker({
		clearBtn: true,
	    daysOfWeekHighlighted: "0,6",
	    calendarWeeks: true,
	    autoclose: true,
	    todayHighlight: true,
	    toggleActive: true,
	    orientation: "bottom right",
	    format: 'dd/mm/yyyy'
	});

	/**
	 * Inicializamos el inputmask de cantidad
	 */
	$("input[name='qty']").inputmask("integer");

	/**
	 * Inicializamos el inputmask de los campos precio, subtotal, pvp, descuento e impuetos
	 */
	/*$('input[name="price"], input[name="subtotal"], input[name="pvp"], input[name="total_discount"]').inputmask("decimal", {
		positionCaretOnClick: "radixFocus",
        radixPoint: ".",
        _radixDance: true,
        numericInput: true,
        placeholder: "0",
        definitions: {
            "0": {
                validator: "[0-9\uFF11-\uFF19]"
            }
        }
	});*/

	/**
	 * Inicializamos el inputmask de los campos descuentos y beneficios
	 */
	/*$('input[name="discount1"], input[name="discount2"], input[name="discount3"], input[name="discount4"], input[name="benefit"]').inputmask("decimal", {
		min: 0.00,
		max: 100.00,
		positionCaretOnClick: "radixFocus",
        radixPoint: ".",
        _radixDance: true,
        numericInput: true,
        placeholder: "0",
        definitions: {
            "0": {
                validator: "[0-9\uFF11-\uFF19]"
            }
        }
	});*/

	/**
	 * Evento que apertura la opción para distribuir los productos en los almacenes
	 */
	$('input[name="distribuir"]').click(ev => {

		let selector = $('#divCollapse');

		if(Number($("input[name='qty']").val()) > 0) {

			if($(ev.target).is(':checked')) {
				selector.collapse('show').promise().done(ev => {
					$("input[name='qty']").attr('readonly', true)
				});

			} else {
				selector.collapse('hide').promise().done(ev => {
					$("input[name='qty']").removeAttr('readonly')
				});
			}

		} else {
			$(ev.target).prop('checked' , false);
		}
	})

	/**
	 * Evento que muestra el mensaje en la sección de almacenes
	 */
	$('#divCollapse')
	.on('show.bs.collapse', ev => {
		$('input[name="distribuir"]').prop('readonly', true);
	})
	.on('shown.bs.collapse', ev => {
		$('input[name="distribuir"]').removeAttr('readonly');
	})
	.on('hide.bs.collapse', ev => {
		$('input[name="distribuir"]').prop('readonly', true);
	})
	.on('hidden.bs.collapse', ev => {
		if($(ev.target).hasClass('countMessage')) {
			return false;
		}
		$('input[name="distribuir"]').removeAttr('readonly');
		$("input.qty-store").val(null)
	})

	/**
	 * Evento que ejecuta el calculo de items distribuidos en los almacenes
	 */
	$("input.qty-store").on('keyup', ev => {
		calculateTotalItems();
	})

	/**
	 * Evento que limpia las cantidades de los almacenes
	 */
	$("a.clearCount").on('click', ev => {
		$("input.qty-store").val(null).promise().done( () => {
			$('#calloutCollapse').collapse('show');
		})
	})

	/**
	 * Evento que ejecuta el calculo del importe
	 */
	$("input[name='price']").on('keyup', ev => {
		calculateImporte();
	})

	/**
	 * Evento que ejecuta el calculo del importe
	 */
	$("input[name='qty']").on('keyup', ev => {
		calculateImporte();
	})

	$('input.discount').on('keyup', ev => {
		//console.info("keypress")
		calculateDiscount();
	})

	/**
	 * Caluculo de Impuestos
	 */

	$('select.select2-taxes').on('select2:select', ev => {

		var data = ev.params.data;
		//currentTaxes[data.text] = { 'id': data.id, 'value': taxes[data.id], 'key': Object.keys(currentTaxes).length };
		currentTaxes[data.text] = { 'id': data.id, 'value': taxes[data.id], 'key': Object.keys(currentTaxes).length };
		calculateTaxAmount();
	});

	$('select.select2-taxes').on('select2:unselect', ev => {

		var data = ev.params.data;
		let current = data.text;

		delete currentTaxes[current];

		calculateTaxAmount();

	});

	/**
	 * Evento que ejecuta la apertura de factura
	 */

	$('form.invoice-open').on('submit', ev => {
		ev.preventDefault();
		ev.stopPropagation();
		let data = $(ev.target).serialize();

		openInvoice(data);
	})

	/**
	 * Agregar productos a la factura
	 */
	$('form.invoice-add-item').on('submit', ev => {
		ev.preventDefault();
		ev.stopPropagation();

		addItem()

	});

	/**
	 * Calculo de beneficios y precio unitario
	 */
	$('input[name="benefit"]').on('keyup', ev => {
		calculateBenefit();
	})

	$('input[name="sale_price"]').on('dblclick', ev => {

		let attr = $(ev.target).attr('readonly');

		if(typeof attr !== undefined && attr) {

			$(ev.target).removeAttr('readonly');

			return;
		}

		$(ev.target).attr('readonly', true);

	})

	/**
	 * Evento para eliminar detalles
	 */

	$('table > tbody.table-products').on('click', 'button.delete-detail', ev => {

		let id = $(ev.target).parents('tr').data('detail');

		deleteItem(id)
		.done( (data, textStatus, jqXHR) => {
			if(data._delete)
			{
				//$(ev.target).parents('tr').remove();
				renderItems(data.invoice);
			}
		})
		.fail( (jqXHR, textStatus, errorThrown) => {
			console.info(textStatus)
		});
	});

	/**
	 * Evento que finaliza la factura
	 */

	$("button[finish-invoice]").on('click', ev => {

		swal({
		  	title: '¡Finalizando la Factura!',
		  	html: "Esta a punto de finalizar la factura<br>¿Desa hacerlo realmente?",
		  	type: 'warning',
		  	showCancelButton: true,
		  	//confirmButtonColor: '#807551',
		  	confirmButtonText: 'Finalizar',
		  	cancelButtonText: 'Cancelar'
		}).then((result) => {
		    finish()
    		.done((data, textStatus, jqXHR) => {
    			renderItems();

    			$("button[cancel-invoice]").attr('disabled', 'disabled');
    		})
    		.fail((jqXHR, textStatus, errorThrow) => {

    			let message = jqXHR.responseJSON.message;

    			showSwal(message);

    		});
		});
	});

	/**
	 * Evento que cancela la factura
	 */

	$("button[cancel-invoice]").on('click', ev => {

		cancel()
		.done((data, textStatus, jqXHR) => {
			window.location.href = "{{ route('invoices.create') }}";
		})
		.fail((jqXHR, textStatus, errorThrow) => {

			let message = jqXHR.responseJSON.message;

			showSwal(message);

		})

	});

	/**
	 * Función Ajax
	 */
	const requestAjax = (url, method, data = null) => {

		return $.ajax({
			method: method,
			url: url,
			data: data,
			cache: false,
			dataType: "json"
		});
	}

	/**
	 * Función para la apertura de factura
	 */
	const openInvoice = (data) => {

		let method = "POST";
		let url = '{{ route("invoices.open") }}';

		requestAjax(url, method, data)
		.done((data, textStatus, jqXHR) => {
			$('[notcreated]').remove().promise().done(ev => {
				$('[invoice-number]').text(data.invoice.id.toString().padStart(6, "0")).promise().done(ev => {
					$('[created]').show();
				});
			});

			$("button[cancel-invoice]").removeAttr('disabled');
		})
		.fail((jqXHR, textStatus, errorThrown) => {

			let data = jqXHR.responseJSON;
			let code = jqXHR.status;

			if(code === 404){
				swal({
	                title: "Error!",
	                text: data._message,
	                type: "error"
            	}).then(
	            	value => {
	            		$('input[name="code"]').val(null);
	            	},
	            	() => {
	            		$('input[name="code"]').val(null);
	            	}
	            )

            	return;
			}

			renderValidationErrors('form.invoice-open',data.errors, data.message);

		});
	}

	/**
	 *  Renderizar errores de validación
	 */
	const renderValidationErrors = (selector, errors, message = null) => {

		$('div.form-group').find('span.help-block').remove();

		$.each(errors, (key, error) => {

			$('input[name="'+key+'"], select[name="'+key+'"]')
				.parents('div.form-group')
				.append(
					$('<span></span>').addClass('help-block').text("(*) ".concat(error[0]))
				)
		})

		if(message != null) {
			swal({
                title: "Error!",
                text: message,
                type: "error"
        	})
		}
	}

	/**
	 * Función que despliega un alert con mensajes de error o exito.
	 * Admite [error, success, warning, info]
	 */
	const showSwal = (message, type = 'error', title = null) => {
		return swal({
                title: title || "Error!",
                text: message,
                type: type
        	})
	}

	/**
	 * Funcon para agregar items a la factura
	 */
	const addItem = () =>{

		let data = $('form.invoice-add-item').serializeArray();

		swal({
			title: "¿Actulizamos el precio?",
			text: "¿Desea actualizar el precio de venta del producto?",
			type: "info",
			showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            confirmButtonText: "Si, Actualizar!",
		})
		.then( result => {
			data.push({ name:'update_price', value: 1 });
			sendItems(data);
		},
		result => {
			sendItems(data);
		});

	}

	const sendItems = (data) => {

		let url = '{{ route("details.store") }}';
		let method = 'post';

		requestAjax(url, method, data)
		.done((data, textStatus, jqXHR) => {
			let invoice = data.invoice;
			renderItems(invoice);

		})
		.fail((jqXHR, textStatus, errorThrown) => {

			let data = jqXHR.responseJSON;

			if(typeof data.errors === "undefined"){

				showSwal(data.message);
				return;
			}

			renderValidationErrors('form.invoice-add-item',data.errors);
			//console.info(jqXHR)
		})
	}

	/**
	 * Calculo de la sumatoria de los almacenes
	 */
	const calculateTotalItems = () => {

		let inputs = $("input.qty-store");
		let qty = $("input[name='qty']");
		let init = 0;

		$.each(inputs, (key, input) =>{

			if($(input).val().length > 0 && $(input).val() !== null) {
				init = init + parseInt($(input).val());
			}

		})

		if(init == parseInt(qty.val())) {

			$('#calloutCollapse').collapse('hide');

		} else {

			$('#calloutCollapse').collapse('show');

		}
	}

	/**
	 * Calculo del importe (precio unidad X cantidad)
	 */
	const calculateImporte = () => {
		let price = $("input[name='price']").val();
		let qty = $("input[name='qty']").val();

		price = price.replace(",", ".");

		total = parseFloat(qty) * parseFloat(price);

		if(Number(price) > 0 && Number(qty) > 0) {

			$("input[name='subtotal']").val(total.toFixed(0));

			calculateDiscount();
			calculateTaxAmount();

			return;
		}


	}

	/**
	 * Función que calcula los descuentos
	 */

	const calculateDiscount = () => {
		let total = parseFloat(0.00);
		let importe = parseFloat(0.00);
		let factor = parseFloat(0.00);
		let amount_discount = $('input[name="subtotal"]').val() || parseFloat(0.00);
		let resultado = parseFloat(0.00);
		let aux = parseFloat(0.00);

		$('input.discount').each((key, input) => {
			if($(input).val() != null && $(input).val().length > 0) {
				//total = total + parseFloat($(input).val());

				factor = (parseFloat($(input).val()) / 100.00);

				if (key == 0) {
					importe = $('input[name="subtotal"]').val();
				} else {
					importe = $('input[name="amount_discount"]').val();
				}

				aux = importe * factor;
				resultado += aux;
				amount_discount = importe - aux;

				$('input[name="amount_discount"]').val(parseFloat(amount_discount).toFixed(2));
				$('input[name="total_discount"]').val(parseFloat(resultado).toFixed(2));
			}
		})

		//console.info("Total: " + total, "importe: " + importe)

		/*if(total > 0 && importe != null && importe.length > 0) {

			factor = (parseFloat(total) / 100.00);
			resultado = importe * factor;
			amount_discount = importe - resultado;
			//console.info("factor: " + factor)

			$('input[name="total_discount"]').val(resultado.toFixed(2));
			$('input[name="amount_discount"]').val(amount_discount.toFixed(2))

			//console.info("Total: " + total, "importe: " + importe, "Resultado: " + resultado.toFixed(2))

		} else {
			$('input[name="total_discount"]').val(null);
			$('input[name="amount_discount"]').val(amount_discount)
		}*/

		calculateTaxAmount();
		calculateBenefit();

	}

	/**
	 * Función que calcula los impuestos
	 */
	const calculateTaxAmount = () => {
		let importe = parseFloat(0.00);
		let total_discount = parseFloat($('input[name="total_discount"]').val()) || parseFloat(0.00);
		let total_taxes = parseFloat(0.00);
		let amount_taxes = parseFloat(0.00);


		let newArray = [];
		// aqui generas tu arreglo de objetos para trabajarlo mejor
		Object.keys(currentTaxes).forEach((key, i) => {
		  // con spread operator queda mejor
		  newArray.push({label: 10.50 });
		});

		// aqui el arreglo con el objeto ya ordenado
		let arrayOderBy = currentTaxes;
			
			console.log(arrayOderBy);

		$.map(arrayOderBy, (val, i) => {
			
			if (importe == 0) {
				importe = (parseFloat($('input[name="subtotal"]').val()) - total_discount);
			} else {
				importe = amount_taxes;
			}
			total_taxes += (importe * (val.value / 100));
			
			amount_taxes = (importe + (importe * (val.value / 100)));
			
		});

		$('input[name="total_taxes"]').val(parseFloat(total_taxes).toFixed(2));
		$('input[name="amount_taxes"]').val(parseFloat(amount_taxes).toFixed(2));

		calculateBenefit();
	}

	/**
	 * Calcular beneficios
	 */

	const calculateBenefit = () => {

		let importe = parseFloat($('input[name="subtotal"]').val()) || parseFloat(0.00);
		let amount_discount = parseFloat($('input[name="total_discount"]').val()) || parseFloat(0.00);
		let amount_taxes = parseFloat($('input[name="total_taxes"]').val()) || parseFloat(0.00);
		let qty = parseFloat($('input[name="qty"]').val()) || parseFloat(0.00);
		let benefit = parseFloat($('input[name="benefit"]').val()) || parseFloat(0.00);
		let sale_price = parseFloat(0.00);


		sale_price = ((importe - amount_discount) + amount_taxes);
		//console.info("Importe: " + sale_price);
		sale_price = (sale_price / qty);
		//console.info("Precio por unidad (sin beneficio): " + sale_price);
		sale_price = (sale_price * (1 + (benefit / 100))).toFixed(0)
		//console.info("Precio por unidad (con beneficio): " + sale_price);

		//console.info("Importe: " + importe, "Descuento: " + amount_discount, "Impuestos: " + amount_taxes, "Cantidad: " + qty, "Beneficio: " + benefit, "Precio venta: " + sale_price)

		if(importe > 0 && !isNaN(sale_price) && qty > 0){

			$('input[name="sale_price"]').val(sale_price);

			return;

		}

		$('input[name="sale_price"]').val(null);

	}

	/**
	 * Renderizar la respuesta al añadir el detalle de la factura
	 */

	const renderItems = (invoice = null) => {
		let table = $('table > tbody.table-products');

		$(table).find('tr').remove();

		let total_discount = parseFloat(0.00);
		let total_taxes = parseFloat(0.00);
		let total_import = parseFloat(0.00);

		if(invoice == null)
		{
			$("th[discount]").html(total_discount.toFixed(0) + " ARS");
			$("th[taxes]").html(total_taxes.toFixed(0) + " ARS");
			$("th[total]").html(total_import.toFixed(0) + " ARS");

			showSwal("Factura almacenada", "info", "Éxito!")
			.then(
				(result) => {
					location.reload();
				},
				(result) => {
					location.reload();
				}
			)

			return;
		}

		let details = invoice.invoice_details;

		$.each(details, (key, detail) => {

			let tr = $("<tr></tr>").attr('data-detail', detail.id);

			let button = $("<button style='margin-top:10px;'></button>").attr('type', 'button').addClass('btn btn-block btn-danger btn-xs delete-detail');
			$(button).append($("<i></>").addClass('fa fa-close'));

			let total = parseFloat(0.00);
			detail.total_discount = detail.total_discount || parseFloat(0.00).toFixed(2);

			total = ((parseFloat(detail.subtotal) - parseFloat(detail.total_discount)) + parseFloat(detail.total_taxes));
			total = parseFloat(total).toFixed(0);

			total_discount = parseFloat(total_discount) + parseFloat(detail.total_discount);
			total_taxes = parseFloat(total_taxes) + parseFloat(detail.total_taxes);
			total_import = parseFloat(total_import) + parseFloat(total);

			$(tr).append($("<td></td>").html(detail.product.name + '</br>' + detail.qty + " X " + $.fn.money(detail.price) ));
			$(tr).append($("<td style='text-align: right;'></td>").html('<b>Desc.: </b>' + $.fn.money(detail.total_discount) + '</br> <b>Imp.: </b>' + $.fn.money(detail.total_taxes) ));
			$(tr).append($("<td style='text-align: right; line-height: 40px;'></td>").html($.fn.money(total) ));
			$(tr).append($("<td style='text-align: right;'></td>").append(button));

			$(table).append(tr);

			$('form.invoice-add-item')[0].reset()
			$('select.select2, select.select2-product, select.select2-taxes').val(null).trigger('change');

			$('input[name="distribuir"]').collapse('hide').promise().done(ev => {
				$("input[name='qty']").removeAttr('readonly')
			});

		});

		$("th[discount]").html($.fn.money(total_discount.toFixed(0)));
		$("th[taxes]").html($.fn.money(total_taxes.toFixed(0)));
		$("th[total]").html($.fn.money(total_import.toFixed(0)));
	}

	const deleteItem = (id) => {

		let url = "{{ route('details.destroy', ['detail' => 'variable']) }}".replace("variable", id);
		let data = {
			_token: '{{ csrf_token() }}',
			_method: "DELETE",
		};

		return requestAjax(url, "POST", data);

	}

	const finish = () => {

		let url = "{{ route('invoices.finish') }}";
		let data = {
			_token: '{{ csrf_token() }}'
		};

		return requestAjax(url, 'POST', data);
	}

	const cancel = () => {

		let url = "{{ route('invoices.cancel') }}";
		let data = {
			_token: '{{ csrf_token() }}'
		};

		return requestAjax(url, 'POST', data);
	}

	if(invoice !== null) {
		renderItems(JSON.parse(invoice));
	}

})
</script>
@endsection
