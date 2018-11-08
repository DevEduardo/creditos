@extends('adminlte::page')

@section('content')

<div class="row">

    <div class="col-md-12">
        <div class="nav-tabs-custom">

          <div class="pull-right">
                <a href="{{route('companies.edit', $company->id)}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"> <i class="fa fa-edit"></i> Editar </a>
          </div>

          <ul class="nav nav-tabs">
            <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Datos de la Empresa</a></li>
            {{-- <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Datos de Contacto</a></li>
            <li class=""><a href="#settings" data-toggle="tab" aria-expanded="false"> Historial de Compras</a></li> --}}
          </ul>
          <div class="tab-content">

            <div class="tab-pane active" id="activity">

              <ul class="timeline timeline-inverse">
                  <li>
                  <i class="fa fa-building bg-blue"></i>
                  <div class="timeline-item">
                    <h3 class="timeline-header"><a href="#">Información </a> </h3>
                    <div class="timeline-body">
                       <div class="row">

                          <div class="col-md-2 col-xs-6 col-sm-2">
                              <a href="{{asset('uploads/companies/'.$company->profile->image)}}" data-lightbox="{{$company->name}}" data-title="{{$company->name}}" class="user-block2">
                                <img src="{{asset('uploads/companies/'.$company->profile->image)}}" alt="{{$company->name}}" style="width: 125px; height: auto;">
                              </a>
                          </div>

                          <div class="col-md-10 col-xs-6 col-sm-10">
                              <h5> <b>Nombre: </b> <br> {{$company->name}}  <h5>   
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
                        <div class="col-md-4 col-xs-12 col-sm-12">
                           <h5>
                            <b>Email:</b> <br>
                              {{$company->profile->email}}
                            <h5>
                        </div>

                        <div class="col-md-4 col-xs-12 col-sm-12">
                          <h5>
                            <b>Teléfonos :</b> <br>
                            {{$company->profile->phone1}} 

                            <br>

                            {{$company->profile->phone2}}
                            
                          <h5>
                        </div>

                        <div class="col-md-4 col-xs-12 col-sm-12">
                          <h5> 
                            <b>Página Web: </b> <br>
                            <a href="{{$company->profile->webpage}}"> {{$company->profile->webpage}} </a>
                          <h5>
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
                        <div class="col-md-4 col-xs-12 col-sm-12">
                           <h5> <b>Ciudad:</b>  <br> {{ $company->profile->location }}<h5>
                        </div>
                        <div class="col-md-4 col-xs-12 col-sm-12">
                           <h5> <b>Barrio:</b>  <br> {{ $company->profile->district }}<h5>
                        </div>
                        <div class="col-md-4 col-xs-12 col-sm-12">
                           <h5> <b>Código Postal:</b> <br> {{ $company->profile->postal_code }}<h5>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-4 col-xs-12 col-sm-12">
                           <h5> <b>Entre Calles:</b>  <br> {{ $company->profile->between_street }}<h5>
                        </div>
                        <div class="col-md-4 col-xs-12 col-sm-12">
                           <h5> <b>Coordenas:</b>  <br> {{ $company->profile->coordinates }}<h5>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                          <h5> <b>Dirección:</b> <br>{{$company->profile->address}}  <h5>
                        </div>
                      </div>

                    </div>
                    
                  </div>
                </li>

                <li>
                  <i class="fa fa-bank bg-blue"></i>
                  <div class="timeline-item">
                    <h3 class="timeline-header"><a href="#"> Bancos </a></h3>
                    <div class="timeline-body">
                      @foreach($banks as $bank)
                      <div class="row">
                        <div class="col-md-3 col-xs-12 col-sm-12">
                           <h5> <b>Banco</b>  <br> {{ $bank->bank }}<h5>
                        </div>
                        <div class="col-md-3 col-xs-12 col-sm-12">
                           <h5> <b>CBU</b>  <br> {{ $bank->cbu }}<h5>
                        </div>
                        <div class="col-md-3 col-xs-12 col-sm-12">
                           <h5> <b>Numero de cuenta</b> <br> {{ $bank->number }}<h5>
                        </div>
                        <div class="col-md-3 col-xs-12 col-sm-12">
                           <h5> <b>Alias</b> <br> {{ $bank->alias }}<h5>
                        </div>
                      </div>
                      @endforeach
                    </div>
                    
                  </div>
                </li>
              </ul>    

             
              
            </div>
            <!-- /.Datos Personales -->

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