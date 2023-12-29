<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactionheader';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kodeTransaction',
        'no',
        'idDataPasien',
        'hargaTotal',
        'date',
        'status'
    ];
}
