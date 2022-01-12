<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventJoin extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=[
        'user_id','name', 'phone_number', 'email', 'event_id', 'join_type_id', 'values', 'amount', 'payment_status', 'status',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
