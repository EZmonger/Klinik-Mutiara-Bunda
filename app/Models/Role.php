<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $fillable = [
        'koderole',
        'nomor',
        'role',
        'pekerjaanpg', 
        'nakespg',
        'satuanpg',
        'tindakanpg', 
        'obatpg', 
        'regpasienpg', 
        'pasienTranspg', 
        'paymentTranspg',
        'profilepg',
    ];
}
