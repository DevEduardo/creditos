@extends('adminlte::page')

@section('css')
	<style type="text/css">
		.mt-2{margin-top: 2%!important}
		.text-right{text-align: right;}
	</style>

@section('content')
<div>
	@if(auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Master'))

	@endif			
</div>
<div class="bg-gray col-lg-6 border-right mt-2">
	
	<h2 class="text-center"><b>Hogar</b></h2>
	<div class="row">
		<div class="col-md-4 @if($errors->has('amount')) has-error @endif">
			<div class="form-group">
				{{ Form::label('Monto') }}
				{{ Form::text('amount', null, ['class' => 'form-control' , 'id' => 'amount']) }}
				@if($errors->has('amount'))
					<span class="help-block">(*) {{$errors->first('amount')}}</span>
				@endif
			</div>
			<button class="btn  btn-primary" id="calculateBtnHome">Calcular</button>
		</div>
			<table class="col-md-7">
				<tr>
					<th>N.</th>
					<th>Cuota</th>
					<th></th>
					<th></th>
					@if(auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Master'))	
						<th class="text-center">% Cuota</th>
					@endif
				</tr>
				{{ Form::open(['route' => ['clients.quoting'] ]) }}
				<input type="hidden" name="type" value="0">
				@for($i=0;$i< 36; $i++)
				<tr>
					<td>{{$i + 1}}</td>

					<td>
						@if($share->count()>0)
						<input type="text" class="form-control" id="share{{($i + 1)}}" >
						@endif
					</td>

					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					@if($share->count()>0)
						@if(auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Master'))	
							<td><input id="porcent{{$i}}" type="text" class="form-control" name="porcentage[]" value="{{$shareHogar[$i]->porcentage}}"></td>
						@else
							<td><input id="porcent{{$i}}" type="hidden" class="form-control" name="porcentage[]" value="{{$shareHogar[$i]->porcentage}}"></td>
						@endif
					@else
						<td><input  type="text" class="form-control" name="porcentage[]" required></td>
					@endif
				</tr>
				@endfor
				<tr>
					<td colspan="5" class="text-right"><button type="submit" class="btn  btn-primary" id="btnHome">Guardar</button></td>
				</tr>
				{{ Form::close() }}
			</table>
	</div>
</div>
<div class="bg-gray col-lg-6 border-left mt-2">
	<h2 class="text-center"><b>Motos</b></h2>
	<div class="row">
		<div class="col-md-4 @if($errors->has('amounts')) has-error @endif">
			<div class="form-group">
				{{ Form::label('Monto') }}
				{{ Form::text('amount', null, ['class' => 'form-control' , 'id' => 'amountS']) }}
				@if($errors->has('amounts'))
					<span class="help-block">(*) {{$errors->first('amounts')}}</span>
				@endif
			</div>
			<button class="btn  btn-primary" id="calculateBtnScooter">Calcular</button>
		</div>
			<table class="col-md-7">
				<tr>
					<th>N.</th>
					<th>Cuota</th>
					<th></th>
					<th></th>
					@if(auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Master'))	
						<th class="text-center">% Cuota</th>
					@endif
				</tr>
				{{ Form::open(['route' => ['clients.quoting'] ]) }}
				<input type="hidden" name="type" value="1">
				@for($i=1;$i< 37; $i++)
				<tr>
					<td>{{$i + 1}}</td>

					<td>
						@if($shareScooter->count()>0)
						<input type="text" class="form-control" id="shareS{{($i + 1)}}" >
						@endif
					</td>

					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					@if($shareScooter->count()>0)
						@if(auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Master'))	
							<td><input id="porcents{{$i}}" type="text" class="form-control" name="porcentage[]" value="{{$shareScooter[$i]->porcentage}}"></td>
						@else
							<td><input id="porcents{{$i}}" type="hidden" class="form-control" name="porcentage[]" value="{{$shareScooter[$i]->porcentage}}"></td>
						@endif
					@else
						<td><input id="porcent{{$i}}" type="text" class="form-control" name="porcentage[]" required></td>
					@endif
				</tr>
				@endfor
				<tr>
					<td colspan="5" class="text-right"><button type="submit" class="btn  btn-primary" id="btnScooter">Guardar</button></td>
				</tr>
				{{ Form::close() }}
			</table>
	</div>	
</div>	
@stop

@section('js')
	<script type="text/javascript">
		$(document).ready(function() {
			$('#calculateBtnScooter').on('click', function(){
				var amount = $('#amountS').val();
				for (var i = 0; i < 36; i++) {
					var porcent = $('#porcents'+i ).val();
					var share  = amount*porcent / 100 + parseInt(amount);
					$('#shareS'+(i + 1)).val(Math.floor(share));
				}
			});

			$('#calculateBtnHome').on('click', function(){
				var amount = $('#amount').val();
				var total  = parseInt(amount) / 36;
				for (var i = 0; i < 36; i++) {
					var porcent = $('#porcent'+i ).val();
					var share  = amount*porcent / 100 + parseInt(amount);
					$('#share'+(i + 1)).val(Math.floor(share));
				}
			});
		});
	</script>
@endsection