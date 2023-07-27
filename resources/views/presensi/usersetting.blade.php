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
        <div class="col-12 text-center">
            <img src="{{ asset('public/upload/imageprofile/'.$karyawan->image_profile) }}" class="mt-3" style="border-radius:50%;object-fit: cover;width: 230px;height: 230px;" alt="image">
        </div>
        <div class="col-12 mt-3">
           <table class="table table-bordered">
               <tbody>
                 <tr>
                   <th scope="col" style="width: 40%">Nama Lengkap</th>
                   <th scope="col">{{ $karyawan->nama_lengkap }}</th>
                 </tr>
                 <tr>
                    <th scope="col">NIM</th>
                    <th scope="col">{{ $karyawan->nim }}</th>
                 </tr>
                 <tr>
                    <th scope="col">Jabatan</th>
                    <th scope="col">{{ $karyawan->jabatan }}</th>
                 </tr>
                 <tr>
                    <th scope="col">No. HP</th>
                    <th scope="col">{{ $karyawan->no_hp }}</th>
                 </tr>
               </tbody>
             </table>     
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