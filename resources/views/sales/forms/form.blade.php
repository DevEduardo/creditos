<td style="width: 500px;" style="vertical-align: text-top;">
    <div id="pos">
        {!! Form::open(['route' => ['sales.finished', $sale_id], 'method' => 'POST', 'id' => "SendFormSale"]) !!}
        
            @if($type_sale == 'simple' || $type_sale == 'online' || $type_sale == 'others' || $type_sale == 'scooter')
                {!! Form::hidden('type_sale', $type_sale) !!}
            @endif

            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <div class="well well-sm" id="leftdiv">
                <div id="lefttop" style="margin-bottom:5px;">

                    <div class="form-group sale_number" style="margin-bottom:5px;">
                        <div class="input-group">
                            <div class="input-group-addon no-print" style="padding: 2px 5px;">
                                <a href="#" class="external" >
                                    <i class="fa fa-2x fa-barcode"></i>
                                </a>
                            </div>
                            <input type="text" name="sale_number" class="form-control" readonly="true">
                        </div>
                    </div>

                    <div class="form-group client" style="margin-bottom:5px;">

                        <div class="input-group client">

                            <input type="text" name="client" class="form-control" readonly="true" data-toggle="tooltip" data-placement="bottom" title='Escriba el nombre o DNI, use las teclas de "Arriba y Abajo" para recorrer el listado y presione "Enter" para seleccionar un cliente'>

                            <div class="input-group-addon no-print" style="padding: 2px 5px;">
                                <a href="#" class="external" >
                                    <i class="fa fa-2x fa-plus-circle" id="addIcon"></i>
                                </a>
                            </div>
                        </div>


                    </div>

                    <div class="form-group" style="margin-bottom:5px;">
                        <div class="input-group product">
                            <input type="text" name="product" class="form-control" placeholder="Buscar producto por código o nombre" data-toggle="tooltip" data-placement="bottom" title='Escriba el nombre o código del producto, Presione las tecla de "Arriba o Abajo" para desplazarse, "Enter" para seleccionar un producto'/>
                            <div class="input-group-addon no-print addItem" style="padding: 2px 5px;" data-toggle="tooltip" data-placement="bottom" title='Haz click aquí para agregar un producto'>
                                <a href="#" class="external" onclick="return false; ">
                                    <i class="fa fa-2x fa-cart-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!--No se esta usando los impuestos ya son calculados previamente en el precio de venta que trae el producto-->
                    <div class="row" style="display: none;">
                      <div class="form-group col-sm-12 col-md-12 col-lg-12" style="margin-bottom:5px;">
                          {{ Form::select('taxes[]', $taxes, old('tax_id'), ['class' => 'form-control select2-taxes', 'style' => 'width: 100%', 'multiple' => 'multiple']) }}
                      </div>
                    </div>
                    <!--END-->

                    <div class="row">

                        <div class="form-group col-sm-12 col-md-4 col-lg-4" style="margin-bottom:5px;">
                            <input type="number" name="price" value="" id="hold_ref" step="0.01" class="form-control kb-text" placeholder="Precio" readonly/>
                        </div>
                        <div class="form-group  col-sm-12 col-md-4 col-lg-4" style="margin-bottom:5px;">
                            <input type="number" name="qty" value="" id="hold_ref" step="1" class="form-control kb-text" placeholder="Cantidad" data-toggle="tooltip" data-placement="bottom" title='Ingrese la cantidad de productos y presione "Enter"'>
                        </div>
                        <div class="form-group  col-sm-12 col-md-4 col-lg-4" style="margin-bottom:5px;">
                            <input type="number" name="discount" value="" id="discount" step="0.01" max="100" class="form-control kb-text" placeholder="Descuento (%)" data-toggle="tooltip" data-placement="bottom" title='Ingrese el descuento y presione "Enter" para agregar el producto al carrito'/>
                        </div>

                    </div>

                </div>
                <div id="print" class="fixed-table-container">
                    <div id="list-table-div">
                        <div class="fixed-table-header">
                            <table class="table table-striped table-condensed table-hover list-table" style="margin:0;" id="products-table">
                                <thead>
                                    <tr class="success">
                                        <th style="text-align:left;">Producto</th>
                                        <th style="text-align:left;">Precio</th>
                                        <th style="text-align:center;">Cantidad</th>
                                        <th style="text-align:left;">Descuento</th>
                                        <th style="text-align:left;">Subtotal</th>
                                        <th style="width: 20px;" class="satu"><i class="fa fa-trash-o"></i></th>
                                    </tr>
                                </thead>
                                <tbody id="prodcut-list"></tbody>
                            </table>
                        </div>
                        <table id="posTable" class="table table-striped table-condensed table-hover list-table" style="margin:0px;" data-height="100">
                            <thead>
                              <tr class="success">
                                  <th>Producto</th>
                                  <th style="text-align:left;">Producto</th>
                                  <th style="text-align:left;">Precio</th>
                                  <th style="text-align:center;">Cantidad</th>
                                  <th style="text-align:left;">Descuento</th>
                                  <th style="text-align:left;">Subtotal</th>
                                  <th style="width: 20px;" class="satu"><i class="fa fa-trash-o"></i></th>
                              </tr>
                            </thead>

                            <tbody></tbody>

                        </table>
                    </div>
                    <div style="clear:both;"></div>
                    <div id="totaldiv">
                        <table id="totaltbl" class="table table-condensed totals" style="margin-bottom:10px;">
                            <tbody>
                                <tr class="info">
                                    <td width="50%">Total Items</td>
                                    <td class="text-right"><span class="count">0</span></td>
                                </tr>

                                <tr class="info">
                                    <td width="50%">Subtotal</td>
                                    <td class="text-right" colspan="2"><span class="total">0</span></td>
                                </tr>
                                
                                <tr class="info">
                                    <td width="50%" class="add_discount">Descuento</td>
                                    <td class="text-right"><span class="ds_con">0</span></td>
                                </tr>

                                <tr class="info" style="display: none;">
                                    <td width="50%" class="add_tax">Impuestos</td>
                                    <td class="text-right"><span class="ts_con">0</span></td>
                                </tr>
                                
                                <tr class="success">
                                    <td style="font-weight:bold;">
                                        Total a pagar:
                                    </td>
                                    <td class="text-right" style="font-weight:bold;"><span class="total-payable">0</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($type_sale == 'simple')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group" field="way_to_pay">
                                {!! Form::label('way_to_pay', 'Seleccione forma de pago de la venta:') !!}
                                {!! Form::select('way_to_pay', [
                                    'cash' => 'Efectivo', 
                                    'card' => 'Tarjeta'
                                    ], null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opción', 'required']) !!}
                            </div>
                        </div>
                    </div>
                @endif
                <div id="botbuttons" class="col-xs-12 text-center">
                    <div class="row">
                        <div class="col-xs-6" style="padding: 0;">
                            <div class="btn-group-vertical btn-block">
                                <!-- <button type="button" class="btn btn-warning btn-block btn-flat" id="suspend">Hold</button> -->
                                <button
                                    type="button"
                                    class="btn btn-danger btn-block btn-flat delete-sale"
                                    id="reset" style="height: 67px;"
                                    data-href="{{ route('sales.destroy', [$sale_id]) }}"
                                >
                                  Cancel
                                </button>
                            </div>
                        </div>
                        {{-- <div class="col-xs-4" style="padding: 0 5px;">
                            <div class="btn-group-vertical btn-block">
                                <button type="button" class="btn bg-purple btn-block btn-flat" id="">Imprimir Orden</button>
                                <button type="button" class="btn bg-navy btn-block btn-flat" id="">Imprimir Factura</button>
                            </div>
                        </div> --}}
                        <div class="col-xs-6" style="padding: 0;">
                            @php
                                $tb = 'submit';

                                if ($type_sale != 'simple' && $type_sale != 'online' && $type_sale != 'others') {
                                    $tb = 'button';
                                }
                            @endphp
            
                            <button id="modal-button"
                                type="{{ $tb }}"
                                class="btn btn-success btn-block btn-flat finished-sale"
                                style="height:67px;"
                                disabled 
                            >
                                Procesar
                            </button>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <span id="hidesuspend"></span>
                {{--  <input type="hidden" name="spos_note" value="" id="spos_note"> --}}
                <div id="payment-con">
                    {{-- <input type="hidden" name="amount" id="amount_val" value="" />
                    <input type="hidden" name="balance_amount" id="balance_val" value="" />
                    <input type="hidden" name="paid_by" id="paid_by_val" value="cash" />
                    <input type="hidden" name="cc_no" id="cc_no_val" value="" />
                    <input type="hidden" name="paying_gift_card_no" id="paying_gift_card_no_val" value="" />
                    <input type="hidden" name="cc_holder" id="cc_holder_val" value="" />
                    <input type="hidden" name="cheque_no" id="cheque_no_val" value="" />
                    <input type="hidden" name="cc_month" id="cc_month_val" value="" />
                    <input type="hidden" name="cc_year" id="cc_year_val" value="" />
                    <input type="hidden" name="cc_type" id="cc_type_val" value="" />
                    <input type="hidden" name="cc_cvv2" id="cc_cvv2_val" value="" />
                    <input type="hidden" name="balance" id="balance_val" value="" />
                    <input type="hidden" name="payment_note" id="payment_note_val" value="" /> --}}
                </div>
                {{-- <input type="hidden" name="customer" id="customer" value="1" />
                <input type="hidden" name="order_tax" id="tax_val" value="" />
                <input type="hidden" name="order_discount" id="discount_val" value="" />
                <input type="hidden" name="count" id="total_item" value="" />
                <input type="hidden" name="did" id="is_delete" value="0" />
                <input type="hidden" name="eid" id="is_delete" value="0" />
                <input type="hidden" name="total_items" id="total_items" value="0" />
                <input type="hidden" name="total_quantity" id="total_quantity" value="0" />
                <input type="submit" id="submit" value="Submit Sale" style="display: none;" /> --}}
            </div>
            @if($type_sale != 'simple' && $type_sale != 'online' && $type_sale != 'others')
                @include('sales.credit_modal')
            @endif
        {!! Form::close() !!}
    </div>
</td>

{{--  
<div class="modal fade" tabindex="-1" role="dialog" id="register">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Aceptar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
--}}