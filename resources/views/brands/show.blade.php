@extends('adminlte::page')

@section('content')

<div class="row">

    <div class="col-md-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Información de la Marca</a></li>
            <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Productos</a></li>
            <!--<li class=""><a href="#settings" data-toggle="tab" aria-expanded="false"> Historial de Compras</a></li>-->
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="activity">

                  @php
                    $image = $brand->image;

                    if ($image == null) {
                      $image = 'avatar.png';
                    }
                  @endphp

              <!-- Datos Personales -->
              <div class="row">
                <div class="col-md-2">
                  <a href="{{asset('uploads/brands/'.$image)}}" data-lightbox="{{$brand->name}}" data-title="{{$brand->name}}">
                    <img src="{{asset('uploads/brands/'.$image)}}" alt="{{$brand->slug}}"
                     width="120px" height="90px">
                  </a>
                </div>
                
                <div class="col-md-10">
                  <h5> <b> Marca: </b> {{$brand->name}}</h5>
                </div>
                  
                </div>
                <!-- /.user-block -->
                
                <div class="btn btn-group">
                  
                  {!! Form::model($brand, ['method' => 'delete', 'route' => ['brands.destroy', $brand->id], 'class' =>'form-inline form-delete']) !!}
                            {!! Form::hidden('id', $brand->id) !!}
                           
                    <a href="{{route('brands.edit', $brand->id)}}" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> Editar</a>

                    <button type="submit" name="delete_modal" class="btn btn-danger btn-sm delete " data-toggle="tooltip" data-placement="top" title="Eliminar" data-original-title="Eliminar"><i class="fa fa-trash"></i>Eliminar</button>
                
                  {!! Form::close() !!}

                </div>
              </div>
              <!-- /.Datos Personales -->

          
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