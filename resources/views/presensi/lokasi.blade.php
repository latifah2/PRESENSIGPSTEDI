@extends('layout.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-ugm text-light">
        <div class="left">
            <a href="/" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Lokasi</div>
        <div class="right"></div>
    </div>
<style>
#map { height: 700px; }
</style>
    <!-- * App Header --> 
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endsection
@section('content')
<div class="row" style="margin-top: 70px">
    <div class="col">
        <input type="text" id="lokasi">
        <div class="webcam-capture"></div>
    </div>
</div> 
<div class="row mt-2">
    <div class="col">
        <div id="map">
        </div>
    </div>
</div>
@endsection
@push('myscript')
<script>
var lokasi = document.getElementById('lokasi'); 
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
    }

    function successCallback(position) {
        lokasi.value = position.coords.latitude + "," + position.coords.longitude;
        var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 17);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
        var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
        var rectangle = L.rectangle([
            //-7.7753514048291175, 110.37387617367335
            [-7.7753514048291175 - 0.0003, 110.37387617367335 - 0.0003],
            [-7.7753514048291175 + 0.0003, 110.37387617367335 + 0.0003]
            ], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: 5
        }).addTo(map);
        var polygon = L.polygon([
            [-7.774817272052524, 110.37340413069931],
            [-7.775217233513341, 110.37437777252539],
            [-7.775711537516158, 110.37414039704429],
            [-7.775303603878854, 110.37316943743558]
        ]).addTo(map);

        

    }

    function errorCallback() {

    }
</script>
@endpush

<!--AIzaSyBOgmBMhKUtn9GKnZ6MjYad9-1VrnHjGms-->