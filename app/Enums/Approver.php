<?php
// app/Enums/Approver.php
namespace App\Enums;

enum Approver: int
{
    case DC = 1;
    case ADCG = 2;
    public function label(): string
    {
        return match($this) {
            self::DC => 'Deputy Commissioner',
            self::ADCG => 'Additional Deputy Commissioner General',
        };
    }
}
