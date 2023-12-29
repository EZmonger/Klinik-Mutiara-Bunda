<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;
    protected $table = 'obats';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kodeobat', 
        'idSatuan',
        'nomor', 
        'obat', 
        'stock', 
        'harga'
    ];
    
}
