@extends('adminlte::page')

@section('content')

<div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="btn btn-group pull-right">
                        
          {!! Form::model($enterprise, ['method' => 'delete', 'route' => ['enterprises.destroy', $enterprise->id], 'class' =>'form-inline form-delete']) !!}
                              
            {!! Form::hidden('id', $enterprise->id) !!}
                              
              <a href="{{route('enterprises.edit', $enterprise->id)}}" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> Editar</a>

              <button type="submit" name="delete_modal" class="btn btn-danger btn-sm delete " data-toggle="tooltip" data-placement="top" title="Eliminar" data-original-title="Eliminar"><i class="fa fa-trash"></i>Eliminar</button>
                            
            {!! Form::close() !!}
        </div>

        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Datos de la Empresa</a></li>
            
            {{--<li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Datos de Contacto</a></li>
            <li class=""><a href="#settings" data-toggle="tab" aria-expanded="false"> Historial de Compras</a></li>--}}

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

                              <div class="col-md-4 col-sm-6 col-xs-12">
                                <h5> <b>Nombre:</b>  <br> {{$enterprise->name}}</h5>
                              </div>

                              <div class="col-md-4 col-sm-6 col-xs-12">
                                <h5> <b>CUIT:</b>  <br> {{$enterprise->cuit}} </h5>
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
                                <h5> <b>Email:</b>  <br> {{$enterprise->profile->email}}</h5>
                              </div>

                              <div class="col-md-4 col-sm-6 col-xs-12">
                                <h5> <b>Teléfonos:</b>  <br> {{$enterprise->profile->phone1}} <br> {{$enterprise->profile->phone2}}</h5>
                              </div>

                              <div class="col-md-4 col-sm-12 col-xs-12">
                                <h5> <b>Página Web:</b>  <br> <a href="{{$enterprise->profile->webpage}}" title="{{$enterprise->profile->webpage}}" target="_blank">{{str_limit($enterprise->profile->webpage, 30, '...')}}</a> </h5>
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
                                  <h5> <b>Provincia:</b> <br> {{$enterprise->profile->state->name}} </h5>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-12">
                                  <h5> <b>Ciudad:</b> <br> {{$enterprise->profile->city->name}} </h5> 
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-12">
                                   <h5> <b>Código Postal:</b> <br> {{$enterprise->profile->postal_code}}</h5> 
                                </div>
                            </div>

                            <div class="row">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <h5> <b>Dirección:</b> <br> {{$enterprise->profile->address}}</h5>  
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
            <div class="tab-pane" id="timeline">
              <!-- The timeline -->
              
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