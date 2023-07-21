@extends('layout.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-ugm text-light">
        <div class="left">
            <a href="/" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Prosentase Kehadiran</div>
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
  <div class="row mt-4">
    <div class="col">
      <table class="table">
        <thead class="bg-ugm">
          <tr>
            <th scope="col" style="color:white;">#</th>
            <th scope="col" style="color:white;">First</th>
            <th scope="col" style="color:white;">Last</th>
            <th scope="col" style="color:white;">Handle</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>@fat</td>
          </tr>
          <tr>
            <th scope="row">3</th>
            <td>Larry</td>
            <td>the Bird</td>
            <td>@twitter</td>
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
  const ctx = $('#chart-presensi');
  new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Tepat Waktu', 'Terlambat', 'Cuti'],
      datasets: [{
        label: '# of Votes',
        data: [12, 19, 3],
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