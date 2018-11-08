
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


				<div class="col-md-4 @if($errors->has('image')) has-error @endif">
					
					<div class="form-group">
					
					{{ Form::label('Imagen') }}
					
						<div class="user-block input-group">

							@if(isset($brand->image))
							
								<a href="{{asset('uploads/brands/'.$brand->image)}}" data-lightbox="{{$brand->name}}" data-title="{{$brand->name}}">
									<img src="{{asset('uploads/brands/'.$brand->image)}}" alt="{{$brand->name}}">
								</a>
							
							@endif
							
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
								
									@if($errors->has('image'))
										<span class="help-block">(*) {{$errors->first('image')}}</span>
									@endif
								</span>
							</div><!-- /input-group image-preview -->
						</div>					
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