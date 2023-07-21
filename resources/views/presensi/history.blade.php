@extends('layout.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-ugm text-light">
        <div class="left">
            <a href="/" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">History</div>
        <div class="right"></div>
    </div>
    <!-- * App Header --> 
@endsection
@section('content')
  <div class="container">
    <div class="row" style="margin-top: 70px">
      <div class="col-12">
        <div class="form-group">
          <select name="bulan" id="bulan" class="form-control">
            <option value="">Bulan</option>
            @php
            $namabulan = ["", "januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            @endphp
            @for ($i=1 ; $i <= 12; $i++) 
              <option value="{{ $i }}" {{date("m") == $i ? 'selected' : ''}}>{{ $namabulan [$i] }}</option>
            @endfor
          </select>
        </div>
      </div>
      <div class="col-12">
        <div class="form-grup">
          <select name="tahun" id="tahun" class="form-control">
            <option value="">Tahun</option>
            @php
              $tahunmulai = 2022;
              $tahunskrg = date("Y");  
            @endphp
            @for ($tahun =$tahunmulai ; $tahun <= $tahunskrg ; $tahun++) <option value="{{ $tahun }}" {{date("Y") == $tahun ? 'selected' : ''}}>{{ $tahun }}</option>
            @endfor
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="form-group mt-2">
          <button class="btn bg-ugm btn-block" id="getdata">
            <ion-icon name="search-outline"></ion-icon>Submit
          </button>
        </div>
      </div>
    </div>
  <div class="row">
    <div class="col-12" id="showhistory">
      
    </div>
  </div>
</div>
  
@endsection
@push('myscript')
<script>
  $(function() {
      $("#getdata").click(function(e) {
        var bulan = $("#bulan").val();
        var tahun = $("#tahun").val();
        $.ajax({
          type: 'POST',
          url: '/gethistory',
          data: {
            _token: "{{csrf_token ()}}",
            bulan:bulan,
            tahun:tahun,
          },
          dataType: 'html',
          cache: false,
          beforeSend: function() {
            $('#showhistory').html('<b>Sedang memuat data..</b>')
          },
          success: function(respond) {
            $("#showhistory").html(respond);
          }
        })
      })
   })
</script>
@endpush