<?php

namespace App\Events;

use App\Models\AuditDepense;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AuditUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $stats;
    public array $lastEntry;

    public function __construct()
    {
        $this->stats = [
            'insertions'    => AuditDepense::where('type_action', 'Ajout')->count(),
            'modifications' => AuditDepense::where('type_action', 'Modification')->count(),
            'suppressions'  => AuditDepense::where('type_action', 'Suppression')->count(),
        ];

        $last = AuditDepense::orderBy('date_operation', 'desc')->first();
        $this->lastEntry = $last ? $last->toArray() : [];
    }

    public function broadcastOn(): array
    {
        return [new Channel('audit')];
    }

    public function broadcastAs(): string
    {
        return 'audit.updated';
    }
}
