@extends('adminlte::page')

@section('content')
    
	<div class="table-responsive">

	    <table class="table table-striped table-hover" id="data" class="display" cellspacing="0" width="100%">
	    	
			<thead>
				<th>#</th>
				<th>Marca</th>
				<th>Nombre</th>
				<th> <i class="fa fa-cogs fa-2x"></i> </th>
			</thead>

			<tbody>

				@foreach ($models as $model)

				<tr>
					<td>{{$model->id}}</td>
					<td> 
						<a href="{{route('brands.show', $model->brand->id)}}"> 
							{{$model->brand->name}}
						</a>
					</td>
					<td>{{$model->name}}</td>
					
					<td>
						<div class="btn btn-group">
							<a href="{{route('models.show', $model->id)}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Ver"> <i class="fa fa-eye"></i> </a>
					
							<a href="{{route('models.edit', $model->id)}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"> <i class="fa fa-edit"></i> </a>
													
							{!! Form::model($model, ['method' => 'delete', 'route' => ['models.destroy', $model->id], 'class' =>'form-inline form-delete']) !!}
		                        {!! Form::hidden('id', $model->id) !!}
		                        <button type="submit" name="delete_modal" class="btn btn-danger btn-sm delete " data-toggle="tooltip" data-placement="top" title="Eliminar" data-original-title="Eliminar"><i class="fa fa-trash"></i></button>
		                    {!! Form::close() !!}
						</div>
						
						
					</td>
				</tr>

				@endforeach

			</tbody>

	    </table>

	</div>
		
	
@stop
