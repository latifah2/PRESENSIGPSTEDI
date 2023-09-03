<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>Presensi TEDI UGM</title>
    <meta name="description" content="Mobilekit HTML Mobile UI Kit">
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}" sizes="32x32">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="manifest" href="{{asset('assets/js/web.webmanifest?v='.time()) }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/icon/tedi-icon.png')}}">
</head>

<body class="bg-white">

    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->


    <!-- App Capsule -->
    <div id="appCapsule" class="pt-0">

        <div class="login-form mt-1">
            <div class="section">
            <img src=" {{ asset('assets/img/login/login.webp')}}" alt="image" class="form-image">
            </div>
            <div class="section mt-1">
                <h1>PRESENSI TEDI UGM</h1>
                <h4>Silahkan masuk dengan akun UGM Anda</h4>
            </div>
            <div class="section mt-1 mb-5">
                @php
                   $checkIfErrorLogin = Session::get('massage');
                @endphp
                @if ($checkIfErrorLogin)
                <div class="alert alert-danger" role="alert">
                    {{ $checkIfErrorLogin }}
                  </div>
                @endif
                {{-- untuk mengirim data input nim dan password --}}
                <form action="/proseslogin" method= "POST">
                    @csrf
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="text" name="nim" class="form-control" id="nim" placeholder="NIM">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="password" class="form-control" id="password1" name="password" placeholder="Password">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-links mt-2">
                        <div>
                            <a href="/auth/google">Login With Google</a>
                        </div>
                        <div>
                            <a href="#" class="text-muted" data-toggle="modal" data-target="#exampleModal">Forgot Password?</a>
                        </div>
                    </div>
                    <div class="form-button-group">
                        <button type="submit" class="btn btn-primary btn-block btn-lg">Log in</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Perhatian</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Silahkan Hubungi Admin
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
    <!-- * App Capsule -->



    <!-- ///////////// Js Files ////////////////////  -->
    <!-- Jquery -->
    <script src={{ ( 'assets/js/lib/jquery-3.4.1.min.js')}}></script>
    <!-- Bootstrap-->
    <script src={{ ('assets/js/lib/popper.min.js')}}></script>
    <script src={{ ('assets/js/lib/bootstrap.min.js')}}></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.js"></script>
    <!-- Owl Carousel -->
    <script src={{ ('assets/js/plugins/owl-carousel/owl.carousel.min.js')}}></script>
    <!-- jQuery Circle Progress -->
    <script src={{ ('assets/js/plugins/jquery-circle-progress/circle-progress.min.js')}}></script>
    <!-- Base Js File -->
    <script src="{{asset ('assets/js/base.js?v='.time())}}"></script>
    <script> const baseUrl = "{{ url('/') }}"; </script>
    <script src="{{asset ('assets/js/register.js?v='.time())}}"></script>


</body>

</html>