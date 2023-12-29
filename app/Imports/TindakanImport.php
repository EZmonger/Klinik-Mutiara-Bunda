<?php

namespace App\Imports;

use App\Models\Tindakan;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

class TindakanImport implements 
ToModel,
WithHeadingRow,
SkipsOnError,
WithValidation,
SkipsOnFailure
{
    use Importable, SkipsErrors;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $no = Tindakan::max('nomor');
        $nomor = str::padLeft($no+1, 3, '0');

        // INPUT DATA TINDAKAN 
        return new Tindakan([
            'kodetindakan'  => "TDK-".$nomor,
            'nomor'         => $nomor,
            'tindakan'      => strtoupper($row['tindakan']),
            'tujuan'        => strtoupper($row['tujuan']),
            'harga'         => $row['harga']
        ]);
    }

    public function rules(): array
    {
        // VALIDASI INPUT EXCEL
        return [
            '*.tindakan'      => ['required', 'unique:tindakans,tindakan'],
            '*.tujuan'    => ['required'],
            '*.harga'     => ['required']
        ];
    }
    public function onFailure(Failure ...$failures)
    {
        
    }
}
