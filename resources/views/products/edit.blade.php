@extends('adminlte::page')

@section('content')

	{{ Form::model($product, ['route' => ['products.update', $product->id], 'method' => 'patch', 'files' => true ])}}
	
		{{ Form::token() }}

		@include('products.form')

	{{ Form::close() }}
	  
	  	
@stop