<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Kelas;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade as PDF;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $mahasiswa = Mahasiswa::with('kelas')->get();
        // $paginate = Mahasiswa::orderBy('nim', 'desc')->paginate(2);
        // return view('mahasiswa.index', ['mahasiswa' => $mahasiswa, 'paginate' => $paginate]);
        $mahasiswa = Mahasiswa::where([
            ['nim', '!=', null, 'OR', 'nama', '!=', null], //ketika form search kosong, maka request akan null. Ambil semua data di database
            [function ($query) use ($request) {
                if (($keyword = $request->keyword)) {
                    $query->orWhere('nim', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('nama', 'LIKE', '%' . $keyword . '%')->get(); //ketika form search terisi, request tidak null. Ambil data sesuai keyword
                }
            }]
        ])
            ->orderBy('nim', 'desc')
            ->paginate(5);


        $mahasiswa_relasi = Mahasiswa::with('kelas')
            ->orderBy('nim')
            ->paginate(5);
        return view('mahasiswa.index', compact('mahasiswa', 'mahasiswa_relasi'))->with('i', (request()->input('page', 1) - 1) * 5);

        // $mahasiswa = $mahasiswa = DB::table('mahasiswa')->get();
        // $keyword = $request->get('keyword');
        // $mahasiswa = Mahasiswa::all();

        // if($keyword){
        //     $mahasiswa = Mahasiswa::where("nama","LIKE", "%$keyword%")->get();
        //     $posts = Mahasiswa::orderBy('nim', 'desc')->paginate(3); 
        // }

        // $posts = Mahasiswa::orderBy('nim', 'desc')->paginate(3); 
        // return view('mahasiswa.index', compact('mahasiswa','posts','keyword'));
        // with('i', (request()->input('page', 1) - 1) * 5);`
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $class = Kelas::all();
        return view('mahasiswa.create', compact('class'));
        // return view('mahasiswa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required',
            'foto' => 'required|mimes:jpg,png|dimensions:max_width=50px,max_height=50px',
            'nama' => 'required',
            'email' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
            'alamat' => 'required',
            'tgl_lahir' => 'required',
        ]);

        $mahasiswa = new Mahasiswa;
        $mahasiswa->nim = $request->get('nim');
        $mahasiswa->nama = $request->get('nama');
        $mahasiswa->email = $request->get('email');
        $mahasiswa->jurusan = $request->get('jurusan');
        $mahasiswa->alamat = $request->get('alamat');
        $mahasiswa->tgl_lahir = $request->get('tgl_lahir');
        $mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('kelas');
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();

        //Menyimpan gambar
        if ($request->file('foto')) {
            $image_dir = $request->file('foto')->store('images', 'public');
            $mahasiswa->foto_profil = $image_dir;
        }
        
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($nim)
    {
        $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
        return view('mahasiswa.detail', compact('Mahasiswa'));

        /*  $Mahasiswa = Mahasiswa::find($nim);
        return view('mahasiswa.detail', compact('Mahasiswa')); */
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($nim)
    {
        $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
        $class = Kelas::all();
        return view('mahasiswa.edit', compact('Mahasiswa', 'class'));
    }

    public function show_khs($nim)
    {
        $mahasiswa = Mahasiswa::with('kelas', 'matakuliah')->where('nim', $nim)->first();
        // dd($mahasiswa->matakuliah[0]);
        return view('mahasiswa.khs', compact('mahasiswa'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $nim)
    {
        $request->validate([
            'nim' => 'required',
            'foto' => 'nullable|mimes:jpg,png|dimensions:max_width=100,max_height=100',
            'nama' => 'required',
            'email' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
            'alamat' => 'required',
            'tgl_lahir' => 'required',
        ]);
        // Mahasiswa::find($nim)->update($request->all());
        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
        $mahasiswa->nim = $request->get('nim');
        $mahasiswa->nama = $request->get('nama');
        $mahasiswa->email = $request->get('email');
        $mahasiswa->jurusan = $request->get('jurusan');
        $mahasiswa->alamat = $request->get('alamat');
        $mahasiswa->tgl_lahir = $request->get('tgl_lahir');

        //Menyimpan id kelas yang merupakan foreign key
        $kelas = new Kelas();
        $kelas->id = $request->get('kelas');
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();

        //Menghapus gambar profil yang sama
        if ($mahasiswa->foto_profil && file_exists(storage_path('app/public' . $mahasiswa->foto_profil))) {
            Storage::delete('public/' . $mahasiswa->foto_profil);
        }

        //Menyimpan gambar perubahan jika ada
            $image_dir = $request->file('foto')->store('images', 'public');
            $mahasiswa->foto_profil = $image_dir;
        
        $mahasiswa->save();
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($nim)
    {
        Mahasiswa::find($nim)->delete();
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Dihapus');
    }
    public function cetak_khs($nim)
    {
        $mahasiswa = Mahasiswa::with('kelas', 'matakuliah')->where('nim', $nim)->first();
        $pdf = PDF::loadView('mahasiswa.khs_cetak', compact('mahasiswa'));
        return $pdf->stream();
    }
}
