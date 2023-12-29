<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class TransactionExport implements FromCollection, 
WithHeadings, 
ShouldAutoSize,
WithCustomStartCell ,
WithEvents
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $fromDate;
    protected $toDate;

    function __construct($from_date,$to_date)
    {
        $this->fromDate = $from_date;
        $this->toDate = $to_date;
    }

    public function collection()
    {
        // PENGISIAN DATA KE EXCEL
        $data = Transaction::join('datapasiens', 'transactionheader.idDataPasien', '=', 'datapasiens.id')
        ->join('pasiens', 'datapasiens.idPasien', '=', 'pasiens.id')
        ->join('nakes', 'datapasiens.idNakes', '=', 'nakes.id')
        ->where('transactionheader.created_at', '>=', $this->fromDate)
        ->where('transactionheader.created_at', '<=', $this->toDate)
        ->select(
        'kodeTransaction', 
        'pasiens.nama as namaPasien',
        'nakes.nama as namaNakes', 
        'datapasiens.keluhan',
        'transactionheader.created_at as date',
        'transactionheader.status',
        'hargaTotal')
        ->get();

        

        return $data;
    }

    public function headings(): array{
        // HEADING 
        return [
            ['Ringkasan Transaksi'],
            [' '],
            ['Kode Transaksi',
            'Nama Pasien',
            'Nama Tenaga Kesehatan',
            'Keluhan',
            'Tanggal',
            'Status',
            'Harga']
        ];
    }

    public function registerEvents(): array{
        return [
            AfterSheet::class => function (AfterSheet $event){
                $event->sheet->getStyle('A1:G1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);
            }
        ];
    }
    public function startCell(): string
    {
        return 'A1';
    }
}
