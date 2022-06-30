<?php

namespace App\Exports;

use App\Models\Kandidat;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KandidatExport implements FromQuery, WithMapping, WithHeadings
{    
    use Exportable;

    public function query()
    {
        return Kandidat::query();
    }

    /**
    * @var Kandidat $kandidat
    */
    public function map($kandidat): array
    {
        return [
            $kandidat->nama,
            $kandidat->jumlahsuara,
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Kandidat',
            'Jumlah Suara',
        ];
    }
}

?>