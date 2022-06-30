<?php

namespace App\Exports;

use App\Models\Pemilih;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PemilihExport implements FromQuery, WithMapping, WithHeadings
{    
    use Exportable;

    public function query()
    {
        return Pemilih::query();
    }

    /**
    * @var Pemilih $pemilih
    */
    public function map($pemilih): array
    {
        if ($pemilih->status == 1) {
            $status = 'Sudah voting';
        } else {
            $status = 'Belum voting';
        }

        return [
            $pemilih->username,
            $status,
        ];
    }

    public function headings(): array
    {
        return [
            'Token',
            'Status',
        ];
    }
}

?>