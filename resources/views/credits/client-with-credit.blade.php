@extends('adminlte::page')

@section('content')
    
	<div class="table-responsive">
	    <table class="table table-striped table-hover" id="credits-client-table" class="display" cellspacing="0" width="100%">
			<thead>
				<th>#</th>
				<th>DNI</th>
				<th>Nombre</th>
				<th>Email</th>
				<th>Tipo de Cliente </th>
				<th>Creditos</th>
				<th> <i class="fa fa-cogs fa-2x"></i> </th>
			</thead>
	    </table>
	</div>	
@stop

@section('js')
    @parent

    <script type="text/javascript">
        $(document).ready(function() {
            $('#credits-client-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('credit.clients.datatable') !!}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'dni', name: 'dni' },
                    { data: 'name', name: 'name' },
                    { data: 'profile.email', name: 'profile.email' },
                    { data: 'client_type.name', name: 'client_type.name' },
                    { data: 'quantity_credits', name: 'quantity_credits' },
                    { data: 'action', searchable: false, orderable: false }
                ],
                "language": {
                  "lengthMenu": "Ver _MENU_ registros por página",
                  "zeroRecords": "No se encontraron resultados",
                  "info": "Viendo la página _PAGE_ de _PAGES_",
                  "infoEmpty": "No hay información",
                  "search": " Buscar: ",
                  "paginate": {
                    "previous": "Anterior",
                    "next": "Proximo"
                  },
                }
            });
        });
    </script>
@endsection