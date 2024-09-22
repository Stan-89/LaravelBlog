<header class="top-nav">
<nav>
  <ul>
    <?php
    /*
        Another way to mark which tab is "active" would be to check the route
        For example:
        Request::is('/user/blog/post*') ? 'class=active' : ''
        ^ (had we structured our site this way) We could have used * so that all
        URLs matching this would get the class [also, no '' on class]
    */
    ?>
    <li><a href="{{route('theDashboard')}}">Dashboard</a></li>
    <li><a href="{{route('showPosts')}}">Posts</a></li>
    <li><a href="{{route('categoriesPage')}}">Categories</a></li>
    <li><a href="{{route('showMessages')}}">Contact Messages</a></li>
    <li><a href="{{route('getLogout')}}">Logout</a></li>
  </ul>
</nav>
</header>
