@extends('adminlte::page')

@section('content')

	{{ Form::open(['route' => ['users.store'] , 'files' => true ]) }}

		{{ Form::token() }}

		@include('users.form')
	
	{{ Form::close() }}

@stop

@section('js')
	<script src="{{asset('js/cities.js')}}"></script>
@stop
