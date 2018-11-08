@extends('adminlte::page')

@section('content')
    
	<div class="table-responsive">


	    <table class="table table-striped table-hover" id="data" class="display" cellspacing="0" width="100%">
	    	
			<thead>
				<th>#</th>
				<th>Nombre</th>
				<th>Email</th>
				<th>Empresa</th>
				<th width="120px"> <i class="fa fa-cogs fa-2x"></i> </th>
			</thead>

			<tbody>
				@foreach ($users as $key => $user)

				<tr>
					<td>{{$key+1}}</td>
					<td>{{$user->name}}</td>
					<td>{{$user->email}}</td>
					<td>{{$user->company->name}}</td>
					<td>
						<div class="btn btn-group">
							<a href="{{route('users.show', $user->id)}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Ver"> <i class="fa fa-eye"></i> </a>
							
							<a href="{{route('users.edit', $user->id)}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"> <i class="fa fa-edit"></i> </a>
							
							{!! Form::model($user, ['method' => 'delete', 'route' => ['users.destroy', $user->id], 'class' =>'form-inline form-delete']) !!}
	                          	{!! Form::hidden('id', $user->id) !!}
	                            	<button type="submit" name="delete_modal" class="btn btn-danger btn-sm delete " data-toggle="tooltip" data-placement="top" title="Eliminar" data-original-title="Eliminar"><i class="fa fa-trash"></i></button>
	                        {!! Form::close() !!}

	                        </div>

						</div>
						

					</td>
				</tr>

				@endforeach

			</tbody>

	    </table>

	</div>
	
@stop
