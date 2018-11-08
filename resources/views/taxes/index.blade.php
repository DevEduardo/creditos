@extends('adminlte::page')

@section('content')
    
	<div class="table-responsive">

	    <table class="table table-striped table-hover" id="data" class="display" cellspacing="0" width="100%">
	    	
			<thead>
				<th>#</th>
				<th>Nombre</th>
				<th> % </th>
				<th> <i class="fa fa-cogs fa-2x"></i> </th>
			</thead>

			<tbody>

				@foreach ($taxes as $key => $tax)

				<tr>
					<td> {{$key+1}} </td>
					<td>{{$tax->name}}</td>
					<td>{{$tax->value}}</td>
				
					<td>
						<div class="btn btn-group">
							<a href="{{route('taxes.show', $tax->id)}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Ver"> <i class="fa fa-eye"></i> </a>
					
							<a href="{{route('taxes.edit', $tax->id)}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"> <i class="fa fa-edit"></i> </a>
						
							{!! Form::model($tax, ['method' => 'delete', 'route' => ['taxes.destroy', $tax->id], 'class' =>'form-inline form-delete']) !!}
			                        {!! Form::hidden('id', $tax->id) !!}
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