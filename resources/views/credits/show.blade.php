@extends('adminlte::page')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li><a href="#info" data-toggle="tab" >Datos del Crédito</a></li>
                <li><a href="#fees" data-toggle="tab" >Cuotas</a></li>
            </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="info">

              <!-- Datos Personales -->
                
                <div class="row">

                  <div class="col-md-12">

                  <ul class="timeline timeline-inverse">
                     
                      <li>
                        <i class="fa fa-list bg-blue"></i>
                        <div class="timeline-item">
                          <h3 class="timeline-header"><a href="#">Compra </a> </h3>
                          <div class="timeline-body">
                            <div class="row">

                              <div class="col-sm-12 col-md-8 col-lg-8">
                                <!-- Sale Info-->

                                <div class="row">
                                  <div class="col-sm-12 sol-md-6 col-lg-6">
                                    {{Form::label('Empresa')}} <br>
                                    {{$credit->sale->company->name}} 
                                  </div>

                                  <div class="col-sm-12 sol-md-3 col-lg-3">
                                    {{Form::label('Código')}} <br>
                                    {{$credit->sale->id}} 
                                  </div>

                                  <div class="col-sm-12 sol-md-3 col-lg-3">
                                    {{Form::label('Fecha')}} <br>
                                    {{$credit->sale->date->format('d-m-Y')}} 
                                  </div>
                                </div>
                                
                                <br>

                                <div class="row">

                                    <div class="col-sm-12 sol-md-6 col-lg-3">
                                        {{Form::label('DNI')}} <br>
                                        {{$credit->sale->client->dni}} 
                                    </div>

                                  <div class="col-sm-12 sol-md-6 col-lg-5">
                                    {{Form::label('Cliente')}} <br>
                                    {{$credit->sale->client->name}} 
                                  </div>

                                  
                                  <div class="col-sm-12 sol-md-6 col-lg-4">
                                    {{Form::label('Vendedor')}} <br>
                                    {{$credit->sale->user->name}} 
                                  </div>
                                </div>

                                <br>
                                
                                  
                                <div class="table-responsive">
                                    <table class="table table-hoover table-striped">
                                      <tr>
                                        <th colspan="5"> 
                                          <p class="text-center">
                                            Detalles de Compra
                                          </p>
                                        </th>
                                      </tr>
                                      <tr>
                                        <td>#</td>
                                        <td>Producto</td>
                                        <td>Cant.</td>
                                        <td>Precio Unit.</td>
                                        <td>Descuento %</td>
                                        <td>Precio Total</td>
                                      </tr>
                                      
                                      @foreach ($credit->sale->sale_details as $key => $credit->sale_detail)
                                      
                                        <tr>
                                          <td>{{$key+1}}</td>
                                          <td>{{$credit->sale_detail->product->name}}</td>
                                          <td>{{$credit->sale_detail->qty}}</td>
                                          <td>{{ number_format($credit->sale_detail->price, 0, ',', '.') }}</td>
                                          <td>{{($credit->sale_detail->amount_discount * 100) / $credit->sale_detail->price}}%</td>
                                          <td>{{ number_format($credit->sale_detail->subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                        
                                      @endforeach
                                      
                                    </table>
                                </div>

                                <div class="row">
                                  <div class="pull-right">
                                    <b>Subtotal: </b> {{ number_format($credit->sale->subtotal, 0, ',', '.') }} <br>

                                    <b>Impuesto: </b> @if(empty($credit->sale->tax)) No Tiene @else {{ $credit->sale->tax }} @endif <br>
                                        
                                    <b>Descuento: </b> @if(empty($credit->sale_detail->amount_discount)) No Tiene @else {{ ($credit->sale_detail->amount_discount * 100) / $credit->sale_detail->price  }}% @endif <br>
                                        
                                    <b>Total: </b> {{ number_format($credit->sale->total - $credit->sale->tax, 0, ',', '.') }}
                                  </div>
                                </div>
                              </div>

                              <div class="col-sm-12 col-md-4 col-lg-4">
                                
                                <div class="row">
                                    <h5 class="text-bold"> Detalles del Crédito </h5>
                                    <h5>Crédito N°: {{ $credit->id }} </h5>
                                    <h5> Monto del Crédito: {{ number_format($credit->sale->total - $credit->sale->tax, 0, ',', '.') }} </h5>
                                    @if($credit->type == 'sing')
                                        <h5> Monto Cancelado: {{ $credit->payment_raw + $credit->advance_I + $credit->advance_II }} </h5>
                                    @else
                                        <h5> Monto Cancelado: {{ $credit->payment }} </h5>
                                    @endif
                                    @if($credit->type == 'sing')
                                        <h5> Monto Por Cancelar: {{ $credit->sale->total - ($credit->payment_raw + $credit->advance_I + $credit->advance_II) }} </h5>
                                    @else
                                        <h5> Monto Por Cancelar: {{ number_format($credit->final_amount - $credit->payment_raw, 0, ',', '.') }} </h5>
                                    @endif
                                    @if($credit->type != 'sing')
                                    <h5> Cuotas: {{ $credit->fees }}</h5>
                                    <h5> Interes por cuotas vencidas: {{ $credit->interest_expired }} % </h5>
                                    @endif
                                    <h5> Liquidado:  
                                        @if($credit->is_payed == true)
                                            Si
                                        @else
                                            No
                                        @endif
                                    </h5>
                                </div>
                                <div class="row">
                                    @for($i = 0; $i < $credit->fees; $i++)
                                        <div class="col-md-2">
                                            <h5>Interes cuota N° {{ ($i+1) }}: </h5> {{ json_decode($credit->interest, true)[$i] }}
                                        </div>
                                    @endfor
                                </div>
                              </div>
                          
                            </div>
                            @isset($refinanceAmout)
                                <div class="row">
                                    <div class="col-md-12">
                                        <button id="modal-button" type="button" title="Refinanciar credito" class="btn btn-warning">
                                            Refinanciar
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                      </li>

                      
                    </ul>

                  </div>

                </div>


              <!-- /.post -->
            </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="fees">
                    <div class="container-fluid">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="data" class="display" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th scope="col">N° Cuota</th>
                                        <th scope="col">Fecha de pago</th>
                                        @if($credit->type != 'sing')
                                            <th scope="col">Monto de la cuota</th>
                                        @endif
                                        <th scope="col">Monto pagado</th>
                                        <th scope="col">Por Pagar</th>
                                        @if($credit->type != 'sing')
                                        <th scope="col">Fecha de expiración</th>
                                        @endif
                                        <th scope="col">Días de retraso</th>
                                        <th scope="col">Pagada</th>
                                        <th scope="col">Vencida</th>
                                        <th scope="col">Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                      $preview = true;
                                    @endphp
                                    <tr>
                                        <td>
                                                0
                                        </td>
                                        <td>
                                          @if($credit->date_advance_I != null) 
                                            {{ $credit->date_advance_I->format('d-m-Y') }}
                                          @else
                                            No aplica
                                          @endif
                                        </td>
                                        @if($credit->type != 'sing')
                                        <td>{{ number_format($credit->advance_I, 0, ',', '.') }}</td>
                                        @endif
                                        <td>{{ number_format($credit->advance_I, 0, ',', '.') }}</td>
                                        <td> - </td>
                                        @if($credit->type != 'sing')
                                            <td>{{ $credit->created_at->format('d-m-Y') }}</td>
                                        @endif
                                        <td>-</td>
                                        <td class="bg-green"> Si </td>
                                        <td> @if($credit->created_at->diffInDays($credit->date_advance_I) > 0) Si @else No @endif </td>
                                        <td> <a href="{{route('coupon.singAdvanceOne', $credit->id)}}" target="blanck" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Cupon de pago" > <i class="fa fa-file-pdf-o"></i></a></td>
                                    </tr>
                                    @if($credit->type == 'two_advance' || $credit->type == 'sing')
                                        <tr>
                                            <td> 
                                                00
                                            </td>
                                            <td>
                                                @empty ($credit->date_advance_II)
                                                    -
                                                @else
                                                    {{ $credit->date_advance_II->format('d-m-Y') }}
                                                @endempty
                                            </td>
                                            @if ($credit->type == 'two_advance')
                                                <td>{{ number_format($credit->advance_I, 0, ',', '.') }}</td>
                                            @else
                                                <td>{{ number_format($credit->advance_II, 0, ',', '.') }}</td>
                                            @endif
                                            @if($credit->type != 'sing')
                                                <td>{{ number_format($credit->advance_II, 0, ',', '.') }}</td>
                                            @endif
                                            <td>
                                                @if ($credit->type == 'two_advance')
                                                    {{ number_format(($credit->advance_I - $credit->advance_II), 0, ',', '.') }} 
                                                @else
                                                    @if(! empty($credit->advance_II))
                                                        {{ number_format(($credit->sale->total - $credit->advance_II )- $credit->advance_I, 0, ',', '.') }}
                                                    @else
                                                        @if($credit->is_expired == 1)
                                                            {{ number_format(((($credit->sale->total - ($credit->advance_I + $credit->advance_II)) * $credit->interest_expired) + $credit->sale->total - ($credit->advance_I + $credit->advance_II)), 0, ',', '.') }} 
                                                        @else
                                                            {{ number_format(($credit->sale->total - ($credit->advance_I + $credit->advance_II)), 0, ',', '.') }} 
                                                        @endif
                                                    @endif
                                                @endif
                                            </td>
                                            
                                            @if(\Carbon\Carbon::now() > $credit->date_advance_I->addDays(60))
                                                <td>{{ \Carbon\Carbon::now()->diffInDays($credit->date_advance_I->addDays(60)) }}</td>
                                            @else
                                                <td>  -</td>
                                            @endif
                                            @if ($credit->type == 'two_advance')
                                                @if( ($credit->advance_I - $credit->advance_II) == 0) 
                                                    <td class="bg-green">Si</td>
                                                @else 
                                                    <td>No</td> 
                                                @endif
                                            @else
                                                @if(! empty($credit->advance_II)) 
                                                    <td class="bg-green">Si</td>
                                                @else 
                                                    <td>No</td> 
                                                @endif
                                            @endif
                                            <td>@if($credit->created_at->diffInDays($credit->date_advance_I) > 0) Si @else No @endif</td>
                                            <td>
                                                @if ($credit->type == 'two_advance')
                                                    @if( ($credit->advance_I - $credit->advance_II) == 0) <center>-</center> @else <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#secondModal" data-placement="top" title="Pagar segundo avance" @if( ($credit->advance_I - $credit->advance_II) == 0) disabled @endif> <i class="fa fa-usd"></i></a> @endif
                                                @else
                                                    @if(! empty($credit->advance_II)) 
                                                        <a href="{{route('coupon.singAdvanceSecond', $credit->id)}}" target="blanck" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Cupon de pago" > <i class="fa fa-file-pdf-o"></i></a>
                                                    @else 
                                                        <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" 
                                                            data-target="#secondModal" data-placement="top" 
                                                            title="Pagar segundo avance" 
                                                            @if(! empty($credit->advance_II)) disabled @endif> 
                                                            <i class="fa fa-usd"></i>
                                                        </a> 
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                        @php
                                            if ($credit->type == 'two_advance') {
                                                if (($credit->advance_I - $credit->advance_II) != 0) {
                                                    $preview = false;
                                                }
                                            } else {
                                                if (($credit->sale->total - ($credit->advance_I + $credit->advance_II)) != 0) {
                                                    $preview = false;
                                                }
                                            }
                                        @endphp
                                    @endif
                                    @php
                                        $amount = 0;
                                    @endphp
                                    @foreach ($credit_details as $credit_detail)
                                        
                                        <tr>
                                          <td>{{$credit_detail->fee_number  }}</td>
                                          <td>
                                            @if(!empty($credit_detail->fee_date)) 
                                            {{ $credit_detail->fee_date->format('d-m-Y') }} @endif 
                                            </td>
                                            @if($credit->type != 'sing')
                                                <td>{{ number_format($credit_detail->fee_amount, 0,',','.') }}</td>
                                            @endif
                                                <td>{{ number_format($credit_detail->payment, 0,',','.') }}</td>
                                            
                                        <td>
                                            @if($credit->type == 'sing' )
                                            @php
                                                $amount += $credit_detail->fee_amount;
                                            @endphp
                                                {{ number_format( $credit->sale->total -($amount + $credit->advance_I + $credit->advance_II), 0,',','.') }}
                                            @else
                                                {{ number_format($credit_detail->fee_amount - $credit_detail->payment, 0,',','.') }}
                                            @endif
                                        </td>
                                        @if($credit->type != 'sing')
                                            <td>{{$credit_detail->fee_date_expired->format('d-m-Y')}}</td>
                                        @endif
                                          <td>
                                            @if($credit->type != 'sing')
                                                @if(\Carbon\Carbon::now() > $credit_detail->fee_date_expired && $credit_detail->is_payed == 0)
                                                    {{ $credit_detail->fee_date_expired->diffInDays(\Carbon\Carbon::now()) }}
                                                @endif
                                            @else
                                                @if(\Carbon\Carbon::now() > $credit->date_advance_I->addDays(60))
                                                        {{ \Carbon\Carbon::now()->diffInDays($credit->date_advance_I->addDays(60)) }}
                                                    @else
                                                        -
                                                @endif
                                            @endif
                                          </td>
                                           <td @if($credit_detail->is_payed) class="bg-green" @endif>
                                            @if($credit_detail->is_payed)
                                              Si
                                            @else
                                              No
                                            @endif
                                          </td>
                                          <td @if(!$credit_detail->is_payed && $credit_detail->is_expired) class="bg-red" @endif>
                                            @if($credit_detail->is_expired)
                                              Si
                                            @else
                                              No
                                            @endif
                                          </td>
                                          <td> 
                                            
                                            @if($credit_detail->payment)
                                                @if($credit->type == 'sing')
                                                    <a href="{{route('findFee', $credit_detail->id)}}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Pagar" @if($credit_detail->is_payed == 1) disabled @endif> <i class="fa fa-usd"></i></a>
                                                    <a href="{{route('coupon.sing', $credit_detail->id)}}" target="blanck" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Cupon de pago" > <i class="fa fa-file-pdf-o"></i></a>
                                                @else
                                                    <a href="{{route('findFee', $credit_detail->id)}}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Pagar" @if($credit_detail->is_payed == 1) disabled @endif> <i class="fa fa-usd"></i></a>
                                                    <a href="{{route('coupon', $credit_detail->id)}}" target="blanck" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Cupon de pago" > <i class="fa fa-file-pdf-o"></i></a>
                                                @endif
                                            @else
                                                <a href="{{route('findFee', $credit_detail->id)}}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Pagar" @if($credit_detail->is_payed == 1) disabled @endif> <i class="fa fa-usd"></i></a>
                                            @endif 

                                            @if($credit_detail->is_payed == 1)
                                              @php
                                                $preview = true;
                                              @endphp
                                            @else
                                              @php
                                                $preview = false;
                                              @endphp
                                            @endif
                                             </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="10">
                                            <p class="text-right">
                                                <strong>Devolver el último pago:</strong>
                                                <a href="#" class="btn btn-warning" title="Devolver el último pago realizado" data-toggle="modal" 
                                        data-target="#lastPaysModal">
                                                    <span class="fa fa-refresh"></span>
                                                </a>
                                            </p>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        @if($credit->type == 'sing')
                            <div class="row">
                                <div class="col-md-12">
                                    <strong>Por pagar:</strong>
                                    @if($credit->type == 'sing')
                                        $ {{ $credit->sale->total - ($credit->payment_raw + $credit->advance_I + $credit->advance_II) }} 
                                    @else
                                        $ {{ number_format($credit->final_amount - $credit->payment_raw, 0, ',', '.') }} 
                                    @endif
                                    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" 
                                        data-target="#secondModal" data-placement="top" 
                                        title="Pagar segundo avance" 
                                        @if( ($credit->sale->total - ($credit->advance_I + $credit->advance_II + $credit->credit_details->sum('fee_amount'))) == 0) disabled @endif> 
                                        <i class="fa fa-usd"></i>
                                    </a>
                                </div>          
                            </div>
                        @endif      
                    </div>
                </div> 
            </div>
            <!-- /.tab-pane -->
          </div>
          <!-- /.tab-content -->
        </div>
        <!-- /.nav-tabs-custom -->
    </div>
      
</div>
    @if($credit->type == 'two_advance' || $credit->type == 'sing')
        <div class="modal fade" id="secondModal" tabindex="-1" role="dialog" aria-labelledby="secondModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    {!! Form::open(['route' => ['credits.second.advance', $credit], 'method' => 'PATCH']) !!}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="secondModalLabel">Pago de segundo avance</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                {{ Form::label('advance_II', 'Segundo Anticipo') }}
                                {{ Form::text('advance_II', null, ['class' => 'form-control', 'placeholder' => 'Monto segundo anticipo', 'required', 'pattern' => '[0-9]{1,999}']) }}
                            </div>

                            <div class="form-group">
                                {!! Form::label('way_to_pay', 'Seleccione forma de pago del anticipo:') !!}
                                {!! Form::select('way_to_pay', [
                                    'cash' => 'Efectivo', 
                                    'card' => 'Tarjeta'
                                    ], null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opción', 'required']) !!}
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">Pagar</button>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    @endif


    @isset($refinanceAmout)
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    {!! Form::open(['route' => ['credits.refinance', $credit->id], 'method' => 'POST']) !!}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Refinanciamiento</h4>
                        </div>
                        <div class="modal-body">
                            
                            <div class="form-group">
                                {!! Form::label('way_sale', 'Seleccione forma de venta:') !!}
                                {!! Form::select('way_sale', [
                                    'credit' => 'Cr&eacute;dito (Un Anticipo)',
                                    'two_advance' => 'Cr&eacute;dito (Doble Anticipo) '
                                ], null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opción', 'required'=>false, 'not-disabled']) !!}
                            </div>
                            
                            <!--Form-->
                            <div id="sale-credit-form">
                                
                                <div class="form-group" field="anticipo-i" data-valid="sing|credit|two_advance">
                                    
                                    {{ Form::label('advance_I', 'Anticipo') }}
                                
                                    {{ Form::text('advance_I', null, ['class' => 'form-control', 'placeholder' => 'Mínimo de Anticipo', 'required'=>false, 'autocomplete'=>'off']) }}
                                </div>

                                <div class="form-group" field="way_to_pay" data-valid="sing|credit|two_advance">
                                    {!! Form::label('way_to_pay', 'Seleccione forma de pago del anticipo:') !!}
                                    {!! Form::select('way_to_pay', [
                                        'cash' => 'Efectivo', 
                                        'card' => 'Tarjeta'
                                        ], null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opción', 'required'=>false]) !!}
                                </div>

                                <div class="form-group" field="anticipo-ii" data-valid="sing|two_advance">
                                    
                                    <div class="alert alert-warning">
                                        El segundo anticipo se solicita despues de procesado el registro
                                    </div>
                                </div>

                                <div class="form-group" field="first_fee" data-valid="without_advance">
                                    {!! Form::label('first_fee', 'Seleccione la fecha de la primera cuota, en dias:') !!}
                                    {!! Form::select('first_fee', [
                                        '0' => 'Primera cuota hoy', 
                                        '30' => '30 dias', 
                                        '60' => '60 dias', 
                                        '90' => '90 dias (Con autorización)'
                                        ], null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opción', 'required'=>false, 'first_fee']) !!}
                                </div>

                                <div class="form-group" field="fees" data-valid="credit|two_advance|without_advance">
                                    {{ Form::label('Cuotas') }}
                                    @php 
                                    $cuotas = [];
                                    for($i = 1; $i <= 12; $i++){
                                        $cuotas[$i] = sprintf('En %s cuotas', $i);
                                    }
                                    $cuotas['add'] = 'Autorizar otro n&uacute;mero de cuotas';

                                    @endphp
                                    {{ Form::select('fees', $cuotas , null, ['class' => 'form-control' ,'placeholder' => 'Seleccionar numero de cuotas', 'fees_select', 'required'=>false ]) }}

                                </div>
                                
                                <div class="row">
                                    {{--
                                        <div class="col-md-6">
                                            <div class="form-group" field="surcharge" data-valid="credit|two_advance|without_advance">
                                                {{ Form::label('% de recargo') }}
                                               
                                                {{ Form::text('surcharge', null, ['class' => 'form-control','placeholder' => ' % de recargo', 'required'=>false, 'disabled', 'readonly' ]) }}
                                            </div>
                                        </div>
                                    --}}

                                    <div class="col-md-12">
                                        <div class="form-group" field="amount_financial" data-valid="credit|two_advance|without_advance">
                                            {{ Form::label('Monto a Refinanciar') }}
                                           
                                            {{ Form::text('amount_refinance', null, ['class' => 'form-control', 'required'=>false, 'disabled', 'readonly' ]) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" field="observation" data-valid="sing|credit|two_advance|without_advance">
                                    {!! Form::label('observation', 'Observaciones:') !!}
                                    {!! Form::textarea('observation', null, ['class' => 'form-control', 'placeholder' => 'Observaciones']) !!}
                                </div>
                            
                            </div>
                            <!--End Form-->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success btn-flat">Continuar</button>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    @endisset
    
    <div class="modal" tabindex="-1" role="dialog" id="lastPaysModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Devolución de pago</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            @if($idLastPays)

            {!! Form::open(['route' => ['returnPayment.auth'], 'method' => 'POST']) !!}
            
            {{ Form::hidden('credit_id', $idLastPays->credit_id) }}
            {{ Form::hidden('share_id', $idLastPays->id) }}
            <div class="col-md-12 @if($errors->has('auth')) has-error @endif">
                <div class="form-group">
                    {!! Form::label('auth', 'Código de autorización') !!}
                    {!! Form::text('auth', old('auth'), ['class' => 'form-control']) !!}
                </div>
            </div>
           
            <div class="col-md-12 @if($errors->has('currentAmount')) has-error @endif">
                <div class="form-group">
                    {{ Form::label('Monto actual de la cuota') }}
                    {{ Form::text('currentAmount', $idLastPays->fee_amount, ['class' => 'form-control', 'readonly']) }}

                    @if($errors->has('name'))
                        <span class="help-block">(*) {{$errors->first('name')}}</span>
                    @endif
                </div>
            </div>

            <div class="col-md-12 @if($errors->has('name')) has-error @endif">
                <div class="form-group">
                    {{ Form::label('Monto a descontar') }}
                    {{ Form::text('discountAmount', 0, ['class' => 'form-control discount', 'autocomplete' => 'off']) }}

                    @if($errors->has('name'))
                        <span class="help-block">(*) {{$errors->first('name')}}</span>
                    @endif
                </div>
            </div>

            <div class="col-md-12 @if($errors->has('name')) has-error @endif">
                <div class="form-group">
                    {{ Form::label('Monto final de la cuota') }}
                    {{ Form::text('finalAmount', 0, ['class' => 'form-control final', 'readonly']) }}

                    @if($errors->has('name'))
                        <span class="help-block">(*) {{$errors->first('name')}}</span>
                    @endif
                </div>
            </div>
                        
          </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-success btn-flat">Generar descuento</button>
            </div>
            {!! Form::close() !!}
            @endif
        </div>
      </div>
    </div>

@stop

@section('js')
    @parent
    
    @isset($refinanceAmout)
        <script type="text/javascript">

            $('#modal-button').on('click', function (){

                $.fn.hiddenFields();
                $('select#way_sale').val('');
                $('#myModal').find('[remove-msg-error]').remove();
                $('#myModal').modal('show');

            });

            $.fn.hiddenFields = function(){
                
                $('form#SendFormSale').find('[remove-pwd-input="zxc"]').remove();

                $('#sale-credit-form').find('input, select, textarea').not('[not-disabled]').prop('disabled',true);
                $('#sale-credit-form').find('input, select, textarea').val('');
                $('#sale-credit-form').find('div[field]').hide();
                //$('#sale-credit-form').find('input[name="surcharge"]').val(sale.client.client_type.surcharge);
                //$('#sale-credit-form').find('input[name="interest"]').val(sale.client.client_type.interest);

                //var recargo = Math.ceil((sale.subtotal * (1+(sale.client.client_type.surcharge/100))))
                $('#sale-credit-form').find('input[name="amount_refinance"]').val("{{ number_format($refinanceAmout, 0, ',', '.') }}");

            }

            $('select[name="way_sale"]').on('change', function (){
                
                var type = $(this).val();

                if(type){

                    $.fn.hiddenFields();

                    $('#sale-credit-form').find('div[field]').each(function(k,v){

                        if($(this).data('valid').indexOf(type) !== -1){
                            $(this).find('input, select, textarea').prop('disabled', false);
                            $(this).show();
                        }

                    });

                }else{

                    $.fn.hiddenFields();

                }

            });

            //Autorización del numero de cuotas
            $('select[fees_select]').on('change', function(){

                var select = $(this);

                if($(this).val() == 'add'){

                    $('#myModal').css('display', 'none');

                    swal({
                      title: '<b>Autorizar</b>',
                      type: 'warning',
                      html:
                        `<div id="authorization-store">
                            <p>Debe pedir a un usuario con privilegios que autorice esta acci&oacute;n</p>
                            @php 
                            $cuotas = [];
                            for($i = 13; $i <= 64; $i++){
                                $cuotas[$i] = $i;
                            }
                            @endphp
                            {{ Form::select('value', $cuotas , null, ['class' => 'form-control' ,'placeholder' => 'Seleccionar n&uacute;mero de cuotas para autorizar' ]) }}

                            <br>
                            <label>Clave de autorizaci&oacute;n</label>
                            <input type="hidden" name="type" value="fees">
                            <input type="password" name="clave" class="form-control" placeholder="Ingrese clave de autorizaci&oacute;n"/><br>
                        </div>`,
                      showCloseButton: true,
                      showCancelButton: true,
                      focusConfirm: false,
                      confirmButtonText:
                        'Autorizar',
                      //confirmButtonAriaLabel: 'Thumbs up, great!',
                      cancelButtonText:
                      'Cancelar',
                      //cancelButtonAriaLabel: 'Thumbs down',
                    }).then(
                        (confirm) => {
                            
                            if(confirm){
                                var data = {
                                    value: $('#authorization-store').find('select[name="value"]').val(),
                                    clave: $('#authorization-store').find('input[name="clave"]').val(),
                                    type: $('#authorization-store').find('input[name="type"]').val()
                                };

                                $.ajax({
                                    type: 'post',
                                    url: '{{ route("authorizations.store") }}',
                                    data: data,
                                    dataType: "json",
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                }).done(function(response){
                            
                                    select.find('option[authorization]').remove();

                                    select.append('<option value="'+response.token+'" data-cuotas="'+response.cuotas+'" authorization selected>Cuotas autorizadas: '+response.cuotas+' (Es valido s&oacute;lo para esta operaci&oacute;n)</option>')

                                    select.parent().append('<div class="alert alert-success" style="margin-top:10px;" error-cuota>'+response.message+'</div>');

                                    setTimeout(function(){
                                        $('[error-cuota]').remove();
                                    }, 5000);

                                    $.fn.calculeCuotas();

                                     

                                }).fail(function(a,b,c){
                                    
                                    select.parent().append('<div class="alert alert-error" style="margin-top:10px;" error-cuota>'+a.responseJSON.message+'</div>');
                                    
                                    select.val('');

                                    setTimeout(function(){
                                        $('[error-cuota]').remove();
                                    }, 5000);

                                });

                            }
                            
                            $('#myModal').css('display', 'block');
                        }, 
                        () => {
                            $('#myModal').css('display', 'block');
                            select.val('');
                        }
                    );

                }else{
                    $.fn.calculeCuotas();
                }

            });

            $.fn.calculeCuotas = function(){
                
                var cuotas = $('select[fees_select]').val();
                if($('select[fees_select]').find('option:selected').data('cuotas')){
                    cuotas = $('select[fees_select]').find('option:selected').data('cuotas');
                }

                 

                var recargo = Math.ceil((sale.subtotal * (1+(sale.client.client_type.surcharge/100))));

                var interes = (sale.client.client_type.interest/100)+1;
                var monto_cuota = Math.ceil((recargo/cuotas)*interes);

                
                $('#sale-credit-form').find('input[name="amount_cuotes"]').val($.fn.money(monto_cuota));

                
            }

            //Autorización para 90 dias sin anticipo
            $('select[first_fee]').on('change', function(){

                var select = $(this);

                @isset($sale)
                    @if(! json_decode($sale, true)['client']['first_fee'])
                        if($(this).val() == 90){
                    @endif

                        if(select.val() != 0){

                            $('#myModal').css('display', 'none');

                            swal({
                              title: '<b>Autorizar</b>',
                              type: 'warning',
                              html:
                                `<div id="authorization-store">
                                    <p>Debe pedir a un usuario con privilegios que autorice esta acci&oacute;n</p>
                                    <br>
                                    <label>Clave de autorizaci&oacute;n</label>
                                    <input type="hidden" name="type" value="first_fee">
                                    <input type="password" name="clave" class="form-control" placeholder="Ingrese clave de autorizaci&oacute;n"/><br>
                                </div>`,
                              showCloseButton: true,
                              showCancelButton: true,
                              focusConfirm: false,
                              confirmButtonText:
                                'Autorizar',
                              //confirmButtonAriaLabel: 'Thumbs up, great!',
                              cancelButtonText:
                              'Cancelar',
                              //cancelButtonAriaLabel: 'Thumbs down',
                            }).then(
                                (confirm) => {
                                    
                                    if(confirm){
                                        var data = {
                                            value: $('#myModal').find('select[name="first_fee"]').val(),
                                            clave: $('#authorization-store').find('input[name="clave"]').val(),
                                            type: $('#authorization-store').find('input[name="type"]').val(),
                                        };

                                        $.ajax({
                                            type: 'post',
                                            url: '{{ route("authorizations.store") }}',
                                            data: data,
                                            dataType: "json",
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        }).done(function(response){

                                            select.find('option[authorization]').remove();

                                            select.append('<option value="'+response.token+'" authorization selected>Primera cuota autorizada a: '+response.cuotas+' dias (Es valido s&oacute;lo para esta operaci&oacute;n)</option>')

                                            select.parent().append('<div class="alert alert-success" style="margin-top:10px;" error-cuota>'+response.message+'</div>');

                                            setTimeout(function(){
                                                $('[error-cuota]').remove();
                                            }, 5000);

                                        }).fail(function(a,b,c){
                                            
                                            select.parent().append('<div class="alert alert-error" style="margin-top:10px;" error-cuota>'+a.responseJSON.message+'</div>');
                                            
                                            select.val('');

                                            setTimeout(function(){
                                                $('[error-cuota]').remove();
                                            }, 5000);

                                        });

                                    }
                                    
                                    $('#myModal').css('display', 'block');
                                }, 
                                () => {
                                    $('#myModal').css('display', 'block');
                                    select.val('');
                                }
                            );
                            
                        }
                    @if(! json_decode($sale, true)['client']['first_fee'])
                    }
                    @endif
                @endif

            });
            {{--  
            $('form#SendFormSale').on('submit', function(event){
                // event.stopPropagation();
                // event.preventDefault();

                var form = $(this);

                form.find('[remove-msg-error]').remove();

                $.ajax({
                    type: 'post',
                    url: '{{ route("sales.validate.form") }}',
                    data: $(this).serialize(),
                    dataType: "json",
                    async: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).done(function(response){
                    
                    if(!response.OK){
                        event.stopPropagation();
                        event.preventDefault();
                    }

                }).fail(function(a){
                    
                    event.stopPropagation();
                    event.preventDefault();
                    $('form#SendFormSale').find('[remove-pwd-input="zxc"]').remove();
                    $.each(a.responseJSON[0], function(k, v) {
                        /* iterate through array or object */

                        if (isJson(v[0])) {
                            var elem = JSON.parse(v[0]);

                            var msg = '<span class="help-block" style="color:red;" remove-msg-error>'+elem[0]+'</span>';

                            if (elem[1] === 'auth') {
                                var html = `
                                    <div class="form-group" remove-pwd-input="zxc">
                                        {!! Form::label('auth_limit_credit', 'Ingrese contraseña para autorizar l&iacute;mite extra de cr&eacute;dito') !!}
                                        {!! Form::password('auth_limit_credit', ['class' => 'form-control', 'placeholder' => 'Contraseña para autorizar', 'autocomplete'=>'off']) !!}
                                    </div>
                                `;

                                form.find('[name="'+k+'"]').parent().after(html);
                            }
                        } else {
                            var msg = '<span class="help-block" style="color:red;" remove-msg-error>'+v+'</span>';
                        }

                        form.find('[name="'+k+'"]').parent().append(msg);
                    });
                });
            });
            --}}
            function isJson(str) {
                try {
                    JSON.parse(str);
                } catch (e) {
                    return false;
                }
                return true;
            }
        </script>
    @endif

    <script type="text/javascript">
        $(document).ready(function() {
            //Tomo el 'hash' que viene en la url
            let hash = window.location.hash;

            //si no esta definido
            if (hash === '' || hash == undefined || hash == null) {
                hash = '#info'; //'hash' por defecto
            }

            //tomo el 'li' padre del 'a'
            let parent = $('a[href="'+hash+'"]').parent();

            //Busco los 'li' hermanos
            $(parent).siblings('li').each(function(index, el) {
                //si tiene la clase 'active' se la remuevo
                $(el).hasClass('active') ? $(el).removeClass('active') : '';
            });

            //Le agrego la clase 'active' al 'li' padre
            $(parent).addClass('active');

            //seteo el 'aria-expanded' a 'true'
            $('a[href="'+hash+'"]').attr('aria-expanded', true);

            //busco los 'div' hermanos
            $(hash).siblings('div.tab-pane').each(function(index, el) {
                //si tiene la clase 'active' se las remuevo
                $(el).hasClass('active') ? $(el).removeClass('active') : '';
            });

            //le agrego la clase 'active' al 'div' con 'id' = 'hash' 
            $(hash).addClass('active');

            //currentAmount
            //discountAmount
            //finalAmount
            $("input[name='discountAmount']").on('click', ev => {
                $("input[name='discountAmount']").val('');
            })
            $("input[name='discountAmount']").on('keyup', ev => {
                //console.log($("input[name='discountAmount']").val());
                calculateDiscount();
            })
        });

        const calculateDiscount = () => {
            let currentAmount = $("input[name='currentAmount']").val();
            let discountAmount = $("input[name='discountAmount']").val();
            let finalAmount = parseFloat(0.00);

            currentAmount = currentAmount.replace(",", ".");
            if (discountAmount == '') {
                $("input[name='finalAmount']").val(0.00);
            }else if(parseFloat(currentAmount) < parseFloat(discountAmount)){
                alert('El monto ingresado debe ser menor o igual al monto actual');
                $("input[name='discountAmount']").val('');
                $("input[name='finalAmount']").val(0);
            }else{
                finalAmount = parseFloat(currentAmount) - parseFloat(discountAmount);
                $("input[name='finalAmount']").val(parseFloat(finalAmount).toFixed(2));
            }
        }
    </script>
@endsection