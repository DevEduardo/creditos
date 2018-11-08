@extends('adminlte::page')


@section('content')
	
	{{ Form::model($tax, ['route' => ['taxes.update', $tax->id], 'method' => 'patch' ]) }}

		{{ Form::token() }}

		@include('taxes.form')

	{{ Form::close() }}
	
@stop