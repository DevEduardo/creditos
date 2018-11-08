@extends('adminlte::page')

@section('content')
    <h4>
    	{{ $role->display_name }}: <small>{{ $role->description }}</small>	
    </h4>
    <hr>
    	<h4>Permisos actuales:</h4>
    	<ul>
	    	@forelse($role->permissions as $permission)
				<li>{{ $permission->display_name }}: <small>{{ $permission->description }}</small></li>
			@empty
				<li>Solo tiene tiene los permisos de su rol</li>
	    	@endforelse
    	</ul>
    <hr>
    <h4>
    	Agregar permisos:
    </h4>
    {!! Form::open(['route' => ['roles.update', $role->id], 'method' => 'PUT']) !!}
    	<div class="form-group">
    		{!! Form::label('permissions', 'Permisos Disponibles') !!}
    		{!! Form::select('permissions[]', $permissions, null, ['class' => 'form-control', 'multiple', 'seleccione los permisos a agregar']) !!}
    	</div>
    	<div class="form-group">
    		<button type="submit" class="btn btn-success" title="Agregar permisos">
    			<span class="fa fa-floppy-o"></span>
    		</button>
    		<button type="reset" class="btn btn-danger" title="Limpiar selección">
    			<span class="fa fa-trash"></span>
    		</button>
    	</div>
    {!! Form::close() !!}
@stop