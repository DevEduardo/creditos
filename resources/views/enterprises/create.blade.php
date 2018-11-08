@extends('adminlte::page')

@section('content')
	    
	{{ Form::open(['route' => ['enterprises.store'] , 'files' => true ]) }}

		{{ Form::token() }}

		@include('enterprises.form')
		
	{{ Form::close() }}
@stop


@section('js')
	<script src="{{asset('js/cities.js')}}"></script>
@stop