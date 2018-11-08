@extends('adminlte::page')

@section('content')

<div class="row">

    <div class="col-md-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Información de Categoría</a></li>
            <!--<li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Productos</a></li>-->
            <!--<li class=""><a href="#settings" data-toggle="tab" aria-expanded="false"> Historial de Compras</a></li>-->
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="activity">

              <!-- Datos Personales -->
              <div class="post">
                <div class="user-block">
                  
                  <p> <b>Nombre: </b> {{$category->name}} </p>
                  

                </div>
                <!-- /.user-block -->
                
                <div class="btn-group">
                  <a href="{{route('categories.edit', $category->id)}}" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> Editar</a>

                  <a href="#" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> Eliminar </a>

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