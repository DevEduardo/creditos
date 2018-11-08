
<div class="row">
	<div class="col-md-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#personal" data-toggle="tab" aria-expanded="true"><span class="badge"> 1</span> Información Personal  </a></li>
            <li class=""><a href="#contact" data-toggle="tab" aria-expanded="false"><span class="badge"> 2</span> Información de Contacto</a></li>
            
            {{-- <li class="disabled"><a href="#" data-toggle="tab" aria-expanded="false"><span class="badge"> 3</span> Información Laboral</a></li> --}}

          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="personal">
              <!-- Datos Personales -->
              <div class="post">
                <div class="user-block">
                    <ul class="timeline timeline-inverse">
						<li>
		                	<i class="fa fa-user bg-blue"></i>
			                <div class="timeline-item">
			                    <h3 class="timeline-header"><a href="#">Datos Personales </a> </h3>
			                    <div class="timeline-body">

			                    	<div class="row">
				                      	<div class="col-md-4  @if($errors->has('name')) has-error @endif">
											<div class="form-group">
												{{ Form::label('Nombre Completo') }}

												{{ Form::text('name', null, ['class' => 'form-control']) }}

												@if($errors->has('name'))
													<span class="help-block">(*) {{$errors->first('name')}}</span>
												@endif
											</div>
										</div>

										<div class="col-md-4  @if($errors->has('dni')) has-error @endif">
											<div class="form-group">
												{{ Form::label('DNI') }}

												{{ Form::text('dni', null, ['class' => 'form-control', 'pattern' => '[0-9]{4,99}', 'title' => 'Solo números']) }}

												@if($errors->has('dni'))
													<span class="help-block">(*) {{$errors->first('dni')}}</span>
												@endif
											</div>
										</div>

										<div class="col-md-4  @if($errors->has('image_dni')) has-error @endif">
					                    	<div class="form-group">
												{{ Form::label('Imagen DNI') }}

												{{ Form::file('image_dni', ['class' => 'form-control']) }}

										        @if($errors->has('image_dni'))
													<span class="help-block">(*) {{$errors->first('image_dni')}}</span>
												@endif
											</div>
			                    		</div> 
									</div>

									<div class="row">
										<div class="col-md-4  @if($errors->has('email')) has-error @endif">
											<div class="form-group">
												{{ Form::label('Correo Electrónico') }}

												{{ Form::text('email', null, ['class' => 'form-control']) }}

												@if($errors->has('email'))
													<span class="help-block">(*) {{$errors->first('email')}}</span>
												@endif
											</div>
										</div>

										<div class="col-md-4  @if($errors->has('client_type_id')) has-error @endif">
											<div class="form-group">
												{{ Form::label('Tipo de Cliente') }}

												{{ Form::select('client_type_id', $type_clients, null, ['class' => 'form-control', 'placeholder' => '--Seleccione--', 'id' => 'client_type']) }}

												@if($errors->has('client_type_id'))
													<span class="help-block">(*) {{$errors->first('client_type_id')}}</span>
												@endif
											</div>
										</div>

										<div class="col-md-4  @if($errors->has('image_service')) has-error @endif">
					                    	<div class="form-group">
												{{ Form::label('Imagen de Servicio') }}
										            
									            {{ Form::file('image_service', ['class' => 'form-control']) }}

									            @if($errors->has('image_service'))
													<span class="help-block">(*) {{$errors->first('image_service')}}</span>
												@endif
											</div>
			                    		</div> 
		                    		</div> <!-- row-->

									<div class="row">
										<div class="col-md-4  @if($errors->has('profession')) has-error @endif">
											<div class="form-group">
												{{ Form::label('Profesión / Ocupación') }}

												{{ Form::text('profession', null, ['class' => 'form-control']) }}

												@if($errors->has('profession'))
													<span class="help-block">(*) {{$errors->first('profession')}}</span>
												@endif
											</div>
										</div>

										<div class="col-md-4">
											<div class="row">
												<div class="col-md-6 @if($errors->has('is_working')) has-error @endif">
													<div class="form-group">
														{{ Form::label('Trabaja Actualmente') }}
														<br>
														<label class="radio-inline">
															
															<input type="radio" name="is_working" value="1" checked="" > <b>Si</b>
														</label>
														
														<label class="radio-inline">
															
															<input type="radio" name="is_working" value="0"> 
															<b>No</b>
														</label>

														@if($errors->has('is_working'))
															<span class="help-block">(*) {{$errors->first('is_working')}}</span>
														@endif
													</div>	
												</div>
												<div class="col-md-6">
													<div class="form-group">
														@ability('Master', 'admin-clients')
														{{ Form::label('Aplica para Motos') }}
														{{ Form::checkbox('applies_moto', true) }}
														@endability
													</div>
												</div>
											</div>
										</div>

										<div class="col-md-4  @if($errors->has('receipt_payment')) has-error @endif">
					                    	<div class="form-group">
												{{ Form::label('Recibo de Pago') }}

												{{ Form::file('receipt_payment', ['class' => 'form-control']) }}

										        @if($errors->has('receipt_payment'))
													<span class="help-block">(*) {{$errors->first('receipt_payment')}}</span>
												@endif
											</div>
			                    		</div> 
									</div>

		                    		<div class="row" id="enterprises_div">
										<div class="col-md-12">
											<div class="row">
												<div class="col-md-12">
													<h5><strong>Información laboral o de la empresa</strong></h5>
												</div>
											</div>
					                      	<div class="row">
					                    		<div class="col-md-4 @if($errors->has('enterprise.name')) has-error @endif">
					                    			<div class="form-group">	
						                    			{{ Form::label('Nombre') }}
														{{ Form::text('enterprise[name]', null, ['class' => 'form-control']) }}

														@if($errors->has('enterprise.name'))
															<span class="help-block">(*) {{$errors->first('enterprise.name')}}</span>
														@endif
					                    			</div>
												</div>
					                    	
					                    		<div class="col-md-4 @if($errors->has('enterprise.cuit')) has-error @endif">
					                    			<div class="form-group">
						                    			{{ Form::label('CUIT') }}
														{{ Form::text('enterprise[cuit]', null, ['class' => 'form-control']) }}
														
														@if($errors->has('enterprise.cuit'))
															<span class="help-block">(*) {{$errors->first('enterprise.cuit')}}</span>
														@endif
					                    			</div>
												</div>

												<div class="col-md-4 @if($errors->has('enterprise.email')) has-error @endif">
													<div class="form-group">
														{{ Form::label('Email') }}
														{{ Form::text('enterprise[email]', null, ['class' => 'form-control']) }}

														@if($errors->has('enterprise.email'))
															<span class="help-block">(*) {{$errors->first('enterprise.email')}}</span>
														@endif
													</div>
												</div>
					                    	</div>

					                    	<div class="row">
		                						<div class="col-md-4 @if($errors->has('enterprise.location')) has-error @endif">
		                							<div class="form-group">
		                								{{ Form::label('Localidad') }}
			                							{!! Form::text('enterprise[location]', null, ['class' => 'form-control']) !!}

			                							@if($errors->has('enterprise.location'))
			                								<span class="help-block">(*) {{ $errors->first('enterprise.location') }}</span>
			                							@endif
		                							</div>
		                						</div>

		                						<div class="col-md-4 @if($errors->has('enterprise.postal_code')) has-error @endif">
		                							<div class="form-group">
		                								{{ Form::label('Código Postal') }}	
			                							{!! Form::text('enterprise[postal_code]', null, ['class' => 'form-control']) !!}

			                							@if($errors->has('enterprise.postal_code'))
			                								<span class="help-block">(*) {{$errors->first('enterprise.postal_code')}}</span>
			                							@endif
		                							</div>
		                						</div>

		                						<div class="col-md-4 @if($errors->has('enterprise.district')) has-error @endif">
		                							<div class="form-group">
		                								{{ Form::label('Barrio') }}
			                							{{ Form::text('enterprise[district]', null, ['class' => 'form-control']) }}

			                							@if($errors->has('enterprise.district'))
			                								<span class="help-block">(*) {{$errors->first('enterprise.district')}}</span>
			                							@endif
		                							</div>
		                						</div>
		                					</div>

											<div class="row">
												<div class="col-md-4 @if($errors->has('enterprise.between_street')) has-error @endif">
													{{ Form::label('Entrecalle') }}
													{{ Form::text('enterprise[between_street]', null, ['class' => 'form-control']) }}

													@if($errors->has('enterprise.between_street'))
														<span class="help-block">(*) {{$errors->first('enterprise.between_street')}}</span>
													@endif
												</div>

												<div class="col-md-4">
													{{ Form::label('Coordenadas') }}
													{{ Form::text('enterprise[coordinates]', null, ['class' => 'form-control']) }}
												</div>
											</div>

											<div class="row">
												<div class="col-md-12">
													<h5><strong>Teléfonos</strong></h5>
												</div>
											</div>
		        	                      	<div class="row">
		        	                    		<div class="col-md-4 @if($errors->has('enterprise.phone1')) has-error @endif">
		        	                    			<div class="form-group">
		        	                    				{{ Form::text('enterprise[phone1]', null, ['class' => 'form-control', 'placeholder' => 'Teléfono']) }}

			        									@if($errors->has('enterprise.phone1'))
			        										<span class="help-block">(*) {{$errors->first('enterprise.phone1')}}</span>
			        									@endif
		        	                    			</div>
		        								</div>

		        								<div class="col-md-4 @if($errors->has('enterprise.phone2')) has-error @endif">
		        									<div class="form-group">
		        										{{ Form::text('enterprise[phone2]', null, ['class' => 'form-control', 'placeholder' => 'Teléfono']) }}

			        									@if($errors->has('enterprise.phone2'))
			        										<span class="help-block">(*) {{$errors->first('enterprise.phone2')}}</span>
			        									@endif
		        									</div>
		        								</div>
		        	                    	</div>

		        	                    	<div class="row">
		        	                    		<div class="col-md-12 @if($errors->has('enterprise.address')) has-error @endif">
		        	                    			<div class="form-group">
		        	                    				{{ Form::label('Dirección') }}
		        	                    				{{ Form::text('enterprise[address]', null, ['class' => 'form-control']) }}

		        	                    				@if($errors->has('enterprise.address'))
		        	                    					<span class="help-block">(*) {{$errors->first('enterprise.address')}}</span>
		        	                    				@endif
		        	                    			</div>
		        	                    		</div>
		        	                    	</div>
										</div>
		                    		</div>
			                  	</div> <!-- timeline-body -->
			                </div>
		                </li>
						<!-- /.timeline-label -->
		                <!-- timeline item -->
		            </ul>
				</div> <!-- user-block-->
              </div>
            </div>
                <!-- /.post -->
            
              <!-- /.Datos Personales -->
			          
            <!-- /.tab-personal -->



            <div class="tab-pane" id="contact">
              <!-- The timeline -->
              <ul class="timeline timeline-inverse">
                <!-- END timeline item -->
                <!-- timeline item -->
                <li>
                  <i class="fa fa-phone bg-blue"></i>
                  <div class="timeline-item">
                    <h3 class="timeline-header"><a href="#">Teléfonos </a> </h3>
                    <div class="timeline-body" id="phones-form">
                      	<div class="row">
                    		<div class="col-md-4 @if($errors->has('phone1.0')) has-error @endif">
								{{ Form::text('phone1[]', null, ['class' => 'form-control', 'placeholder' => 'Teléfono', 'multiple']) }}

								@if($errors->has('phone1.0'))
									<span class="help-block">(*) {{$errors->first('phone1.0')}}</span>
								@endif
							</div>
							<div class="col-md-4 @if($errors->has('phone1.0')) has-error @endif">
								{{ Form::text('desc_phone[]', null, ['class' => 'form-control', 'placeholder' => 'Descripción', 'multiple']) }}

								@if($errors->has('desc_phone'))
									<span class="help-block">(*) {{$errors->first('desc_phone')}}</span>
								@endif
							</div>
							<div class="col-md-4">
								<button id="add-phone" type="button" class="btn btn-success" title="Agregar nuevo número telefonico">
									<span class="fa fa-plus"></span>
								</button>
							</div>
							{{--
							<div class="col-md-4 @if($errors->has('phone2')) has-error @endif">
								{{ Form::text('phone2', null, ['class' => 'form-control', 'placeholder' => 'Teléfono']) }}

								@if($errors->has('phone2'))
									<span class="help-block">(*) {{$errors->first('phone2')}}</span>
								@endif
							</div>
							--}}
                    	</div>
                    </div>
                  </div>
                </li>
                <!-- END timeline item -->
                <!-- timeline item -->
                <li>
                  <i class="fa fa-globe bg-blue"></i>
                  <div class="timeline-item">
                    <h3 class="timeline-header"><a href="#"> Dirección </a></h3>
                    <div class="timeline-body">

                    	<div class="form-group">
				
							<div class="row">

								<div class="col-md-4 @if($errors->has('location')) has-error @endif">
									{{ Form::label('Localidad') }}
									{!! Form::text('location', null, ['class' => 'form-control']) !!}

									@if($errors->has('location'))
										<span class="help-block">(*) {{ $errors->first('location') }}</span>
									@endif
								</div>

								<div class="col-md-4 @if($errors->has('postal_code')) has-error @endif">
			                    	{{ Form::label('Código Postal') }} <br>
											
									{!! Form::text('postal_code', null, ['class' => 'form-control']) !!}


									@if($errors->has('postal_code'))
										<span class="help-block">(*) {{$errors->first('postal_code')}}</span>
									@endif
								</div>

								<div class="col-md-4 @if($errors->has('district')) has-error @endif">
									{{ Form::label('Barrio') }}
									{{ Form::text('district', null, ['class' => 'form-control']) }}

									@if($errors->has('district'))
										<span class="help-block">(*) {{$errors->first('district')}}</span>
									@endif
								</div>
							</div>
                    		
                    	</div>

                    	<div class="form-group">
				
							<div class="row">

								<div class="col-md-4 @if($errors->has('between_street')) has-error @endif">
									{{ Form::label('Entrecalle') }}
									{{ Form::text('between_street', null, ['class' => 'form-control']) }}

									@if($errors->has('between_street'))
										<span class="help-block">(*) {{$errors->first('between_street')}}</span>
									@endif
								</div>

								<div class="col-md-4">
									{{ Form::label('Coordenadas') }}
									{{ Form::text('coordinates', null, ['class' => 'form-control']) }}
								</div>
							</div>
                    		
                    	</div>

                    	<div class="form-group">

                    	<div class="row">

							<div class="col-md-12 @if($errors->has('address')) has-error @endif">
								{{ Form::label('Dirección') }}

								{{ Form::text('address', null, ['class' => 'form-control']) }}

								@if($errors->has('address'))
									<span class="help-block">(*) {{$errors->first('address')}}</span>
								@endif
							</div>
						</div>
                    	</div>
                    	<div class="form-group">

	                    	<div class="row">

								<div class="col-md-12">
									{{ Form::label('Dirección Anterior:') }}

									{{ Form::text('prev_address', null, ['class' => 'form-control']) }}
								</div>
							</div>
                    	</div>
                    </div>
                    
                  </div>
                </li>
              </ul>
            </div>
            
            <!-- Empresa -->

			{{-- <div class="tab-pane" id="enterprise">
	             <ul class="timeline timeline-inverse">
	                <li>
	                  <i class="fa fa-building bg-blue"></i>
	                  <div class="timeline-item">
	                    <h3 class="timeline-header"><a href="#">Empresa </a> </h3>
	                    <div class="timeline-body">
	                      	
	                    </div>
	                  </div>
	                </li>
	                <!-- END timeline item -->
	                <!-- timeline item -->
	                <li>
	                  <i class="fa fa-phone bg-blue"></i>
	                  <div class="timeline-item">
	                    <h3 class="timeline-header"><a href="#">Teléfonos </a> </h3>
	                    <div class="timeline-body">
	                      	<div class="row">
	                    		<div class="col-md-4 @if($errors->has('enterprise[phone1]')) has-error @endif">
									{{ Form::text('enterprise[phone1]', null, ['class' => 'form-control', 'placeholder' => 'Teléfono']) }}
									@if($errors->has('enterprise[phone1]'))
										<span class="help-block">(*) {{$errors->first('enterprise[phone1]')}}</span>
									@endif
								</div>

								<div class="col-md-4 @if($errors->has('enterprise[phone2]')) has-error @endif">
									{{ Form::text('enterprise[phone2]', null, ['class' => 'form-control', 'placeholder' => 'Teléfono']) }}
									@if($errors->has('enterprise[phone2]'))
										<span class="help-block">(*) {{$errors->first('enterprise[phone2]')}}</span>
									@endif
								</div>
	                    	</div>
	                    </div>
	                  </div>
	                </li>
	                <!-- END timeline item -->
	                <!-- timeline item -->
	                <li>
	                  <i class="fa fa-globe bg-blue"></i>
	                  <div class="timeline-item">
	                    <h3 class="timeline-header"><a href="#"> Dirección </a></h3>
	                    <div class="timeline-body">

	                    	<div class="form-group">
							
								<div class="row">
									<div class="col-md-4">
										{{ Form::label('Provincia') }}
										{{ Form::select('enterprise[state_id]', $states, null, ['class' => 'form-control', 'placeholder' => ' -- Seleccciona -- ']) }}
									</div>

									<div class="col-md-4">
										{{ Form::label('Localidad') }}
										<select name="enterprise[city_id]" id="city" class="form-control">
										</select>
									</div>


									<div class="col-md-4 @if($errors->has('enterprise[postal_code]')) has-error @endif">
		                    			{{ Form::label('Código Postal') }} <br>
										
										<select name="enterprise[postal_code]" class="form-control">
											
										</select>


										@if($errors->has('enterprise[postal_code]'))
											<span class="help-block">(*) {{$errors->first('enterprise[postal_code]')}}</span>
										@endif
									</div>
								</div>	
	
	                    	</div>

	                    	<div class="form-group">

	                    	<div class="row">

								<div class="col-md-12 @if($errors->has('enterprise[address]')) has-error @endif">
									{{ Form::label('Dirección') }}
									{{ Form::text('enterprise[address]', null, ['class' => 'form-control']) }}
									@if($errors->has('enterprise[address]'))
										<span class="help-block">(*) {{$errors->first('enterprise[address]')}}</span>
									@endif
								</div>
							</div>
	                    	</div>
	                    </div>
	                    
	                  </div>
	                </li>
	              </ul>
            </div> --}}
            
            <!-- /.tab-pane-enterprise -->

          </div>
		</div> <!-- nav-tabs-->
	</div>
