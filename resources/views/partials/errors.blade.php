@extends('adminlte::master')

@if ($errors->any())
    <div class="alert alert-danger alert-dismissable fade in">
    	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <ul>
        	<h3>Por favor corrige los siguientes errores para continuar:</h3>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif