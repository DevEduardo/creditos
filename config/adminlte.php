<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
    */

    'title' => 'Crédito',

    'title_prefix' => '',

    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => '<b>Crédito</b>',

    'logo_mini' => '<b>C</b>',

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | ligth variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => 'green-light',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */

    'layout' => null,

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */

    'collapse_sidebar' => false,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs. The
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | You can set the request to a GET or POST with logout_method.
    | Set register_url to null if you don't want a register link.
    |
    */

    'dashboard_url' => 'home',

    'logout_url' => 'logout',

    'logout_method' => 'POST',

    'login_url' => 'login',

    'register_url' => 'register',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and and a URL. You can also specify an icon from
    | Font Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    |
    */


    'menu' => [

        'OPCIONES',
        [
            'text' => 'Perfil',
            'url'  => 'user/profile',
            'icon' => 'user',
        ],

        [
            'text'    => 'Usuarios',
            'icon'    => 'users',
            'submenu' => [
                [
                    'text' => 'Lista de Usuarios',
                    'url'  => 'users',
                ],

                [
                    'text'    => 'Nuevo Usuario',
                    'url'     => 'users/create',
                ],
                /*
                [
                    'text'    => 'Ejemplo',
                    'url'     => 'users-create',
                    'submenu' => [
                        [
                            'text' => 'Level Two',
                            'url'  => '#',
                        ],
                        [
                            'text'    => 'Level Two',
                            'url'     => '#',
                            'submenu' => [
                                [
                                    'text' => 'Level Three',
                                    'url'  => '#',
                                ],
                                [
                                    'text' => 'Level Three',
                                    'url'  => '#',
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'text' => 'Level One',
                    'url'  => '#',
                ],*/
            ],
        ],

        [
            'text'    => 'Empresa',
            'icon'    => 'building',
            'submenu' => [
                [
                    'text' => 'Información de Empresa',
                    'url'  => 'companies/1',
                ],


            ],
        ],

        [
            'text'    => 'Almacenes',
            'icon'    => 'university',
            'submenu' => [
                [
                    'text' => 'Lista de Almacenes',
                    'url'  => 'stores',
                ],

                [
                    'text'    => 'Nuevo Almacen',
                    'url'     => 'stores/create',
                ],
            ],
        ],

        [
            'text'    => 'Proveedores',
            'icon'    => 'truck',
            'submenu' => [
                [
                    'text' => 'Lista de Proveedores',
                    'url'  => 'providers',
                ],

                [
                    'text'    => 'Nuevo Proveedor',
                    'url'     => 'providers/create',
                ],
            ],
        ],


        [
            'text'    => 'Clientes',
            'icon'    => 'briefcase',
            'submenu' => [
                [
                    'text' => 'Lista de Clientes',
                    'url'  => 'clients',
                ],

                [
                    'text'    => 'Nuevo Cliente',
                    'url'     => 'clients/create',
                ],

                [
                    'text'    => 'Tipos de Clientes',
                    'url'     => 'clientTypes',
                ],

                // [
                //     'text'    => 'Nuevo Tipo de Cliente',
                //     'url'     => 'clientTypes/create',
                // ],
            ],
        ],

        [
            'text'    => 'Productos',
            'icon'    => 'shopping-cart',
            'submenu' => [
                [
                    'text' => 'Lista de Productos',
                    'url'  => 'products',
                ],

                [
                    'text'    => 'Nuevo Producto',
                    'url'     => 'products/create',
                ],

                [
                    'text' => 'Actualizar Precios',
                    'url'  => 'changePrice',
                ],

                [
                    'text' => 'Lista de Categorías',
                    'url'  => 'categories',
                ],

                [
                    'text'    => 'Nueva Categoría',
                    'url'     => 'categories/create',
                ],
                // [
                //     'text' => 'Lista de Marcas',
                //     'url'  => 'brands',
                // ],

                // [
                //     'text'    => 'Nueva Marca',
                //     'url'     => 'brands/create',
                // ],
                // [
                //     'text' => 'Lista de Modelos',
                //     'url'  => 'models',
                // ],

                // [
                //     'text'    => 'Nuevo Modelo',
                //     'url'     => 'models/create',
                // ],
            ],
        ],

        [
            'text'    => 'Impuestos',
            'icon'    => 'briefcase',
            'submenu' => [
                [
                    'text' => 'Lista de Impuestos',
                    'url'  => 'taxes',
                ],

                [
                    'text'    => 'Nuevo Impuesto',
                    'url'     => 'taxes/create',
                ],
            ],
        ],

        [
            'text'    => 'Inventario',
            'icon'    => 'truck',
            'submenu' => [
                [
                    'text' => 'Lista de Facturas',
                    'url'  => 'invoices',
                ],

                [
                    'text'    => 'Cargar Factura',
                    'url'     => 'invoices/create',
                ],
            ],
        ],
        [
            'text'    => 'Créditos',
            'icon'    => 'cart-plus',
            'submenu' => [
                [
                    'text' => 'Simular de credito',
                    'url'  => 'credit/simulate',
                ],
                [
                    'text' => 'Alta',
                    'url'  => 'sales/create?opt=high',
                ],
                [
                    'text' => 'Renovación',
                    'url'  => 'sales/create?opt=renovation',
                ],
                [
                    'text' => 'Motos',
                    'url'  => 'sales/create?opt=scooter',
                ],
                [
                    'text' => 'Lista de Créditos',
                    'url'  => 'credits?opt=credits',
                ],
                [
                    'text' => 'Lista de Créditos de motos',
                    'url'  => 'credits?opt=motos',
                ],
                [
                    'text' => 'Lista de Morosos',
                    'url'  => 'credits?opt=morosos',
                ],
                [
                    'text' => 'Consulta de clientes',
                    'url'  => 'credits/clients/list',
                ],
            ],
        ],
        [
            'text'    => 'Ventas',
            'icon'    => 'cart-plus',
            'submenu' => [
                [
                    'text' => 'Directa',
                    'url'  => 'sales/create?opt=simple',
                ],
                [
                    'text' => 'Seña',
                    'url'  => 'sales/create?opt=sing',
                ],
                [
                    'text' => 'Lista de Ventas',
                    'url'  => 'credits?opt=sales',
                ],
                [
                    'text' => 'Lista de Morosos',
                    'url'  => 'credits?opt=morososSales',
                ],
                [
                    'text' => 'Online',
                    'url'  => 'sales/create?opt=online',
                ],
                 [
                    'text' => 'Otras cuentas',
                    'url'  => 'sales/create?opt=others',
                ],
            ],
        ],
        [
            'text'    => 'Despachos',
            'icon'    => 'truck',
            'submenu' => [
                [
                    'text' => 'Listado',
                    'url'  => 'deliveries',
                ]
            ]
        ],
        // [
        //     'text'    => 'Créditos',
        //     'icon'    => 'list',
        //     'submenu' => [
        //         [
        //             'text' => 'Lista de Créditos',
        //             'url'  => 'credits',
        //         ],
        //     ],
        // ],
        [
            'text'    => 'Permisologia',
            'icon'    => 'list',
            'submenu' => [
                [
                    'text' => 'Roles',
                    'url'  => 'roles',
                ],
            ],
        ],
        [
            'text'    => 'Autorizacion',
            'icon'    => 'key',
            'submenu' => [
                [
                    'text' => 'Generar clave',
                    'url'  => 'tokens/create',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Choose which JavaScript plugins should be included. At this moment,
    | only DataTables is supported as a plugin. Set the value to true
    | to include the JavaScript file from a CDN via a script tag.
    |
    */

    'plugins' => [
        'datatables' => true,
        'select2'    => true
    ],
];