</div>

<div class="row">
	<div class="col-md-2">					
		<div class="form-group">
			{{ Form::submit('Guardar', ['class' => 'btn btn-success']) }}
		</div>

	</div>
</div>

@section('js')
	@parent

	<script>
		$(document).ready(function() {

			$('#enterprises_div').hide();

			if ($('#client_type').val() == 2) {
				$('#enterprises_div').show();	
			}
			
			$('#enterprises').select2();
			$('#client_type').select2(); 

			$('#client_type').on('change', function (ev){
				if ($('#client_type').val() == 2) {
					$('#enterprises_div').show();	
				}else{
					$('#enterprises_div').hide();
				}
			});


			let url = "#enterprise";
			$("select[name='enterprise_id']").on('change', function (e){
				$("ul.nav.nav-tabs li:eq(2)").addClass('disabled').find('a').attr("href", '#');

				if( $("select[name='enterprise_id']").val() == 'new'){
					$("ul.nav.nav-tabs li:eq(2)").removeClass('disabled').find('a').attr("href", url);
				}
			});
		});

		$('button#add-phone').on('click', function (){
			var html = `
				<div class="row" style="margin-top: 10px;">
					<div class="col-md-4">
						{{ Form::text('phone1[]', null, ['class' => 'form-control', 'placeholder' => 'Teléfono', 'multiple']) }}
					</div>
					<div class="col-md-4">
						{{ Form::text('desc_phone[]', null, ['class' => 'form-control', 'placeholder' => 'Descripción', 'multiple']) }}
					</div>
					<div class="col-md-4">
						<button type="button" class="btn btn-danger" title="Eliminar teléfono" onclick="delete_phone(this);">
							<span class="fa fa-minus"></span>
						</button>
					</div>
				</div>
			`;

			$('div#phones-form').append(html);
		});

		function delete_phone(button) {
			$(button).parents('div.row').first().remove();
		}
	</script>

	<script src="{{asset('js/cities.js')}}"></script>

@stop