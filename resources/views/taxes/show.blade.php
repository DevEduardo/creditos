@extends('adminlte::page')

@section('content')

<div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="btn btn-group pull-right">
                        
          {!! Form::model($tax, ['method' => 'delete', 'route' => ['taxes.destroy', $tax->id], 'class' =>'form-inline form-delete']) !!}
                              
            {!! Form::hidden('id', $tax->id) !!}
                              
              <a href="{{route('taxes.edit', $tax->id)}}" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> Editar</a>

              <button type="submit" name="delete_modal" class="btn btn-danger btn-sm delete " data-toggle="tooltip" data-placement="top" title="Eliminar" data-original-title="Eliminar"><i class="fa fa-trash"></i>Eliminar</button>
                            
            {!! Form::close() !!}
        </div>

        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Datos del Proveedor</a></li>
            
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

                              <div class="col-md-5 col-sm-5 col-xs-12">
                                <h5> <b>Nombre:</b>  <br> {{$tax->name}}</h5>
                              </div>

                              <div class="col-md-5 col-sm-5 col-xs-12">
                                <h5> <b>Valor %:</b>  <br> {{$tax->value}} </h5>
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