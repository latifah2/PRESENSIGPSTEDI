@extends('layout.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-ugm text-light">
        <div class="left">
            <a href="/" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Daftar Keterlambatan</div>
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
            @for ($i=1 ; $i <= 12; $i++) 
              <option value="{{ $i }}" {{date("m") == $i ? 'selected' : ''}}>{{ $namabulan[$i] }}</option>
            @endfor
          </select>
        </div>
      </div>
      <div class="col-12">
        <div class="form-group">
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
      @if (Auth::guard('userAuthentication')->user()->user_status != 'Guest')
      <div class="col-12">
        <div class="form-group">
          <select name="karyawan" id="iKaryawan" class="form-control">
            <option value="">Nama Lengkap</option>
            @foreach($listKaryawan as $karyawan)
              <option value="{{ $karyawan->id }}">{{ $karyawan->nama_lengkap }}</option>
            @endforeach
          </select>
        </div>
      </div>
    @endif
    </div>
    <div class="row">
      <div class="col-12">
        <div class="form-group mt-2">
          <button type="button" class="btn bg-ugm btn-block" id="getdata">
            <ion-icon name="search-outline"></ion-icon>Submit
          </button>
        </div>
      </div>
    </div>
  <div class="row">
    <div class="col-12" id="showterlambat">
      
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
        var karyawan = $("#iKaryawan").val();

        // Pengecekan untuk karyawan yang dipilih
        if (karyawan === "") {
          karyawan = null; // Kirimkan nilai null jika karyawan tidak dipilih
        }
        $.ajax({
          type: 'POST',
          url: '/getterlambat',
          data: {
            _token: "{{csrf_token ()}}",
            bulan:bulan,
            tahun:tahun,
            karyawan:karyawan
          },
          dataType: 'html', 
          cache: false,
          beforeSend: function() {
            $('#showterlambat').html('<b>Sedang memuat data..</b>')
          },
          success: function(respond) {
            $("#showterlambat").html(respond);
          }
        })
      })
   })
</script>
@endpush