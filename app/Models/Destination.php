<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function storyteller()
    {
        return $this->belongsTo(User::class, 'storyteller_id');
    }

    public function scopeIsMine($query, $user)
    {
        return $user->role === 'user' ? $query->where('storyteller_id', $user->id) : $query;
    }

    public function comments()
    {
        return $this->hasMany(DestinationComment::class);
    }
}
