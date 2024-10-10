<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item @if(Request::is('dashboard.index*')) active @endif">
        <a class="nav-link" href="">
          <i class="mdi mdi-grid-large menu-icon"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>

      <li class="nav-item @if(Request::is('product*')) active @endif">
        <a class="nav-link" href="">
          <i class="fa fa-shopping-cart fa-lg"></i>
          <span class="menu-title"><i class="fa-shopping-cart"></i>Products</span>
        </a>
      </li>
      
      <li class="nav-item @if(Request::is('supplier*')) active @endif">
        <a class="nav-link" href="">
          <i class="fa fa-truck fa-lg"></i>
          <span class="menu-title"><i class="fa-shopping-cart"></i>Supplier</span>
        </a>
      </li>

      <li class="nav-item @if(Request::is('users*')) active @endif">
        <a class="nav-link" href="">
          <i class="fa fa-user-circle fa-lg"></i>
          <span class="menu-title"><i class="fa-shopping-cart"></i>Users</span>
        </a>
      </li>

    </ul>
  </nav>