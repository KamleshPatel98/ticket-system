<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'user_id',
        'subject',
        'description',
        'priority',
        'status',
        'assigned_to',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignedAgent()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function comments()
    {
        return $this->hasMany(TicketComment::class, 'ticket_id');
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopePriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeRoleAccess($query, $user)
    {
        if ($user->isAdmin()) {
            return $query;
        } else if ($user->isAgent()) {
            return $query->where('assigned_to', $user->id);
        } 
        return $query->where('user_id', $user->id);
    }

    public static function allowedTransitions()
    {
        return [
            'open' => ['in_progress'],
            'in_progress' => ['closed'],
            'closed' => [], // final state
        ];
    }

    public function canChangeStatus($newStatus)
    {
        $allowed = self::allowedTransitions();
        return in_array($newStatus, $allowed[$this->status] ?? []);
    }

    public function updateStatus($newStatus)
    {
        if (!$this->canChangeStatus($newStatus)) {
            return false;
        }

        $this->status = $newStatus;
        return $this->save();
    }
}
