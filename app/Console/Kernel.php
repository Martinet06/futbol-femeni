<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\EnviarCorreusArbitres::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        // Opcional: programar enviament setmanal
        // $schedule->command('arbitres:enviar-correus')->weeklyOn(1, '9:00');
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
