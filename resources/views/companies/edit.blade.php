@extends('adminlte::page')

@section('content')

    
	{{ Form::model($company, ['route' => ['companies.update', $company->id] , 'files' => true, 'method' => 'patch' ]) }}

		{{ Form::token() }}

		<div class="row">
			<div class="col-md-12">
		        <div class="nav-tabs-custom">
		          <ul class="nav nav-tabs">
		            <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true"><span class="badge"> 1</span> Datos de Empresa  </a></li>
		            <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false"><span class="badge"> 2</span> Datos de Contacto</a></li>
		            <li class=""><a href="#banck" data-toggle="tab" aria-expanded="false"><span class="badge">3</span> Bancos</a></li>
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
				                    <h3 class="timeline-header"><a href="#">Datos de Empresa </a> </h3>
				                    <div class="timeline-body">
				                    	
				                    	<div class="row">
						                      	<div class="col-md-4 @if($errors->has('name')) has-error @endif">
													<div class="form-group">
														{{ Form::label('Nombre') }}
														{{ Form::text('name', $company->name, ['class' => 'form-control']) }}

														@if($errors->has('name'))
															<span class="help-block">(*) {{$errors->first('name')}}</span>
														@endif
													</div>
												</div>

												<div class="col-md-4 @if($errors->has('webpage')) has-error @endif">
													<div class="form-group">
														{{ Form::label('Página Web') }}
														{{ Form::text('webpage', $company->profile->webpage, ['class' => 'form-control']) }}

														@if($errors->has('webpage'))
															<span class="help-block">(*) {{$errors->first('webpage')}}</span>
														@endif
													</div>
												</div>
										</div>

										<div class="row">
												<div class="col-md-4 @if($errors->has('profile.image')) has-error @endif">
														<div class="form-group">
														{{ Form::label('Imagen') }}

															<div class="input-group">
																
																<a href="{{asset('uploads/companies/'.$company->profile->image)}}" data-lightbox="{{$company->name}}" data-title="{{$company->name}}">
																	<img src="{{asset('uploads/companies/'.$company->profile->image)}}" alt="{{$company->name}}">
																</a>

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
												                        <input type="file" accept="image/png, image/jpeg, image/gif" name="profile[image]"/> <!-- rename it -->
												                    </div>
												                </span>
												            </div><!-- /input-group image-preview [TO HERE]--> 
												            @if($errors->has('profile.image'))
																<span class="help-block">(*) {{$errors->first('profile.image')}}</span>
															@endif
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
		                    		<div class="col-md-4 @if($errors->has('profile.email')) has-error @endif">
										{{ Form::text('profile[email]', old('profile[email]'), ['class' => 'form-control']) }}

										@if($errors->has('profile.email'))
											<span class="help-block">(*) {{$errors->first('profile.email')}}</span>
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
		                    		<div class="col-md-4 @if($errors->has('profile.phone1')) has-error @endif">
										{{ Form::text('profile[phone1]', old('profile[phone1]'), ['class' => 'form-control', 'placeholder' => 'Teléfono']) }}

										@if($errors->has('profile.phone1'))
											<span class="help-block">(*) {{$errors->first('profile.phone1')}}</span>
										@endif
									</div>

									<div class="col-md-4 @if($errors->has('profile.phone2')) has-error @endif">
										{{ Form::text('profile[phone2]', old('profile[phone2]'), ['class' => 'form-control', 'placeholder' => 'Teléfono']) }}

										@if($errors->has('profile.phone2'))
											<span class="help-block">(*) {{$errors->first('profile.phone2')}}</span>
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
											{!! Form::text('location', $company->profile->location, ['class' => 'form-control']) !!}

											@if($errors->has('location'))
												<span class="help-block">(*) {{ $errors->first('location') }}</span>
											@endif
										</div>

										<div class="col-md-4 @if($errors->has('postal_code')) has-error @endif">
					                    	{{ Form::label('Código Postal') }} <br>
													
											{!! Form::text('postal_code', $company->profile->postal_code, ['class' => 'form-control']) !!}


											@if($errors->has('postal_code'))
												<span class="help-block">(*) {{$errors->first('postal_code')}}</span>
											@endif
										</div>

										<div class="col-md-4 @if($errors->has('district')) has-error @endif">
											{{ Form::label('Barrio') }}
											{{ Form::text('district', $company->profile->district, ['class' => 'form-control']) }}

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
											{{ Form::text('between_street', $company->profile->between_street, ['class' => 'form-control']) }}

											@if($errors->has('between_street'))
												<span class="help-block">(*) {{$errors->first('between_street')}}</span>
											@endif
										</div>
										<div class="col-md-4">
											{{ Form::label('Coordenadas') }}
											{{ Form::text('coordinates', $company->profile->coordinates, ['class' => 'form-control']) }}
										</div>
									</div>
		                    	</div>

		                    	<div class="form-group">

		                    	<div class="row">

		                    		
		                    		<div class="col-md-4 @if($errors->has('profile.postal_code')) has-error @endif">
		                    			{{ Form::label('Código Postal') }}
										{{ Form::text('profile[postal_code]', old('profile[postal_code]'), ['class' => 'form-control',  'maxlength' => 8]) }}

										@if($errors->has('profile.postal_code'))
											<span class="help-block">(*) {{$errors->first('profile.postal_code')}}</span>
										@endif

									</div>

									<div class="col-md-8 @if($errors->has('profile.address')) has-error @endif">
										{{ Form::label('Dirección') }}
										{{ Form::text('profile[address]', old('profile[address]'), ['class' => 'form-control']) }}

										@if($errors->has('profile.address'))
											<span class="help-block">(*) {{$errors->first('profile.address')}}</span>
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

		            <div class="tab-pane" id="banck">
		              <!-- Datos Personales -->
		              <div class="post">
		                <div class="user-block">
		                  <!--<img class="img-circle img-bordered-sm" src="{{asset('img/avatar.png')}}" alt="user image">-->
		                      
		                    <ul class="timeline timeline-inverse">
								<li>
				                  <i class="fa fa-bank bg-blue"></i>
				                  <div class="timeline-item">
				                    <h3 class="timeline-header"><a href="#">Datos de bancos </a> </h3>
				                    <div class="timeline-body">
				                    	@foreach($banks as $key => $bank)
					                    	<div class="row">
						                      	<div class="col-md-3 @if($errors->has('bank')) has-error @endif">
													<div class="form-group">
														{{ Form::label('Banco') }}
														<input type="text" name="bank[]" id="bank" value="{{ $bank->bank}}" class="form-control">
														@if($errors->has('bank'))
															<span class="help-block">(*) {{$errors->first('bank')}}</span>
														@endif
													</div>
												</div>
												<div class="col-md-3 @if($errors->has('cbu')) has-error @endif">
													<div class="form-group">
														{{ Form::label('N CBU') }}
														<input type="text" name="cbu[]" id="cbu" value="{{ $bank->cbu}}" class="form-control">
														@if($errors->has('cbu'))
															<span class="help-block">(*) {{$errors->first('cbu')}}</span>
														@endif
													</div>
												</div>

												<div class="col-md-3 @if($errors->has('number')) has-error @endif">
													<div class="form-group">
														{{ Form::label('N Cuenta') }}
														<input type="text" name="number[]" id="number" value="{{ $bank->number}}" class="form-control">

														@if($errors->has('number'))
															<span class="help-block">(*) {{$errors->first('number')}}</span>
														@endif
													</div>
												</div>

												<div class="col-md-3 @if($errors->has('alias')) has-error @endif">
													<div class="form-group">
														{{ Form::label('Alias') }}
														<input type="text" name="alias[]" id="alias" value="{{ $bank->alias}}" class="form-control">

														@if($errors->has('alias'))
															<span class="help-block">(*) {{$errors->first('alias')}}</span>
														@endif
													</div>
												</div>
											</div>
										@endforeach
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

	{{ Form::close() }}

@stop


@section('js')
	<script src="{{asset('js/cities.js')}}"></script>
@stop