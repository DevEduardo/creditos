@extends('adminlte::page')
@section('css')
    @parent

    <link rel="stylesheet" href="{{ asset('enlinea/responsive.bootstrap.min.css') }}">
@endsection
@section('content')
	    
	<div class="table-responsive">

	    <table class="table table-striped table-hover display nowrap" id="product-table" cellspacing="0" width="100%">
			<thead>
				<th>CUC</th>
				<th>Código</th>
				<th>Nombre</th>
				<th>Precio $</th>
				<th>Stock</th>
				<th>Marca</th>
				<th>Actualizado</th>
				<th>Descripción</th>
				<th>WWW</th>
				<th> <i class="fa fa-cogs fa-2x"></i> </th>
			</thead>
			<tbody></tbody>
	    </table>
	</div>
@stop
@section('js')
    @parent
    
    <script src="{{ asset('enlinea/dataTables.responsive.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).ready(function() {
			    $('#product-table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: '{!! route('products.datatable') !!}',
                columns: [
                    { data: 'id', name: 'id', searchable: false },
                    { data: 'reference', name: 'reference' },
                    { data: 'name', name: 'name' },
                    { data: 'price', name: 'price', searchable: false },
                    { data: 'qty', name: 'inventory.qty', searchable: false },
                    { data: 'brand', name: 'brand' },
                    { data: 'date_update_price', name: 'date_update_price', searchable: false },
                    { data: 'model', name: 'model', searchable: false },
                    { data: 'web', name: 'web', searchable: false },
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
                },
                "lengthMenu": [[20, 50, 100, 150], [25, 50, 100, 150]]
            });
			} );
        });
    </script>
@endsection
