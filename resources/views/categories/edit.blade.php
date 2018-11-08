@extends('adminlte::page')

@section('content')
	    
	{{ Form::model($category, ['route' => ['categories.update', $category->id], 'method' => 'patch' ]) }}

		{{ Form::token() }}

		@include('categories.form')

	{{ Form::close() }}
	
@stop