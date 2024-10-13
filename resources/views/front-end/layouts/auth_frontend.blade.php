<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/typicons/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
</head>
<body>
  @session('success')
  <div class="toast text-bg-success position-fixed top-0 end-0 mt-5 me-3" style="z-index: 1074;" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-body">
          <div class="d-flex gap-4">
              <span><i class="fa-solid fa-circle-check fa-lg"></i></span>
              <div class="d-flex flex-grow-1 align-items-center">
                  <span class="fw-semibold">{{ session('success') }}</span>
              </div>
          <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
      </div>
  </div>
  @endsession

    @session('error')
    <div class="toast text-bg-danger position-fixed top-0 end-0 mt-5 me-3" style="z-index: 1074;" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body">
          <div class="d-flex gap-4">
            <span><i class="fa-solid fa-circle-exclamation fa-lg"></i></span>
            <div class="d-flex flex-grow-1 align-items-center">
              <span class="fw-semibold">{{ session('error') }}</span>
            </div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
      </div>
    @endsession
    
@yield('content')
@stack('js')
</body>
</html>
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
<script src="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/off-canvas.js') }}"></script>
<script src="{{ asset('assets/js/template.js') }}"></script>
<script src="{{ asset('assets/js/settings.js') }}"></script>
<script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('assets/js/todolist.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
      setTimeout(function () {
          var toastElements = document.querySelectorAll('.toast');
          toastElements.forEach(function (toastElement) {
              if (toastElement) { 
                  var toast = new bootstrap.Toast(toastElement);
                  toast.show();
              }
          });
      }, 100);
  });
  @session('success')
      setTimeout(() => {
          $('.toast').addClass('d-none');
      }, 4000);
  @endsession
  
  @session('error')
      setTimeout(() => {
          $('.toast').addClass('d-none');
      }, 4000);
  @endsession
  </script>
