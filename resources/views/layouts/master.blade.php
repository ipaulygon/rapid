<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/semantic.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/jquery-ui.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/jquery-ui.structure.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/jquery-ui.theme.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/dataTables.jqueryui.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/dataTables.semanticui.css')}}">

    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-3.1.1.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-ui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/semantic.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dataTables.jqueryui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dataTables.semanticui.js') }}"></script>
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <div class="ui vertical inverted left fixed large visible menu" id="toc">
        <div class="item">
            <img class="ui image" src="{{ asset('pics/logo.png')}}">
        </div>
        <a href="{{URL::to('/dashboard')}}" class="item">Dashboard</a>
        <!--Maintenance-->
        <div class="ui vertical accordion inverted fluid">
            <div style="border-top: 1px solid grey;border-bottom: 1px solid grey;" class="item">
                <div id="mTitle" class="title header">Maintenance</div>
                <div id="mContent" style="margin-top: -2em" class="content">
                    <div class="accordion">
                        <div class="item">
                            <a id="miTitle" class="title"><i class="dropdown icon"></i>Inventory</a>
                            <div id="miContent" class="content">
                                <div class="ui form">
                                    <a href="{{URL::to('/maintenance/supplier')}}" class="item">Supplier</a>
                                    <a href="{{URL::to('/maintenance/product-brand')}}" class="item">Product Brand</a>
                                    <a href="{{URL::to('/maintenance/product-type')}}" class="item">Product Type</a>
                                    <a href="{{URL::to('/maintenance/product-unit')}}" class="item">Product UOM</a>
                                    <a href="{{URL::to('/maintenance/product-variance')}}" class="item">Product Variances</a>
                                    <a href="{{URL::to('/maintenance/product')}}" class="item">Product</a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <a id="msTitle" class="title"><i class="dropdown icon"></i>Car Care</a>
                            <div id="msContent" class="content">
                                <div class="ui form">
                                    <a href="{{URL::to('/maintenance/service-category')}}" class="item">Service Category</a>
                                    <a href="{{URL::to('/maintenance/service')}}" class="item">Service</a>
                                    <a href="{{URL::to('/maintenance/inspect-type')}}" class="item">Inspection Type</a>
                                    <a href="{{URL::to('/maintenance/inspect-item')}}" class="item">Inspection Item</a>
                                </div>
                            </div>
                        </div>
                        <div class="ui form">
                            <a href="{{URL::to('/maintenance/package')}}" class="item">Package</a>
                            <a href="{{URL::to('/maintenance/promo')}}" class="item">Promo</a>
                            <a href="{{URL::to('/maintenance/discount')}}" class="item">Discount</a>
                            <a href="{{URL::to('/maintenance/technician')}}" class="item">Technician</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Transaction-->
        <div class="ui vertical accordion inverted fluid">
            <div style="border-top: 1px solid grey;border-bottom: 1px solid grey;" class="item">
                <div id="tTitle" class="title header">Transaction</div>
                <div id="tContent" style="margin-top: -2em" class="content">
                    <div class="accordion">
                        <div class="item">
                            <a id="tiTitle" class="title"><i class="dropdown icon"></i>Inventory</a>
                            <div id="tiContent" class="content">
                                <div class="ui form">
                                    <a href="{{URL::to('/transaction/order-supply')}}" class="item">Order Supplies</a>
                                    <a href="{{URL::to('/transaction/receive-delivery')}}" class="item">Receive Deliveries</a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <a id="tsTitle" class="title"><i class="dropdown icon"></i>Car Care</a>
                            <div id="tsContent" class="content">
                                <div class="ui form">
                                    <a href="{{URL::to('/transaction/inspect')}}" class="item">Inspect Vehicle</a>
                                    <a href="{{URL::to('/transaction/estimate')}}" class="item">Estimate Cost</a>
                                </div>
                            </div>
                        </div>
                        <div class="ui form">
                            <a href="{{URL::to('/transaction/job')}}" class="item">Job Order</a>
                            <a href="{{URL::to('/transaction/payment')}}" class="item">Payments and Collections</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Queries-->
        <a href="{{URL::to('/queries')}}" class="item">Queries</a>
        <!--Reports-->
        <div class="item">
            <div class="header">Reports</div>
        </div>
        <div class="item">
            <div class="header">Utilities</div>
            <div class="ui vertical accordion inverted">
                <div class="ui form">
                    <a href="{{URL::to('/utilities/data-reactivation')}}" class="item">Data Activation</a>
                </div>
            </div>
        </div>
        <a class="item" href="{{ url('/logout') }}"
            onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
            Logout
        </a>
        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </div>
    <div class="ui vertical inverted sidebar large menu" id="tokhang">
        <a href="{{URL::to('/dashboard')}}" class="item">Dashboard</a>
        <!--Maintenance-->
        <div class="ui vertical accordion inverted fluid">
            <div style="border-top: 1px solid grey;border-bottom: 1px solid grey;" class="item">
                <div id="smTitle" class="title header">Maintenance</div>
                <div id="smContent" style="margin-top: -2em" class="content">
                    <div class="accordion">
                        <div class="item">
                            <a id="smiTitle" class="title"><i class="dropdown icon"></i>Inventory</a>
                            <div id="smiContent" class="content">
                                <div class="ui form">
                                    <a href="{{URL::to('/maintenance/supplier')}}" class="item">Supplier</a>
                                    <a href="{{URL::to('/maintenance/product-brand')}}" class="item">Product Brand</a>
                                    <a href="{{URL::to('/maintenance/product-type')}}" class="item">Product Type</a>
                                    <a href="{{URL::to('/maintenance/product-unit')}}" class="item">Product UOM</a>
                                    <a href="{{URL::to('/maintenance/product-variance')}}" class="item">Product Variances</a>
                                    <a href="{{URL::to('/maintenance/product')}}" class="item">Product</a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <a id="smsTitle" class="title"><i class="dropdown icon"></i>Car Care</a>
                            <div id="smsContent" class="content">
                                <div class="ui form">
                                    <a href="{{URL::to('/maintenance/service-category')}}" class="item">Service Category</a>
                                    <a href="{{URL::to('/maintenance/service')}}" class="item">Service</a>
                                    <a href="{{URL::to('/maintenance/inspect-type')}}" class="item">Inspection Type</a>
                                    <a href="{{URL::to('/maintenance/inspect-item')}}" class="item">Inspection Item</a>
                                </div>
                            </div>
                        </div>
                        <div class="ui form">
                            <a href="{{URL::to('/maintenance/package')}}" class="item">Package</a>
                            <a href="{{URL::to('/maintenance/promo')}}" class="item">Promo</a>
                            <a href="{{URL::to('/maintenance/discount')}}" class="item">Discount</a>
                            <a href="{{URL::to('/maintenance/technician')}}" class="item">Technician</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Transaction-->
        <div class="ui vertical accordion inverted fluid">
            <div style="border-top: 1px solid grey;border-bottom: 1px solid grey;" class="item">
                <div id="stTitle" class="title header">Transaction</div>
                <div id="stContent" style="margin-top: -2em" class="content">
                    <div class="accordion">
                        <div class="item">
                            <a id="stiTitle" class="title"><i class="dropdown icon"></i>Inventory</a>
                            <div id="stiContent" class="content">
                                <div class="ui form">
                                    <a href="{{URL::to('/transaction/order-supply')}}" class="item">Order Supplies</a>
                                    <a href="{{URL::to('/transaction/receive-delivery')}}" class="item">Receive Deliveries</a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <a id="stsTitle" class="title"><i class="dropdown icon"></i>Car Care</a>
                            <div id="stsContent" class="content">
                                <div class="ui form">
                                    <a href="{{URL::to('/transaction/inspect')}}" class="item">Inspect Vehicle</a>
                                    <a href="{{URL::to('/transaction/estimate')}}" class="item">Estimate Cost</a>
                                </div>
                            </div>
                        </div>
                        <div class="ui form">
                            <a href="{{URL::to('/transaction/job')}}" class="item">Job Order</a>
                            <a href="{{URL::to('/transaction/payment')}}" class="item">Payments and Collections</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Queries-->
        <a href="{{URL::to('/queries')}}" class="item">Queries</a>
        <!--Reports-->
        <div class="item">
            <div class="header">Reports</div>
        </div>
        <div class="item">
            <div class="header">Utilities</div>
            <div class="ui vertical accordion inverted">
                <div class="ui form">
                    <a href="{{URL::to('/utilities/data-reactivation')}}" class="item">Data Activation</a>
                </div>
            </div>
        </div>
        <a class="item" href="{{ url('/logout') }}"
            onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
            Logout
        </a>
        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </div>
    <div id="main-content" class="pusher">
        <div class="ui inverted fixed top menu" id="top-menu">
            <div class="ui container">
                <a class="launch icon item" id="sidebar-menu-button">
                    <i class="content icon"></i>
                </a>
                <div class="item">
                    Rapide Sales
                </div>
            </div>
        </div>
        <div class="ui container" id="main">
            @yield('content')
            <br>
            <hr>
            &copy;<?php echo(date('Y')) ?> - RAPIDS 
        </div>
    </div>
    @yield('scripts')
    <script type="text/javascript">
        $('.ui.accordion').accordion();
        $('#sidebar-menu-button').click(function (){
            $('.ui.vertical.inverted.sidebar.large.menu').sidebar('toggle');
        })
    </script>   
</body>
</html>
