<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    @if($type_sale == 'high')
                        Creando Alta de Credito
                        @isset($sale) 
                            para el cliente: {{ json_decode($sale, true)['client']['name']  }}
                        @endisset
                    @elseif($type_sale == 'renovation')
                        Creando Renovación
                        @isset($sale) 
                            para el cliente: {{ json_decode($sale, true)['client']['name']  }}
                        @endisset
                    @elseif($type_sale == 'sing')
                        Creando Venta por seña
                    @elseif($type_sale == 'simple')
                        Creando Venta directa
                    @else
                        Creando Credito para motos
                    @endif
                </h4>
            </div>
            <div class="modal-body">
                {!! Form::hidden('type_sale', $type_sale) !!}
                <div class="form-group">
                    {!! Form::label('way_sale', 'Seleccione forma de venta:') !!}
                    {!! Form::select('way_sale', $type_credit, null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opción', 'required'=>false, 'not-disabled']) !!}
                </div>
                
                <!--Form-->
                <div id="sale-credit-form">
                    
                    <div class="form-group" field="anticipo-i" data-valid="sing|credit|two_advance">
                        
                        {{ Form::label('advance_I', 'Anticipo') }}
                    
                        {{ Form::text('advance_I', null, ['class' => 'form-control', 'placeholder' => 'Mínimo de Anticipo', 'required'=>false, 'autocomplete'=>'off']) }}
                    </div>

                    <div class="form-group" field="way_to_pay" data-valid="sing|credit|two_advance|without_advance">
                        {!! Form::label('way_to_pay', 'Seleccione forma de pago del anticipo:') !!}
                        {!! Form::select('way_to_pay', [
                            'cash' => 'Efectivo', 
                            'card' => 'Tarjeta'
                            ], null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opción', 'required'=>false]) !!}
                    </div>

                    <div class="form-group" field="anticipo-ii" data-valid="sing|two_advance">
                        
                        <div class="alert alert-warning">
                            El segundo anticipo se solicita despues de procesado el registro
                        </div>

                    </div>

                    <div class="form-group" field="first_fee" data-valid="without_advance">
                        {!! Form::label('first_fee', 'Seleccione la fecha de la primera cuota, en dias:') !!}
                        {!! Form::select('first_fee', [
                            '0' => 'Primera cuota hoy', 
                            '1' => '30 dias', 
                            '2' => '60 dias', 
                            '3' => '90 dias (Con autorización)'
                            ], null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opción', 'required'=>false, 'first_fee']) !!}
                    </div>

                    <div class="form-group" field="fees" data-valid="credit|two_advance|without_advance">
                        {{ Form::label('Cuotas') }}
                        @php 
                        $cuotas = [];
                        for($i = 1; $i <= 12; $i++){
                            $cuotas[$i] = sprintf('En %s cuotas', $i);
                        }
                        $cuotas['add'] = 'Autorizar otro n&uacute;mero de cuotas';

                        @endphp
                        {{ Form::select('fees', $cuotas , null, ['class' => 'form-control' ,'placeholder' => 'Seleccionar numero de cuotas', 'fees_select', 'required'=>false ]) }}

                        {{-- <span class="help-block">(*) {{$errors->first('fees')}}</span>
                        
                        <span class="help-block fees" style="display: none">(*) La cantidad máxima de cuotas es de: 12</span> --}}
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" field="surcharge" data-valid="credit|two_advance|without_advance">
                                {{ Form::label('% de recargo') }}
                               
                                {{ Form::text('surcharge', null, ['class' => 'form-control','placeholder' => ' % de recargo', 'required'=>false, 'disabled', 'readonly' ]) }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" field="amount_financial" data-valid="credit|two_advance|without_advance">
                                {{ Form::label('Monto a financiar con recargo') }}
                               
                                {{ Form::text('amount_financial', null, ['class' => 'form-control', 'required'=>false, 'disabled', 'readonly' ]) }}
                            </div>
                        </div>

                        {{--
                            <div class="col-md-6">
                                <div class="form-group" field="interest" data-valid="credit|two_advance|without_advance">
                                    {{ Form::label('% Interes mensual de la cuota') }}
                                                            
                                    {{ Form::text('interest', null, ['class' => 'form-control', 'required'=>false, 'disabled', 'readonly']) }}                       
                                </div>  
                            </div>
                        --}}
                    </div>

                    <div class="row">
                        
                        {{--  
                        <div class="col-md-6">
                            <div class="form-group" field="amount_cuotes" data-valid="credit|two_advance|without_advance">
                                {{ Form::label('Monto de la cuota') }}
                                                        
                                {{ Form::text('amount_cuotes', null, ['class' => 'form-control', 'required'=>false, 'disabled', 'readonly']) }}                       
                            </div>  
                        </div>
                        --}}
                    </div>

                    <div class="form-group" field="observation" data-valid="sing|credit|two_advance|without_advance">
                        {!! Form::label('observation', 'Observaciones:') !!}
                        {!! Form::textarea('observation', null, ['class' => 'form-control', 'placeholder' => 'Observaciones']) !!}
                    </div>
                
                </div>
                <!--End Form-->

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Cerrar</button>
                <button id="finished-sale" type="submit" class="btn btn-success btn-flat">Continuar</button>
            </div>
        </div>
    </div>
</div>

@section('js')
    @parent

    <script type="text/javascript">

        $('#modal-button').on('click', function (){

            $.fn.hiddenFields();
            $('select#way_sale').val('');
            $('#myModal').find('[remove-msg-error]').remove();
            $('#myModal').modal('show');

        });

        $.fn.hiddenFields = function(){
            
            $('form#SendFormSale').find('[remove-pwd-input="zxc"]').remove();

            $('#sale-credit-form').find('input, select, textarea').not('[not-disabled]').prop('disabled',true);
            $('#sale-credit-form').find('input, select, textarea').val('');
            $('#sale-credit-form').find('div[field]').hide();
            $('#sale-credit-form').find('input[name="surcharge"]').val(sale.client.client_type.surcharge);
            $('#sale-credit-form').find('input[name="interest"]').val(sale.client.client_type.interest);

            var recargo = Math.ceil((sale.subtotal * (1+(sale.client.client_type.surcharge/100))))
            $('#sale-credit-form').find('input[name="amount_financial"]').val($.fn.money(recargo));

        }

        $('select[name="way_sale"]').on('change', function (){
            
            var type = $(this).val();

            if(type){

                $.fn.hiddenFields();

                $('#sale-credit-form').find('div[field]').each(function(k,v){

                    if($(this).data('valid').indexOf(type) !== -1){
                        $(this).find('input, select, textarea').prop('disabled', false);
                        $(this).show();
                    }

                });

            }else{

                $.fn.hiddenFields();

            }

        });

        //Autorización del numero de cuotas
        $('select[fees_select]').on('change', function(){

            var select = $(this);

            if($(this).val() == 'add'){

                $('#myModal').css('display', 'none');

                swal({
                  title: '<b>Autorizar</b>',
                  type: 'warning',
                  html:
                    `<div id="authorization-store">
                        <p>Debe pedir a un usuario con privilegios que autorice esta acci&oacute;n</p>
                        @php 
                        $cuotas = [];
                        for($i = 13; $i <= 64; $i++){
                            $cuotas[$i] = $i;
                        }
                        @endphp
                        {{ Form::select('value', $cuotas , null, ['class' => 'form-control' ,'placeholder' => 'Seleccionar n&uacute;mero de cuotas para autorizar' ]) }}

                        <br>
                        <label>Clave de autorizaci&oacute;n</label>
                        <input type="hidden" name="type" value="fees">
                        <input type="password" name="clave" class="form-control" placeholder="Ingrese clave de autorizaci&oacute;n"/><br>
                    </div>`,
                  showCloseButton: true,
                  showCancelButton: true,
                  focusConfirm: false,
                  confirmButtonText:
                    'Autorizar',
                  //confirmButtonAriaLabel: 'Thumbs up, great!',
                  cancelButtonText:
                  'Cancelar',
                  //cancelButtonAriaLabel: 'Thumbs down',
                }).then(
                    (confirm) => {
                        
                        if(confirm){
                            var data = {
                                value: $('#authorization-store').find('select[name="value"]').val(),
                                clave: $('#authorization-store').find('input[name="clave"]').val(),
                                type: $('#authorization-store').find('input[name="type"]').val()
                            };

                            $.ajax({
                                type: 'post',
                                url: '{{ route("authorizations.store") }}',
                                data: data,
                                dataType: "json",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            }).done(function(response){
                        
                                select.find('option[authorization]').remove();

                                select.append('<option value="'+response.token+'" data-cuotas="'+response.cuotas+'" authorization selected>Cuotas autorizadas: '+response.cuotas+' (Es valido s&oacute;lo para esta operaci&oacute;n)</option>')

                                select.parent().append('<div class="alert alert-success" style="margin-top:10px;" error-cuota>'+response.message+'</div>');

                                setTimeout(function(){
                                    $('[error-cuota]').remove();
                                }, 5000);

                                $.fn.calculeCuotas();

                                 

                            }).fail(function(a,b,c){
                                
                                select.parent().append('<div class="alert alert-error" style="margin-top:10px;" error-cuota>'+a.responseJSON.message+'</div>');
                                
                                select.val('');

                                setTimeout(function(){
                                    $('[error-cuota]').remove();
                                }, 5000);

                            });

                        }
                        
                        $('#myModal').css('display', 'block');
                    }, 
                    () => {
                        $('#myModal').css('display', 'block');
                        select.val('');
                    }
                );

            }else{
                $.fn.calculeCuotas();
            }

        });
        
        $('input#advance_I').on('blur',function(){
           var recargo = Math.ceil(((sale.subtotal - $(this).val()) * (1+(sale.client.client_type.surcharge/100))));
           $('#sale-credit-form').find('input[name="amount_financial"]').val($.fn.money(recargo));
            
        });

        $.fn.calculeCuotas = function(){
            
            var cuotas = $('select[fees_select]').val();
            if($('select[fees_select]').find('option:selected').data('cuotas')){
                cuotas = $('select[fees_select]').find('option:selected').data('cuotas');
            }

             

            var recargo = Math.ceil((sale.subtotal * (1+(sale.client.client_type.surcharge/100))));

            var interes = (sale.client.client_type.interest/100)+1;
            var monto_cuota = Math.ceil((recargo/cuotas)*interes);

            
            $('#sale-credit-form').find('input[name="amount_cuotes"]').val($.fn.money(monto_cuota));

            
        }

        //Autorización para 90 dias sin anticipo
        $('select[first_fee]').on('change', function(){

            var select = $(this);
            var tpSale = "{{ $type_sale }}";

            @isset($sale)
                @if(! json_decode($sale, true)['client']['first_fee'])
                    if($(this).val() == 3 || ($(this).val() == 2 && tpSale == 'high') || ($(this).val() == 1 && tpSale == 'high')){
                @endif

                    if(select.val() != 0){

                        $('#myModal').css('display', 'none');

                        swal({
                          title: '<b>Autorizar</b>',
                          type: 'warning',
                          html:
                            `<div id="authorization-store">
                                <p>Debe pedir a un usuario con privilegios que autorice esta acci&oacute;n</p>
                                <br>
                                <label>Clave de autorizaci&oacute;n</label>
                                <input type="hidden" name="type" value="first_fee">
                                <input type="password" name="clave" class="form-control" placeholder="Ingrese clave de autorizaci&oacute;n"/><br>
                            </div>`,
                          showCloseButton: true,
                          showCancelButton: true,
                          focusConfirm: false,
                          confirmButtonText:
                            'Autorizar',
                          //confirmButtonAriaLabel: 'Thumbs up, great!',
                          cancelButtonText:
                          'Cancelar',
                          //cancelButtonAriaLabel: 'Thumbs down',
                        }).then(
                            (confirm) => {
                                
                                if(confirm){
                                    var data = {
                                        value: $('#myModal').find('select[name="first_fee"]').val(),
                                        clave: $('#authorization-store').find('input[name="clave"]').val(),
                                        type: $('#authorization-store').find('input[name="type"]').val(),
                                    };

                                    $.ajax({
                                        type: 'post',
                                        url: '{{ route("authorizations.store") }}',
                                        data: data,
                                        dataType: "json",
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    }).done(function(response){

                                        var txtCuotas = '';

                                        switch (response.cuotas) {
                                            case "1":
                                                txtCuotas = "30";                                      
                                                break;

                                            case "2":
                                                txtCuotas = "60";                                      
                                                break;

                                            default:
                                                txtCuotas = "90";
                                                break;
                                        }

                                        select.find('option[authorization]').remove();

                                        select.append('<option value="'+response.token+'" authorization selected>Primera cuota autorizada a: '+txtCuotas+' dias (Es valido s&oacute;lo para esta operaci&oacute;n)</option>');

                                        select.parent().append('<div class="alert alert-success" style="margin-top:10px;" error-cuota>'+response.message+'</div>');

                                        setTimeout(function(){
                                            $('[error-cuota]').remove();
                                        }, 5000);

                                    }).fail(function(a,b,c){
                                        
                                        select.parent().append('<div class="alert alert-error" style="margin-top:10px;" error-cuota>'+a.responseJSON.message+'</div>');
                                        
                                        select.val('');

                                        setTimeout(function(){
                                            $('[error-cuota]').remove();
                                        }, 5000);

                                    });

                                }
                                
                                $('#myModal').css('display', 'block');
                            }, 
                            () => {
                                $('#myModal').css('display', 'block');
                                select.val('');
                            }
                        );
                        
                    }
                @if(! json_decode($sale, true)['client']['first_fee'])
                }
                @endif
            @endif

        });


        $('form#SendFormSale').on('submit', function(event){
            // event.stopPropagation();
            // event.preventDefault();

            var form = $(this);

            form.find('[remove-msg-error]').remove();

            $.ajax({
                type: 'post',
                url: '{{ route("sales.validate.form") }}',
                data: $(this).serialize(),
                dataType: "json",
                async: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function(response){
                
                if(!response.OK){
                    event.stopPropagation();
                    event.preventDefault();
                }

            }).fail(function(a){
                
                event.stopPropagation();
                event.preventDefault();
                $('form#SendFormSale').find('[remove-pwd-input="zxc"]').remove();
                $.each(a.responseJSON[0], function(k, v) {
                    /* iterate through array or object */

                    if (isJson(v[0])) {
                        var elem = JSON.parse(v[0]);

                        var msg = '<span class="help-block" style="color:red;" remove-msg-error>'+elem[0]+'</span>';

                        if (elem[1] === 'auth') {
                            var html = `
                                <div class="form-group" remove-pwd-input="zxc">
                                    {!! Form::label('auth_limit_credit', 'Ingrese contraseña para autorizar l&iacute;mite extra de cr&eacute;dito') !!}
                                    {!! Form::password('auth_limit_credit', ['class' => 'form-control', 'placeholder' => 'Contraseña para autorizar', 'autocomplete'=>'off']) !!}
                                </div>
                            `;

                            form.find('[name="'+k+'"]').parent().after(html);
                        }
                    } else {
                        var msg = '<span class="help-block" style="color:red;" remove-msg-error>'+v+'</span>';
                    }

                    form.find('[name="'+k+'"]').parent().append(msg);
                });
            });
        });

        function isJson(str) {
            try {
                JSON.parse(str);
            } catch (e) {
                return false;
            }
            return true;
        }
    </script>


@endsection
