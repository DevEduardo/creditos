@extends('adminlte::page')

@section('content')
	
	{{ Form::open(['route' => ['brands.store'], 'files' => true]) }}

		{{ Form::token() }}

		@include('brands.form')

	{{ Form::close() }}
	
@stop