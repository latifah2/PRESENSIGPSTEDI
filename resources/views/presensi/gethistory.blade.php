
<table class="table">
    <thead class="bg-ugm">
        <tr>
            <th scope="col" style="color:white;">No</th>
            <th scope="col" style="color:white;">Nama</th>
            <th scope="col" style="color:white;">Tanggal</th>
            <th scope="col" style="color:white;">Jam Masuk</th>
            <th scope="col" style="color:white;">Jam Pulang</th>
            <th scope="col" style="color:white;">Total Jam</th>
            <th scope="col" style="color:white;">Status</th>
            <th scope="col" style="color:white;width:130px;">Foto Masuk</th>
            <th scope="col" style="color:white;width:130px;">Foto Pulang</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($history as $key => $item)
        <tr>
            <th scope="row">{{ $key+1 }}</th>
            <td>{{ $item->nama_lengkap }}</td>
            <td>{{ $item->tgl_presensi }}</td>
            <td>{{ $item->jam_in }}</td>
            <td>{{ $item->jam_out }}</td>
            <td>
                @php
                    $detik = strtotime($item->jam_out)-strtotime($item->jam_in);

                    //konversi detik ke format his
                    $jam = floor($detik / 3600);
                    $sisaDetik = $detik % 3600;
                    $menit = floor($sisaDetik / 60);
                    $detikSisa = $sisaDetik % 60;

                    $waktuFormat = sprintf("%02d:%02d:%02d", $jam, $menit, $detikSisa);
                    echo $waktuFormat;
                @endphp
            </td>
            <td>
                <?php 
                if (strtotime($item->jam_in)> strtotime('07:00:00')) {
                    echo "Terlambat";  
                }
                else {
                    echo "Tepat waktu";
                }
                ?>
            </td>
            <td><a href="{{ asset('storage/upload/absensi/'.$item->foto_in) }}" target="_blank">{{ $item->foto_in }}</a></td>
            <td><a href="{{ asset('storage/upload/absensi/'.$item->foto_out) }}" target="_blank">{{ $item->foto_out }}</a></td>
        </tr>
        @endforeach
        
    </tbody>
</table> 