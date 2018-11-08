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
				
			</div>

			<div class="row">
					
				<div class="col-md-2">
					
					<div class="form-group">
					
						{{ Form::submit('Guardar', ['class' => 'btn btn-success']) }}
				
					</div>

				</div>

			</div>