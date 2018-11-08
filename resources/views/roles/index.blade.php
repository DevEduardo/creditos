@extends('adminlte::page')

@section('content')
	    
	<div class="table-responsive">

	    <table class="table table-striped table-hover" id="data" class="display" cellspacing="0" width="100%">
	    	
			<thead>
				<th>
					#
				</th>
				<th>
					Nombre
				</th>
				<th>
					Descripción
				</th>
				<th> <i class="fa fa-cogs fa-2x"></i> </th>
			</thead>

			<tbody>
				
				@foreach($roles as $key => $role)
					<tr>
						<td>
							{{ ($key+1) }}
						</td>
						<td>
							{{ $role->display_name }}
						</td>
						<td>
							{{ $role->description }}
						</td>
						<td>
							@if($role->name == 'Master' || $role->name == 'Administrador')
								<span class="label label-info">No Aplica</span>
							@else
								<a href="{{ route('roles.edit', $role->id) }}" title="Editar permisos" class="btn btn-warning btn-sm">
									<span class="fa fa-pencil"></span>
								</a>
							@endif
						</td>
					</tr>
				@endforeach

			</tbody>
	    </table>
	</div>
@stop