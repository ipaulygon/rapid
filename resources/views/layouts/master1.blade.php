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
    <!-- <link href="{{asset('css/app.css')}}" rel="stylesheet"> -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/semantic.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/dataTables.jqueryui.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/dataTables.semanticui.css')}}">
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-3.1.1.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/semantic.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dataTables.jqueryui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dataTables.semanticui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.tablesort.js') }}"></script>

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <div class="ui vertical inverted sidebar large visible menu" id="toc">
        <div class="item">
            <img class="ui image" src="{{ asset('pics/logo.png')}}">
        </div>
        <!--Maintenance-->
        <div class="item">
            <div class="header">Maintenance</div>
            <div class="ui vertical accordion inverted menu">
                <div class="item">
                    <a class="title"><i class="dropdown icon"></i>Inventory</a>
                    <div class="content">
                        <div class="ui form">
                            <a href="/maintenance/product-brand" class="item">Product Brand</a>
                            <a href="/maintenance/product-type" class="item">Product Type</a>
                            <a href="/maintenance/product-unit" class="item">Product Unit</a>
                            <a href="/maintenance/product-variance" class="item">Product Variances</a>
                            <a href="/maintenance/product" class="item">Product</a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <a class="title"><i class="dropdown icon"></i>Car Care</a>
                    <div class="content">
                        <div class="ui form">
                            <a href="/maintenance/service-category" class="item">Service Category</a>
                            <a href="/maintenance/service" class="item">Service</a>
                            <a href="/maintenance/inspect-type" class="item">Inspection Type</a>
                            <a href="/maintenance/inspect-item" class="item">Inspection Item</a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <a class="title"><i class="dropdown icon"></i>Sales</a>
                    <div class="content">
                        <div class="ui form">
                            <a href="/maintenance/promo" class="item">Promo</a>
                            <a href="/maintenance/discount" class="item">Discounts</a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <a href="/maintenance/technician" class="title">Technician</a>
                </div>
            </div>
        </div>
        <!--Transaction-->
        <div class="item">
            <div class="header">Transaction</div>
            <div class="ui vertical accordion inverted menu">
                <div class="item">
                    <a class="title"><i class="dropdown icon"></i>Inventory</a>
                    <div class="content">
                        <div class="ui form">
                            <a href="" class="item">Order Supplies</a>
                            <a href="" class="item">Accept Delivery</a>
                            <a href="" class="item">Add Price</a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <a class="title"><i class="dropdown icon"></i>Car Care</a>
                    <div class="content">
                        <div class="ui form">
                            <a href="" class="item">Inspect Vehicle</a>
                            <a href="" class="item">Customize Vehicle</a>
                            <a href="" class="item">Repair Vehicle</a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <a class="title">Sales</a>
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
        <div classs="item">
            <div class="content">
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
        </div>
    </div>
    <div id="main-content" class="pusher">
        <div class="ui inverted top menu" id="top-menu">
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
        </div>
    </div>
    @yield('scripts')
    <script type="text/javascript">
        $('.ui.accordion').accordion();
    </script>
</body>
</html>
