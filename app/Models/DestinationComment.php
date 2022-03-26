<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DestinationComment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function parent()
    {
        return $this->belongsTo(DestinationComment::class, 'parent_id');
    }

    public function responder()
    {
        return $this->belongsTo(User::class, 'responder_id');
    }

    public function scopeIsMine($query, $user)
    {
        return $user->role === 'user' ? $query->whereHas('destination', function ($query1) use ($user) {
            $query1->where('storyteller_id', $user->id);
        }) : $query;
    }
}
