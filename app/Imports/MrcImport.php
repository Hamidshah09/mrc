<?php

namespace App\Imports;

use App\Models\MrcStatus;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class MrcImport implements ToModel
{
    public function model(array $row)
    {   
        if (empty($row[0])) {
            return null; // skip if no tracking_id
        }
        $status = ['Certificate Signed', 'Sent for Verification', 'Objection'];
        
        return new MrcStatus([
            'tracking_id' => (string) $row[0],
            'certificate_type' => $row[3],
            'applicant_name'   => $row[4],
            'applicant_cnic'   => $row[5],
            'processing_date'  => $this->transformDate($row[6]),
            'status'  => $status[$row[7]-1],
        ]);
    }

    private function transformDate($value)
    {
        try {
            if (is_numeric($value)) {
                return Date::excelToDateTimeObject($value);
            }
            $clean = preg_replace('/\s?(AM|PM)$/i', '', $value);

            return \Carbon\Carbon::createFromFormat('d-m-Y H:i:s', $clean);
        } catch (\Exception $e) {
            return null;
        }
    }
}
