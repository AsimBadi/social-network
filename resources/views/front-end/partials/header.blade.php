<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <div class="me-3">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button"
                data-bs-toggle="minimize">
                <span class="icon-menu"></span>
            </button>
        </div>
        <div>
            <a class="navbar-brand brand-logo" href="">
                <h4 class="mt-1">Social-network</h4>
            </a>
        </div>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-top">
        <ul class="navbar-nav">
            <li class="nav-item fw-semibold d-none d-lg-block ms-0">
                <h1 class="welcome-text"><span class="text-black fw-bold">@yield('page-name')</span></h1>
                <h4 class="welcome-sub-text">@yield('page-title')</h3>
            </li>
        </ul>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item d-none d-lg-block">
                <div class="input-group d-none">
                    <form action="{{ route('logout') }}" method="POST" id="logout-form">
                        @csrf
                        <button class="btn btn-danger" type="button">Logout</button>
                    </form>
                </div>
            </li>
            <li class="nav-item dropdown d-none d-lg-block user-dropdown">
                <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                  <img class="img-xs rounded-circle" src="{{ Auth::user()->image_url }}" alt="Profile image"> </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                  <div class="dropdown-header text-center">
                    <img class="img-xs rounded-circle" src="{{ Auth::user()->image_url }}" alt="Profile image">
                    <p class="mb-1 mt-3 fw-semibold">{{ Auth::user()->username }}</p>
                    <p class="fw-light text-muted mb-0">{{ Auth::user()->email }}</p>
                  </div>
                  <a href="{{ route('profile.index') }}" class="dropdown-item"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> My Profile</a>
                  <a class="dropdown-item" id="logout_btn"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Sign Out</a>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link count-indicator" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                  <i class="icon-bell"></i>
                  <span class="count"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="notificationDropdown">
                  <a class="dropdown-item py-3 border-bottom">
                    <p class="mb-0 fw-medium float-start">You have 4 new notifications </p>
                    <span class="badge badge-pill badge-primary float-end">View all</span>
                  </a>
                  <a class="dropdown-item preview-item py-3">
                    <div class="preview-thumbnail">
                      <i class="mdi mdi-alert m-auto text-primary"></i>
                    </div>
                    <div class="preview-item-content">
                      <h6 class="preview-subject fw-normal text-dark mb-1">Application Error</h6>
                      <p class="fw-light small-text mb-0"> Just now </p>
                    </div>
                  </a>
                  <a class="dropdown-item preview-item py-3">
                    <div class="preview-thumbnail">
                      <i class="mdi mdi-lock-outline m-auto text-primary"></i>
                    </div>
                    <div class="preview-item-content">
                      <h6 class="preview-subject fw-normal text-dark mb-1">Settings</h6>
                      <p class="fw-light small-text mb-0"> Private message </p>
                    </div>
                  </a>
                  <a class="dropdown-item preview-item py-3">
                    <div class="preview-thumbnail">
                      <i class="mdi mdi-airballoon m-auto text-primary"></i>
                    </div>
                    <div class="preview-item-content">
                      <h6 class="preview-subject fw-normal text-dark mb-1">New user registration</h6>
                      <p class="fw-light small-text mb-0"> 2 days ago </p>
                    </div>
                  </a>
                </div>
              </li>
        </ul>
    </div>
</nav>
<script>
    $(document).on('click', '#logout_btn', function (e) { 
            e.preventDefault();
                Swal.fire({
                title: "Are Sure You Want to Logout",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Logout",
                showLoaderOnConfirm: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#logout-form').submit();
                    Swal.fire("Logged Out!", "", "success");
                }else{
                    return;    
                }                
            });
        });
</script>