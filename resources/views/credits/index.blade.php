@extends('adminlte::page')

@section('css')
    @parent

    <link rel="stylesheet" href="{{ asset('enlinea/responsive.bootstrap.min.css') }}">
@endsection

@section('content')
	<div class="table-responsive">
        @if($opt == 'morososSales')
            <table class="display nowrap" id="credits-table" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>N° Crédito</th>
                        <th>DNI</th>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Financiado</th>
                        <th>A pagar</th>
                        <th>Pagado</th>
                        <th>Cuotas</th>
                        <th>Liquidado</th>
                        @if(Auth::user()->hasRole('Administrador') ||  Auth::user()->hasRole('Master'))
                            @if ($opt == 'credits') 
                                <th>N° Reimpresiones Contratos</th>
                                <th>N° Reimpresiones Orden de Salida</th>
                            @endif
                            <th>Creado por</th>
                        @endif
                        <th> <i class="fa fa-cogs fa-2x"></i> </th>
                    </tr>
                </thead>
            </table>
        @elseif($opt == 'sales')
            <table class="display nowrap" id="sales-table" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>N° Venta</th>
                        <th>DNI</th>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Financiado</th>
                        <th>A pagar</th>
                        <th>Pagado</th>
                        <th>Cuotas</th>
                        <th>Liquidado</th>
                        @if(Auth::user()->hasRole('Administrador') ||  Auth::user()->hasRole('Master'))
                            @if ($opt == 'credits') 
                                <th>N° Reimpresiones Contratos</th>
                                <th>N° Reimpresiones Orden de Salida</th>
                            @endif
                            <th>Creado por</th>
                        @endif
                        <th> <i class="fa fa-cogs fa-2x"></i> </th>
                    </tr>
                </thead>
            </table>
        @else
            <table class="display nowrap" id="credits-table" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>N° Crédito</th>
                        <th>DNI</th>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Financiado</th>
                        <th>A pagar</th>
                        <th>Pagado</th>
                        <th>Cuotas</th>
                        <th>Liquidado</th>
                        @if(Auth::user()->hasRole('Administrador') ||  Auth::user()->hasRole('Master'))
                            @if ($opt == 'credits') 
                                <th>N° Reimpresiones Contratos</th>
                                <th>N° Reimpresiones Orden de Salida</th>
                            @endif
                            <th>Creado por</th>
                        @endif
                        <th> <i class="fa fa-cogs fa-2x"></i> </th>
                    </tr>
                </thead>
            </table>
        @endif
	    
	</div> 

    @if($opt == 'sales')
        <div class="modal fade" id="authorizationlSale" tabindex="-1" role="dialog" >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    {!! Form::open(['route' => 'sales.unsubscribe', 'method' => 'POST']) !!}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="unsubscribeModalLabel">Dar de baja la venta</h4>
                        </div>
                        <div class="modal-body">
                            {!! Form::hidden('sale_id') !!}
                            <div class="form-group">
                                {!! Form::label('auth', 'Código de autorización') !!}
                                {!! Form::text('auth', old('auth'), ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('observation', 'Observación:') !!}
                                {!! Form::textarea('observation', null, ['class' => 'form-control', 'placeholder' => 'Ingrese la observacion', 'required'])  !!}
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success" title="Procesar">
                                    Autorizar
                                </button>
                            </div>
                    {!! Form::close()  !!}
                </div>
            </div>
        </div> 
    @else
        <div class="modal fade" id="authorizationModal" tabindex="-1" role="dialog" aria-labelledby="unsubscribeModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    {!! Form::open(['route' => 'deleteCredit.auth', 'method' => 'POST']) !!}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="unsubscribeModalLabel">Dar de baja credito</h4>
                        </div>
                        <div class="modal-body">
                            {!! Form::hidden('credit_id') !!}
                            <div class="form-group">
                                {!! Form::label('auth', 'Código de autorización') !!}
                                {!! Form::text('auth', old('auth'), ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('observation', 'Observación:') !!}
                                {!! Form::textarea('observation', null, ['class' => 'form-control', 'placeholder' => 'Ingrese la observacion', 'required'])  !!}
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success" title="Procesar">
                                    Autorizar
                                </button>
                            </div>
                    {!! Form::close()  !!}
                </div>
            </div>
        </div>
    @endif

        

   	

 

@stop

@section('js')
    @parent
    
    <script src="{{ asset('enlinea/dataTables.responsive.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#credits-table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: '{!! route('credit.datatable', ['opt' => $opt]) !!}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'dni', name: 'dni' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'type', name: 'type' },
                    { data: 'financial_amount', name: 'financial_amount' },
                    { data: 'final_amount', name: 'final_amount' },
                    { data: 'payment', name: 'payment' },
                    { data: 'fees', name: 'fees' },
                    { data: 'is_payed', name: 'credit.is_payed' },
                    @if(Auth::user()->hasRole('Administrador') ||  Auth::user()->hasRole('Master'))
                        @if($opt == 'credits')
                            { data: 'credit.contract_print', name: 'contract_print' },
                            { data: 'credit.departure_order_print', name: 'departure_order_print' },
                        @endif
						{ data: 'name', name: 'sale.user.name' },
					@endif
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
                "lengthMenu": [[20, 50, 100, 150], [25, 50, 100, 150]],
                "order": [[ 0, "desc" ]]
            });

            $('#morososSales-table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: '{!! route('credit.datatable', ['opt' => $opt]) !!}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'dni', name: 'dni' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'type', name: 'type' },
                    { data: 'financial_amount', name: 'financial_amount' },
                    { data: 'final_amount', name: 'final_amount' },
                    { data: 'payment', name: 'payment' },
                    { data: 'fees', name: 'fees' },
                    { data: 'is_payed', name: 'credit.is_payed' },
                    @if(Auth::user()->hasRole('Administrador') ||  Auth::user()->hasRole('Master'))
                        @if($opt == 'credits')
                            { data: 'credit.contract_print', name: 'contract_print' },
                            { data: 'credit.departure_order_print', name: 'departure_order_print' },
                        @endif
                        { data: 'name', name: 'sale.user.name' },
                    @endif
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
                "lengthMenu": [[20, 50, 100, 150], [25, 50, 100, 150]],
                "order": [[ 0, "desc" ]]
            });

            $('#sales-table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: '{!! route('credit.datatable', ['opt' => $opt]) !!}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'dni', name: 'dni' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'type', name: 'type' },
                    { data: 'financial_amount', name: 'financial_amount' },
                    { data: 'final_amount', name: 'final_amount' },
                    { data: 'payment', name: 'payment' },
                    { data: 'fees', name: 'fees' },
                    { data: 'is_payed', name: 'is_payed' },
                    @if(Auth::user()->hasRole('Administrador') ||  Auth::user()->hasRole('Master'))
                        @if($opt == 'credits')
                            { data: 'credit.contract_print', name: 'contract_print' },
                            { data: 'credit.departure_order_print', name: 'departure_order_print' },
                        @endif
                        { data: 'name', name: 'sale.user.name' },
                    @endif
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
                "lengthMenu": [[20, 50, 100, 150], [25, 50, 100, 150]],
                "order": [[ 0, "desc" ]]
            });
        });


        //dispara el modal para dar de baja el credito
        
        function modalAuthorization(button) {
            let credit_id = $(button).data('credit');

            $('input[name="credit_id"]').val(credit_id);

            $('#authorizationModal').modal('show');
        }

        function modalSale(button) {
            
            let sale_id = $(button).data('sale');

            $('input[name="sale_id"]').val(sale_id);
            $('#authorizationlSale').modal('show');
        }
    </script>
@endsection
