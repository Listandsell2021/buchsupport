<?php

namespace App\Events\Admin;


use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeadNoteAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $leadId;
    public int $noteId;
    public string $note;

    /**
     * Create a new event instance.
     */
    public function __construct(int $leadId, int $noteId, string $note)
    {
        $this->leadId   = $leadId;
        $this->noteId   = $noteId;
        $this->note     = $note;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
