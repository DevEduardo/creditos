@extends('adminlte::page')

@section('content')

	{{ Form::open(['route' => ['clients.store'] , 'files' => true ]) }}

		{{ Form::token() }}

		@include('clients.form')
		
	{{ Form::close() }}
@stop

@section('js')
	<script src="{{asset('js/cities.js')}}"></script>
@stop