@extends('adminlte::page')

@section('content')
    
	{{ Form::open(['route' => ['updatePrice']]) }}

		{{ Form::token() }}

		<div class="row">
			<div class="col-md-12">
	           	<div class="post">
	               	<div class="user-block">
		               <ul class="timeline timeline-inverse">
							<li>
					            <i class="fa fa-list bg-blue"></i>
				                <div class="timeline-item">
				    	            <h3 class="timeline-header"><a href="#"> Seleccione los Productos </a> </h3>
				                   <div class="timeline-body">
									
										<div class="row">
											<div class="col-md-4 @if($errors->has('brand')) has-error @endif">
												{{Form::label('Marcas')}} <br>
												
												{{Form::select('brand', $brands, old('brand'), ['class' => 'form-control', 'id' => 'brand', 'placeholder' => 'Solo para actualizar por marca'])}}

												@if($errors->has('brand'))
													<span class="help-block">(*) {{ $errors->first('brand') }}</span>
												@endif
											</div>

											<div class="col-md-4 @if($errors->has('products[]')) has-error @endif">
												{{Form::label('Productos')}} <br>
												
												{{Form::select('products[]', $products, null, ['class' => 'form-control', 'id' => 'products', 'multiple'=>'true'])}}

												@if($errors->has('products[]'))
														<span class="help-block">(*) {{$errors->first('products[]')}}</span>
												@endif
											</div>

											<div class="col-md-2 @if($errors->has('percent')) has-error @endif">
												{{Form::label('Porcentaje %')}}
												{{Form::number('percent', null, ['class' => 'form-control'])}}

												@if($errors->has('percent'))
														<span class="help-block">(*) {{$errors->first('percent')}}</span>
												@endif
											</div>

											<div class="col-md-2 @if($errors->has('op')) has-error @endif">
												{{Form::label('Operación')}}

												{{Form::select('op', ['+' => 'Aumento', '-' => 'Rebaja'], null, ['class'=>'form-control'])}}

												@if($errors->has('op'))
														<span class="help-block">(*) {{$errors->first('op')}}</span>
												@endif
											</div>
										</div>
										<hr>
										<div class="row">
											<div class="col-md-12">
												<div class="alert alert-warning">
													<p><strong>Nota:</strong> Las marcas tiene prioridad sobre los productos, si selecciona una, el precio sera actualizado para todos los productos de dicha marca.</p>
												</div>
											</div>
										</div>
				                    </div>
				                </div>
				                 
							</li>
				        </ul>
					</div> 
				</div>
			</div>
		</div>

<div class="row">
	<div class="col-md-4">					
		{{ Form::submit('Guardar', ['class' => 'btn btn-success']) }}
	</div>
</div>

</div>


	{{ Form::close() }}
	
@stop

@section('js')

	<script>
		$(document).ready(function() {
			$('#products').select2();
		});
	</script>
@stop