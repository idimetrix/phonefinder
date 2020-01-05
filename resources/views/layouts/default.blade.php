<!doctype html>
<html lang="{{env('HTML_LANG')}}">
<head>
    @include('includes.head')
</head>
<body data-csrf-token="{{ csrf_token() }}">

    <header class="row">
        @include('includes.header')
    </header>

    <div class="container-fluid">
        <div class=" row" >
            @yield('top-element')
        </div>
    </div>

    <div class="gray-bg container">
        <div  id="app" class="row ">
            @yield('content')
        </div>

        <footer class="row footer">
            @include('includes.footer')
        </footer>

        @include('includes.foot')
    </div>

{!! isset($google_analytics->value) ? $google_analytics->value : '' !!}

</body>
</html>