@extends('adminlte::page')

@section('content')

<div class="row">

    <div class="col-md-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Datos de Tipo de Cliente</a></li>
            <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Clientes</a></li>
            
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="activity">

              <!-- Datos Personales -->
              <div class="post">
                <div class="user-block">
                   <p>
                     <b>Código:</b>
                     {{$clientType->code}}
                   </p>

                   <p>
                     <b>Nombre:</b>
                     {{$clientType->name}}
                   </p>

                   <p>
                     <b>Máximo de Crédito:</b>
                     {{ number_format($clientType->credit, 2, ',', '.') }} $
                   </p>

                   <p>
                     <b>Máximo de Cuotas:</b>
                     {{$clientType->max_fees}} Cuotas
                   </p>
                </div>
                <!-- /.user-block -->

                <div class="row">
                    <div class="col-md-12">
                        <h4>Intereses de las cuotas</h4>
                    </div>
                </div>

                <div class="row">
                    @php
                        $i = 1;
                    @endphp
                    @foreach(json_decode($clientType->interest) as $interest)
                        <div class="col-md-2">
                            <p class="text-justify">
                                <b>Cuota N° {{ $i }}:</b> {{ $interest }} %
                            </p>
                        </div>
                        @php
                            $i ++;
                        @endphp
                    @endforeach
                </div>
                
                <div class="btn-group">
                  <a href="{{route('clientTypes.edit', $clientType->id)}}" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> Editar</a>

                  <a href="#" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> Eliminar </a>

                </div>
              </div>
              <!-- /.Datos Personales -->

          
              <!-- /.post -->
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="timeline">
                <div class="table-responsive">

                    <table class="table table-striped table-hover" id="data" class="display" cellspacing="0" width="100%">
                        
                        <thead>
                            <th>#</th>
                            <th>DNI</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th> <i class="fa fa-cogs fa-2x"></i> </th>
                        </thead>

                        <tbody>

                            @foreach ($clientType->clients as $key => $client)

                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$client->dni}}</td>
                                <td>{{$client->name}}</td>
                                <td>{{$client->profile->email}}</td>
                                <td>
                                    <div class="btn btn-group">
                                        <a href="{{route('clients.show', $client->id)}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Ver"> <i class="fa fa-eye"></i> </a>
                                
                                        <a href="{{route('clients.edit', $client->id)}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"> <i class="fa fa-edit"></i> </a>
                                    
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
            </div>
            <!-- /.tab-pane -->

            <div class="tab-pane" id="settings">
              
            </div>
            <!-- /.tab-pane -->
          </div>
          <!-- /.tab-content -->
        </div>
        <!-- /.nav-tabs-custom -->
    </div>
      
</div>

@stop