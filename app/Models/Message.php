<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_parent_id',
        'sender_agent_id',
        'receiver_parent_id',
        'receiver_agent_id',
        'message'
    ];

    public function senderParent():BelongsTo
    {
        return $this->belongsTo(Parents::class, 'sender_parent_id');
    }

    public function senderAgent():BelongsTo
    {
        return $this->belongsTo(Agent::class, 'sender_agent_id');
    }

    public function receverParent():BelongsTo
    {
        return $this->belongsTo(Parents::class, 'receiver_parent_id');
    }

    public function receverAgent():BelongsTo
    {
        return $this->belongsTo(Agent::class, 'receiver_agent_id');
    }
}
