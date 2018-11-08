@section('css')
<link href="{{ asset('css/pos.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/jquery.autocomplete.min.css') }}" rel="stylesheet" type="text/css" />

<style type="text/css">
    .easy-autocomplete-container { z-index: 10; }
    .easy-autocomplete-container ul { margin-top: 34px; }
    .easy-autocomplete{
      width: 100% !important;
    }
    .bootstrap-filestyle.input-group{
      display: none !important;
    }
</style>

@endsection


@section('js')

<script type="text/javascript">

    var base_url = 'https://spos.tecdiary.com/',
    assets = 'https://spos.tecdiary.com/themes/default/assets/';

    var dateformat = 'jS F Y', timeformat = 'h:i A';
    var Settings = {"logo":"logo1.png","site_name":"SimplePOS","tel":"0105292122","dateformat":"jS F Y","timeformat":"h:i A","language":"english","theme":"default","mmode":"0","captcha":"0","currency_prefix":"USD","default_customer":"1","default_tax_rate":"5%","rows_per_page":"10","total_rows":"30","header":null,"footer":null,"bsty":"3","display_kb":"0","default_category":"1","default_discount":"0","item_addition":"1","barcode_symbology":null,"pro_limit":"10","decimals":"2","thousands_sep":",","decimals_sep":".","focus_add_item":"ALT+F1","add_customer":"ALT+F2","toggle_category_slider":"ALT+F10","cancel_sale":"ALT+F5","suspend_sale":"ALT+F6","print_order":"ALT+F11","print_bill":"ALT+F12","finalize_sale":"ALT+F8","today_sale":"Ctrl+F1","open_hold_bills":"Ctrl+F2","close_register":"ALT+F7","java_applet":"0","receipt_printer":"","pos_printers":"","cash_drawer_codes":"","char_per_line":"42","rounding":"1","pin_code":"abdbeb4d8dbe30df8430a8394b7218ef","purchase_code":null,"envato_username":null,"theme_style":"blue-light","after_sale_page":"1","overselling":"1","multi_store":"1","qty_decimals":"2","symbol":"","sac":"0","display_symbol":"0","remote_printing":"1","printer":null,"order_printers":"null","auto_print":"0","local_printers":"0","rtl":"0","print_img":"0","selected_language":"english"};

    var sid = false, username = 'admin', spositems = {};

    $('#mm_pos').addClass('active');
    $('#pos_index').addClass('active');

    var pro_limit = 10, java_applet = 0, count = 1, total = 0, an = 1, p_page = 0, page = 0, cat_id = 1, tcp = 2;
    var gtotal = 0, order_discount = 0, order_tax = 0, protect_delete = 0;
    var order_data = {}, bill_data = {};

    var csrf_hash = 'dbdbfd7b3a7afeca031e32303d2de71a';
    var lang = new Array();

    lang['code_error'] = 'Code Error';
    lang['r_u_sure'] = '<strong>Are you sure?</strong>';
    lang['please_add_product'] = 'Please add product';
    lang['paid_less_than_amount'] = 'Paid amount is less than paying';
    lang['x_suspend'] = 'Sale can not be suspended';
    lang['discount_title'] = 'Discount (5 or 5%)';
    lang['update'] = 'Update';
    lang['tax_title'] = 'Tax (5 or 5%)';
    lang['leave_alert'] = 'You will loss the data, are you sure?';
    lang['close'] = 'Close';
    lang['delete'] = 'Delete';
    lang['no_match_found'] = 'No match found';
    lang['wrong_pin'] = 'Wrong Pin';
    lang['file_required_fields'] = 'Please fill required fields';
    lang['enter_pin_code'] = 'Enter Pin code';
    lang['incorrect_gift_card'] = 'Gift card number is wrong or card is already used.';
    lang['card_no'] = 'Card No';
    lang['value'] = 'Value';
    lang['balance'] = 'Balance';
    lang['unexpected_value'] = 'Unexpected Value Provided!';
    lang['inclusive'] = 'Inclusive';
    lang['exclusive'] = 'Exclusive';
    lang['total'] = 'Total';
    lang['total_items'] = 'Total Items';
    lang['order_tax'] = 'Order Tax';
    lang['order_discount'] = 'Order Discount';
    lang['total_payable'] = 'Total Payable';
    lang['rounding'] = 'Rounding';
    lang['grand_total'] = 'Grand Total';
    lang['register_open_alert'] = 'Register is open, are you sure to sign out?';
    lang['discount'] = 'Discount';
    lang['order'] = 'Order';
    lang['bill'] = 'Bill';
    lang['merchant_copy'] = 'Merchant Copy';

