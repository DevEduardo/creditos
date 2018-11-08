@extends('adminlte::page')

@section('css')
    @parent

    <link rel="stylesheet" href="{{ asset('enlinea/responsive.bootstrap.min.css') }}">
@endsection

@section('content')
    
	<div class="table-responsive">

	    <table class="table responsive nowrap display" id="data" cellspacing="0" width="100%">
	    	
			<thead>
				<tr>
					<th>N° Cl</th>
					<th>DNI</th>
					<th>Nombre Completo</th>
					<th>Direccion</th>
					<th>Contactos</th>
					<th> Tipo de Cliente </th>
					<th>Limite de Credito Disponible</th>
					<th> <i class="fa fa-cogs fa-2x"></i> </th>
				</tr>
			</thead>

			<tbody>

				@foreach ($clients as $key => $client)

				<tr>
					<td>{{ $client->id }}</td>
					<td>{{$client->dni}}</td>
					<td>{{$client->name}}</td>
					<td>{{ $client->profile->address }}</td>
					<td>
						Teléfono: {{ $client->phone1[0]['phone'] }}<br>
						Descripción: {{ $client->phone1[0]['description'] }}<br>
						@if (count($client->phone1) > 1)
							<a href="{{ route('clients.show', $client->id) }}">Ver más...</a>
						@endif
					</td>
					<td> <a href="{{route('clientTypes.show', $client->client_type_id )}}">
						{{$client->client_type->name}}
					</a>  </td>
					<td>
						{{ $client->credit_limit }}
					</td>
					<td>
						<div class="btn btn-group">
							<a href="{{route('clients.show', $client->id)}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Ver"> <i class="fa fa-eye"></i> </a>
							
							@if(Auth::user()->name != 'Vendedor')
							<a href="{{route('clients.edit', $client->id)}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"> <i class="fa fa-edit"></i> </a>
							@endif
							{!! Form::model($client, ['method' => 'delete', 'route' => ['clients.destroy', $client->id], 'class' =>'form-inline form-delete']) !!}
			                    {!! Form::hidden('id', $client->id) !!}
			                    
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

@section('js')
    @parent
    
    <script src="{{ asset('enlinea/dataTables.responsive.min.js') }}"></script>
@endsection