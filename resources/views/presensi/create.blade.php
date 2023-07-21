@extends('layout.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-ugm text-light">
        <div class="left">
            <a href="/" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Presensi</div>
        <div class="right"></div>
    </div>
    <!-- * App Header --> 
<style> 
    .webcam-capture,
    .webcam-capture video {
        display: inline-block;
        width: 100% !important;
        margin: auto;
        height: auto !important;
        border-radius: 15px;
    }
</style>
@endsection
@section('content')
<div class="row" style="margin-top: 70px">
    <div class="col">
        <input type="hidden" id="lokasi">
        <div class="webcam-capture"></div>
    </div>
</div>
<div class="row">
    @if (empty($checkAbsen->jam_in) || empty($checkAbsen->jam_out))
    @if (empty($checkAbsen->jam_in))
        <div class="col">
        <div class="card-body br-27 pb-1">
            <button id="takeabsen" class="btn bg-ugm btn-block">
            <ion-icon name="camera-outline"></ion-icon>
            Absen Masuk</button>
        </div>
        </div>
    @else
    <div class="col">
        <div class="card-body br-27 pt-1">
            <button id="takeabsenpulang" class="btn bg-ugm btn-block">
            <ion-icon name="camera-outline"></ion-icon>
            Absen Pulang</button>
        </div>
    </div>
    @endif
    @else
    <div class="col">
        <div class="card-body br-27 pt-1">
            Anda Sudah Absen Pulang
        </div>
    </div>
    @endif
    
</div>  
@endsection
@push('myscript')
<script> 
    Webcam.set({
        height: 480,
        width: 640,
        image_format: 'jpeg',
        jpeg_quality: 80
    });

    Webcam.attach('.webcam-capture');

    $("#takeabsen").click(function(e) {
        Webcam.snap(function(uri) {
            image = uri;
        });

        var lokasi = $("#lokasi").val();
        $.ajax({
            type : 'POST',
            url : '/presensi/store',
            dataType: 'json',
            data : {
                _token: "{{ csrf_token()}}",
                image: image,
                lokasi : lokasi
            },
            cache: false,
            success : function(response) {
                if (response) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Anda sudah berhasil absen',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 2000
                    })
                    setTimeout(() => {
                        location.replace('/dashboard');
                    }, 2100);
                }else{
                    Swal.fire({
                        title: 'gagal absen!',
                        text: status[1],
                        icon: 'error',
                        confirmButtonText: 'Okee'
                    })
                }
            }
        })
    });

    $("#takeabsenpulang").click(function(e) {
        Webcam.snap(function(uri) {
            image = uri;
        });

        var lokasi = $("#lokasi").val();
        console.log(lokasi, 'lokasiiii');
        $.ajax({
            type : 'POST',
            url : '/presensi/update',
            dataType: 'json',
            data : {
                _token: "{{ csrf_token()}}",
                image: image,
                lokasi : lokasi
            },
            cache: false,
            success : function(response) {
                if (response.status == 'true') {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: response.message,
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 2000
                    })
                    setTimeout(() => {
                        location.replace('/dashboard');
                    }, 2100);
                }else{
                    Swal.fire({
                        title: 'gagal absen!',
                        text: response.message,
                        icon: 'error',
                        confirmButtonText: 'Okee'
                    })
                }
            }
        })

    });

    var lokasi = $('#lokasi'); 
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
    }

    function successCallback(position) {
        let myLocation = position.coords.latitude + "," + position.coords.longitude;
        $('#lokasi').val(myLocation);
        console.log(myLocation, 'iniii');
    }

    function errorCallback() {
        console.error();
    }

</script>
@endpush

<!---7.8839811,110.3633581-->