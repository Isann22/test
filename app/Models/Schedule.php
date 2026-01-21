<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Zap\Models\Schedule as BaseSchedule;

class Schedule extends BaseSchedule
{
    use HasUuids;
}
