@extends('adminlte::page')

@section('content')
	
	{{ Form::open(['route' => ['stores.store']]) }}

		{{ Form::token() }}

		@include('stores.form')

	{{ Form::close() }}
	
@stop