@extends('adminlte::page')

@section('content')
	    
	{{ Form::model($store, ['route' => ['stores.update', $store->id] , 'files' => true, 'method' => 'patch' ]) }}

		{{ Form::token() }}

		@include('stores.form')

	{{ Form::close() }}
	
@stop