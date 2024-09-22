<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>User area</title>
    <link rel="stylesheet" href="{{ URL::to('css/admin.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    @yield('styles')
</head>
<body>
  @include('users.header')
  <div id="theMain">
    @yield('theMainContent')
  </div>
  <!-- Best way to include scripts: yeild scripts. This way -> each view can has its own -->
  @yield('scripts')
</body>
</html>
