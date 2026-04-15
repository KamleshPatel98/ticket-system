<?php

namespace App\Helpers;

class TicketHelper
{
    public static function format($ticket)
    {
        return [
            'id' => $ticket->id,
            'subject' => $ticket->subject,
            'description' => $ticket->description,

            'status' => $ticket->status,
            'priority' => $ticket->priority,

            'user_id' => $ticket->user_id,
            'user_name' => $ticket->user ? $ticket->user->name : null,
            'user_email' => $ticket->user ? $ticket->user->email : null,

            'assigned_to' => $ticket->assigned_to,
            'assigned_agent_name' => $ticket->assignedAgent ? $ticket->assignedAgent->name : null,
            'assigned_agent_email' => $ticket->assignedAgent ? $ticket->assignedAgent->email : null,

            'comments_count' => $ticket->comments_count ?? 0,
        ];
    }
}