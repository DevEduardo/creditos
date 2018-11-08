@section('css')
	@parent
	
	<style type="text/css">
		input[type="text"] {
			text-transform: uppercase;
		}
	</style>
@endsection

<div class="row">
	<div class="col-md-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true"><span class="badge"> 1</span> Información del Producto  </a></li>
            <!--<li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false"><span class="badge"> 2</span> Información de Contacto</a></li> -->
          </ul>
          	<div class="tab-content">
	            <div class="tab-pane active" id="activity">
	              <!-- Datos Personales -->
	              	<div class="post">
	                	<div class="user-block">
		                    <ul class="timeline timeline-inverse">
								<li>
				                  <i class="fa fa-list bg-blue"></i>
				                  <div class="timeline-item">
				                    <h3 class="timeline-header"><a href="#">Datos del Producto </a> </h3>
				                    <div class="timeline-body">
				                    	
										{{Form::hidden('company_id', 1)}}

				                    	<div class="row">
						                      	<div class="col-md-4 pull-left @if($errors->has('name')) has-error @endif">
													<div class="form-group">
														{{ Form::label('Nombre') }}
														{{ Form::text('name', null, ['class' => 'form-control']) }}

														@if($errors->has('name'))
															<span class="help-block">(*) {{$errors->first('name')}}</span>
														@endif
													</div>
												</div>

												<div class="col-md-4 @if($errors->has('reference')) has-error @endif">
													<div class="form-group">
														{{ Form::label('Código') }}
														{{ Form::text('reference', null, ['class' => 'form-control']) }}

														@if($errors->has('reference'))
															<span class="help-block">(*) {{$errors->first('reference')}}</span>
														@endif
													</div>
												</div>

												<div class="col-md-4 @if($errors->has('status')) has-error @endif">
													<div class="form-group">
														{{ Form::label('Status') }}
														{{ Form::select('status', ['Activo','Inactivo'], null, ['class' => 'form-control']) }}

														@if($errors->has('status'))
															<span class="help-block">(*) {{$errors->first('status')}}</span>
														@endif
													</div>
												</div>
				                    	</div> <!-- row-->


				                    	<div class="row">

											<div class="col-md-4 @if($errors->has('brand')) has-error @endif">
												<div class="form-group">
													{{ Form::label('Marca') }}
													{{ Form::text('brand', null, ['class' => 'form-control']) }}

													@if($errors->has('brand'))
														<span class="help-block">(*) {{$errors->first('brand')}}</span>
													@endif
												</div>
											</div>

											<div class="col-md-4 @if($errors->has('model')) has-error @endif">
												<div class="form-group">
													{{ Form::label('Modelo') }}
													{{ Form::text('model', null, ['class' => 'form-control']) }}

													@if($errors->has('model'))
														<span class="help-block">(*) {{$errors->first('model')}}</span>
													@endif
												</div>
											</div>

											<div class="col-md-4 @if($errors->has('web')) has-error @endif">
												<div class="form-group">
													{{ Form::label('En la web') }}
													{{ Form::checkbox('web', true) }}

													@if($errors->has('web'))
														<span class="help-block">(*) {{$errors->first('web')}}</span>
													@endif
												</div>

												<div class="form-group">
													{{ Form::label('Observación') }}
													{{ Form::checkbox('observation', true) }}

													@if($errors->has('observation'))
														<span class="help-block">(*) {{ $errors->first('observation') }}</span>
													@endif
												</div>
											</div>
										
										</div>

										<div class="row">

											<div class="col-md-4 @if($errors->has('color')) has-error @endif">
												
												<div class="form-group">
													{{ Form::label('Color Primario') }}
													{{ Form::text('color', old('color'), ['class' => 'form-control']) }}

								                  	@if($errors->has('color'))
														<span class="help-block">(*) {{ $errors->first('color') }}</span>
													@endif
									            </div>

											</div>

											<div class="col-md-4">
												<div class="form-group">
													{{ Form::label('Color Secundario') }}
													{{ Form::text('color_secondary', old('color_secondary'), ['class' => 'form-control']) }}
									            </div>
											</div>

											<div class="col-md-4">
												<div class="form-group">
													{{ Form::label('Color Terciario') }}
													{{ Form::text('color_tertiary', old('color_tertiary'), ['class' => 'form-control']) }}
									            </div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-4 @if($errors->has('height')) has-error @endif">
												<div class="form-group">
													{{ Form::label('Alto') }}
													{{ Form::text('height', old('height'), ['class' => 'form-control', 'placeholder' => 'cm']) }}

								                  	@if($errors->has('height'))
														<span class="help-block">(*) {{ $errors->first('height') }}</span>
													@endif
									            </div>
											</div>

											<div class="col-md-4 @if($errors->has('width')) has-error @endif">
												<div class="form-group">
													{{ Form::label('Ancho') }}
													{{ Form::text('width', old('width'), ['class' => 'form-control', 'placeholder' => 'cm']) }}

								                  	@if($errors->has('width'))
														<span class="help-block">(*) {{ $errors->first('width') }}</span>
													@endif
									            </div>
											</div>

											<div class="col-md-4 @if($errors->has('depth')) has-error @endif">
												<div class="form-group">
													{{ Form::label('Profundidad') }}
													{{ Form::text('depth', old('depth'), ['class' => 'form-control', 'placeholder' => 'cm']) }}

								                  	@if($errors->has('depth'))
														<span class="help-block">(*) {{ $errors->first('depth') }}</span>
													@endif
									            </div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-4 @if($errors->has('stock_minimun')) has-error @endif">
												<div class="form-group">
													{{ Form::label('Stock Mínimo') }}
													{{ Form::text('stock_minimun', null, ['class' => 'form-control']) }}

													@if($errors->has('stock_minimun'))
														<span class="help-block">(*) {{$errors->first('stock_minimun')}}</span>
													@endif
												</div>
											</div>

											<div class="col-md-4 @if($errors->has('stock')) has-error @endif">
												<div class="form-group">
													{{ Form::label('Categorías') }}
													{{ Form::select('categories[]', $categories, old('categories[]'), ['class' => 'form-control js-example-basic-multiple',  'multiple'=>'multiple']) }}
												</div>
											</div>
										</div>
		  
				                    	<div class="row">

											<div class="col-md-6">
												<div class="form-group">
													{{ Form::label('Descripción') }}
													{{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3]) }}
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													{{ Form::label('Especificaciones') }}
													{{ Form::textarea('specification', null, ['class' => 'form-control', 'rows' => 3]) }}
												</div>
											</div>
										</div>
				                  	</div> <!-- timeline-body -->
				                  </div>
				                </li>
								<!-- /.timeline-label -->
				                <!-- timeline item -->
				                <li>
				                  <i class="fa fa-money bg-blue"></i>
				                  <div class="timeline-item">
				                    <h3 class="timeline-header"><a href="#">Precios </a> </h3>
				                    <div class="timeline-body">
				                    	<div class="row">
				                    		<div class="col-md-4 @if($errors->has('original_price')) has-error @endif">
				                    			{{ Form::label('Precio Base') }}
												{{ Form::text('original_price', null, ['class' => 'form-control', 'pattern' => '[0-9]{1,999}', 'title' => 'Solo números']) }}

												@if($errors->has('original_price'))
													<span class="help-block">(*) {{$errors->first('original_price')}}</span>
												@endif
											</div>


											<div class="col-md-4 @if($errors->has('price')) has-error @endif">
											<div class="form-group">
												{{ Form::label('Precio Venta') }}
												{{ Form::text('price', null, ['class' => 'form-control', 'pattern' => '[0-9]{1,999}', 'title' => 'Solo números']) }}

												@if($errors->has('price'))
													<span class="help-block">(*) {{$errors->first('price')}}</span>
												@endif
											</div>
										</div>
				                    	</div>
				                    </div>
				                  </div>
				                </li>

				                <li>
				                  <i class="fa fa-image bg-blue"></i>
				                  <div class="timeline-item">
				                    <h3 class="timeline-header"><a href="#">Grupo de Imagenes </a> </h3>
				                    <div class="timeline-body">
				                    	<div class="row">
				                    		<div class="col-md-4 @if($errors->has('image')) has-error @endif">
						                    	<div class="form-group">
													{{ Form::label('Imágenes') }}
											            <!-- image-preview-filename input [CUT FROM HERE]-->
											            <div class="input-group image-preview">
											                <input type="text" class="form-control image-preview-filename" disabled="disabled"> <!-- don't give a name === doesn't send on POST/GET -->
											                <span class="input-group-btn">
											                    <!-- image-preview-clear button -->
											                    <button type="button" class="btn btn-danger image-preview-clear" style="display:none;">
											                        <span class="glyphicon glyphicon-remove"></span> Quitar
											                    </button>
											                    <!-- image-preview-input -->
											                    <div class="btn btn-primary image-preview-input">
											                        <span class="glyphicon glyphicon-folder-open"></span>
											                        <span class="image-preview-input-title">Abrir</span>
											                        <input type="file" accept="image/png, image/jpeg, image/gif" name="image[]" multiple="true" /> <!-- rename it -->
											                    </div>
											                </span>
											            </div><!-- /input-group image-preview [TO HERE]--> 
											            @if($errors->has('image'))
															<span class="help-block">(*) {{$errors->first('image')}}</span>
														@endif


												</div>
				                    		</div> 
										</div>
				                    </div>
				                    </div>
				                  </div>
				                </li>
				            </ul>
						</div> <!-- user-block-->
	            	</div> <!-- /.post -->
	            
	            
	            <div class="tab-pane" id="timeline">
	              <!-- The timeline -->
	              	tab2 <div class="iradio_flat-blue checked" aria-checked="true" aria-disabled="false" style="position: relative;"><input type="radio" name="r3" class="flat-red" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
	            </div>
            	<!-- /.tab-panel2 -->

          	</div>  <!-- /.tab-content -->
		</div> 
	</div>
