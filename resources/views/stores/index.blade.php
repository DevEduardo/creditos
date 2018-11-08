@extends('adminlte::page')

@section('content')
    
	<div class="table-responsive">

	    <table class="table table-striped table-hover" id="data" class="display" cellspacing="0" width="100%">
	    	
			<thead>
				<th>#</th>
				<th>Nombre</th>
				<th><i class="fa fa-cogs fa-2x"></i> </th>
			</thead>

			<tbody>
				
				@foreach ($stores as $key => $store)

				<tr>
					<td>{{$key+1}}</td>
					<td>
						@if($store->default)
							<i class="fa fa-check text-green"></i>
						@else
							<i class="fa fa-close text-red"></i>
						@endif
						-
						{{$store->name}}
					</td>
					<td>

						<div class="btn btn-group">
							<a href="{{route('stores.show', $store->id)}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Ver"> <i class="fa fa-eye"></i> </a>
						
							<a href="{{route('stores.edit', $store->id)}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"> <i class="fa fa-edit"></i> </a>
						
							{!! Form::model($store, ['method' => 'delete', 'route' => ['stores.destroy', $store->id], 'class' =>'form-inline form-delete']) !!}
		                        {!! Form::hidden('id', $store->id) !!}
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