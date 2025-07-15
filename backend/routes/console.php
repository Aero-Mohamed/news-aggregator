<?php

use App\Console\Commands\NewsSyncCommand;
use Illuminate\Support\Facades\Schedule;

Schedule::command(NewsSyncCommand::class)->everyThirtyMinutes();
