@extends('adminlte::page')

@section('content')
	    
	<div class="table-responsive">

	    <table class="table table-striped table-hover" id="data2" class="display" cellspacing="0" width="100%">
	    	
			<thead>
				<th>
					#
				</th>
				<th>
					Fecha
				</th>
				<th>
					Observación
				</th>
				<th>
					Código de producto
				</th>
				<th>
					Estatdo
				</th>
				<th> <i class="fa fa-cogs fa-2x"></i> </th>
			</thead>

			<tbody>
				
				@foreach ($deliveries as $key => $delivery)
					<tr>
						<td>
							{{ $delivery->id }}
						</td>	
						<td>
							{{ $delivery->created_at->diffForHumans() }}
						</td>
						<td>
							@php
                              $num = 0;
                            @endphp
							@foreach ($getProduct as $key => $value2) 
								
				                @if ($delivery->sale_id == $value2->sale_id ) 
										
				                    @foreach ($products as $key => $value3)
				                    	
				                        @if ($value2->product_id == $value3->id) 
				                        	@php
			                                  $num += 1;
			                                @endphp 
				                            @if($num%2 == 0)
												/ {{$value3->name}} 
											@elseif($num > 1 && $num%2 != 0)
												/{{$value3->name}} 
											@elseif($num%2 != 0)
												{{$value3->name}}
											@endif
				                        @endif
				                    @endforeach
				                @endif
				            @endforeach
						</td>
						<td>
							@php
                              $num = 0;
                            @endphp
							@foreach ($getProduct as $key => $value2) 
								
				                @if ($delivery->sale_id == $value2->sale_id ) 
										
				                    @foreach ($products as $key => $value3)
				                    	
				                        @if ($value2->product_id == $value3->id) 
				                        	@php
			                                  $num += 1;
			                                @endphp 
				                            @if($num%2 == 0)
												/ {{$value3->code}} 
											@elseif($num > 1 && $num%2 != 0)
												/{{$value3->code}} 
											@elseif($num%2 != 0)
												{{$value3->code}}
											@endif
				                        @endif
				                    @endforeach
				                @endif
				            @endforeach
						</td>
						<td>
							@if($delivery->completed)
								<span class="label label-success">Despachado</span>
							@else
								<span class="label label-warning">Pendiente</span>
							@endif
						</td>
						<td>
							@if($delivery->completed)
								<a href="#" class="btn btn-primary btn-sm" disabled data-toggle="tooltip" data-placement="top" title="Despachado"> 
									<i class="fa fa-paper-plane"></i> 
								</a>
								<a href="{{route('order.dispatch', $delivery->id)}}" target="blanck" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Orden de despacho"> 
									<i class="fa fa-file-pdf-o"></i> 
								</a>
							@else
								<a href="{{route('deliveries.dispatches', $delivery->id)}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Despachar"> 
									<i class="fa fa-paper-plane-o"></i> 
								</a>
							@endif
						</td>
					</tr>
				@endforeach

			</tbody>
	    </table>
	</div>
@stop
@section('js')
	@parent
	<script src="{{ asset('enlinea/dataTables.responsive.min.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#data2').DataTable({
				"order": [[ 0, "desc" ]]
			});
		});
	</script>
@endsection
