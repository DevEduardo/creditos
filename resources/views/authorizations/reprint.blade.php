@extends('adminlte::page')

@section('content')
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			{!! Form::open(['route' => 'reprint.auth', 'method' => 'POST']) !!}
				{!! Form::hidden('credit_id', $credit_id) !!}
				{!! Form::hidden('type', $type) !!}
				<div class="form-group">
					{!! Form::label('auth', 'Ingrese el codigo de autorización') !!}
					{!! Form::text('auth', old('auth'), ['class' => 'form-control']) !!}
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-success" title="Procesar">
						Autorizar
					</button>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
@endsection