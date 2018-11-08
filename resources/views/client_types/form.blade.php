<div class="row">
	<div class="col-md-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true"><span class="badge"> 1</span> Información Principal  </a></li>
            
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
		                    <h3 class="timeline-header"><a href="#">Datos Tipo de Cliente </a> </h3>
		                    <div class="timeline-body">
		                    	
		                    		{{Form::hidden('company_id', 1)}}

		                    	<div class="row">
				                      	<div class="col-md-4 @if($errors->has('code')) has-error @endif">
											<div class="form-group">
												{{ Form::label('Código') }}
												{{ Form::text('code', null, ['class' => 'form-control']) }}
												@if($errors->has('code'))
													<span class="help-block">(*) {{$errors->first('code')}}</span>
												@endif
											</div>
										</div>

										<div class="col-md-4 @if($errors->has('name')) has-error @endif">
											<div class="form-group">
												{{ Form::label('Nombre del Tipo de Cliente') }}
												{{ Form::text('name', null, ['class' => 'form-control']) }}
												@if($errors->has('name'))
													<span class="help-block">(*) {{$errors->first('name')}}</span>
												@endif
											</div>
										</div>
								</div>

								<div class="row">
										<div class="col-md-4 @if($errors->has('credit')) has-error @endif">
											<div class="form-group">
												{{ Form::label('Monto Máximo de Crédito') }}
												<!--<input type="number" name='credit' min="0.00" max="99999999.00" step="0.01" class="form-control" maxlength="8"/> -->

												{{Form::text('credit', null, ['class' => 'form-control'])}}
												
												@if($errors->has('credit'))
													<span class="help-block">(*) {{$errors->first('credit')}}</span>
												@endif
											</div>
										</div>


										<div class="col-md-4 @if($errors->has('max_fees')) has-error @endif">
											<div class="form-group">
												{{ Form::label('Monto Máximo de Cuotas') }}
												{{ Form::text('max_fees', null, ['class' => 'form-control']) }}
												@if($errors->has('max_fees'))
													<span class="help-block">(*) {{$errors->first('max_fees')}}</span>
												@endif
											</div>
										</div>

										<div class="clearfix"></div>

										<div class="col-md-4 @if($errors->has('surcharge')) has-error @endif">
											<div class="form-group">
												{{ Form::label('% de recargo del monto financionado') }}
												{{ Form::text('surcharge', null, ['class' => 'form-control']) }}
												@if($errors->has('surcharge'))
													<span class="help-block">(*) {{$errors->first('surcharge')}}</span>
												@endif
											</div>
										</div>

										<div class="col-md-4 @if($errors->has('daily_interest')) has-error @endif">
											<div class="form-group">
												{{ Form::label('% de inter&eacute;s diario') }}
												{{ Form::text('daily_interest', null, ['class' => 'form-control']) }}
												@if($errors->has('daily_interest'))
													<span class="help-block">(*) {{$errors->first('daily_interest')}}</span>
												@endif
											</div>
										</div>
		                    	</div> <!-- row-->
		                    	<hr>
  								<div class="row">
  									<div class="col-md-12">
  										<h4>% de inter&eacute;s de las cuotas</h4>
  									</div>
  								</div>
  								@isset($clientType)
  									<div class="row">
	  									@for($i = 0; $i < 24; $i++)
	  										<div class="col-md-4">
												<div class="form-group">
													{{ Form::label('Cuota N° '.($i+1)) }}
													{{ Form::text('interest[]', json_decode($clientType->interest, true)[$i], ['class' => 'form-control', 'multiple']) }}
													@if($errors->has('interest'))
														<span class="help-block">(*) {{$errors->first('interest')}}</span>
													@endif
												</div>
	  										</div>
	  									@endfor
  									</div>
  								@else
	  								<div class="row">
	  									<div class="col-md-4">
											<div class="form-group">
												{{ Form::label('Cuota N° 1') }}
												{{ Form::text('interest[]', null, ['class' => 'form-control', 'multiple']) }}
												@if($errors->has('interest'))
													<span class="help-block">(*) {{$errors->first('interest')}}</span>
												@endif
											</div>
	  									</div>
	  									<div class="col-md-4">
	  										<div class="form-group">
												{{ Form::label('Cuota N° 2') }}
												{{ Form::text('interest[]', null, ['class' => 'form-control', 'multiple']) }}
												@if($errors->has('interest'))
													<span class="help-block">(*) {{$errors->first('interest')}}</span>
												@endif
											</div>
	  									</div>
	  									<div class="col-md-4">
	  										<div class="form-group">
												{{ Form::label('Cuota N° 3') }}
												{{ Form::text('interest[]', null, ['class' => 'form-control', 'multiple']) }}
												@if($errors->has('interest'))
													<span class="help-block">(*) {{$errors->first('interest')}}</span>
												@endif
											</div>
	  									</div>
	  								</div>
	  								<div class="row">
	  									<div class="col-md-4">
	  										<div class="form-group">
												{{ Form::label('Cuota N° 4') }}
												{{ Form::text('interest[]', null, ['class' => 'form-control', 'multiple']) }}
												@if($errors->has('interest'))
													<span class="help-block">(*) {{$errors->first('interest')}}</span>
												@endif
											</div>
	  									</div>
	  									<div class="col-md-4">
	  										<div class="form-group">
												{{ Form::label('Cuota N° 5') }}
												{{ Form::text('interest[]', null, ['class' => 'form-control', 'multiple']) }}
												@if($errors->has('interest'))
													<span class="help-block">(*) {{$errors->first('interest')}}</span>
												@endif
											</div>
	  									</div>
	  									<div class="col-md-4">
	  										<div class="form-group">
												{{ Form::label('Cuota N° 6') }}
												{{ Form::text('interest[]', null, ['class' => 'form-control', 'multiple']) }}
												@if($errors->has('interest'))
													<span class="help-block">(*) {{$errors->first('interest')}}</span>
												@endif
											</div>
	  									</div>
	  								</div>
	  								<div class="row">
	  									<div class="col-md-4">
	  										<div class="form-group">
												{{ Form::label('Cuota N° 7') }}
												{{ Form::text('interest[]', null, ['class' => 'form-control', 'multiple']) }}
												@if($errors->has('interest'))
													<span class="help-block">(*) {{$errors->first('interest')}}</span>
												@endif
											</div>
	  									</div>
	  									<div class="col-md-4">
	  										<div class="form-group">
												{{ Form::label('Cuota N° 8') }}
												{{ Form::text('interest[]', null, ['class' => 'form-control', 'multiple']) }}
												@if($errors->has('interest'))
													<span class="help-block">(*) {{$errors->first('interest')}}</span>
												@endif
											</div>
	  									</div>
	  									<div class="col-md-4">
	  										<div class="form-group">
												{{ Form::label('Cuota N° 9') }}
												{{ Form::text('interest[]', null, ['class' => 'form-control', 'multiple']) }}
												@if($errors->has('interest'))
													<span class="help-block">(*) {{$errors->first('interest')}}</span>
												@endif
											</div>
	  									</div>
	  								</div>
	  								<div class="row">
	  									<div class="col-md-4">
	  										<div class="form-group">
												{{ Form::label('Cuota N° 10') }}
												{{ Form::text('interest[]', null, ['class' => 'form-control', 'multiple']) }}
												@if($errors->has('interest'))
													<span class="help-block">(*) {{$errors->first('interest')}}</span>
												@endif
											</div>
	  									</div>
	  									<div class="col-md-4">
	  										<div class="form-group">
												{{ Form::label('Cuota N° 11') }}
												{{ Form::text('interest[]', null, ['class' => 'form-control', 'multiple']) }}
												@if($errors->has('interest'))
													<span class="help-block">(*) {{$errors->first('interest')}}</span>
												@endif
											</div>
	  									</div>
	  									<div class="col-md-4">
	  										<div class="form-group">
												{{ Form::label('Cuota N° 12') }}
												{{ Form::text('interest[]', null, ['class' => 'form-control', 'multiple']) }}
												@if($errors->has('interest'))
													<span class="help-block">(*) {{$errors->first('interest')}}</span>
												@endif
											</div>
	  									</div>
	  								</div>
	  								<div class="row">
	  									<div class="col-md-4">
	  										<div class="form-group">
												{{ Form::label('Cuota N° 13') }}
												{{ Form::text('interest[]', null, ['class' => 'form-control', 'multiple']) }}
												@if($errors->has('interest'))
													<span class="help-block">(*) {{$errors->first('interest')}}</span>
												@endif
											</div>
	  									</div>
	  									<div class="col-md-4">
	  										<div class="form-group">
												{{ Form::label('Cuota N° 14') }}
												{{ Form::text('interest[]', null, ['class' => 'form-control', 'multiple']) }}
												@if($errors->has('interest'))
													<span class="help-block">(*) {{$errors->first('interest')}}</span>
												@endif
											</div>
	  									</div>
	  									<div class="col-md-4">
	  										<div class="form-group">
												{{ Form::label('Cuota N° 15') }}
												{{ Form::text('interest[]', null, ['class' => 'form-control', 'multiple']) }}
												@if($errors->has('interest'))
													<span class="help-block">(*) {{$errors->first('interest')}}</span>
												@endif
											</div>
	  									</div>
	  								</div>
	  								<div class="row">
	  									<div class="col-md-4">
	  										<div class="form-group">
												{{ Form::label('Cuota N° 16') }}
												{{ Form::text('interest[]', null, ['class' => 'form-control', 'multiple']) }}
												@if($errors->has('interest'))
													<span class="help-block">(*) {{$errors->first('interest')}}</span>
												@endif
											</div>
	  									</div>
	  									<div class="col-md-4">
	  										<div class="form-group">
												{{ Form::label('Cuota N° 17') }}
												{{ Form::text('interest[]', null, ['class' => 'form-control', 'multiple']) }}
												@if($errors->has('interest'))
													<span class="help-block">(*) {{$errors->first('interest')}}</span>
												@endif
											</div>
	  									</div>
	  									<div class="col-md-4">
	  										<div class="form-group">
												{{ Form::label('Cuota N° 18') }}
												{{ Form::text('interest[]', null, ['class' => 'form-control', 'multiple']) }}
												@if($errors->has('interest'))
													<span class="help-block">(*) {{$errors->first('interest')}}</span>
												@endif
											</div>
	  									</div>
	  								</div>
	  								<div class="row">
	  									<div class="col-md-4">
	  										<div class="form-group">
												{{ Form::label('Cuota N° 19') }}
												{{ Form::text('interest[]', null, ['class' => 'form-control', 'multiple']) }}
												@if($errors->has('interest'))
													<span class="help-block">(*) {{$errors->first('interest')}}</span>
												@endif
											</div>
	  									</div>
	  									<div class="col-md-4">
	  										<div class="form-group">
												{{ Form::label('Cuota N° 20') }}
												{{ Form::text('interest[]', null, ['class' => 'form-control', 'multiple']) }}
												@if($errors->has('interest'))
													<span class="help-block">(*) {{$errors->first('interest')}}</span>
												@endif
											</div>
	  									</div>
	  									<div class="col-md-4">
	  										<div class="form-group">
												{{ Form::label('Cuota N° 21') }}
												{{ Form::text('interest[]', null, ['class' => 'form-control', 'multiple']) }}
												@if($errors->has('interest'))
													<span class="help-block">(*) {{$errors->first('interest')}}</span>
												@endif
											</div>
	  									</div>
	  								</div>
	  								<div class="row">
	  									<div class="col-md-4">
	  										<div class="form-group">
												{{ Form::label('Cuota N° 22') }}
												{{ Form::text('interest[]', null, ['class' => 'form-control', 'multiple']) }}
												@if($errors->has('interest'))
													<span class="help-block">(*) {{$errors->first('interest')}}</span>
												@endif
											</div>
	  									</div>
	  									<div class="col-md-4">
	  										<div class="form-group">
												{{ Form::label('Cuota N° 23') }}
												{{ Form::text('interest[]', null, ['class' => 'form-control', 'multiple']) }}
												@if($errors->has('interest'))
													<span class="help-block">(*) {{$errors->first('interest')}}</span>
												@endif
											</div>
	  									</div>
	  									<div class="col-md-4">
	  										<div class="form-group">
												{{ Form::label('Cuota N° 24') }}
												{{ Form::text('interest[]', null, ['class' => 'form-control', 'multiple']) }}
												@if($errors->has('interest'))
													<span class="help-block">(*) {{$errors->first('interest')}}</span>
												@endif
											</div>
	  									</div>
	  								</div>
  								@endif
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