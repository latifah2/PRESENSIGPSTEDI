@extends('layout.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-ugm text-light">
        <div class="left">
            <a href="/" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Pengajuan Cuti dan Izin</div>
        <div class="right"></div>
    </div>
    <!-- * App Header --> 
@endsection
@section('content')
<div class="container">
  <div class="row"  style="margin-top: 70px">
    <div class="col-12">
    <!--<a class="btn btn-primary" href="/contohfiledownload.pdf" role="button"><i class="fa fa-download"></i>&nbsp;&nbsp; Download File</a>-->
    </div>
    <div class="col-12 mt-3">
      <a class="btn btn-primary mb-2" href="/public/downloads/Form-Cuti-Karyawan-TEDI.pdf" role="button"><i class="fa fa-download"></i>&nbsp;&nbsp; Download File</a>
      <form action="/cuti/save" enctype="multipart/form-data" method="POST"> 
        @csrf
        <div class="form-group">
          <label for="">Tanggal Cuti/Izin</label>
          <input type="date" name="tanggal_izin" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="">Upload file Cuti</label>
          <input type="file" name="file_cuti" class="form-control-file" required accept=".pdf" id="exampleFormControlFile1">
        </div>
        <div class="form-group">
        <button type="submit" class="btn btn-primary" role="button"><i class="fa fa-upload"></i>&nbsp;&nbsp; Upload</button>
        </div>
      </form>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Tanggal Pengajuan</th>
            <th scope="col">Tanggal Cuti</th>
            <th scope="col">File Cuti</th>
            <th scope="col">Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($listCuti as $key => $item)
          <tr>
            <th scope="row">{{ $key+1 }}</th>
            <td>{{ $item->created_at }}</td>
            <td>{{ $item->tanggal_izin }}</td>
            <td><a href="{{ asset('public/upload/cuti/'.$item->file_cuti) }}" target="_blank">{{ $item->file_cuti }}</a></td>
            <td>{{ $item->status }}</td>
          </tr>    
          @endforeach
          
        </tbody>
      </table>
    </div>
  </div>
</div>
  
@endsection
@push('myscript')

@endpush