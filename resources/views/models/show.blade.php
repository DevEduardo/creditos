@extends('adminlte::page')

@section('content')

<div class="row">

    <div class="col-md-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Modelo</a></li>
            <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Productos</a></li>
            <!--<li class=""><a href="#settings" data-toggle="tab" aria-expanded="false"> Historial de Compras</a></li>-->
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="activity">

              <!-- Datos Personales -->
              <div class="post">
                <div class="user-block">
                  <h3> <b>Modelo:</b> {{$model->name}}</h3>
                  <h4> <b>Marca: </b>  
                    <a href="{{route('brands.show', $model->brand->id)}}"> {{$model->brand->name}} </a>
                  </h4>
                </div>
                <!-- /.user-block -->
                
                <div class="btn btn-group">
                  
                  {!! Form::model($model, ['method' => 'delete', 'route' => ['models.destroy', $model->id], 'class' =>'form-inline form-delete']) !!}
                            {!! Form::hidden('id', $model->id) !!}
                           
                    <a href="{{route('models.edit', $model->id)}}" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> Editar</a>

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