<div class="row">
	<div class="col-md-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true"><span class="badge"> 1</span> Datos del Proveedor  </a></li>
            <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false"><span class="badge"> 2</span> Datos de Contacto</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="activity">
              <!-- Datos Personales -->
              <div class="post">
                <div class="user-block">
                  <!--<img class="img-circle img-bordered-sm" src="{{asset('img/avatar.png')}}" alt="user image">-->
                      
                    <ul class="timeline timeline-inverse">
						<li>
		                  <i class="fa fa-user bg-blue"></i>
		                  <div class="timeline-item">
		                    <h3 class="timeline-header"><a href="#">Datos del Proveedor </a> </h3>
		                    <div class="timeline-body">
		                    	
								{{ Form::hidden('company_id', 1) }}

		                    	<div class="row">
				                      	<div class="col-md-4 @if($errors->has('name')) has-error @endif">
											<div class="form-group">
												{{ Form::label('Nombre') }}
												
												{{ Form::text('name', null, ['class' => 'form-control']) }}

												@if($errors->has('name'))
													<span class="help-block">(*) {{$errors->first('name')}}</span>
												@endif
											</div>
										</div>

										<div class="col-md-4 @if($errors->has('cuit')) has-error @endif">
											<div class="form-group">
												{{ Form::label('CUIT') }}

												{{ Form::text('cuit', null, ['class' => 'form-control']) }}

												@if($errors->has('cuit'))
													<span class="help-block">(*) {{$errors->first('cuit')}}</span>
												@endif
											</div>
										</div>

										<div class="col-md-4 @if($errors->has('is_active')) has-error @endif">
											<div class="form-group">
												{{ Form::label('Activo') }}
												
												{{ Form::select('is_active', [1 => 'Si', 0 => 'No'], null, ['class' => 'form-control']) }}

												@if($errors->has('is_active'))
													<span class="help-block">(*) {{$errors->first('is_active')}}</span>
												@endif
											</div>
										</div>

										
								</div>

								<div class="row">

									<div class="col-md-4 @if($errors->has('webpage')) has-error @endif">
											<div class="form-group">
												{{ Form::label('Página Web') }}
												
												{{ Form::text('webpage', null, ['class' => 'form-control']) }}

												@if($errors->has('webpage'))
													<span class="help-block">(*) {{$errors->first('webpage')}}</span>
												@endif
											</div>
										</div>

									<div class="col-md-4 @if($errors->has('image')) has-error @endif">
										<div class="form-group">
											{{ Form::label('Imagen') }}
										
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
											            <input type="file" accept="image/png, image/jpeg, image/gif" name="image"/> <!-- rename it -->
											        </div>
											    </span>
											</div><!-- /input-group image-preview [TO HERE]--> 

											@if($errors->has('image'))
												<span class="help-block">(*) {{$errors->first('image')}}</span>
											@endif
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
                <!-- /.post -->
            </div>
              <!-- /.Datos Personales -->
			          
            <!-- /.tab-pane -->
            <div class="tab-pane" id="timeline">
              <!-- The timeline -->
              <ul class="timeline timeline-inverse">
                <!-- END timeline item -->
                <!-- timeline item -->
                <li>
                  <i class="fa fa-envelope bg-blue"></i>
                  <div class="timeline-item">
                    <h3 class="timeline-header"><a href="#">Email </a> </h3>
                    <div class="timeline-body">
                      	<div class="row">
                    		<div class="col-md-4 @if($errors->has('email')) has-error @endif">
								{{ Form::text('email', null, ['class' => 'form-control']) }}
								@if($errors->has('email'))
									<span class="help-block">(*) {{$errors->first('email')}}</span>
								@endif
							</div>

                    	</div>
                    </div>
                  </div>
                </li>

                <li>
                  <i class="fa fa-phone bg-blue"></i>
                  <div class="timeline-item">
                    <h3 class="timeline-header"><a href="#">Teléfonos </a> </h3>
                    <div class="timeline-body">
                      	<div class="row">
                    		<div class="col-md-4 @if($errors->has('phone1')) has-error @endif">
								
								{{ Form::text('phone1', null, ['class' => 'form-control', 'placeholder' => 'Teléfono']) }}

								@if($errors->has('email'))
									<span class="help-block">(*) {{$errors->first('phone1')}}</span>
								@endif
							</div>

							<div class="col-md-4 @if($errors->has('phone2')) has-error @endif">

								{{ Form::text('phone2', null, ['class' => 'form-control', 'placeholder' => 'Teléfono']) }}

								@if($errors->has('phone2'))
									<span class="help-block">(*) {{$errors->first('phone2')}}</span>
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
                    </div>
                    
                  </div>
                </li>
              </ul>
            </div>
            <!-- /.tab-pane -->

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