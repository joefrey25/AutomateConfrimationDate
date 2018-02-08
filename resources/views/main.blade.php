<!DOCTYPE html>
<html lang="en">
    <head>
        @include('layout.partials.head')
    </head>
<body> 
    <div class="container">
        <div class="header clearfix">
            <nav>
                <ul class="nav nav-pills pull-right">
                <li role="presentation"><a href="/products">Products</a></li>
                <li role="presentation"><a href="/orders">Orders</a></li>
                {{--  <li role="presentation"><a href="#">Products</a></li>  --}}
                </ul>
            </nav>
            <h3 class="text-muted">Belta INC.</h3>
        </div>
    </div>
    @yield('content')
    @include('layout.partials.footer')
</body>
</html>