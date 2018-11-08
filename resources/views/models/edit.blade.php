@extends('adminlte::page')

@section('content')
	    
	{{ Form::model($model, ['route' => ['models.update', $model->id] , 'files' => true, 'method' => 'patch' ]) }}

		{{ Form::token() }}

		@include('models.form')

	{{ Form::close() }}
	
@stop