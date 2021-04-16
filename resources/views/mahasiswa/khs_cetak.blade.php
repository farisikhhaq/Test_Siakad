<!DOCTYPE html>
<html>

<head>
    <title>Sistem Informasi Mahasiswa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
    <h4 class="text-center mt-3">Jurusan Teknologi Informasi - Politeknik Negeri Malang</h4>
    <h3 class="text-center">Kartu Hasil Studi(KHS)</h3>

    <div class="mt-5">
        <h6><b>Nama: </b> {{$mahasiswa->nama}} </h6>
        <h6><b>NIM: </b> {{$mahasiswa->nim}} </h6>
        <h6><b>Kelas: </b> {{$mahasiswa->kelas->nama_kelas}} </h6>
    </div>

    <table class="table table-bordered mt-3">
        <tr>
            <th width="300px">Mata Kuliah</th>
            <th>SKS</th>
            <th>Semester</th>
            <th>Nilai</th>
        </tr>
        @foreach($mahasiswa->matakuliah as $matakuliah)
        <tr>
            <td>{{$matakuliah->nama_matkul}}</td>
            <td>{{$matakuliah->sks}}</td>
            <td>{{$matakuliah->semester}}</td>
            <td>{{$matakuliah->pivot->nilai}}</td>
        </tr>
        @endforeach

    </table>

</body>

</html>