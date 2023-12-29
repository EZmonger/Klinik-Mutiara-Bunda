<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    use HasFactory;
    protected $table = 'pekerjaans';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kodepekerjaan', 
        'nomor', 
        'pekerjaan', 
    ];
}
