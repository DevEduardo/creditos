@extends('adminlte::page')


@section('content')
	
	{{ Form::open(['route' => ['models.store']]) }}

		{{ Form::token() }}

		@include('models.form')

	{{ Form::close() }}
	
@stop