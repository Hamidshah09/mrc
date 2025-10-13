<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\DomicileStatus;

class ImportDomicileStatus extends Command
{
    protected $signature = 'import:domicile-status';
    protected $description = 'Bulk import domicile status from remote DB';

    public function handle()
    {
        $localMaxId = DomicileStatus::max('id');
        if (!$localMaxId){
            $localMaxId = 0;
        }
        // Explicitly select only the required columns
        DB::connection('remote_mysql')
            ->table('domicile')
            ->select([
                'Dom_id',
                'First_Name',
                'CNIC',
                'Status',
                'receipt_no',
                'remarks',
                'created_at',
            ])
            ->where('Dom_id', '>', $localMaxId)
            ->orderBy('Dom_id')
            ->chunk(500, function ($rows) {
                $insertData = $rows->map(function ($row) {
                    return [
                        'id' => $row->Dom_id,
                        'first_name' => $row->First_Name,
                        'cnic' => $row->CNIC,
                        'status' => $row->Status,
                        'receipt_no' => $row->receipt_no,
                        'remarks' => $row->remarks,
                        'created_at'=>$row->created_at,
                    ];
                })->toArray();

                \App\Models\DomicileStatus::insert($insertData);
            });

        $this->info('records imported successfully.');
    }

}
