<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datapasien extends Model
{
    use HasFactory;
    protected $table = 'datapasiens';
    protected $primaryKey = 'id';
    protected $fillable = [
        'idPasien', 
        'idNakes', 
        'kodepasien', 
        'keluhan',
        'berat',
        'tensi',
        'suhu',
        'heartRate',
        'resRate',
        'saturasiOx'
    ];
}
