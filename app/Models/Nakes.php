<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nakes extends Model
{
    use HasFactory;
    protected $table = 'nakes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'idPekerjaan',
        'kodenakes', 
        'idRole',
        'nomor', 
        'nama', 
        'tgllahir', 
        'alamat', 
        'jeniskelamin',
        'pekerjaan', 
        'username', 
        'password', 
        'role'
    ];


}
