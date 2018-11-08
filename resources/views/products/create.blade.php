@extends('adminlte::page')

@section('content')
    
	{{ Form::open(['route' => ['products.store'], 'files' => true]) }}

		{{ Form::token() }}

		@include('products.form')

	{{ Form::close() }}
	
@stop