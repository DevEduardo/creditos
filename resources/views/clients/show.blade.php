@extends('adminlte::page')

@section('content')

<div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="btn btn-group pull-right">
                        
          {!! Form::model($client, ['method' => 'delete', 'route' => ['clients.destroy', $client->id], 'class' =>'form-inline form-delete']) !!}
                              
            {!! Form::hidden('id', $client->id) !!}
                              
              <a href="{{route('clients.edit', $client->id)}}" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> Editar</a>

              <button type="submit" name="delete_modal" class="btn btn-danger btn-sm delete " data-toggle="tooltip" data-placement="top" title="Eliminar" data-original-title="Eliminar"><i class="fa fa-trash"></i>Eliminar</button>
                            
            {!! Form::close() !!}
        </div>

        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Datos del Cliente</a></li>
            
            {{--  <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Créditos</a></li> --}}

            <li class=""><a href="#records" data-toggle="tab" aria-expanded="false">Historial</a></li>

          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="activity">

              <!-- Datos Personales -->
                
                <div class="row">

                  <div class="col-md-12">

                  <ul class="timeline timeline-inverse">
                     
                      <li>
                        <i class="fa fa-user bg-blue"></i>
                        <div class="timeline-item">
                          <h3 class="timeline-header"><a href="#">Información Personal </a> </h3>
                          <div class="timeline-body">
                            <div class="row">

                              <div class="col-md-4 col-sm-6 col-xs-12">
                                <h5> <b>Nombre:</b>  <br> {{$client->name}}</h5>
                              </div>

                              <div class="col-md-4 col-sm-6 col-xs-12">
                                <h5> <b>DNI:</b>  <br> {{$client->dni}} </h5>
                              </div>

                              <div class="col-md-4 col-sm-6 col-xs-12">
                                <h5> <b>Tipo de Cliente:</b>  <br> {{$client->client_type->name}} </h5>
                              </div>
                            </div>
                            
                          </div>
                        </div>
                      </li>


                      <li>
                        <i class="fa fa-list bg-blue"></i>
                        <div class="timeline-item">
                          <h3 class="timeline-header"><a href="#">Información Laboral </a> </h3>
                          <div class="timeline-body">
                            <div class="row">

                              <div class="col-md-4 col-sm-6 col-xs-12">
                                <h5> <b>Trabaja Actualmente:</b>  <br> 

                                  @if($client->is_working == true)
                                    Si
                                  @else
                                    No  
                                  @endif

                                </h5>
                              </div>

                              <div class="col-md-4 col-sm-6 col-xs-12">
                                <h5> <b>Profesión / Ocupación :</b>  <br> {{$client->profession}} </h5>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xs-12">
                                <h5> <b>Información de empresa:</b></h5>
                                @php
                                    $enterprise = json_decode($client->enterprise, true);
                                @endphp
                              </div>
                            </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <p>
                                            <strong>Nombre: </strong> {{ $enterprise['name'] }}
                                        </p>
                                        <p>
                                            <strong>CUIT: </strong> {{ $enterprise['cuit'] }}
                                        </p>
                                        <p>
                                            <strong>Email: </strong> {{ $enterprise['email'] }}
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <p>
                                            <strong>Localidad: </strong> {{ $enterprise['location'] }}
                                        </p>
                                        <p>
                                            <strong>Barrio: </strong> {{ $enterprise['district'] }}
                                        </p>
                                        <p>
                                            <strong>Entrecalles: </strong> {{ $enterprise['between_street'] }}
                                        </p>
                                        <p>
                                            <strong>Dirección: </strong> {{ $enterprise['address'] }}
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <p>
                                            <strong>Coordenadas: </strong> {{ $enterprise['coordinates'] }}
                                        </p>
                                        <p>
                                            <strong>Codigo postal: </strong> {{ $enterprise['postal_code'] }}
                                        </p>
                                        <p>
                                            <strong>Telefono 1: </strong> {{ $enterprise['phone1'] }}
                                        </p>
                                        <p>
                                            <strong>Telefono 2: </strong> {{ $enterprise['phone2'] }}
                                        </p>
                                    </div>
                                </div>
                          </div>
                        </div>
                      </li>


                      <li>
                        <i class="fa fa-file-o bg-blue"></i>
                        <div class="timeline-item">
                          <h3 class="timeline-header"><a href="#">Archivos </a> </h3>
                          <div class="timeline-body">
                            <div class="row">

                              <div class="col-md-4 col-sm-6 col-xs-12">
                                <h5> <b>Archivo DNI:</b>  <br> </h5>


                                <a href="{{asset('uploads/clients/'.$client->image_dni)}}" data-lightbox="{{$client->name}}" data-title="{{'DNI: ' . $client->dni}}"  class="user-block2">
                                  <img src="{{asset('uploads/clients/'.$client->image_dni)}}" alt="{{$client->name}}">
                                </a>
                            
                              </div>

                              <div class="col-md-4 col-sm-6 col-xs-12">
                                <h5> <b>Archivo de Servicio:</b>  <br> </h5>

                                <a href="{{asset('uploads/clients/'.$client->image_service)}}" data-lightbox="{{$client->name}}" data-title="Servicio"  class="user-block2">
                                  <img src="{{asset('uploads/clients/'.$client->image_service)}}" alt="{{$client->name}}">
                                </a>
                              </div>

                              <div class="col-md-4 col-sm-6 col-xs-12">
                                <h5> <b>Recibo de pago:</b>  <br> </h5>

                                <a href="{{asset('uploads/clients/'.$client->receipt_payment)}}" data-lightbox="{{$client->name}}" data-title="Recibo de Pago"  class="user-block2">
                                  <img src="{{asset('uploads/clients/'.$client->receipt_payment)}}" alt="{{$client->name}}">
                                </a>
                              </div>

                            </div>
                            
                          </div>
                        </div>
                      </li>

                      <li>
                        <i class="fa fa-phone bg-blue"></i>
                        <div class="timeline-item">
                          <h3 class="timeline-header"><a href="#">Contactos </a> </h3>
                          <div class="timeline-body">
                            <div class="row">
                              <div class="col-md-4 col-sm-6 col-xs-12">
                                <h5> <b>Email:</b>  <br> {{$client->profile->email}}</h5>
                              </div>

                              <div class="col-md-4 col-sm-6 col-xs-12">
                                <h5> <b>Teléfonos:</b>
                                  @foreach($client->phone1 as $phone)
                                    <br><br>
                                    Teléfono: {{ $phone['phone'] }}<br>
                                    Descripción: {{ $phone['description'] }}
                                  @endforeach
                              </div>
                            
                          </div>
                        </div>
                      </li>
                     
                      <li>
                        <i class="fa fa-globe bg-blue"></i>
                        <div class="timeline-item">
                          <h3 class="timeline-header"><a href="#"> Dirección </a></h3>
                          <div class="timeline-body">

                            <div class="row">

                              <div class="col-md-4 col-sm-4 col-xs-12">
                                <h5> <b>Localidad: </b>  <br> {{$client->profile->location}} </h5>
                              </div>

                              <div class="col-md-4 col-sm-4 col-xs-12">
                                 <h5> <b>Código Postal:</b> <br> {{$client->profile->postal_code}}</h5> 
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-4 col-sm-4 col-xs-12">
                                <h5> <b>Barrio: </b>  <br> {{$client->profile->district}} </h5>
                              </div>

                              <div class="col-md-4 col-sm-4 col-xs-12">
                                <h5> <b>Entrecalle: </b>  <br> {{$client->profile->between_street}} </h5>
                              </div>

                              <div class="col-md-4 col-sm-4 col-xs-12">
                                 <h5> <b>Coordenadas:</b> <br> {{$client->profile->coordinates}}</h5> 
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <h5> <b>Dirección:</b> <br> {{$client->profile->address}}</h5>  
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <h5> <b>Dirección anterior:</b></h5>  
                                <p>
                                  @if(!empty($client->profile->add_info))
                                    {{ json_decode($client->profile->add_info, true)['prev_address'] }}
                                  @else
                                    N/A
                                  @endif
                                </p>
                              </div>
                            </div>
                            
                          </div>
                          
                        </div>
                      </li>
                    </ul>

                  </div>

                </div>

              <!-- /.post -->
            </div>


            <!-- /.tab-pane -->
            <div class="tab-pane" id="records">
                <div class="table-responsive">
                    <h4>Compras</h4>
                    <table id="client-sales-table" class="table table-hover" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Fecha</th>
                                <th>Monto</th>
                                <th>Producto</th>
                                <th>Estado</th>
                                <th><i class="fa fa-cogs fa-2x"></i></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- /.tab-pane -->
          </div>
          <!-- /.tab-content -->
        </div>
        <!-- /.nav-tabs-custom -->
    </div>
      
</div>

@stop

@section('js')
    @parent

    <script type="text/javascript">
        $(document).ready(function() {
            $('#client-sales-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('clients.sales.datatable', $client->id) !!}',
                columns: [
                    {data: 'id', name: 'id'},
                    { data: 'date', name: 'date' },
                    { data: 'total', name: 'total' },
                    { data: 'product', name: 'product' },
                    { data: 'is_payed', name: 'is_payed' },
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