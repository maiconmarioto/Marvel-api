<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Marvel Viewer</title>
        <link rel="stylesheet" href="{{ url('lib/picnic.min.css') }}">
        <link rel="stylesheet" href="{{ url('css/style.css') }}">
    </head>
    <body>
        <div class="wrapper">
            @yield('content')
        </div>
    </body>
</html>