let sale = <?php echo $sale; ?>;
  
$(document).ready(function() {

    //$('select.select2-taxes').val(null).trigger('change');

    let $input = $("div.input-group.client").clone();
    let $inputProduct = $("div.input-group.product").clone();

    let product = {

      product_id: null,
      price: 0.00,
      qty: 0,
      discount: 0.00,
      taxes: Array(),
      init: () => {
        this.product_id = null;
        this.price      = 0.00;
        this.qty        = 0;
        this.discount   = 0.00;
        this.taxes      = [];
      },
      setProduct: (type, item) => {
        switch (type) {
          case 'SET_PRODUCT':
            this.product_id = item.id;
            this.price      = item.price;
            this.qty        = 1;
            setOtherInputs(this);
            break;
          case 'SET_PRICE':
            this.price      = item;
            break;
          case 'SET_QTY':
            this.qty        = item;
            break;
          case 'SET_DISCOUNT':
            this.discount   = item;
            break;
          case 'SET_TAXES':
            this.taxes.push(item);
            break;
          case 'DELETE_TAX':
            $.each(this.taxes, (key, val) => {
                if(val === item)
                {
                    this.taxes.splice(key, 1);
                }
            });

            break;
          default:

        }
      },
      getProduct: () => {
        return {
          product_id: this.product_id,
          price: this.price,
          qty: this.qty,
          discount: this.discount,
          taxes: this.taxes
        }
      },
      check: () => {
        if(
          this.product_id === null || this.product_id === 0 || this.product_id === undefined || this.product_id === "" ||
          this.price === null || this.price <= 0.00 || this.price === undefined || this.price === "" ||
          this.qty === null || this.qty <= 0  || this.qty === undefined || this.qty === "")
        {
          return false;
        }
        return true;
      },
      clearProduct: () => {
        this.product_id = null;
        this.price      = 0.00;
        this.qty        = 0;
        this.discount   = 0.00;
        this.taxes      = [];
        $('select.select2-taxes').val(null).trigger('change');
      }
    };

    product.init();

    const setOtherInputs = (product) => {
      $('select.select2-taxes').select().focus();
      $("input[name='price']").val(product.price);
      $("input[name='discount']").val(0.00);
      $("input[name='qty']").val(1);
    }

    $("div.addItem").on('click', ev => {
        sendDetail();
    })

    $("form#pos-sale-form").on('submit', ev => {

      ev.preventDefault();
      ev.stopPropagation();

    });

    $('select.select2-taxes').on('select2:select', ev => {
        product.setProduct('SET_TAXES', ev.params.data);
    });

    $('select.select2-taxes').on('select2:unselect', ev => {
        product.setProduct('DELETE_TAX', ev.params.data);
    });

    $("input[name='price']").on('keyup', ev => {

      if(ev.keyCode === 13 && ev.which === 13)
      {
        $("input[name='qty']").select().focus();
        return;
      }

      product.setProduct('SET_PRICE', $(ev.target).val());

    })

    $("input[name='qty']").on('keyup', ev => {

      if(ev.keyCode === 13 && ev.which === 13)
      {
        $("input[name='discount']").select().focus();
        return;
      }

      product.setProduct('SET_QTY', $(ev.target).val());

    })

    $("input[name='discount']").on('keyup', ev => {

      if(ev.keyCode === 13 && ev.which === 13)
      {
        sendDetail();
        $("input[name='qty']").focus();
        return;
      }

      product.setProduct('SET_DISCOUNT', $(ev.target).val());

    })

    $("table#products-table tbody").on('click', 'td.delete-item', ev => {
        let selector = $(ev.target);
        let id = $(selector).data('detail-id');

        if($(selector).hasClass('fa-trash-o')){
            id = $(selector).parent('td').data('detail-id');
        }

        removeItem(id);
    })

    $("button.delete-sale").on('click', ev => {

        let url = $(ev.target).data('href');

        if(typeof sale !== undefined || sale !== null)
        {
          if($(ev.target).data('href')[($(ev.target).data('href').length-1)] == 's'){
            url = url.concat('/').concat(sale.id);
          }
          deleteSale(url);
        } else {
          showSwal('No existe una venta activa', 'error', 'Disculpe!');
        }
    })

    $("button#finished-sale").on('click', ev => {
          /*let url = $(ev.target).data('href');
          let method = "POST";
          let data = {
              _token: '{{--  csrf_token() --}}',
          };

          requestAjax(url, method, data)
          .done( (data, textStatus, jqXHR) => {
              console.log(data);
              //window.location.href = data.url;
          })
          .fail( (jqXHR, textStatus, errorThrow) => {
              showSwal(jqXHR.responseJSON.message, 'error', 'Disculpa!');
          });*/
    })

    const sendDetail = () => {

      if(typeof sale === undefined || sale === null)
      {
        //$("input[name='product']").focus();
        product.clearProduct();
        return;
      }

      if( !product.check())
      {
          $("input[name='product']").focus();
          showSwal('Debe agregar un producto, precio y cantidad.', 'error', 'Disculpe!,');
          return;
      }

      let url = "{{ route('salesDetails.store') }}";
      let method = "POST";
      let data = product.getProduct();
      data.sale_id = sale.id;
      data._token = '{{ csrf_token() }}';
      data.tax = "";

      $.each(data.taxes, (key, item) => {

          data.tax = data.tax.concat(item.id).concat(',');

          if(data.taxes.length -1 === key)
          {
              data.tax = data.tax.substr(0, data.tax.length - 1);
          }
      });

      delete data.taxes;

      requestAjax(url, method, data)
      .done( (data, textStatus, jqXHR) => {
        cleanProductInput();
        renderDetails(data);
        $("input[name='product']").focus();
      })
      .fail( (jqXHR, textStatus, errorThrow) => {
          showSwal(jqXHR.responseJSON.message, "error", "Disculpe!");
      });
    }

    const renderDetails = (data = null) => {
        console.log(data);
        sale = data;
        let selector = $("table#products-table tbody");
        $(selector).find('tr').remove();

        let dis = 0.00;
        let subtotal = 0.00;
        let total = 0.00;
        let counter = 0;
        let taxes = 0.00;
        let tax = 0.00;
        let discount = 0.00;

        if(data !== null && data.hasOwnProperty('sale_details'))
        {

          if (data.sale_details.length > 0) {
            $('#modal-button').attr("disabled", false);
          } else {
            $('#modal-button').attr("disabled", true);
          }

          $.each(data.sale_details, (key, item) => {

              tax = item.amount_taxes || 0.00;

              let tr = $("<tr></tr>").append(`
                <!--Product-->
                <td>${ item.product.name } - ${ item.product.brand } - ${ item.product.model }</td>
                <!--Precio-->
                <td style="text-align:left;">${ $.fn.money(item.price) }</td>
                <!--Cantidad-->
                <td style="text-align:center;">${ item.qty }</td>
                <!--Descuento-->
                <td style="text-align:left;">${ $.fn.money(parseFloat(item.amount_discount)) } <small>(${ parseFloat(item.discount).toFixed(0) }%)</small></td>
                <!--Subtotal-->
                <td style="text-align:left;">${ $.fn.money(parseFloat(item.subtotal).toFixed(0))  }</td>
                <!--Eliminar-->
                <td data-detail-id="${ item.id }" class="satu delete-item" style="cursor: pointer;"><i class="fa fa-trash-o"></i></td>
                `);

              $(selector).append(tr)

              counter = counter + item.qty;

              // dis = item.amount_discount || 0.00;
              // subtotal = subtotal + (parseFloat(item.qty) * parseFloat(item.price));
              // discount = parseFloat(discount) + parseFloat(dis);
              // taxes = parseFloat(taxes) + parseFloat(tax);
              // total = ((subtotal - discount) + taxes);

          });

        }

        $("span.count").html(counter);
        $("span.ds_con").html($.fn.money(parseFloat(data.discount_amount),' ARS'));
        $("span.total").html($.fn.money(data.subtotal,' ARS'));
        //$("span.ts_con").html(taxes.toFixed(2).concat(' ARS'));
        $("span.total-payable").html($.fn.money(parseFloat(data.total),' ARS'));

        if (data !== null && data.last_item) {
            showSwal('Ha agregado el ultimo item disponible.', 'warning', 'Advertencia');
        }
    }

    const removeItem = (id) => {

        let url = '{{ route("salesDetails.destroy") }}'.concat("/").concat(id);
        let method = "POST";
        let data = {
          _token: '{{ csrf_token() }}',
          _method: 'DELETE',
          id: id
        };

        swal({
            title: "Confirmar",
            type: "warning",
            text: "¿Desea eliminar este item?.",
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            confirmButtonText: "Si, continuar",
        })
        .then(
            (confirm) => {
              if(confirm){
                requestAjax(url, method, data)
                .done( (data, textStatus, jqXHR) => {
                    console.info(data)
                    renderDetails(data);
                })
                .fail( (jqXHR, textStatus, errorThrow) => {
                  showSwal("Disculpe!", "error", "El item no pudo ser eliminado.");
                });
              }
            },
            () => {}
        );
    }

    const deleteSale = (url) => {

        let method = "POST";
        let data = {
          _token: '{{ csrf_token() }}',
          _method: 'DELETE'
        };

        swal({
            title: "Confirmar",
            type: "warning",
            text: "¿Desea cerrar eliminar la venta actual?.",
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            confirmButtonText: "Si, continuar",
        })
        .then(
            (confirm) => {
              if(confirm){
                requestAjax(url, method, data)
                .done( (data, textStatus, jqXHR) => {
                    //window.location.reload();
                    window.location.href = "{{ route('sales.create', ['opt' => $type_sale]) }}";
                })
                .fail( (jqXHR, textStatus, errorThrow) => {
                  console.info(jqXHR)
                  //showSwal("", "", ""):
                });
              }
            },
            () => {}
        );
    }

    const initSale = (sale) => {
        if(typeof sale === "object" && sale !== null)
        {
            console.info(sale.client.name)
            $("input[name='sale_number']").val(sale.id.toString().padStart(8, "0"))
            let str = sale.client.name.concat(' - ').concat(sale.client.dni);
            destroyAutocomplete($input, str);
        }
    }

    /**
     * Inicializar el autocomplete de clientes
     */
    const initAutocomplete = () => {
        let options = {
            url: function(phrase) {
              return "../clients/get/" + phrase + "?opt={{ $type_sale }}";
            },
            getValue: function(element){
                return element.name;
            },
            placeholder: "Ingrese Nombre o DNI",
            minCharNumber: 1,
            list: {
                match: {
                    enabled: true
                }
            },
            theme: "square",
            template: {
                type: "description",
                fields: {
                    description: "dni"
                }
            },
            list: {
                maxNumberOfElements: 10,
                onKeyEnterEvent: function(){
                    let index = $("input#client").getSelectedItemIndex();
                    let data = $("input#client").getItemData(index);
                    let str = data.name.concat(' - ').concat(data.dni)

                    swal({
                        title: "¿Desea continuar?",
                        type: "info",
                        text: "Esta a un paso de aperturar una venta al cliente seleccionado.",
                        showCancelButton: true,
                        cancelButtonColor: '#d33',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: "Si, continuar",
                    })
                    .then(
                        (confirm) => {
                          if(confirm){
                            openSale(data.id, str)
                            .done((data, textStatus, jqXHR) => {
                                sale = data.sale;
                                initSale(sale);
                                // destroyAutocomplete($input, str);
                            })
                            .fail((jqXHR, textStatus, errorThrow) => {
                                let message = jqXHR.responseJSON._message;
                                showSwal(message, 'error', "Disculpe!");
                            });
                          }
                        },
                        () => {

                            $("input#client").val(null).trigger('change');

                        }
                    );
                },
                onChooseEvent: function(){
                    let index = $("input#client").getSelectedItemIndex();
                    let data = $("input#client").getItemData(index);
                    let str = data.name.concat(' - ').concat(data.dni)

                    swal({
                        title: "¿Desea continuar?",
                        type: "info",
                        text: "Esta a un paso de aperturar una venta al cliente seleccionado.",
                        showCancelButton: true,
                        cancelButtonColor: '#d33',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: "Si, continuar",
                    })
                    .then(
                        (confirm) => {
                          if(confirm){
                            openSale(data.id, str)
                            .done((data, textStatus, jqXHR) => {
                                sale = data.sale;
                                initSale(sale);
                                // destroyAutocomplete($input, str);
                            })
                            .fail((jqXHR, textStatus, errorThrow) => {
                                let message = jqXHR.responseJSON._message;
                                $("input#client").val(null).trigger('change');
                                showSwal(message, 'error', "Disculpe!");
                            });
                          }
                        },
                        () => {

                            $("input#client").val(null).trigger('change');

                        }
                    );
                }
            }
        };

        $("input[name='client']").attr('id', 'client').removeAttr('readonly').easyAutocomplete(options);

    }

    /**
     * Inicializar el autocomplete de productos
     */
    const initAutocompleteProduct = () => {
        let options = {
            url: function(phrase) {
                return "../products/get/" + phrase + "/{{ $type_sale }}";
            },
            getValue: function(element){
                return element.name;
            },
            placeholder: "Buscar producto por código o nombre",
            minCharNumber: 1,
            list: {
                match: {
                    enabled: true
                }
            },
            theme: "square",
            template: {
                type: "description",
                fields: {
                    description: "code"
                }
            },
            list: {
                maxNumberOfElements: 10,
                /*onKeyEnterEvent: function(){
                    let index = $("input#product").getSelectedItemIndex();
                    let data = $("input#product").getItemData(index);
                },*/
                onHideListEvent: function(){
                    cleanProductList();
                },
                onChooseEvent: function(){
                    let index = $("input#product").getSelectedItemIndex();
                    let data = $("input#product").getItemData(index);

                    product.setProduct('SET_PRODUCT', data);

                },
                onShowListEvent: function(ev){
                  renderProductsOnList($("input#product").getItems());
                }
            }
        };

        $("input[name='product']").attr('id', 'product').removeAttr('readonly').easyAutocomplete(options);

    }

    /**
    * Función que limpia la caja de texto para buscar productos
    */
    const cleanProductInput = () => {
      $("input[name='product']").val(null).trigger('change');
      $("input[name='price']").val(null);
      $("input[name='discount']").val(null);
      $("input[name='qty']").val(null);

      product.clearProduct();
      cleanProductList();
    }

    /**
    * Limpiar la lista de productos, sección derecha de la pantalla
    */
    const cleanProductList = () => {
        let list = $('ul.list-group.list-products');
        list.children().remove();
    }

    /**
     * Función que renderiza los productos en la parte izquierda de la pantalla
     */
    const renderProductsOnList = (items) => {
        let list = $('ul.list-group.list-products');

        cleanProductList();

        $.each(items, (key, item) => {

            let image = item.url;

            let string = `
                  <li class="list-group-item">
                      <div class="row">

                          <div class="col-md-2">
                              <img class="media-object" src="${ image }" alt="..." height="60px" width="auto">
                          </div>

                          <div class="col-md-10" style="line-height: 30px;">
                              <div class="row">
                                  <div class="col-md-4">
                                      ${ item.name }
                                  </div>
                                  <div class="col-md-6">
                                      <b>Código: </b>${ item }
                                  </div>
                                  {{--  <div class="col-md-4">
                                      ${ item.model.name }
                                  </div> --}}
                              </div>
                              <div class="row">
                                  <div class="col-md-4">
                                      <b>Existencia: </b> ${ item.inventory.qty }
                                  </div>
                                  <div class="col-md-4">
                                      ${ item.description || "" }
                                      <b>Color: </><span>${ item.color }</span>
                                  </div>
                                  <div class="col-md-4">
                                      ${ item.price.concat(' ARS') || "0 ARS" }
                                  </div>
                              </div>
                          </div>
                      </div>
                  </li>
                `;

                $(list).append(string);

        });

    }
    /**
     * Función que despliega un alert con mensajes de error o exito.
     * Admite [error, success, warning, info]
     */
    const showSwal = (message, type = 'error', title = null) => {
        return swal({
                title: title || "Error!",
                text: message,
                type: type
            })
    }

    /**
     * Destory Autocomplete
     */
    const destroyAutocomplete = ($input, str) => {
        $input.find('input').val(str);
        $('div.input-group.client').replaceWith($input)
    }

     /**
     * Destory Autocomplete Product
     */
    const destroyAutocompleteProduct = ($input, str) => {
        $input.find('input').val(str);
        $('div.input-group.product').replaceWith($input)
    }

    /**
     * Aperturar una venta
     */
    const openSale = (client_id) => {

        let url = "{{ route('sales.store') }}";
        let method = "POST";
        let data = {
            _method: "POST",
            _token: "{{ csrf_token() }}",
            client_id: client_id,
            type: "{{ $type_sale }}"
        }

        return requestAjax(url, method, data)

    }

    /**
     * Función Ajax
     */
    const requestAjax = (url, method, data = null) => {

        return $.ajax({
            method: method,
            url: url,
            data: data,
            cache: false,
            dataType: "json"
        });
    }

    if (get('rmspos')) {
        if (get('spositems')) { remove('spositems'); }
        if (get('spos_discount')) { remove('spos_discount'); }
        if (get('spos_tax')) { remove('spos_tax'); }
        if (get('spos_note')) { remove('spos_note'); }
        if (get('spos_customer')) { remove('spos_customer'); }
        if (get('amount')) { remove('amount'); }
        remove('rmspos');
    }

    if (! get('spos_discount')) {
        store('spos_discount', '0');
        $('#discount_val').val('0');
    }

    if (! get('spos_tax')) {
        store('spos_tax', '5%');
        $('#tax_val').val('5%');
    }

    if (ots = get('spos_tax')) {
        $('#tax_val').val(ots);
    }

    if (ods = get('spos_discount')) {
        $('#discount_val').val(ods);
    }

    bootbox.addLocale('bl',{OK:'OK',CANCEL:'No',CONFIRM:'Yes'});
    bootbox.setDefaults({closeButton:false,locale:"bl"});
    initAutocomplete();
    initAutocompleteProduct();
    initSale(sale);
    renderDetails(sale);

      /**
       * Inicilizamos los select's
       */
      setTimeout( () => {
        $.fn.select2.defaults.set( "theme", "bootstrap" );

        $('select.select2-taxes').select2({
          placeholder: "Seleccione",
            allowClear: true,
            theme: "bootstrap"
        });
      }, 1000);
});

