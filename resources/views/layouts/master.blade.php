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
        <!--Maintenance-->
        <div class="item">
            <div class="header">Maintenance</div>
            <div class="ui vertical accordion inverted fluid">
                <div class="item">
                    <a id="miTitle" class="title"><i class="dropdown icon"></i>Inventory</a>
                    <div id="miContent" class="content">
                        <div class="ui form">
                            <a href="{{URL::to('/maintenance/supplier')}}" class="item">Supplier</a>
                            <a href="{{URL::to('/maintenance/product-brand')}}" class="item">Product Brand</a>
                            <a href="{{URL::to('/maintenance/product-type')}}" class="item">Product Type</a>
                            <a href="{{URL::to('/maintenance/product-unit')}}" class="item">Product Unit</a>
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
        <!--Transaction-->
        <div class="item">
            <div class="header">Transaction</div>
            <div class="ui vertical accordion inverted">
                <div class="item">
                    <a id="tiTitle" class="title"><i class="dropdown icon"></i>Inventory</a>
                    <div id="tiContent" class="content">
                        <div class="ui form">
                            <a href="{{URL::to('/transaction/order-supply')}}" class="item">Order Supplies</a>
                            <a href="" class="item">Receive Deliveries</a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <a class="title"><i class="dropdown icon"></i>Car Care</a>
                    <div class="content">
                        <div class="ui form">
                            <a href="{{URL::to('/transaction/inspect')}}" class="item">Inspect Vehicle</a>
                            <a href="" class="item">Customize Vehicle</a>
                            <a href="" class="item">Repair Vehicle</a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <a class="title">Payments and Collections</a>
                </div>
            </div>
        </div>
        <!--Queries-->
        <div class="item">
            <div class="header">Queries</div>
        </div>
        <!--Reports-->
        <div class="item">
            <div class="header">Reports</div>
        </div>
        <div class="item">
            <div class="header">Utilities</div>
            <div class="ui vertical accordion inverted">
                <div class="ui form">
                    <a href="{{URL::to('/utilities/data-reactivation')}}" class="item">Data Reactivation</a>
                </div>
            </div>
        </div>
        <div class="ui form">
            <a class="item" href="{{ url('/logout') }}"
                onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
                Logout
            </a>
            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>
    </div>
    <div class="ui vertical inverted sidebar large menu" id="tokhang">
        <div class="item">
            <img class="ui image" src="{{ asset('pics/logo.png')}}">
        </div>
        <!--Maintenance-->
        <div class="item">
            <div class="header">Maintenance</div>
            <div class="ui vertical accordion inverted fluid">
                <div class="item">
                    <a id="smiTitle" class="title"><i class="dropdown icon"></i>Inventory</a>
                    <div id="smiContent" class="content">
                        <div class="ui form">
                            <a href="{{URL::to('/maintenance/supplier')}}" class="item">Supplier</a>
                            <a href="{{URL::to('/maintenance/product-brand')}}" class="item">Product Brand</a>
                            <a href="{{URL::to('/maintenance/product-type')}}" class="item">Product Type</a>
                            <a href="{{URL::to('/maintenance/product-unit')}}" class="item">Product Unit</a>
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
        <!--Transaction-->
        <div class="item">
            <div class="header">Transaction</div>
            <div class="ui vertical accordion inverted">
                <div class="item">
                    <a id="stiTitle" class="title"><i class="dropdown icon"></i>Inventory</a>
                    <div id="stiContent" class="content">
                        <div class="ui form">
                            <a href="{{URL::to('/transaction/order-supply')}}" class="item">Order Supplies</a>
                            <a href="" class="item">Receive Deliveries</a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <a class="title"><i class="dropdown icon"></i>Car Care</a>
                    <div class="content">
                        <div class="ui form">
                            <a href="{{URL::to('/transaction/inspect')}}" class="item">Inspect Vehicle</a>
                            <a href="" class="item">Customize Vehicle</a>
                            <a href="" class="item">Repair Vehicle</a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <a class="title">Payments and Collections</a>
                </div>
            </div>
        </div>
        <!--Queries-->
        <div class="item">
            <div class="header">Queries</div>
        </div>
        <!--Reports-->
        <div class="item">
            <div class="header">Reports</div>
        </div>
        <div class="item">
            <div class="header">Utilities</div>
            <div class="ui vertical accordion inverted">
                <div class="ui form">
                    <a href="{{URL::to('/utilities/data-reactivation')}}" class="item">Data Reactivation</a>
                </div>
            </div>
        </div>
        <div class="ui form">
            <a class="item" href="{{ url('/logout') }}"
                onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
                Logout
            </a>
            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>
    </div>
    <div id="main-content" class="pusher">
        <div class="ui inverted fixed top menu" id="top-menu">
            <div class="ui container">
                <a class="launch icon item" id="sidebar-menu-button">
                    <i class="content icon"></i>
                </a>
                <div class="item">
                    Title goes here
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
