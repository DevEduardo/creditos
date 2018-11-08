@extends('adminlte::page')

@section('content')

<div class="row">

  <div class="col-md-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#timeline" data-toggle="tab" aria-expanded="false">Detalles del Producto</a></li>
            <li class=""><a href="#settings" data-toggle="tab" aria-expanded="false"> Imagenes </a></li>
          </ul>
         <div class="tab-content">
            <!-- /.tab-pane -->
            <div class="tab-pane active" id="timeline">
              <!-- The timeline -->

              <ul class="timeline timeline-inverse">
                <li>
                  <i class="fa fa-list bg-blue"></i>
                  <div class="timeline-item">
                    <h3 class="timeline-header"><a href="#"> Características </a></h3>
                    <div class="timeline-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p> <b> Nombre: </b> {{$product->name}}</p>
                                <p> <b> Código: </b> {{$product->code}}</p>
                                <p> <b> Stock Mínimo: </b> {{$product->stock_minimun}}</p>
                                <p> <b> Precio: </b> {{ number_format($product->price, 0, ',', '.') }}</p>
                                <p> <b>Última Actualización del precio:</b> {{ $product->date_update_price->format('d-m-Y') }} </p>
                                <p> <b>Descripción:</b>  {{ $product->description }}.  
                                </p>
                                <p> <b>Observaciones:</b>  {{$product->specification}}.  </p>
                                <p> <b>Disponibilidad:</b>  <i class="fa fa-check text-success"></i> </p>
                                <p> <b>Color Primario:</b>  {{ $product->color }} </p>
                                @if(!empty($product->color_secondary))
                                  <p> <b>Color Secundario:</b>  {{ $product->color_secondary }} </p>
                                @endif

                                @if(!empty($product->color_tertiary))
                                  <p> <b>Color Terciario:</b>  {{ $product->color_tertiary }} </p>
                                @endif  
                            </div>
                            <div class="col-md-6">
                                <p>
                                    <b>Alto:</b> {{ $product->height }} cm.
                                </p>
                                <p>
                                    <b>Ancho:</b> {{ $product->width }} cm.
                                </p>
                                <p>
                                    <b>Profundidad:</b> {{ $product->depth }} cm.
                                </p>
                                <p> <b> Categorías: </b>
                                    @foreach($product->category_products as $cat)
                                        {{ $cat->category->name }} <br>
                                    @endforeach
                                </p>
                                <p>
                                    <b>Marca: </b> {{ $product->brand }}
                                </p>
                                <p>
                                    <b>Modelo: </b> {{ $product->model }}
                                </p>
                                <p> <b> Compañia: </b> {{ $product->company->name }}</p>
                                <p> <b> Stock en Inventarios: </b> <br>
                                    @foreach($product->store_inventories as $inv)
                                        Nombre: {{ $inv->store->name }}<br>
                                        Cantidad: {{ $inv->qty }}<br>
                                    @endforeach
                                </p>
                                <p>
                                    <b>Disponible en la web: </b> {!! $product->string_web !!}
                                </p>
                            </div>
                        </div>
                    </div>
                  
                  </div>
                </li>
              </ul>
              
            </div>
            <!-- /.tab-pane -->

            <div class="tab-pane" id="settings">
              <div class="post">
                
                  @foreach ($images->chunk(6) as $chunk)
                      <div class="row">
                          @foreach ($chunk as $image)
                              <div class="col-md-2">
                                <a href="{{asset($image->path.'/'.$image->name)}}" data-lightbox="{{$product->name}}" data-title="{{$product->name}}" class="user-block2">
                                  <img width="120px" height="90px" src="{{asset($image->path.'/'.$image->name)}}" alt="{{$product->name}}"> 
                                </a>
                              </div>
                          @endforeach
                      </div>
                  @endforeach

                
              </div>
            </div>

            </div>
            <!-- /.tab-pane -->
          </div>
          <!-- /.tab-content -->
    </div>
        <!-- /.col -->
</div>
<!-- /.row -->

@stop