@extends('adminlte::page')

@section('content')

<div class="row">

    <div class="col-md-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Datos del Almacén</a></li>
            <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Productos</a></li>
            <!--<li class=""><a href="#settings" data-toggle="tab" aria-expanded="false"> Historial de Compras</a></li>-->
          </ul>
        </div>
          <div class="tab-content">
            <div class="tab-pane active" id="activity">

              <!-- Datos Personales -->

              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <h5><b> Nombre: </b> {{$store->name}} </h5>
                </div>
              </div>

              <div class="row">
                    <div class="btn btn-group">
                      <a href="{{route('stores.edit', $store->id)}}" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> Editar</a>

                      {!! Form::model($store, ['method' => 'delete', 'route' => ['stores.destroy', $store->id], 'class' =>'form-inline form-delete']) !!}
                        {!! Form::hidden('id', $store->id) !!}
                        <button type="submit" name="delete_modal" class="btn btn-danger btn-sm delete " data-toggle="tooltip" data-placement="top" title="Eliminar" data-original-title="Eliminar"><i class="fa fa-trash"></i> Eliminar </button>
                      {!! Form::close() !!}
                    </div>
              </div>

              </div>

              <div class="tab-pane" id="timeline">
                <!-- The timeline -->
                @include('stores.products')
              </div>
            </div>
              <!-- /.Datos Personales -->


              <!-- /.post -->
            </div>
            <!-- /.tab-pane -->

            <!-- /.tab-pane -->
{{--
            <div class="tab-pane" id="settings">

            </div> --}}
            <!-- /.tab-pane -->
          </div>
          <!-- /.tab-content -->
        </div>
        <!-- /.nav-tabs-custom -->
    </div>

</div>

@stop
