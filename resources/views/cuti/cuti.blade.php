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
  @if (Auth::guard('userAuthentication')->user()->user_status === 'Guest')
  <div class="row"  style="margin-top: 70px">
    <div class="col-12">
    <!--<a class="btn btn-primary" href="/contohfiledownload.pdf" role="button"><i class="fa fa-download"></i>&nbsp;&nbsp; Download File</a>-->
    </div>
    <div class="col-12 mt-3">
      <a class="btn btn-primary mb-2" href="/public/downloads/Form-Cuti-Karyawan-TEDI.pdf" role="button"><i class="fa fa-download"></i>&nbsp;&nbsp; Download File</a>
      {{-- form input tgl cuti dan file cuti akan dikirimkan ke fungsi save di cutiController melalui link action
       enctype="multipart/form-data" digunakan agar input yg bertipe file dpt dibaca fungsi save --}}
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
  @endif
  <div class="row" @if (Auth::guard('userAuthentication')->user()->user_status === 'Admin') style = "margin-top: 80px" @endif> 
    @if (!empty(Session::get('error')))
    <div class="alert alert-danger" role="alert">
    {{ Session::get('error') }}
    </div>
 @endif
 
 @if (!empty(Session::get('success')))
 <div class="alert alert-success" role="alert">
    {{ Session::get('success') }}
</div>
 @endif
    <div class="col-12" style="padding-bottom: 100px">
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead class="bg-ugm" >
            <tr>
              <th class="text-white">No</th>
              @if (Auth::guard('userAuthentication')->user()->user_status === 'Admin')
              <th class="text-white">Nama Lengkap</th>
              @endif
              <th class="text-white">Tanggal Pengajuan</th>
              <th class="text-white">Tanggal Cuti</th>
              <th class="text-white">File Cuti</th>
              <th class="text-white">Status</th>
              @if (Auth::guard('userAuthentication')->user()->user_status === 'Admin')
              <th class="text-white">Approval</th>
              @endif
            </tr>
          </thead>
          <tbody class="text-center">
            @foreach ($listCuti as $key => $item)
            <tr>
              <th scope="row">{{ $key+1 }}</th>
              @if (Auth::guard('userAuthentication')->user()->user_status === 'Admin')
              <td>{{ $item->nama_lengkap }}</td>
              @endif
              <td>{{ $item->created_at }}</td>
              <td>{{ $item->tanggal_izin }}</td>
              <td><a href="{{ asset('public/upload/cuti/'.$item->file_cuti) }}" target="_blank">{{ $item->file_cuti }}</a></td>
              <td>
                  @if (strtolower($item->status) === 'pending')
                      <span class="badge badge-warning">Pending</span>
                  @elseif (strtolower($item->status) === 'approved')
                      <span class="badge badge-success">Approved</span>
                  @elseif (strtolower($item->status) === 'rejected')
                      <span class="badge badge-danger">Rejected</span>
                  @endif
              </td>
              @if (Auth::guard('userAuthentication')->user()->user_status === 'Admin')
              <td>
                <form action="/cuti/update-status-cuti" class="mb-1" method="POST">
                  @csrf
                  <input type="hidden" name="id" value="{{ $item->id }}">
                  <input type="hidden" name="status" value="Approved">
                  <button type="submit" class="btn btn-primary" style="width: 100px">Approved</button> 
                </form>
                <form action="/cuti/update-status-cuti" class="mb-1" method="POST">
                  @csrf
                  <input type="hidden" name="id" value="{{ $item->id }}">
                  <input type="hidden" name="status" value="Rejected">
                  <button type="submit" class="btn btn-danger" style="width: 100px">Rejected</button>
                </form>
              </td>
              @endif
            </tr>    
            @endforeach
            
          </tbody>
        </table>
      </div>
      
    </div>
  </div>
</div>
  
@endsection
@push('myscript')

@endpush