<!DOCTYPE html>
<html lang="bg">
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ URL::to('/') }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/jquery-ui.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/style.css">

    <script src="{{ URL::to('/') }}/js/jquery-3.3.1.min.js"></script>
    <script src="{{ URL::to('/') }}/js/jquery-ui.min.js"></script>
    <script src="{{ URL::to('/') }}/js/bootstrap.min.js"></script>
</head>
<body>

@include('layout.nav')

@include("carousel.index")

<div class="container-fluid">

    <div class="container">
        @yield('content')
    </div>

    <footer class="container">
        <hr>
        <p>&copy; Company 2018</p>
    </footer>

</div>

</body>
</html>