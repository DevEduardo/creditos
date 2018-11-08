@extends('adminlte::page')

@section('content')
	    
	{{ Form::open(['route' => ['providers.store'] , 'files' => true ]) }}

		{{ Form::token() }}

		@include('providers.form')
		
	{{ Form::close() }}
@stop


@section('js')
	<script src="{{asset('js/cities.js')}}"></script>
@stop