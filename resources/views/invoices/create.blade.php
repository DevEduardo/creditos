@extends('adminlte::page')

@section('content')

	<div class="box box-solid">

		<div class="box-body">
			<div class="col-sm-12 col-md-6 col-lg-6">
				@include('invoices.invoice-provider')
			</div>

			<div class="col-sm-12 col-md-6 col-lg-6">
				@include('invoices.invoice-product')
			</div>
		</div>
	</div>
@stop