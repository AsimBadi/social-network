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
                        <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#logoutConfirmation">Logout</button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>
{{-- Modal For Logout Confirmation --}}
<div class="modal fade" id="logoutConfirmation" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <i class="fa fa-times-circle x-mark"></i>
                <p class="delete-text">Are you Sure you want to Logout?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="logoutbtn">Logout</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#logoutbtn').click(function (e) { 
            e.preventDefault();
            $('#logout-form').submit();
        });
    });
</script>