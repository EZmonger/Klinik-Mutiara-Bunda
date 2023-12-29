<?php

namespace App\Imports;

use App\Models\Obat;
use App\Models\Satuan;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class ObatImport implements 
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
        $no = Obat::max('nomor');
        $nomor = str::padLeft($no+1, 3, '0');
        
        // MELAKUKAN PENGIMPUTAN SATUAN YANG BELUM TERDAFTAR 
        $satuanid = Satuan::where('satuan', $row['satuan'])->pluck('id')->first();
        if ($satuanid == null) {
            $noSatuan = Satuan::max('nomor');
            $nomorSatuan = str::padLeft($noSatuan+1, 2, '0');

            $data = [
                'kodesatuan' => "SAT-".$nomorSatuan,
                'nomor'         => $nomorSatuan,
                'satuan'     => strtoupper($row['satuan']),
            ];

            $createdSatuan = Satuan::create($data);
            $satuanid = $createdSatuan->id;
        }
        
        // INPUT DATA OBAT 
        return new Obat([
            'kodeobat'  => "OBT-".$nomor,
            'idSatuan'    => $satuanid,
            'nomor'     => $nomor,
            'obat'      => strtoupper($row['obat']),
            'stock'     => $row['stock'],
            'harga'     => $row['harga']
        ]);
    }

    public function rules(): array
    {
        // VALIDASI INPUT EXCEL 
        return [
            '*.obat'      => ['required', 'unique:obats,obat'],
            '*.satuan'    => ['required'],
            '*.stock'     => ['required'],
            '*.harga'     => ['required']
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        
    }

    
}
