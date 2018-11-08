@extends('adminlte::page')


@section('content')
	
	{{ Form::open(['route' => ['taxes.store']]) }}

		{{ Form::token() }}

		@include('taxes.form')

	{{ Form::close() }}
	
@stop