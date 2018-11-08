<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Solo puedes acceder si no estas logueado
Route::get('/', function () {
   	return view('auth.login');
});

Auth::routes();

Route::middleware('auth')->group(function (){
	Route::middleware('ability:Administrador|Master,admin-users|administrator')->group(function (){
		Route::get('/home', 'HomeController@index')->name('home');
	});

	Route::middleware('ability:Administrador|Master|Gerente,admin-users|administrator')->group(function (){
		/**
		 * Users
		*/
		Route::resource('users', 'UserController', [ 'middleware' => ['ability:Administrador|Master,admin-users|administrator']]);

	});

	Route::get('user/profile', 'UserController@profile')->name('user.profile');

	Route::middleware('ability:Administrador|Master|Vendedor|Gerente,admin-clients|administrator')->group(function (){
		/**
		 * ClientTypes
		 */
		Route::resource('clientTypes', 'ClientTypeController', ['middleware' => ['ability:Administrador|Master,admin-clients|administrator']]);


		/**
		 * Clients
		 */
		Route::get('clients/get/{query}', 'ClientController@get')->name('clients.get');
		Route::resource('clients', 'ClientController', ['except' => ['index', 'show'], 'middleware' => ['ability:Administrador|Master,admin-clients|administrator']]);
		Route::resource('clients', 'ClientController', ['only' => ['edit', 'update'], 'middleware' => ['ability:Administrador|Gerente|Master,admin-clients|administrator']]);
		Route::get('clients/create', 'ClientController@create', ['middleware' => ['ability:Administrador|Gerente|Master,admin-clients|administrator']])->name('clients.create');
		Route::get('clients-sales-datatable/{client}', 'ClientController@salesDatatable')->name('clients.sales.datatable');
		Route::post('client-checkform', 'ClientController@validationForm')->name('client.validate.form');
	});

		Route::get('clients', 'ClientController@index')->name('clients.index');
		Route::get('clients/{id}', 'ClientController@show')->name('clients.show');
		Route::get('products-datatable', 'ProductController@productDatatable')->name('products.datatable');

	Route::middleware('ability:Administrador|Master,admin-products|administrator')->group(function (){
		/**
		 * Categories
		 */
		Route::resource('categories', 'CategoryController', ['except' => ['index'], 'middleware' => ['ability:Administrador|Master,admin-products|administrator']]);
		Route::get('categories', 'CategoryController@index', ['middleware' => ['ability:Administrador|Master,admin-products|administrator']])->name('categories.index');

		/**
		 * Products
		 */
		Route::get('changePrice', 'ProductController@changePrice', ['middleware' => ['ability:Administrador|Master,admin-products|administrator']])->name('changePrice');
		Route::post('updatePrice', 'ProductController@updatePrice', ['middleware' => ['ability:Administrador|Master,admin-products|administrator']])->name('updatePrice');
		Route::resource('products', 'ProductController', ['except' => ['index','show'], 'middleware' => ['ability:Administrador|Master,admin-products|administrator']]);
		Route::get('products', 'ProductController@index')->name('products.index');
		Route::get('products/{id}', 'ProductController@show')->name('products.show');
		/**
		 * Bands
		 */
		Route::get('brands/models/{brand}', 'BrandController@models')->name('brands.models');
		Route::resource('brands', 'BrandController', ['except' => ['index'], 'middleware' => ['ability:Administrador|Master,admin-products|administrator']]);
		Route::get('brands', 'BrandController@index')->name('brands.index');

		/**
		 * Models
		 */
		Route::resource('models', 'ModelController', ['except' => ['index'], 'middleware' => ['ability:Administrador|Master,admin-products|administrator']]);
		Route::get('models', 'ModelController@index')->name('models.index');
	});

	Route::middleware('ability:Administrador|Master|Vendedor|Gerente,admin-products|administrator')->group(function (){
		
		Route::get('products', 'ProductController@index')->name('products.index');
		Route::get('products/{id}', 'ProductController@show')->name('products.show');
		
	});

	Route::middleware('ability:Administrador|Master|Gerente,admin-enterprise|administrator')->group(function () {
		/**
		 * Enterprises
		 */
		Route::resource('enterprises', 'EnterpriseController', ['except' => ['index'], 'middleware' => ['ability:Administrador|Master|Gerente,admin-enterprise|administrator']]);
		Route::get('enterprises', 'EnterpriseController@index')->name('enterprises.index');
	});

	Route::middleware('ability:Administrador|Master,administrator')->group(function () {
		/**
		 * tokens
		 */
		
		Route::get('tokens/create', 'TokenController@create')->name('tokens.create');
		Route::get('tokens/store', function() {
			$nToken = new \App\Token;

			$token = substr(uniqid(), -6);

			$nToken->value = strtoupper($token);

			$nToken->user()->associate(\Auth::user());

			$nToken->save();

			return redirect()->route('tokens.create', ['token' => $nToken->value]);
		})->name('tokens.store');
	});

	/**
	 * Companies
	 */

	Route::resource('companies', 'CompanyController');
	Route::resource('companies', 'CompanyController', ['only' => ['edit', 'update'], 'middleware' => ['ability:Administrador|Master,admin-companies|administrator']]);
	
	Route::middleware('ability:Administrador|Master|Gerente,admin-stores|administrator')->group(function (){
		/**
		 * Stores
		 */
		Route::get('/stores-get', 'StoreController@getStores')->name('stores.get');
		Route::post('/stores/transfer', 'StoreController@transfer')->name('stores.transfer');
		Route::resource('stores', 'StoreController', ['except' => ['index'], 'middleware' => ['ability:Administrador|Master,admin-stores|administrator']]);
		Route::get('stores', 'StoreController@index')->name('stores.index');
	});

	Route::middleware('ability:Administrador|Master|Gerente,admin-providers|administrator')->group(function (){
		/**
		 * Providers
		 */
		Route::resource('providers', 'ProviderController', ['except' => ['index'], 'middleware' => ['ability:Administrador|Master,admin-providers|administrator']]);
		Route::get('providers', 'ProviderController@index')->name('providers.index');
		Route::any('provider-invoices-datatable/{provider}', 'ProviderController@invoicesDatatable')->name('providers.invoices.datatable');
	});

	

	Route::middleware('ability:Administrador|Master|Gerente|Vendedor,admin-sales|administrator')->group(function (){
		/**
		 * Sales
		 */
		Route::resource('sales', 'SaleController', ['except' => ['index'], 'middleware' => ['ability:Administrador|Master|Vendedor|Gerente,admin-sales|administrator']]);
		Route::get('sales', 'SaleController@index')->name('sales.index');
		Route::post('sales/finished', 'SaleController@finished')->name('sales.finished');
		Route::post('sales-checkform', 'SaleController@validationFormCredit')->name('sales.validate.form');
		Route::get('sale-preview/{sale}', 'SaleController@salePreview')->name('sale.preview');
		Route::get('sale-contract/{id}', 'PdfController@pdfSale')->name('sales.contract');

		/*
		* Autorizaciones de reimpresion
		*/
		Route::post('reprint-auth', 'AuthorizationController@reprintAuth')->name('reprint.auth');
		Route::post('deleteCredit-auth', 'AuthorizationController@deleteCredit')->name('deleteCredit.auth');
		Route::post('returnPayment-auth', 'AuthorizationController@returnPayment')->name('returnPayment.auth');
		Route::post('returnSale-auth', 'AuthorizationController@deleteSale')->name('sales.unsubscribe');

		/**
		 * Sales Details
		 */
		Route::resource('salesDetails', 'SaleDetailController', [
		  'except' => ['destory']
		]);
		Route::delete('salesDetails/{param?}', 'SaleDetailController@destroy')->name('salesDetails.destroy');

		/**
		 * Authorization
		 */
		Route::resource('authorizations', 'AuthorizationController');

		/**
		 * Invoices
		 */
		Route::post('invoices/open', 'InvoiceController@openInvoice')->name('invoices.open');
		Route::post('invoices/finish', 'InvoiceController@finishInvoice')->name('invoices.finish');
		Route::post('invoices/cancel', 'InvoiceController@cancelInvoice')->name('invoices.cancel');
		Route::resource('invoices', 'InvoiceController', [ 'middleware' => ['ability:Administrador|Master|,admin-sales|administrator']]);
		
		/**
		 * Invoices Details
		 */
		Route::resource('invoices/details', 'InvoiceDetailController');

		/**
		 * Taxes
		 */
		Route::resource('taxes', 'TaxController', ['middleware' => ['ability:Administrador|Master,admin-sales|administrator']]);
		
		/*
		*	Buscar productos para la venta
		*/
		Route::get('products/get/{query}/{opt}', 'ProductController@get')->name('products.get');
	});
	

	/*
		Check Request Client - Enterprise
	 */

	Route::post('checkClientRequest', 'ClientController@checkClientRequest')->name('checkClientRequest');


	/*Actualiza estado - ciudad */

	Route::get('states/get/{id}', 'Controller@getCities')->name('states.get');


	/*Actualiza codigo postal */

	Route::get('cities/getPostalCode/{id}', 'Controller@getPostalCode')->name('cities.get');

	Route::middleware('ability:Administrador|Master|Gerente|Vendedor,admin-credits|administrator')->group(function (){
		/* Credits */

		Route::resource('credits', 'CreditController', ['except' => ['index', 'show'], 'middleware' => ['ability:Administrador|Master|Vendedor,admin-credits|administrator']]);
		Route::get('credits', 'CreditController@index')->name('credits.index');
		Route::get('credits/{id}', 'CreditController@show')->name('credits.show');
		Route::get('credit/findFee/{id}', 'CreditController@findFee')->name('findFee');
		Route::get('credit/coupon/{id}', 'PdfController@coupon')->name('coupon');
		Route::get('sing/coupon/{id}', 'PdfController@couponSing')->name('coupon.sing');
		Route::get('singAdvanceOne/coupon/{id}', 'PdfController@couponSingAdvanceOne')->name('coupon.singAdvanceOne');
		Route::get('singAdvanceSecond/coupon/{id}', 'PdfController@couponSingAdvanceSecond')->name('coupon.singAdvanceSecond');
		Route::post('credit/payFee', 'CreditController@payFee')->name('payFee');
		Route::get('view-contract/{id}', 'PdfController@pdfContract')->name('credits.contract');
		Route::get('view-departure-order/{id}', 'PdfController@pdfDepartureOrder')->name('credits.departure.order');
		Route::get('view-remit/{id}', 'PdfController@pdfRemit')->name('credits.remit');
		Route::post('credits/{credit}/refinance', 'CreditController@refinanceCredit')->name('credits.refinance');
		Route::get('credits/clients/list', 'CreditController@clientWhithCredit')->name('credits.client-with-credit');
		Route::get('credits/{client}/clients', 'CreditController@creditClient')->name('credit.client');
		Route::any('credit-datatable', 'CreditController@creditDatatable')->name('credit.datatable');
		Route::any('credit-datatable-date/{date}/{dateEnd}', 'CreditController@creditDatatableDate')->name('credit.datatable.date');
		Route::any('sales-datatable-date/{date}', 'CreditController@salesDatatableDate')->name('sales.datatable.date');
		Route::any('credit-clients-datatable', 'CreditController@clientsWithCreditDatatable')->name('credit.clients.datatable');
		Route::post('multi-credit-payment', 'CreditController@multiCreditPay')->name('credit.multi.pay');
		Route::patch('credits/{credit}/second-advance', 'CreditController@secondAdvance')->name('credits.second.advance');
		Route::post('credit/unsubscribe', 'CreditController@unsubscribe')->name('credits.unsubscribe');
		Route::get('credit/{date}/{dateEnd}', 'CreditController@getDateCredit')->name('credits.date');
		Route::get('sale/{date}/{dateEnd}', 'CreditController@getDateSales')->name('sale.date');
		Route::post('lastPays', 'CreditController@lastPays')->name('lastPays');
		Route::post('quoting', 'CreditController@sharePorcentage')->name('clients.quoting');

		Route::get('credit/simulate','CreditController@simulate')->name('credit.simulate');
	});

	Route::middleware('ability:Administrador|Master|Gerente|Despachador,admin-deliveries|administrator')->group(function () {
		/**
		 * Deliveries
		 */
		Route::resource('deliveries', 'DeliveryController', ['except' => ['index'], 'middleware' => ['ability:Administrador|Master|Despachador,admin-deliveries|administrator']]);
		Route::put('deliveries/send/{delivery}', 'DeliveryController@send')->name('deliveries.send');
		Route::get('deliveries/{delivery}', 'DeliveryController@dispatches')->name('deliveries.dispatches');
		Route::get('order/{delivery}', 'PdfController@orderDispatch')->name('order.dispatch');
		Route::get('deliveries', 'DeliveryController@index')->name('deliveries.index');
	});
	
	Route::middleware('ability:Administrador|Master,admin-roles|administrator')->group(function (){
		/**
		 * Roles
		 */
		Route::resource('roles', 'RoleController');
	});
});


Route::get('prueba', 'PruebaWord@index');
