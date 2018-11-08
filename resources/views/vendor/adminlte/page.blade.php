@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/dist/css/skins/skin-' . config('adminlte.skin', 'blue') . '.min.css')}} ">

    <!-- SweetAlert -->
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css')}} ">

    <!-- Preview Image Bootstrap -->

    <link rel="stylesheet" href="{{ asset('css/preview-image.css')}} ">


    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('css/select2.css')}} ">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/select2-bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker3.min.css') }}">


     <!-- Lightbox -->

    <link rel="stylesheet" href="{{ asset('css/lightbox.css')}} ">


     <!-- Estilos Propios -->

    <link rel="stylesheet" href="{{ asset('css/style.css')}} ">

    <style type="text/css">
        .wrapper{
            overflow-y: hidden !important;
        }
    </style>
    
    @stack('css')
    @yield('css')
@stop

@section('body_class', 'skin-' . config('adminlte.skin', 'blue') . ' sidebar-mini ' . (config('adminlte.layout') ? [
    'boxed' => 'layout-boxed',
    'fixed' => 'fixed',
    'top-nav' => 'layout-top-nav'
][config('adminlte.layout')] : '') . (config('adminlte.collapse_sidebar') ? ' sidebar-collapse ' : ''))

@section('title', 'Cŕeditos')


@section('body')
    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">
            @if(config('adminlte.layout') == 'top-nav')
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="navbar-brand">
                            {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
                        </a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            @each('adminlte::partials.menu-item-top-nav', $adminlte->menu(), 'item')
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
            @else
            <!-- Logo -->
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">{!! config('adminlte.logo_mini', '<b>A</b>LT') !!}</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">{{ trans('adminlte::adminlte.toggle_navigation') }}</span>
                </a>
            @endif
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">

                    <ul class="nav navbar-nav">
                        <li>
                            @if(config('adminlte.logout_method') == 'GET' || !config('adminlte.logout_method') && version_compare(\Illuminate\Foundation\Application::VERSION, '5.3.0', '<'))
                                <a href="{{ url(config('adminlte.logout_url')) }}">
                                    <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
                                </a>
                            @else
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" >
                                    <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
                                </a>
                                <form id="logout-form" action="{{ url(config('adminlte.logout_url')) }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            @endif
                        </li>
                    </ul>
                </div>
                @if(config('adminlte.layout') == 'top-nav')
                </div>
                @endif
            </nav>
        </header>

        @if(config('adminlte.layout') != 'top-nav')
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- Sidebar Menu -->
                <ul class="sidebar-menu" data-widget="tree">
                    @each('adminlte::partials.menu-item', $adminlte->menu(), 'item')
                </ul>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>
        @endif

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @if(config('adminlte.layout') == 'top-nav')
            <div class="container">
            @endif

            <!-- Content Header (Page header)
            <section class="content-header">
                @yield('content_header')
            </section>  Content Superior -->

            <!-- Main content -->
            <section class="content">
                @if(isset($viewInvoice))

                    @yield('content')

                @else

                <div class="box box-primary">
                    <div class="box-header with-border">

                        <h3 class="box-title"> 
                            @if(isset($title))
                                {{ $title }}
                            @else 
                                Accion no permitida 
                            @endif
                        </h3>


                        <div class="box-tools pull-right">

                            <div class="btn-group">
                                <a class="btn btn-sm btn-primary" onclick="history.back(-1)"> <i class="fa fa-chevron-circle-left" aria-hidden="true"></i> Atrás</a>
                                @if(isset($new))
                                    <a class="btn btn-sm btn-success" href="{{ $new }}"> <i class="fa fa-plus-circle" aria-hidden="true"></i> Nuevo </a>
                                @endif
                            </div>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        @yield('content')
                    </div>
                </div>

                @endif
            </section>
            <!-- /.content -->
            @if(config('adminlte.layout') == 'top-nav')
            </div>
            <!-- /.container -->
            @endif
        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- ./wrapper -->
@stop

@section('adminlte_js')

    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>

    <script src="{{ asset('js/dataTable.js')}}"> </script>

    <script src="{{ asset('js/tooltip.js')}}"> </script>

    <script src="{{ asset('js/sweetalert2.min.js')}}"> </script>

    <script src="{{ asset('js/bootstrap-datepicker.min.js')}}"> </script>


    <script src="{{ asset('js/preview-image.js')}}"> </script>


    <script src="{{asset('js/lightbox.js')}}"></script>

    

        @if (alert()->ready())
            <script>
                swal({
                    title: "{!! alert()->message() !!}",
                    text: "{!! alert()->option('text') !!}",
                    type: "{!! alert()->type() !!}"
                });
            </script>
        @endif


        <script>
            $(document).ready(function() {
                $('form.form-inline.form-delete').on('submit', function(e){
                    e.preventDefault();
                    e.stopPropagation();

                    swal({
                        title: "¿Estás seguro de eliminar este registro?",
                        type: "warning",
                        text: "Recuerda que no podrás revertir esta operación!",
                        showCancelButton: true,
                        cancelButtonColor: '#d33',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: "Si, Eliminar!",
                    }).then(function () {
                        swal(
                            'Eliminado!',
                            'El registro ha sido eliminado.',
                            'success'
                        )

                    e.currentTarget.submit();

                    });
                });
            });
        </script>

    @if(count($errors) > 0)
        <script>
        
        swal({
          type: "error",
          title: 'Error!',
          text: "Por favor, verifica los datos en los formularios e intenta nuevamente.",
        });
        
        </script>
    @endif


    @stack('js')
    @yield('js')
@stop
