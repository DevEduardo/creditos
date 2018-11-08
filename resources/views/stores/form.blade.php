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

		<div class="col-md-4 @if($errors->has('default')) has-error @endif">

			<div class="form-group">
				<div class="input-group" style="margin-top: 25px;">
					<div class="input-group-addon">
						{{ Form::checkbox('default', old('default'), false) }}
					</div>
					{{ Form::text('benefit', old('benefit'), ['class' => 'form-control', 'readonly', 'placeholder'=>'¿Almacen predeterminado?']) }}

				</div>
				
				@if($errors->has('default'))
					<span class="help-block">(*) {{$errors->first('default')}}</span>
				@endif
			</div>

		</div>


		{{Form::hidden('profile_id', 1)}}

		{{ Form::hidden('company_id', 1) }}
</div>

<div class="row">
		
	<div class="col-md-2">
		
		<div class="form-group">
		
			{{ Form::submit('Guardar', ['class' => 'btn btn-success']) }}
	
		</div>

	</div>

</div>