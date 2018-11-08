@extends('adminlte::page')

@section('content')

<div class="row">

    <div class="col-md-12">
   
         <div class="btn-group pull-right">
                        
            <!-- {!! Form::model($user, ['method' => 'delete', 'route' => ['users.destroy', $user->id], 'class' =>'form-inline form-delete']) !!}
                              
            {!! Form::hidden('id', $user->id) !!} -->
                              
            <a href="{{route('users.edit', $user->id)}}" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> Editar</a>

            <!-- <button type="submit" name="delete_modal" class="btn btn-danger btn-sm delete " data-toggle="tooltip" data-placement="top" title="Eliminar" data-original-title="Eliminar"><i class="fa fa-trash"></i>Eliminar</button>
                            
            {!! Form::close() !!} -->
        </div>


        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Datos Personales</a></li>
            {{--<li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Datos de Contacto</a></li>
            <li class=""><a href="#settings" data-toggle="tab" aria-expanded="false"> Permisos de Usuario</a></li>--}}
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="activity">
               <ul class="timeline timeline-inverse">
                
                  <li>
                    <i class="fa fa-user bg-blue"></i>
                    <div class="timeline-item">
                      <h3 class="timeline-header"><a href="#">Datos de Acceso </a> </h3>
                      <div class="timeline-body">
                        
                        <div class="row">
                          <div class="col-md-4 col-sm-12 col-xs-12">
                            <div align="center">
                              <a href="{{asset('uploads/users/'.$user->profile->image)}}" data-lightbox="{{$user->name}}" data-title="{{$user->name}}" class="user-block2">
                                <img src="{{asset('uploads/users/'.$user->profile->image)}}" alt="{{$user->name}}">
                              </a>
                            </div>
                          </div>

                          <div class="col-md-4 col-sm-12 col-xs-12">
                             <h5> <b> Nombre: </b> <br>
                              {{$user->name}}
                            </h5>
                          </div>


                          <div class="col-md-4 col-sm-12 col-xs-12">
                            <h5> <b> Rol de Usuario: </b> <br>
                              {{'Master'}}
                            </h5>
                          </div>

                        </div>

                      </div>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-phone bg-blue"></i>
                    <div class="timeline-item">
                      <h3 class="timeline-header"><a href="#">Contactos </a> </h3>
                      <div class="timeline-body">
                        <div class="row">
                          <div class="col-md-4 col-sm-12 col-xs-12">
                            <h5> <b> Email: </b> <br>
                                {{$user->email}}
                            </h5>
                            
                          </div>


                          <div class="col-md-4 col-sm-12 col-xs-12">
                             <h5> <b> Teléfonos: </b> <br>
                                {{$user->profile->phone1}} <br>
                                {{$user->profile->phone2}}
                            </h5>
                          </div>


                          <div class="col-md-4 col-sm-12 col-xs-12">
                            <h5> <b> Página Web: </b> <br>
                                <a href="{{$user->profile->webpage}}"> {{$user->profile->webpage}} </a>  
                            </h5>
                          </div>
                        </div>
                
                      </div>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-globe bg-blue"></i>
                    <div class="timeline-item">
                      <h3 class="timeline-header"><a href="#"> Dirección </a></h3>
                      <div class="timeline-body">

                      <div class="row">
                          <div class="col-md-4 col-xs-12 col-sm-12">
                            <h5> <b>Ciudad:</b>  <br> {{$user->profile->location }} <h5>
                          </div>

                          <div class="col-md-4 col-xs-12 col-sm-12">
                             <h5> <b>Código Postal:</b> <br> {{$user->profile->postal_code }}<h5>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-12 col-xs-12 col-sm-12">
                            <h5> <b>Dirección:</b> <br>{{ $user->profile->address }}  <h5>
                          </div>
                        </div>
                      </div>
                      
                    </div>
                  </li>
                </ul>
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
      
</div>

@stop