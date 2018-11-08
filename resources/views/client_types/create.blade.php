@extends('adminlte::page')

@section('content')
	    
	{{ Form::open(['route' => ['clientTypes.store']]) }}

		{{ Form::token() }}

		@include('client_types.form')
		
	{{ Form::close() }}
@stop