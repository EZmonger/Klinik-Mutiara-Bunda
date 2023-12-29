<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tindakan extends Model
{
    use HasFactory;
    protected $table = 'tindakans';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kodetindakan', 
        'nomor', 
        'tindakan', 
        'tujuan', 
        'harga'
    ];
    
}
