<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Laravel Shop') - Laravel</title>
    <!-- 样式 -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <!-- {{route_class()}}是从helpers.php中自定义的（blade中自定义方法的创建方式） -->
    <div id="app" class="{{ route_class() }}-page">
        @include('layouts._header')
        <div class="container">
            @yield('content')
        </div>
        @include('layouts._footer')
    </div>
    <!-- JS 脚本 -->
    <!-- mix()是laravel mix的前端处理功能，它会将JS/CSS等存在的各种依赖打包成一个文件，让浏览器可以一次请求 -->
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>