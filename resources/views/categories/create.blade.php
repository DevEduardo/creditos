@extends('adminlte::page')

@section('content')
	
	{{ Form::open(['route' => ['categories.store']]) }}

		{{ Form::token() }}

		@include('categories.form')

	{{ Form::close() }}
	
@stop