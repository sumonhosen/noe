<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PreUser extends Model
{
    use HasFactory, Notifiable;

    public function getFullNameAttribute()
    {
        return $this->name;
    }
}
