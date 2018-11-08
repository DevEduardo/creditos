<div class="table-responsive">

    <table class="table table-striped table-hover" id="data" class="display" cellspacing="0" width="100%">

      <thead>
        <th>#</th>
        <th>Nombre</th>
        <th>Cantidad</th>
        <th> <i class="fa fa-cogs fa-2x"></i> </th>
      </thead>

      <tbody>

        @foreach ($products as $key => $product)

        <tr>
          <td>{{$key+1}}</td>
          <td> {{$product->product->name}}</td>
          <td>{{$product->qty}}</td>

          <td>
            <div class="btn btn-group">
              <a href="{{route('products.show', $product->id)}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Ver"> <i class="fa fa-eye"></i> </a>

              <a href="{{route('products.edit', $product->id)}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"> <i class="fa fa-edit"></i> </a>

              <a href="#" class="transfer btn btn-primary btn-sm" data-store="{{$store->id}}" data-product="{{ $product->id }}" data-toggle="tooltip" data-placement="top" title="Transferir"> <i class="glyphicon glyphicon-transfer"></i> </a>
              
            </div>
          </td>
        </tr>

        @endforeach

      </tbody>

    </table>

</div>

@section('js')
<script type="text/javascript">
  $(document).ready(() => {
    $('.transfer').click((event) => {

        let button = $(event.target).hasClass('transfer') ? $(event.target) : $(event.target).parent();
        swal({
            html: `<form id="formulario" class="form-group">
                        <input type="hidden" name="fromStore" value="{{ $store->id }}">
                      <div class="form-group">
                        <label to="almacen">Almacen</label>
                        <select id="almacen" name="toStore" class="form-control" placeholder="--Seleccione--">
                          ${getStores()}
                        </select>
                      </div>
                      <div class="form-group">
                        <label to="qty">Cantidad</label>
                        <input class="form-control" id="qty" name="qty" type="text" require>
                      </div>
                   </form>`,
            showCancelButton: true,
            confirmButtonText: 'Transferir',
        })
        .then((isConfirm) => {
            if (isConfirm) {
                transfer(button);
            }
        })
    })

    const getStores = () => {
      let _array = [];

      $.ajax({
        url: '{{ route('stores.get') }}',
        dataType: 'json',
        success: (data) => {
          let storeCurrent = $('.transfer').data('store');

          data.map((item) => {
            let option = $('<option></option>').attr('value', item.id).text(item.name);
            _array.push(option);
          })

          _array.splice(storeCurrent-1, 1)

            $('select[name="toStore"]').append(_array);


        }
      });
    }

    const transfer = (button) => {
        let datos = $('form#formulario').serializeArray();
        let product = {
            name: 'product',
            value: button.data('product')
        };

        datos.push(product);
        console.log(datos);
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': '{{csrf_token()}}'
        }
      });

      $.ajax({
        url: '{{ route('stores.transfer') }}',
        type: 'POST',
        data: datos,
        dataType: 'json',
        // processData: false,
        // contentType: false,
        success: function (response) {
            swal({
                title: 'Transferencia existosa',
                type: 'success'
            });

            window.location.reload();
        },
        error: function (response) {
          swal({
                title: 'Ha ocurrido un error',
                text: response.responseJSON.message,
                type: 'error'
            });
        }
      })
    }
  })
</script>
@stop
