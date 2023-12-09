<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InteractionEvent extends Model
{
    use HasFactory;
    protected $fillable = [
        'event_type',
        'user_id',
        'interaction_id',
    ];
}
