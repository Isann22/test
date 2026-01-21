<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Zap\Models\SchedulePeriod as BaseSchedulePeriod;

class SchedulePeriod extends BaseSchedulePeriod
{
    use HasUuids;
}
