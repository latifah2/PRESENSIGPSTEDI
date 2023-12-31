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
    <div class="col text-center">
        {{-- input id lokasi untuk menampung titik koordinat
            titik koordinat berasal dari js    
        --}}
        <input type="hidden" id="lokasi">
        {{-- untuk area kamera --}}
        <div class="webcam-capture"></div>
        {{-- untuk menampilakan expresi dalam bentuk text --}}
        <h3 id="status" class="mt-2">Loading...</h3>
    </div>
</div>

<div class="row mb-2">
    @if (empty($checkAbsen->jam_in) || empty($checkAbsen->jam_out))
        @if (empty($checkAbsen->jam_in))
            <div class="col">
                <button id="takeabsen" class="btn bg-ugm btn-block btn-absen" style="display: none">
                <ion-icon name="camera-outline"></ion-icon>
                Absen Masuk</button>
            </div>
        @else
        <div class="col">
            <button id="takeabsenpulang" class="btn bg-ugm btn-block btn-absen" style="display: none">
            <ion-icon name="camera-outline"></ion-icon>
            Absen Pulang</button>
        </div>
        @endif
    @else
    <div class="col">
        <div class="card-body br-27 pt-1 text-center">
            Anda Sudah Absen Pulang
        </div>
    </div>
    @endif
    
</div> 
<div id="map" style="width: 100%; height: 300px;"></div> 

@endsection
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js" ></script>
<script src="{{ asset('assets/js/face-api.min.js') }}"></script>

@push('myscript')
<script> 
    
    // untuk mendapatkan current lokasi
    var lokasi = $('#lokasi'); 
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
    }

    function successCallback(position) {
        let myLocation = position.coords.latitude + "," + position.coords.longitude;
        var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 17);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
        var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
        //var circle = L.circle([-7.775295631227814, 110.3737219724515], {
        var rectangle = L.rectangle([
            [-7.7753514048291175 - 0.0003, 110.37387617367335 - 0.0003],
            [-7.7753514048291175 + 0.0003, 110.37387617367335 + 0.0003]
            ], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: 15
        }).addTo(map);
        var polygon = L.polygon([
            [-7.774817272052524, 110.37340413069931],
            [-7.775217233513341, 110.37437777252539],
            [-7.775711537516158, 110.37414039704429],
            [-7.775303603878854, 110.37316943743558]
        ]).addTo(map);
        $('#lokasi').val(myLocation);
        console.log(myLocation);
    }

    function errorCallback() {
        console.error();
    }

    // set live camera
    Webcam.set({
        height: 480,
        width: 640,
        image_format: 'jpeg',
        jpeg_quality: 80
    });
    Webcam.attach('.webcam-capture');

    $('video').attr('id', 'video');

    // untuk prosess checkin absen -> insert data ke table presensi -> jam_in
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
                _token: "{{ csrf_token()}}", // untuk kemanan standar dari laravelnya
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

    $("#takeabsenpulang").click(function(e) {
        Webcam.snap(function(uri) {
            image = uri;
        });

        var lokasi = $("#lokasi").val();
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
    
    // face detection area
    let smileCheck = 0;
    setTimeout(() => {
        const video = document.getElementById('video'); // vidio ini dapet dari elemen yg terbentuk dari library webcam

        Promise.all([
            faceapi.nets.tinyFaceDetector.loadFromUri("{{ asset('assets/js/models') }}"),
            faceapi.nets.faceLandmark68Net.loadFromUri("{{ asset('assets/js/models') }}"),
            faceapi.nets.faceRecognitionNet.loadFromUri("{{ asset('assets/js/models') }}"),
            faceapi.nets.faceExpressionNet.loadFromUri("{{ asset('assets/js/models') }}")
        ]).then(startVideo)

        function startVideo() {
        navigator.getUserMedia(
            { video: {} },
            stream => video.srcObject = stream,
            err => console.error(err)
        )
        }

        video.addEventListener('play', () => { // ketica
            const canvas = faceapi.createCanvasFromMedia(video)
            const displaySize = { width: 640, height: 480}
            faceapi.matchDimensions(canvas, displaySize)
            setInterval(async () => {
                const detections = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceExpressions()
                const resizedDetections = faceapi.resizeResults(detections, displaySize)
                canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)
                if (resizedDetections.length > 0 && resizedDetections[0].detection.score > 0.5 && resizedDetections[0].expressions.happy > 0.5) {
                    document.getElementById('status').innerHTML = 'Wajah terdeteksi, sedang senyum';
                    $('.btn-absen').show();
                    smileCheck = 1;
                }else if (resizedDetections.length > 0 && resizedDetections[0].detection.score > 0.5) {
                    document.getElementById('status').innerHTML = 'Wajah terdeteksi';
                    if (smileCheck) {
                        $('.btn-absen').show();
                    }else{
                        $('.btn-absen').hide();
                    }
                }else {
                    document.getElementById('status').innerHTML = 'Wajah tidak terdeteksi';
                    $('.btn-absen').hide();
                }
            }, 700)
        })
    }, 700);
</script>
@endpush

<!---7.8839811,110.3633581-->