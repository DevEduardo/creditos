@extends('adminlte::page')

@section('content')
	<div class="row">
		<div class="col-md-4">
			@isset($token)
				<h3>{{ $token }}</h3>
			@endisset
		</div>
		<div class="col-md-4">
			<a href="{{ route('tokens.store') }}" title="Generar Nuevo Token" class="btn btn-primary">
				<span class="fa fa-refresh"></span>
			</a>
		</div>
	</div>
@stop