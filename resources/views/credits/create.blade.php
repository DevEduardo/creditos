@extends('adminlte::page')

@section('content')
	    
	{{ Form::open(['route' => ['credits.store']]) }}

		{{ Form::token() }}

		@include('credits.form')
		
	{{ Form::close() }}
@stop