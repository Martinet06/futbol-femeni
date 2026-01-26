<?php

namespace App\Console\Commands;

use App\Mail\PartitsArbitreMail;
use App\Models\User;
use App\Models\Partit;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class EnviarCorreusArbitres extends Command
{
    protected $signature = 'arbitres:enviar-correus';
    protected $description = 'Envia correus als àrbitres amb els seus partits assignats';

    public function handle()
    {
        $this->info('📨 Iniciant enviament de correus als àrbitres...');

        $arbitres = User::where('role', 'arbitre')->get();

        if ($arbitres->isEmpty()) {
            $this->warn('⚠️  No s\'han trobat àrbitres al sistema.');
            return;
        }

        $enviats = 0;
        $sensePartits = 0;

        foreach ($arbitres as $arbitre) {
            $partits = Partit::where('arbitre_id', $arbitre->id)
                ->with(['equipLocal', 'equipVisitant'])
                ->orderBy('data_partit')
                ->get();

            if ($partits->count() > 0 && $arbitre->email) {
                try {
                    Mail::to($arbitre->email)->send(new PartitsArbitreMail($arbitre, $partits));
                    $enviats++;
                    $this->info("✅ Correu enviat a {$arbitre->email} ({$partits->count()} partits)");
                } catch (\Exception $e) {
                    $this->error("❌ Error enviant a {$arbitre->email}: " . $e->getMessage());
                }
            } else {
                $sensePartits++;
                $this->warn("⚠️  {$arbitre->email} no té partits assignats o no té email");
            }
        }

        $this->newLine();
        $this->info("📊 Resum:");
        $this->info("   - Correus enviats: {$enviats}");
        $this->info("   - Àrbitres sense partits: {$sensePartits}");
        $this->info("   - Total àrbitres: {$arbitres->count()}");
        $this->info('✅ Procés finalitzat!');
    }
}
