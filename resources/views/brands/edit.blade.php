@extends('adminlte::page')

@section('content')
	    
	{{ Form::model($brand, ['route' => ['brands.update', $brand->id] , 'files' => true, 'method' => 'patch' ]) }}

		{{ Form::token() }}

		@include('brands.form')

	{{ Form::close() }}
	
@stop