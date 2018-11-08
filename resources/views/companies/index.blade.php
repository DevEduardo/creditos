@extends('adminlte::page')

@section('content')
    
	<div class="table-responsive">

	    <table class="table table-striped table-hover" id="data" class="display" cellspacing="0" width="100%">
	    	
			<thead>
				<th>#</th>
				<th>Nombre</th>
				<th> <i class="fa fa-cogs fa-2x"></i> </th>
			</thead>

			<tbody>
				<tr>
					<td>1</td>
					<td>WES</td>
					<td>
						<a href="{{route('companies-show')}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Ver"> <i class="fa fa-eye"></i> </a>
					
						<a href="{{route('companies-edit')}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"> <i class="fa fa-edit"></i> </a>
					
						<a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar"> <i class="fa fa-trash"></i> </a>
					</td>
				</tr>

				<tr>
					<td>2</td>
					<td>DDAS</td>
					<td>
						<a href="#" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Ver"> <i class="fa fa-eye"></i> </a>
					
						<a href="#" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"> <i class="fa fa-edit"></i> </a>
					
						<a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar"> <i class="fa fa-trash"></i> </a>
					</td>
				</tr>

				<tr>
					<td>3</td>
					<td>DASAD</td>
					<td>
						<a href="#" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Ver"> <i class="fa fa-eye"></i> </a>
					
						<a href="#" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"> <i class="fa fa-edit"></i> </a>
					
						<a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar"> <i class="fa fa-trash"></i> </a>
					</td>
				</tr>


				<tr>
					<td>4</td>
					<td>DSD</td>
					<td>
						<a href="#" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Ver"> <i class="fa fa-eye"></i> </a>
					
						<a href="#" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"> <i class="fa fa-edit"></i> </a>
					
						<a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar"> <i class="fa fa-trash"></i> </a>
					</td>
				</tr>

				<tr>
					<td>5</td>
					<td>SDSAD</td>
					<td>
						<a href="#" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Ver"> <i class="fa fa-eye"></i> </a>
					
						<a href="#" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"> <i class="fa fa-edit"></i> </a>
					
						<a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar"> <i class="fa fa-trash"></i> </a>
					</td>
				</tr>

				<tr>
					<td>6</td>
					<td>XSS</td>
					<td>
						<a href="#" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Ver"> <i class="fa fa-eye"></i> </a>
					
						<a href="#" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"> <i class="fa fa-edit"></i> </a>
					
						<a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar"> <i class="fa fa-trash"></i> </a>
					</td>
				</tr>

				<tr>
					<td>7</td>
					<td>AS</td>
					<td>
						<a href="#" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Ver"> <i class="fa fa-eye"></i> </a>
					
						<a href="#" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"> <i class="fa fa-edit"></i> </a>
					
						<a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar"> <i class="fa fa-trash"></i> </a>
					</td>
				</tr>	

				<tr>
					<td>8</td>
					<td>ADASDADSS</td>
					<td>
						<a href="#" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Ver"> <i class="fa fa-eye"></i> </a>
					
						<a href="#" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"> <i class="fa fa-edit"></i> </a>
					
						<a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar"> <i class="fa fa-trash"></i> </a>
					</td>
				</tr>	

				<tr>
					<td>9</td>
					<td>EWE</td>
					<td>
						<a href="#" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Ver"> <i class="fa fa-eye"></i> </a>
					
						<a href="#" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"> <i class="fa fa-edit"></i> </a>
					
						<a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar"> <i class="fa fa-trash"></i> </a>
					</td>
				</tr>	

				<tr>
					<td>10</td>
					<td>SDDA</td>
					<td>
						<a href="#" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Ver"> <i class="fa fa-eye"></i> </a>
					
						<a href="#" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"> <i class="fa fa-edit"></i> </a>
					
						<a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar"> <i class="fa fa-trash"></i> </a>
					</td>
				</tr>

			</tbody>

	    </table>

	</div>
		
@stop