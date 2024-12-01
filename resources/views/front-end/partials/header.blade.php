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
                <div class="input-group">
                    <form action="{{ route('logout') }}" method="POST" id="logout-form">
                        @csrf
                        <button class="btn btn-danger" type="button" id="logout_btn">Logout</button>
                    </form>
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