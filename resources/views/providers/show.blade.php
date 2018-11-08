@extends('adminlte::page')

@section('content')

<div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="btn btn-group pull-right">
                        
          {!! Form::model($provider, ['method' => 'delete', 'route' => ['providers.destroy', $provider->id], 'class' =>'form-inline form-delete']) !!}
                              
            {!! Form::hidden('id', $provider->id) !!}
                              
              <a href="{{route('providers.edit', $provider->id)}}" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> Editar</a>

              <button type="submit" name="delete_modal" class="btn btn-danger btn-sm delete " data-toggle="tooltip" data-placement="top" title="Eliminar" data-original-title="Eliminar"><i class="fa fa-trash"></i>Eliminar</button>
                            
            {!! Form::close() !!}
        </div>

        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Datos del Proveedor</a></li>
            
            {{--<li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Datos de Contacto</a></li>--}}
            <li class=""><a href="#records" data-toggle="tab" aria-expanded="false"> Historial </a></li>

          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="activity">

              <!-- Datos Personales -->
                
                <div class="row">

                  <div class="col-md-12">

                  <ul class="timeline timeline-inverse">
                     
                      <li>
                        <i class="fa fa-list bg-blue"></i>
                        <div class="timeline-item">
                          <h3 class="timeline-header"><a href="#">Descripción </a> </h3>
                          <div class="timeline-body">
                            <div class="row">
                              <div class="col-md-2 col-sm-2 col-xs-12">
                                 <a href="{{asset('uploads/providers/'.$provider->profile->image)}}" data-lightbox="{{$provider->name}}" data-title="{{$provider->name}}"  class="user-block2">
                                  <img src="{{asset('uploads/providers/'.$provider->profile->image)}}" alt="{{$provider->name}}">
                                </a>
                              </div>

                              <div class="col-md-5 col-sm-5 col-xs-12">
                                <h5> <b>Nombre:</b>  <br> {{$provider->name}}</h5>
                              </div>

                              <div class="col-md-5 col-sm-5 col-xs-12">
                                <h5> <b>CUIT:</b>  <br> {{$provider->cuit}} </h5>
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
                                <h5> <b>Email:</b>  <br> {{$provider->profile->email}}</h5>
                              </div>

                              <div class="col-md-4 col-sm-6 col-xs-12">
                                <h5> <b>Teléfonos:</b>  <br> {{$provider->profile->phone1}} <br> {{$provider->profile->phone2}}</h5>
                              </div>

                              <div class="col-md-4 col-sm-12 col-xs-12">
                                <h5> <b>Página Web:</b>  <br> <a href="{{$provider->profile->webpage}}" title="{{$provider->profile->webpage}}" target="_blank">{{str_limit($provider->profile->webpage, 30, '...')}}</a> </h5>
                              </div>
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
                                <h5> <b>localidad:</b> <br> {{ $provider->profile->location }} </h5> 
                              </div>

                              <div class="col-md-4 col-sm-4 col-xs-12">
                                 <h5> <b>Código Postal:</b> <br> {{$provider->profile->postal_code}}</h5> 
                              </div>

                              <div class="col-md-4 col-sm-4 col-xs-12">
                                 <h5> <b>Barrio:</b> <br> {{ $provider->profile->district }}</h5> 
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-4 col-sm-4 col-xs-12">
                                <h5> <b>Entre Calles:</b> <br> {{ $provider->profile->between_street }} </h5> 
                              </div>

                              <div class="col-md-4 col-sm-4 col-xs-12">
                                 <h5> <b>Coordenadas:</b> <br> {{ $provider->profile->coordinates }}</h5> 
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <h5> <b>Dirección:</b> <br> {{$provider->profile->address}}</h5>  
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
                    <h4>Facturas</h4>
                    <table id="provider-invoices-table" class="table table-hover" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Fecha</th>
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
            $('#provider-invoices-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('providers.invoices.datatable', $provider->id) !!}',
                columns: [
                    { data: 'code', name: 'code' },
                    { data: 'date', name: 'date' }
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