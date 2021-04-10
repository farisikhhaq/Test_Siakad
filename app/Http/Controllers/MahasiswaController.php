<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Kelas; 

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $mahasiswa = Mahasiswa::with('kelas')->get();
        $paginate = Mahasiswa::orderBy('id_mahasiswa', 'asc')->paginate(6);
        return view('mahasiswa.index',['mahasiswa'=> $mahasiswa, 'paginate'=>$paginate]);

        $mahasiswa_relasi = Mahasiswa::with('kelas')
            ->orderBy('id_mahasiswa', 'asc')
            ->paginate(6);
        return view('mahasiswa.index', compact('mahasiswas', 'mahasiswas_relasi'));

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

    // public function search(){
    //     $search_text = $_GET['query'];
    //     $cari = Mahasiswa::where('nama','LIKE', '%'.$search_text.'%')->get();
    //     return view('mahasiswa.search',compact('cari'));
}