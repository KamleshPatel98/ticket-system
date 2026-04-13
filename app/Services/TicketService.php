<?php

namespace App\Services;

use App\Models\Ticket;

class TicketService
{
    public function create($data)
    {
        $ticket = Ticket::create($data);

        // future logic here
        // send notification
        // assign agent
        // log activity

        return $ticket;
    }

    public function update($ticket, $data)
    {
        $ticket->update($data);
        return $ticket;
    }

    public function delete($ticket)
    {
        return $ticket->delete();
    }
}