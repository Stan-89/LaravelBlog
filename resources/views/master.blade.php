<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('theTitle')</title>
    <link rel="stylesheet" href="{{ URL::to('css/main.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    @yield('styles')
</head>
<body>
  @include('parts.header')
  <div id="theMain">
    @yield('theMainContent')
  </div>
  @include('parts.footer')
</body>
</html>
