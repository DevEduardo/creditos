@extends('adminlte::page')

@section('css')
    @parent

    <link rel="stylesheet" href="{{ asset('enlinea/responsive.bootstrap.min.css') }}">
@endsection

@section('content')
	<div class="table-responsive">
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
                    <th>N° Reimpresiones Contratos</th>
                    <th>N° Reimpresiones Orden de Salida</th>
                    <th>Creado por</th>
    				@endif
    				<th> <i class="fa fa-cogs fa-2x"></i> </th>
                </tr>
			</thead>
	    </table>
	</div>

    <div class="modal fade" id="unsubscribeModal" tabindex="-1" role="dialog" aria-labelledby="unsubscribeModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {!! Form::open(['route' => 'credits.unsubscribe', 'method' => 'POST']) !!}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="unsubscribeModalLabel">Dar de baja credito</h4>
                    </div>
                    <div class="modal-body">
                        {!! Form::hidden('credit_id') !!}
                        <div class="form-group">
                            {!! Form::label('observation', 'Observación:') !!}
                            {!! Form::textarea('observation', null, ['class' => 'form-control', 'placeholder' => 'Ingrese la observacion', 'required'])  !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning">Baja</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                {!! Form::close()  !!}
            </div>
        </div>
    </div>	
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
                ajax: '{!! route('credit.datatable.date', ['date' => $date, 'dateEnd' => $dateEnd]) !!}',
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
                    { data: 'credit.contract_print', name: 'contract_print' },
                    { data: 'credit.departure_order_print', name: 'departure_order_print' },
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
                "lengthMenu": [[25, 50, 100, 150], [25, 50, 100, 150]]
            });
        });

        //dispara el modal para dar de baja el credito
        function modalUnsubscribe(button) {
            let credit_id = $(button).data('credit');

            $('input[name="credit_id"]').val(credit_id);

            $('#unsubscribeModal').modal('show');
        }
    </script>
@endsection
