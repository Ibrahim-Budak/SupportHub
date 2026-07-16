<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use Illuminate\Console\Command;

class CheckSlaBreaches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tickets:check-sla';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Yuksek oncelikli ve 2 saat icinde yanit alamamis ticketlari geciken olarak isaretler';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $breachedTickets = Ticket::where('priority', 'high')
            ->whereNull('first_response_at')
            ->where('sla_breached', false)
            ->where('created_at', '<=', now()->subHours(2))
            ->get();

        if ($breachedTickets->isEmpty()) {
            $this->info('Gecikmis talep bulunamadi.');
            return;
        }

        foreach ($breachedTickets as $ticket) {
            $ticket->update(['sla_breached' => true]);
            $this->warn("Ticket #{$ticket->id} ({$ticket->title}) SLA suresini asti!");
        }

        $this->info($breachedTickets->count() . ' adet ticket geciken olarak isaretlendi.');
    }
}