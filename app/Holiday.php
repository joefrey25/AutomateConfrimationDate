<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Holiday;

class Holiday extends Model
{
    public function isHoliday($date)
    {
        // get all holidays here in db
        $holidays = Holiday::select('holiday_date')->where('holiday_date', 'LIKE', date('Y-m') . '%')->get();
        foreach ($holidays as $holiday) {
            if ($date == $holiday->holiday_date) {
                return true;
            }
        }
        return false;
    }
}
