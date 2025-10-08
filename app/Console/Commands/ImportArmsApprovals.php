<?php

namespace App\Console\Commands;

use App\Models\ArmsApproval;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportArmsApprovals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:arms-approvals';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will update need_approvals table from current db from remote db';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $localMaxId = ArmsApproval::max('id') ?? 0;

        DB::connection('arms_mysql')
            ->table('need_approvals')
            ->select([
                'id',
                'applicant_id',
                'cnic',
                'name',
                'license_no',
                'weapon_no',
                'request_type',
                'action',
                'operator',
                'file_status',
                'url',
                'created_at',
                'updated_at',
            ])
            ->where('id', '>', $localMaxId)
            ->orderBy('id')
            ->chunk(500, function ($rows) {
                $insertData = $rows->map(function ($row) {
                    return [
                        'id' => $row->id,
                        'applicant_id' => $row->applicant_id,
                        'cnic' => $row->cnic,
                        'name' => $row->name,
                        'license_no' => $row->license_no,
                        'weapon_no' => $row->weapon_no,
                        'request_type' => $row->request_type,
                        'action' => $row->action,
                        'operator' => $row->operator,
                        'file_status' => $row->file_status,
                        'url' => $row->url,
                        'created_at' => $row->created_at,
                        'updated_at' => $row->updated_at,
                    ];
                })->toArray();

                ArmsApproval::insert($insertData);
            });

        $this->info('Need approvals imported successfully.');
    }
}
