@extends('layout.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-ugm text-light">
        <div class="left">
            <a href="/" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Edit Profil</div>
        <div class="right"></div>
    </div>
    <!-- * App Header --> 
@endsection
@section('content')
<div class="container">
<div class="col" style="margin-top: 70px">
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

</div>
<form action="/{{$karyawan->nim}}/updateprofile" method="POST" enctype="multipart/form-data">
  @csrf
  <div class="col" style="margin-bottom :100px">
      <div class="form-group boxed">
          <div class="input-wrapper">
           <label for="">Nama Lengkap</label>
          <input type="text" class="form-control" value="{{$karyawan->nama_lengkap}}" name="nama_lengkap" placeholder="Nama Lengkap" autocomplete="off">
          </div>
      </div>
      <div class="form-group boxed">
          <div class="input-wrapper">
              <label for="">No. HP</label>
              <input type="text" class="form-control" value="{{$karyawan->no_hp}}" name="no_hp" placeholder="No. HP" autocomplete="off">
          </div>
      </div>
      <div class="form-group boxed">
        <div class="input-wrapper">
            <label for="">Jabatan</label>
            <input type="text" class="form-control" value="{{$karyawan->jabatan}}" name="jabatan" placeholder="Jabatan" autocomplete="off">
        </div>
    </div>
      <div class="form-group boxed">
          <div class="input-wrapper">
              <label for="">Password</label>
              <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="off">
          </div>
      </div>
      <div class="form-group boxed">
        <label for="">Gambar Profil</label>
        <div class="custom-file-upload" id="fileUpload1">
            <input type="file" name="image_profile" id="fileuploadInput" accept=".png, .jpg, .jpeg">
            <label for="fileuploadInput">
                <span>
                    <strong>
                        <ion-icon name="cloud-upload-outline" role="img" class="md hydrated" aria-label="cloud upload outline"></ion-icon>
                        <i>Tap to Upload</i>
                    </strong>
                </span>
            </label>
        </div>
      </div>
      <div class="form-group boxed">
          <div class="input-wrapper">
              <button type="submit" class="btn btn-primary btn-block">
                  <ion-icon name="refresh-outline"></ion-icon>
                  Update
              </button>
          </div>
      </div>
  </div>
</form>
</div>
@endsection
@push('myscript')

@endpush