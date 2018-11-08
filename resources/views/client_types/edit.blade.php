@extends('adminlte::page')

@section('content')
    
	{{ Form::model($clientType, ['route' => ['clientTypes.update', $clientType->id], 'method' => 'patch' ]) }}
		{{ Form::token() }}

		@include('client_types.form')

	{{ Form::close() }}

@stop