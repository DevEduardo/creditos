@extends('adminlte::page')

@section('content')
	<div class="box box-solid">

		<div class="box-body">
			
			<div class="wrapper rtl rtl-inv">
	            <div class="">
	                <div class="col-lg-12 alerts"></div>
		                <table style="width:100%;" class="layout-table">
		                    <tr>

		                    	@include('sales.forms.form')
		                    	@include('sales.forms.details')

		                    </tr>
		                </table>
		            </div>
		        </div>
		    </div>

		</div>
	</div>

	@include('sales.forms.modals')

	@include('sales.forms.lib')
@stop