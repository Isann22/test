<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Zap\Models\Schedule as BaseSchedule;
use Zap\Models\SchedulePeriod as BaseSchedulePeriod;

class Schedule extends BaseSchedule
{
    use HasUuids;
}

class SchedulePeriod extends BaseSchedulePeriod
{
    use HasUuids;
}

