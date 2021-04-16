@extends('mahasiswa.layout')

@section('content')

    <div class="container mt-5">

        <div class="row justify-content-center align-items-center">
            <div class="card" style="width: 24rem;">
                <div class="card-header">
                    Tambah Mahasiswa
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="post" action="{{ route('mahasiswa.store') }}" id="myForm" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="Nim">Nim</label>
                            <input type="text" name="nim" class="form-control" id="nim" aria-describedby="nim" value="{{old('nim')}}">
                        </div>
                        <div class="form-group">
                            <label for="Nama">Nama</label>
                            <input type="Nama" name="nama" class="form-control" id="nama" ariadescribedby="nama">
                        </div>
                        <div class="form-group">
                            <label for="Foto">Foto</label>
                            <input type="file" name="foto" class="form-control-file" id="Foto" aria-describedby="Foto" value="{{old('foto')}}">
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="text" name="email" class="form-control" id="email" ariadescribedby="email" >
                        </div>
                        {{-- <div class="form-group">
                            <label for="Kelas">Kelas</label>
                            <input type="Kelas" name="kelas" class="form-control" id="kelas" ariadescribedby="kelas">
                        </div> --}}
                        <div class="form-group">
                            <label for="kelas">Kelas</label>
                            <select class="form-control" id="kelas" name="kelas">
                                @foreach ($class as $kls)
                                <option value="{{$kls->id}}" {{old('kelas') == $kls->id ? 'selected' : ''}}>{{$kls->nama_kelas}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jurusan">Jurusan</label>
                            <input type="text" name="jurusan" class="form-control" id="jurusan" aria-describedby="jurusan" value="{{old('jurusan')}}">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="alamat" name="alamat" class="form-control" id="alamat" ariadescribedby="alamat" value="{{old('alamat')}}">
                        </div>
                        <div class="form-group">
                            <label for="tgl_lahir">Tanggal Lahir</label>
                            <input type="date" name="tgl_lahir" class="form-control" id="tgl_lahir" ariadescribedby="tgl_lahir"  value="{{old('tgl_lahir')}}">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
