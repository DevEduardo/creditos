@extends('adminlte::page')

@section('title', 'Creditos')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/morris.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('enlinea/datepicker/datepicker3.css') }}">
@endsection

@section('content_header')
    <h1 class="m">Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <h4>
                @if($date_start == $date_end)
                    Estadisticas para la fecha: {{ $date_start->format('d-m-Y') }}
                @else
                    Estadisticas para el rango de fechas: {{ $date_start->format('d-m-Y') }} a {{ $date_end->format('d-m-Y') }}
                @endif
            </h4>
        </div>
        <div class="col-md-8">
            {!! Form::open(['method' => 'GET', 'class' => 'form-inline']) !!}
                
                <button type="submit" class="btn btn-success pull-right" style="margin-top: 25px; margin-left: 10px;">
                    Buscar
                </button>

                <div class="form-group pull-right">
                    {!! Form::label('date', 'Seleccione otro rango:') !!}

                    <div class="input-daterange input-group" id="datepicker">
                        {!! Form::text('start', old('start'), ['class' => 'form-control', 'placeholder' => 'Fecha inicio', 'autocomplete'=>'off']) !!}
                        <span class="input-group-addon">A</span>
                        {!! Form::text('end', old('end'), ['class' => 'form-control', 'placeholder' => 'Fecha final', 'autocomplete'=>'off']) !!}
                    </div>
                </div>

                
            {!! Form::close() !!}
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-3">
            <h4 class="text-center">
                Total dinero ingresado
            </h4>
            <h3 class="text-center">
                ARS $ {{ number_format($totalMoney, 0, ',', '.') }}
            </h3>
        </div>
        <div class="col-md-3">
            <h4 class="text-center">
                Total dinero en efectivo
            </h4>
            <h3 class="text-center">
                ARS $ {{ number_format($totalCash, 0, ',', '.') }}
            </h3>
        </div>
        <div class="col-md-3">
            <h4 class="text-center">
                Total dinero por tarjetas <br><small>(credito/debito/online)</small>
            </h4>
            <h3 class="text-center">
                ARS $ {{ number_format($totalCard, 0, ',', '.') }}
            </h3>
        </div>
        <div class="col-md-3">
            <h4 class="text-center">
                Total dinero en cuotas <br><small>(Incluye anticipos)</small>
            </h4>
            <h3 class="text-center">
                ARS $ {{ number_format($totalDues, 0, ',', '.') }}
            </h3>
        </div>
        <div class="col-md-3">
            <h4 class="text-center">
                Total dinero en cuotas vencidas<br>
            </h4>
            <h3 class="text-center">
                ARS $ {{ number_format($totalDuesExpired, 0, ',', '.') }}
            </h3>
        </div>
         <div class="col-md-3">
            <h4 class="text-center">
                Total dinero en rembolsado<br>
            </h4>
            <h3 class="text-center">
                ARS $ {{ number_format($refund, 0, ',', '.') }}
            </h3>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Cantidad de ventas</h3>
                </div>
                <div class="box-body">
                    <div id="sales-chart"></div>
                    <a href="{{url('credit/'.$date_start->format('Y-m-d').'/'.$date_end->format('Y-m-d'))}}" class="mr-5 btn btn-sm btn-success"><span class="fa fa-plus"></span> Creditos</a>
                    <a href="{{url('sale/'.$date_start->format('Y-m-d').'/'.$date_end->format('Y-m-d'))}}" class="mr-5 btn btn-sm btn-success"><span class="fa fa-plus"></span> Ventas</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Cuotas</h3>
                </div>
                <div class="box-body">
                    <div id="dues-chart"></div>
                    <a href="" class="mr-5 btn btn-sm btn-success"> <span class="fa fa-plus"></span> Pagadas</a>
                    <a href="" class="mr-5 btn btn-sm btn-success"> <span class="fa fa-plus"></span> Vencidas</a>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <h3>Ventas</h3>
            <table id="low-table" class="table table-hover">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Total dinero</th>
                        <th>Total efectivo</th>
                        <th>Total tarjetas</th>
                        <th>Cant. Creditos</th>
                        <th>Cant. Ventas </th>
                        <th>Cant. Cuotas Cobradas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                {{ $user->name }}
                            </td>
                            <td>
                                ARS $ {{ number_format($user->payments->sum('amount'), 0, ',', '.') }}
                            </td>
                            <td>
                                ARS $ {{ number_format($user->payments->where('way_to_pay', 'cash')->sum('amount'), 0, ',', '.') }}
                            </td>
                            <td>
                                ARS $ {{ number_format($user->payments->where('way_to_pay', 'card')->sum('amount'), 0, ',', '.') }}
                            </td>
                            <td>
                                {{ $user->payments->where('type', 'credit')->count() }}
                            </td>
                            <td>
                                {{ $user->payments->whereIn('type', ['simple', 'sing', 'others', 'online'])->count()}}
                            </td>
                            <td>
                                {{ $user->payments->where('type', 'credit_detail')->count() }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3>Descuentos en ventas</h3>
            <table id="stats-table" class="table table-hover">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Cliente</th>
                        <th>%</th>
                        <th>Cantidad</th>
                        <th>tipo de venta</th>
                        <th><i class="fa fa-cogs fa-2x"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($discounts as $discount)
                    <tr>
                        <td>{{ $discount->user->name }}</td>
                        <td>{{ $discount->client->dni }}</td>
                        <td>{{ $discount->discount }}</td>
                        <td>{{ $discount->discount_amount }}</td>
                        <td>{{ $discount->getStringTypeAttribute() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <h3>Bajas de crèdito</h3>
            <table id="stats-table" class="table table-hover">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Cliente</th>
                        <th>Cantidad</th>
                        <th>Observacion</th>
                        <th><i class="fa fa-cogs fa-2x"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lowCredit as $data)
                    <tr>
                        <td>{{ $data->user }}</td>
                        <td>{{ $data->client_dni }}</td>
                        <td>{{ $data->amount }}</td>
                        <td>{{ $data->observation }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    
    <hr>
    <div class="row">
        <div class="col-md-12">
            <h3>Bajas de cupones</h3>
            <table id="statsCoupons-table" class="table table-hover">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Cliente</th>
                        <th>Cantidad</th>
                        <th>Observacion</th>
                        <th><i class="fa fa-cogs fa-2x"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lowCoupon as $data)
                    <tr>
                        <td>{{ $data->user }}</td>
                        <td>{{ $data->client_dni }}</td>
                        <td>{{ $data->amount }}</td>
                        <td>{{ $data->observation }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h3>Bajas de ventas (Directa-Online-Otras cuentas)</h3>
            <table id="statsCoupons-table" class="table table-hover">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Cliente</th>
                        <th>Cantidad</th>
                        <th>Observacion</th>
                        <th><i class="fa fa-cogs fa-2x"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lowSale as $data)
                    <tr>
                        <td>{{ $data->user }}</td>
                        <td>{{ $data->client_dni }}</td>
                        <td>{{ $data->amount }}</td>
                        <td>{{ $data->observation }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
    </div>
@stop

@section('js')
    @parent
    
    <script src="{{ asset('enlinea/datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('enlinea/datepicker/locales/bootstrap-datepicker.es.js') }}"></script>
    <script src="{{ asset('js/raphael.min.js') }}"></script>
    <script src="{{ asset('js/morris.min.js') }}"></script>

    <script type="text/javascript">
        $('#datepicker').datepicker({
            format: "dd/mm/yyyy",
            language: "es",
            autoclose: true,
            todayHighlight: true
        });
        new Morris.Donut({
            element: 'sales-chart',
            resize: false,
            data: [
                @foreach($chartSales as $data)
                    {label: "{{ $data['label'] }}", value: {{ $data['count'] }} },
                @endforeach
            ],
            colors: [
                @foreach($chartSales as $data)
                    "{{ $data['color'] }}",
                @endforeach
            ]
        });

        new Morris.Donut({
            element: 'dues-chart',
            resize: true,
            data: [
                @foreach($chartDues as $data)
                    {label: "{{ $data['label'] }}", value: {{ $data['count'] }} },
                @endforeach
            ],
            colors: [
                @foreach($chartDues as $data)
                    "{{ $data['color'] }}",
                @endforeach
            ],
        });

        $(document).ready(function() {
            $('#stats-table').DataTable({
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
            $('#low-table').DataTable({
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
            $('#statsCoupons-table').DataTable({
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