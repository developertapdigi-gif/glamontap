<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Schedule::command('app:job-in-progress')->daily()->hourly()->withoutOverlapping();
Schedule::command('app:job-completed')->daily()->hourly()->withoutOverlapping();
Schedule::command('app:subscription-reminder')->daily()->hourly()->withoutOverlapping();