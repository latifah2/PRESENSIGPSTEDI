@extends('layout.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-ugm text-light">
        <div class="left">
            <a href="/" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Setting User</div>
        <div class="right"></div>
    </div>
    <!-- * App Header --> 
@endsection
@section('content')
<div class="container">
    <div class="row" style="margin-top: 70px; margin-bottom: 100px">
       <div class="col-md-12 mb-2">
        @if (!empty(Session::get('error')))
        <div class="alert alert-danger" role="alert">
        {{ Session::get('error') }}
        </div>
     @endif
     
     @if (!empty(Session::get('success')))
     <div class="alert alert-success mb-2" role="alert">
        {{ Session::get('success') }}
    </div>
     @endif
            <h3>Tambah User</h3>
            <div class="card p-3">
                <form action="/user-setting/add" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="inputAddress">NIM</label>
                        <input type="text" class="form-control" id="" name="nim" placeholder="10001231231">
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Nama Lengkap</label>
                        <input type="text" class="form-control" id="" name="nama_lengkap" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Email</label>
                        <input type="email" class="form-control" id="" name="email" placeholder="a@g.com">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputAddress">Jabatan</label>
                            <input type="text" class="form-control" id="" name="jabatan" placeholder="1234 Main St">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputAddress2">No HP</label>
                            <input type="text" class="form-control" id="" name="no_hp" placeholder="">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
       </div>  
       <div class="col-12 mt-3">
           <h3>List User Tamu</h3>
            <table class="table">
                <thead class="bg-ugm">
                   <tr>
                       <th style="color:white">No</th>
                       <th style="color:white">NIM</th>
                       <th style="color:white">Nama Lengkap</th>
                       <th style="color:white">Jabatan</th>
                       <th style="color:white">No. HP</th>
                   </tr>
               </thead>
               <tbody>
                   @foreach ($listUserTamu as $key => $item)
                       <tr>
                           <td>{{ $key+1 }}</td>
                           <td>{{ $item->nim }}</td>
                           <td>{{ $item->nama_lengkap }}</td>
                           <td>{{ $item->jabatan }}</td>
                           <td>{{ $item->no_hp }}</td>
                       </tr>
                   @endforeach
               </tbody>
           </table>
       </div>
</div>

    
@endsection
@push('myscript')

@endpush