@extends('layout.presensi')
@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <ul class="nav justify-content-center" style="background: #083d62;border-radius: 0px 0px 27px 27px;">
        <li class="nav-item pt-2 pb-2 text-center">
          <h3 class="m-0" style="color: #fff;">PRESENSI DIGITAL KARYAWAN TEDI </h3>
          <span style="color: #fff;">Universitas Gadjah Mada</span>
        </li>
      </ul>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 mt-2">
      @php
      $waktu = date("H");
      $ucapanWaktu = '';
      if ($waktu >= 0 && $waktu < 10 ) { $ucapanWaktu='Pagi' ; } elseif ($waktu>= 10 && $waktu < 14 ) {
          $ucapanWaktu='Siang' ; } elseif ($waktu>= 14 && $waktu < 18) { $ucapanWaktu='Sore' ; }elseif ($waktu>= 18 &&
            $waktu < 24) { $ucapanWaktu='Malam' ; } @endphp <h2>Selamat {{ $ucapanWaktu }} Latifah Nisa 😊</h2>
      <div class="card pl-2 pt-2 pr-2 pb-0 br-27" style="background: #083d62;">
        <h3 class="text-white">Today- {{ date("d M Y") }}</h3>
        <div class="row">
          <div class="col-6">
            <div class="card bg-white mb-3 br-27">
              <div class="card-body">
                <h5 class="card-title"> <i class="fa-solid fa-box"></i> Masuk</h5>
                <p class="card-text">{{ empty($infoAbsen->jam_in) ? '-' : $infoAbsen->jam_in }}</p>
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="card bg-white mb-3 br-27">
              <div class="card-body">
                <h5 class="card-title">Pulang</h5>
                <p class="card-text">{{ empty($infoAbsen->jam_out) ? '-' : $infoAbsen->jam_out }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-4 j-center">
      <div class="card mt-3 w-100 text-center bgc-clear c-pointer" onclick="location.replace('presensi/lokasi')">
        <div class="card-body br-27 bgc-blue">
          <i class="fa fa-map-marker" style="font-size: 60px;color:#083d62"></i>
        </div>
        <h3>Lokasi</h3>
      </div>
    </div>
    <div class="col-4 j-center">
      <div class="card mt-3 w-100 text-center bgc-clear c-pointer" onclick="location.replace('presensi/history')">
        <div class="card-body br-27 bgc-blue ">
          <i class="fa fa-history" style="font-size: 60px;color:#083d62"></i>
        </div>
        <h3>History</h3>
      </div>
    </div>
    <div class="col-4 j-center">
      <div class="card mt-3 w-100 text-center bgc-clear c-pointer" onclick="location.replace('presensi/jadwal')" >
        <div class="card-body br-27 bgc-blue">
          <i class="fa fa-calendar" style="font-size: 60px;color:#083d62"></i>
        </div>
        <h3>Jadwal</h3>
      </div>
    </div>
  </div><div class="row">
    <div class="col-4 j-center">
      <div class="card mt-3 w-100 text-center bgc-clear c-pointer" onclick="location.replace('presensi/terlambat')">
        <div class="card-body br-27 bgc-blue">
          <i class="fa fa-hourglass-half" style="font-size: 60px;color:#083d62"></i>
        </div>
        <h3>Terlambat</h3>
      </div>
    </div>
    <div class="col-4 j-center">
      <div class="card mt-3 w-100 text-center bgc-clear c-pointer" onclick="location.replace('cuti')">
        <div class="card-body br-27 bgc-blue ">
          <i class="fa fa-calendar-minus-o" style="font-size: 60px;color:#083d62"></i>
        </div>
        <h3>Cuti & Izin</h3>
      </div>
    </div>
    <div class="col-4 j-center">
      <div class="card mt-3 w-100 text-center bgc-clear c-pointer" onclick="location.replace('presensi/prosentase')" >
        <div class="card-body br-27 bgc-blue">
          <i class="fa fa-pie-chart" style="font-size: 60px;color:#083d62"></i>
        </div>
        <h3>Prosentase</h3>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col">
      <div class="card mt-2">
        <div class="card-header">
          <h3 class="m-0">NOTIFIKASI</h3>
        </div>
        <div class="card-body">
          <blockquote class="blockquote mb-0">
            <!--<p style="font-size: 13px">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
            <footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer>-->
            <div class="tab-content mt-2" style="margin-bottom:100px;">
              <div class="tab-pane fade show active" id="home" role="tabpanel">
                  <ul class="listview image-listview">
                    @foreach ($historybulanini as $d )
                      @php
                      $path = Storage::url('upload/absensi/')
                      @endphp
                      <li>
                          <div class="item">
                              <div class="icon-box bg-primary">
                                  <ion-icon name="finger-print-outline"></ion-icon>
                              </div>
                              <div class="in">
                              <div>{{ date("d-m-Y", strtotime($d->tgl_presensi))}}</div>
                              <div>
                              <span class="badge badge-success">{{ $d-> jam_in }}</span>
                              <span class="badge badge-danger">{{ $presensihariini != null && $d-> jam_out != null ? $d->jam_out : 
                              'Belum Absen'}}</span>
                              </div>
                          </div>
                      </li>
                      @endforeach
                  </ul>
              </div>
          </div>
          </blockquote>
        </div>
      </div>
    </div>
  </div>
  <br /><br /><br /><br /><br />
</div>

@push('scripts')
@endsection