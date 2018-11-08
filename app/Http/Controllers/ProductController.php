<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreProduct;
use App\Http\Requests\UpdateProduct;
use Illuminate\Database\QueryException;
use Yajra\DataTables\CollectionDataTable;
use App\Http\Requests\ChangePriceProducts;

use Exception;
use File;

use App\Brand;
use App\Modelo;
use App\Category;
use App\Product;
use App\ImageProduct;
use App\CategoryProduct;

class ProductController extends Controller
{

	 /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('products.index')
        ->with(
            [
                'title' => 'Lista de Productos', 
                'new' => route('products.create')
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = [];
        $models = [];
        $categories = [];

    	try {
            $brands = Brand::pluck('name', 'id');
	    	$categories = Category::pluck('name', 'id');
        } catch (Exception $e) {
        	alert()->flash(Exception::class, 'warning', ['text' => 'Error intenta nuevamente.']);
        }

        return view('products.create')
        ->with(
            [
                'title' => 'Registrar Nuevo Producto', 'brands' => $brands, 'models' => $models, 'categories' => $categories
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduct $request)
    {
        #dd($request);

        DB::beginTransaction();

        try {

            Product::saveData($request);

        } catch (\Exception $e) {
            #dd($e);
            DB::rollBack();
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);

            return redirect()->back()->withInput();
        }

        DB::commit();
        alert()->flash('Registro Exitoso!', 'success', ['text' => 'El producto se ha registrado con éxito.']);

        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $product    =   Product::findOrFail($id);
            $categories =   CategoryProduct::where('product_id', $id)->get();
            $images     =   ImageProduct::where('product_id', $id)->get();

        } catch (Exception $e) {
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back();
        }

        $product->load('category_products.category', 'store_inventories.store');

        return view('products.show')
        ->with(
            [
                'title' => 'Información del producto', 
                'product' => $product, 
                'images' => $images,
                'new' => route('products.create')
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $brands = [];
        $models = [];
        $categories = [];
        $categoriesSelecteds = [];

    	try {

    		$brands = Brand::orderBy('name', 'ASC')->pluck('name', 'id');
    		$categories = Category::orderBy('name', 'ASC')->pluck('name', 'id');
            //$categoriesSelecteds = CategoryProduct::where('product_id', $id)->pluck('id');
            $product = Product::findOrFail($id);

            $product->load('categories');

            $product->categories = $product->categories->pluck('id', 'name')->toArray();

            $product->price = number_format($product->price, 0, ',', '');
            $product->original_price = number_format($product->original_price, 0, ',', '');

            /*if($product->has('category_products')) {
                $product->categories = Category::findOrFail($categoriesSelecteds)->pluck('id', 'name')->toArray();
            }*/

        } catch (Exception $e) {
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back();
        }

        return view('products.edit')
        ->with(
            [
                'title' => 'Editar Información del producto', 'brands' => $brands, 'models' => $models, 'categories' => $categories, 'product' => $product,
                'new' => route('products.create')
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProduct $request, $id)
    {
        DB::beginTransaction();

        try {
            Product::updateData($request,$id);
        } catch (\Exception $e) {
            DB::rollBack();
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back()->withInput();
        }

        DB::commit();
        alert()->flash('Registro Exitoso!', 'success', ['text' => 'El registro ha sido editado con éxito.']);

        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            Product::deleteData($id);
        } catch (\Exception $e) {
            DB::rollBack();
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back()->withInput();
        }

        DB::commit();
        alert()->flash('Registro Eliminado!', 'success', ['text' => 'El registro ha sido eliminado con éxito.']);

        return redirect()->route('products.index');
    }


    /* View: Massive update product price */

    public function changePrice ()
    {
        $brands = Product::select('brand')->distinct()->pluck('brand', 'brand');

        $products   = Product::select(DB::raw("CONCAT(code, ' - ', name, ' - ', brand, ' - ', model) AS name"), 'id')
        	->orderBy('name', 'ASC')
        	->pluck('name', 'id');
        $categories = Category::orderBy('name', 'ASC')->pluck('name', 'id');

        return view('products.changePrice')->with(
            [
                'title'         => 'Actualizar Precios',
                'new'           => route('products.create'),
                'categories'    => $categories,
                'products'      => $products,
                'brands'    => $brands
            ]
        );
    }

    public function updatePrice (ChangePriceProducts $request)
    {
        
        if (empty($request->get('brand'))) 
        {
            foreach ($request->get('products') as $key => $product) {
                $product = Product::findOrFail($product);
                $percentProduct = (($product->price * $request->get('percent'))/100);

                if ($request->get('op') == '+') {
                    $newPrice = round($product->price + $percentProduct);
                }else{
                    $newPrice = round($product->price - $percentProduct);
                }

                $product->date_update_price = Carbon::now();

                DB::beginTransaction();
                try {
                    $product->update(['price' => $newPrice]);
                } catch (QueryException $e) {
                    DB::rollBack();
                    alert()->flash('Registro no Actualizado!', 'Error', ['text' => 'Hubo un problema al actualizar el precio.']);
                    return redirect()->back();
                }
                DB::commit();
            }
        } else {
            $products = Product::where('brand', $request->get('brand'))->get();

            $products->each(function ($product) use ($request) {
               $percentProduct = (($product->price * $request->get('percent'))/100);

               if ($request->get('op') == '+') {
                   $newPrice = round($product->price + $percentProduct);
               }else{
                   $newPrice = round($product->price - $percentProduct);
               }

               $product->date_update_price = Carbon::now();

               DB::beginTransaction();
                try {
                    $product->update(['price' => $newPrice]);
                } catch (QueryException $e) {
                    DB::rollBack();
                    alert()->flash('Registros no Actualizados!', 'Error', ['text' => 'Hubo un problema al actualizar los precios.']);
                    return redirect()->back();
                }
                DB::commit();
            });
        }

        alert()->flash('Registros Actualizados!', 'success', ['text' => 'Los registros han sido actualizados con éxito.']);

        return redirect()->route('products.index');

    }

    public function get($param, $opt)
    {
        try {
            if ($opt == 'scooter') {
                $result = Product::with(['inventory', 'image_products'])
                        ->join('category_products', 'products.id', '=', 'category_products.product_id')
                        ->join('categories', 'categories.id', '=', 'category_products.category_id')
                        ->whereIn('categories.name', ['MOTO','MOTOS','Motos','moto','motos'])
                        ->where(function ($query) use ($param) {
                            $query->orWhere('products.code', 'LIKE', "%" . $param . "%")
                                ->orWhere('products.name', 'LIKE', "%" . $param . "%")
                                ->orWhere('products.brand', 'LIKE', "%" . $param . "%")
                                ->orWhere('products.model', 'LIKE', "%" . $param . "%");
                        })
                        ->select('products.*')
                        ->get();
            } else {
                $result = Product::with(['inventory', 'image_products'])
                        ->join('category_products', 'products.id', '=', 'category_products.product_id')
                        ->join('categories', 'category_products.category_id', '=', 'categories.id')
                        ->whereNotIn('categories.name', ['MOTO','MOTOS','Motos','moto','motos'])
                        ->where(function ($query) use ($param) {
                            $query->orWhere('products.code', 'LIKE', "%" . $param . "%")
                                ->orWhere('products.name', 'LIKE', "%" . $param . "%")
                                ->orWhere('products.brand', 'LIKE', "%" . $param . "%")
                                ->orWhere('products.model', 'LIKE', "%" . $param . "%");
                        })
                        ->select('products.*')
                        ->get();
            }

            //return response()->json([$result], 500);

            $result->each(function(&$item) {
                $item->name = $item->name.' - '.$item->brand.' - '.$item->model;
                $item->hasImage = false;
                $item->url = asset("/img") . "/sin-definir.png";
                $item->price = number_format($item->price, 0, ',', '');
                if($item->has('image_products') && count($item->image_products))
                {
                    $item->hasImage = true;
                    $item->url = asset("/uploads") . "/products/" . $item->id ."/" . $item->image_products->first()->name;

                }
            });

        } catch (Exception $e) {

            return response()->json([
                'e' => $e->getMessage(),
                '_message' => 'Ocurrio un error'
            ]);

        }

        return response()->json($result);
    }


    public function productDatatable()
    {
        $products = Product::with('inventory')->get();

        $products->load('categories');
        return (new CollectionDataTable($products))
            ->editColumn('web', function($product) {
                if ($product->web == 1) {
                    return '<i class="fa fa-check"></i>';
                }
            })
            ->editColumn('date_update_price', function($product) {
                return $product->date_update_price->format('d-m-Y H:i:s');
            })
            ->editColumn('qty', function($product) {
                if(isset($product->inventory->qty)){
                    return $product->inventory->qty;
                }else{
                    return 0;
                }
            })
            ->addColumn('action', function ($product) {
                return view('buttons-datatables.productDatatables')->with('product', $product);
                
            })
            ->rawColumns(['web', 'action', 'date_update_price', 'qty'])
            ->toJson();
    }

}
