<div class="btn btn-group">
    <a href="{{route('products.show', $product->id)}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Ver"> <i class="fa fa-eye"></i> </a>

    <a href="{{route('products.edit', $product->id)}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"> <i class="fa fa-edit"></i> </a>

    {!! Form::model($product, ['method' => 'delete', 'route' => ['products.destroy', $product->id], 'class' =>'form-inline form-delete']) !!}
        {!! Form::hidden('id', $product->id) !!}
        <button type="submit" name="delete_modal" class="btn btn-danger btn-sm delete " data-toggle="tooltip" data-placement="top" title="Eliminar" data-original-title="Eliminar"><i class="fa fa-trash"></i></button>
    {!! Form::close() !!}
</div>