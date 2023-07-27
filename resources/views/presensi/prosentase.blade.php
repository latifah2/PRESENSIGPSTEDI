@extends('layout.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-ugm text-light">
        <div class="left">
            <a href="/" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Prosentase Kehadiran Bulan {{ date("F-Y") }}</div>
        <div class="right"></div>
    </div>
    <!-- * App Header --> 
@endsection
@section('content')
<div class="container">
  <div class="row" style="margin-top: 70px">
      <div class="col">
        <canvas id="chart-presensi"></canvas>
      </div>
  </div>
  <div class="row mt-4 " style="margin-bottom: 70px">
    <div class="col">
      <table class="table">
        <thead class="bg-ugm">
          <tr>
            <th scope="col" style="color:white;">Tepat Waktu</th>
            <th scope="col" style="color:white;">Terlambat</th>
            <th scope="col" style="color:white;">Cuti</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ $dataChart['tepatWaktu'] }}</td>
            <td>{{ $dataChart['terlambat'] }}</td>
            <td>{{ $dataChart['cuti'] }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
  
@endsection
@push('myscript')
<script src="{{ asset('assets/js/chart.js') }}"></script>

<script>

  const dataFromPHP = <?php echo json_encode($dataChart); ?>;

  const ctx = $('#chart-presensi');
  new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Tepat Waktu', 'Terlambat', 'Cuti'],
      datasets: [{
        label: '# of Votes',
        data: [dataFromPHP.tepatWaktu, dataFromPHP.terlambat, dataFromPHP.cuti],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
@endpush