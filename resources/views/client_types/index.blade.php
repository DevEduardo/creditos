@extends('adminlte::page')

@section('content')
 
	<div class="table-responsive">

	    <table class="table table-striped table-hover" id="data" class="display" cellspacing="0" width="100%">
	    	
			<thead>
				<th>#</th>
				<th>Código</th>
				<th>Nombre</th>
				<th>Monto M&aacute;x.</th>
				<th>% Recargo</th>
				<th>Cuotas</th>
				<th>% Diario</th>
				<th width="120px"> <i class="fa fa-cogs fa-2x"></i> </th>
			</thead>

			<tbody>

				@foreach ($clientTypes as $clientType)

				<tr>
					<td>{{$clientType->id}} </td>
					<td>{{$clientType->code}}</td>
					<td>{{$clientType->name}}</td>
					<td>{{ number_format($clientType->credit, 2, ',','.')}}</td>
					<td>{{$clientType->surcharge}} </td>
					<td>{{$clientType->max_fees}}</td>
					<td>{{$clientType->daily_interest}} </td>
					<td>

						<div class="btn btn-group">
							
							<a href="{{route('clientTypes.show', $clientType->id)}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Ver"> <i class="fa fa-eye"></i> </a>
							
							
							<a href="{{route('clientTypes.edit', $clientType->id)}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"> <i class="fa fa-edit"></i> </a>
							

							{!! Form::model($clientType, ['method' => 'delete', 'route' => ['clientTypes.destroy', $clientType->id], 'class' =>'form-inline form-delete']) !!}
			                    {!! Form::hidden('id', $clientType->id) !!}
			                    
			                    <button type="submit" name="delete_modal" class="btn btn-danger btn-sm delete " data-toggle="tooltip" data-placement="top" title="Eliminar" data-original-title="Eliminar"><i class="fa fa-trash"></i></button>

			                {!! Form::close() !!}
							
						</div>

					</td>
				</tr>

				@endforeach

			</tbody>

	    </table>

	</div>
		
@stop