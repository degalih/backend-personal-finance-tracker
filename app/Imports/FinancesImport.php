<?php

namespace App\Imports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FinancesImport implements
    ToCollection,
    WithHeadingRow
{
    /**
    * @param Collection $collection
    */

    use importable;
    public function collection(Collection $collection): void
    {
        foreach ($collection as $row) {
            // $formattedDate = Carbon::createFromFormat('d/m/y', $row['date']);

            DB::table('finances')->insert([
                'description' => $row['description'],
                'type' => $row['type'],
                'category' => $row['category'],
                'amount' => $row['amount'],
                // Error Parsing
                // 'date' => $formattedDate->format('Y-m-d'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

    }
}
