<footer class="main-footer">
  <nav>
    <ul>
      <li><a href="{{route('about')}}">About</a></li>
      @if(Auth::check())
      <li><a href="{{route('getLogout')}}">Log out</a></li>
      <li><a href="{{route('theDashboard')}}">Dashboard</a></li>
      @else
      <li><a href="{{route('getLogin')}}">Log in</a></li>
      @endif
    </ul>
  </nav>
</footer>
