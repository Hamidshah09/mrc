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
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value);
            }

            $clean = trim(preg_replace('/\s?(AM|PM)$/i', '', $value));

            // Try multiple formats (dashes or slashes)
            $formats = ['d-m-Y', 'd/m/Y', 'Y-m-d', 'd-m-Y H:i:s', 'd/m/Y H:i:s'];

            foreach ($formats as $format) {
                try {
                    return \Carbon\Carbon::createFromFormat($format, $clean);
                } catch (\Exception $e) {
                    continue;
                }
            }

            // Last fallback: let Carbon guess
            return \Carbon\Carbon::parse($clean);

        } catch (\Exception $e) {
            return null;
        }
    }

}
