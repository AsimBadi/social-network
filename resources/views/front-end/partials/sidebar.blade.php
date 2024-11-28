<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item @if(Request::is('profile*')) active @endif">
        <a class="nav-link" href="{{ route('profile.index') }}">
          <i class="fa fa-user-circle fa-lg"></i>
          <span class="menu-title"><i class="fa-shopping-cart"></i>Profile</span>
        </a>
      </li>

      <li class="nav-item @if(Request::is('post*')) active @endif">
        <a class="nav-link" href="{{ route('posts.index') }}">
          <i class="fa fa-envelope-o fa-lg"></i>
          <span class="menu-title"><i class="fa-envelope-o"></i>Create Post</span>
        </a>
      </li>
      
      <li class="nav-item @if(Request::is('search*')) active @endif">
        <a class="nav-link" href="{{ route('search.view') }}">
          <i class="fa fa-search fa-lg"></i>
          <span class="menu-title"><i class="fa-envelope-o"></i>Search</span>
        </a>
      </li>

      <li class="nav-item @if(Request::is('requests*')) active @endif" style="position: relative;">
        <a class="nav-link" href="{{ route('follow.requests') }}">
          <div style="position: relative; display: inline-block;">
            <i class="fa-solid fa-user-group fa-lg"></i>
            <!-- Small icon with count on top -->
            <span class="badge badge-pill badge-danger count-badge">
              6
            </span>
          </div>
          <span class="menu-title"><i class="fa-envelope-o"></i> Requests</span>
        </a>
      </li>

      <li class="nav-item @if(Request::is('requests*')) active @endif">
        <a class="nav-link" href="{{ route('follow.requests') }}">
          <i class="fa-solid fa-house fa-lg"></i>
          <span class="menu-title"><i class="fa-envelope-o"></i>Explore</span>
        </a>
      </li>
    </ul>
  </nav>