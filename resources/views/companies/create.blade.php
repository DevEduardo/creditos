@extends('adminlte::page')

@section('content')
	    
	{{ Form::open(['route' => ['companies'] , 'files' => true ]) }}

		{{ Form::token() }}

		@include('companies.form')
		
	{{ Form::close() }}
@stop

@section('js')
	<script src="{{asset('js/cities.js')}}"></script>
@stop