</script>

<script type="text/javascript">
    var socket = null;

    function printBill(bill) {
        if (Settings.remote_printing == 1) {
            Popup($('#bill_tbl').html());
        } else if (Settings.remote_printing == 2) {
            if (socket.readyState == 1) {
                var socket_data = {'printer': false, 'logo': '{{ asset('enlinea/logo.png') }}', 'text': bill};
                socket.send(JSON.stringify({
                    type: 'print-receipt',
                    data: socket_data
                }));
                return false;
            } else {
                bootbox.alert('Unable to connect to socket, please make sure that server is up and running fine.');
                return false;
            }
        }
    }
    var order_printers = [];

    function printOrder(order) {
        if (Settings.remote_printing == 1) {
            Popup($('#order_tbl').html());
        } else if (Settings.remote_printing == 2) {
            if (socket.readyState == 1) {
                if (order_printers == '') {

                    var socket_data = { 'printer': false, 'order': true,
                    'logo': '{{ asset('enlinea/logo.png') }}',
                    'text': order };
                    socket.send(JSON.stringify({type: 'print-receipt', data: socket_data}));

                } else {

                    $.each(order_printers, function() {
                        var socket_data = {'printer': this, 'logo': '{{ asset('enlinea/logo.png') }}', 'text': order};
                        socket.send(JSON.stringify({type: 'print-receipt', data: socket_data}));
                    });

                }
                return false;
            } else {
                bootbox.alert('Unable to connect to socket, please make sure that server is up and running fine.');
                return false;
            }
        }
    }

    function Popup(data) {
        var mywindow = window.open('', 'spos_print', 'height=500,width=300');
        mywindow.document.write('<html><head><title>Print</title>');
        mywindow.document.write('<link rel="stylesheet" href="{{ asset('enlinea/bootstrap.min.css') }}" type="text/css" />');
        mywindow.document.write('</head><body>');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');
        mywindow.print();
        mywindow.close();
        return true;
    }

</script>

<script src="{{ asset('js/libraries.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/scripts.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/pos.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.autocomplete.min.js') }}"></script>

@endsection
