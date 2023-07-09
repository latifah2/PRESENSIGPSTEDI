@extends('layout.presensi')
@section('content')
<ul class="nav justify-content-center" style="background: #083d62;">
    <li class="nav-item pt-2 pb-2">
        <h2 style="color: #fff;">PRESENSI TEDI UGM</h2>
    </li>
  </ul>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-2">
                @php
                    $waktu = date("H");
                    $ucapanWaktu = '';
                    if ($waktu >= 0 && $waktu < 10 ) {
                        $ucapanWaktu = 'Pagi';
                    } elseif ($waktu >= 10 && $waktu < 14 ) {
                        $ucapanWaktu = 'Siang';
                    } elseif ($waktu >= 14 && $waktu < 18) {
                        $ucapanWaktu = 'Sore';
                    }elseif ($waktu >= 18 && $waktu < 24) {
                        $ucapanWaktu = 'Malam';
                    }
                @endphp
                
                <h2>Selamat {{ $ucapanWaktu }} Latifah Nisa 😊</h2>
                <div class="card p-3" style="background: #083d62;">
                    <h3 class="text-white">Today- {{ date("d M Y") }}</h3>
                    <div class="row">
                        <div class="col-6">
                            <div class="card bg-white mb-3">
                                <div class="card-body">
                                  <h5 class="card-title">Masuk</h5>
                                  <p class="card-text">08:00:00</p>
                                </div>
                              </div>
                        </div>
                        <div class="col-6">
                            <div class="card bg-white mb-3">
                                <div class="card-body">
                                  <h5 class="card-title">Pulang</h5>
                                  <p class="card-text">-</p>
                                </div>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
          <h3 class="text-white">Today- {{ date("d M Y") }}</h3>
          <div class="row">
              <div class="col-6">
                  <div class="card bg-white mb-3">
                      <div class="card-body">
                        <h5 class="card-title">Masuk</h5>
                        <p class="card-text">08:00:00</p>
                      </div>
                    </div>
              </div>
              <div class="col-6">
                  <div class="card bg-white mb-3">
                      <div class="card-body">
                        <h5 class="card-title">Pulang</h5>
                        <p class="card-text">-</p>
                      </div>
                    </div>
              </div>
              <div class="col-6">
                <div class="card bg-white mb-3">
                    <div class="card-body">
                      <h5 class="card-title">Pulang</h5>
                      <p class="card-text">-</p>
                    </div>
                  </div>
               </div>
             <div>
               <div style="width: 50px; height: 50px;"
               class="bg-primary d-inline-block"></div>
               <div style="width: 50px; height: 50px;"
               class="bg-primary d-inline-block"></div>
               <div style="width: 50px; height: 50px;"
               class="bg-primary d-inline-block"></div>
           </div>
          </div>
      </div>
  </div>
</div>
@endsection