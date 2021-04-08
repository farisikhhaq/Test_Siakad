<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Mahasiswa as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model; //Model Eloquent
class Mahasiswa extends Model 
{
    protected $table = 'mahasiswa';
    protected $primaryKey = 'nim';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nim',
        'nama',
        'email',
        'kelas_id',
        'jurusan',
        'alamat',
        'tgl_lahir',
    ];

    public function kelas(){
        return $this->belongsTo(Kelas::class);
    }
};