</div>

<div class="row">
	<div class="col-md-4">					
		{{ Form::submit('Guardar', ['class' => 'btn btn-success']) }}
	</div>
</div>

</div>

@section('js')

<script>
$(document).ready(function() {
    $('.js-example-basic-multiple').select2();

    let current = '<?php echo old('model_id') ?>';
    let url = '{{ url()->current() }}';

    console.info(url.lastIndexOf("/edit"));
    
    if(url.indexOf("/edit") > -1) {
    	current = '{{ isset($product->model_id) ? $product->model_id:"" }}';
    }
	
	const createOptions = (args) => {
		
		let option = [];
		
		$.each(args, (key, val) => {
			option.push($("<option></option").attr('value', key).text(val));
		})

		return option;
	}

	const selectClear = selector => {
		selector.find('option').remove();
		selector.append($('<option>Seleccione una opción</option>'));
	}

	const loadModelByBrand = (brand = null) => {

		let req = $.ajax({
			method: "GET",
			url: "{{ url('/brands/models/') }}" + "/" + brand,
		});
		
		req.done( (data, textStatus, jqXHR) => {
			
			let selector = $("select[name='model_id']");
			selectClear(selector);
			selector.append(createOptions(data));

			if(current) {
				selector.find('option[value="' + current + '"]').attr('selected', 'selected')
			}
		})
		
		req.fail( (jqXHR, textStatus, errorThrown) => {

			selectClear(selector);
		})

	}

	$("select[name='brand_id']").on('change', (e) => {
		
		loadModelByBrand($("select[name='brand_id']").val())
	})

	loadModelByBrand($("select[name='brand_id']").val());
});
</script>

@stop