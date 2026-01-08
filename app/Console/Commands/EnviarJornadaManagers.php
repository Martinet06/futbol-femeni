<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Partit;
use App\Mail\JornadaMail;

class EnviarJornadaManagers extends Command
{
    protected $signature = 'jornada:enviar';
    protected $description = 'Envia la jornada actual als managers';

    public function handle()
    {
        $partit = Partit::whereDate('data_partit', '>', Carbon::now()) // Filtra partits posteriors a avui
            ->orderBy('data_partit', 'asc') // Ordena per la data més propera
            ->first();
        $partits = Partit::with(['equipLocal', 'equipVisitant'])->where('jornada', $partit->jornada)->get();

        // Lògica per obtenir els correus dels managers
        $managers = User::where('role', 'manager')->get();


        foreach ($managers as $manager) {
            Mail::to($manager->email)->send(new JornadaMail($partits));
            $this->info($manager->name . ' ha rebut la jornada.');
        }

        $this->info('La jornada s\'ha enviat correctament als managers.');
    }
}
