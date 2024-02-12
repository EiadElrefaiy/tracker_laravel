<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tracked_id',
        'notification',
        'name',
        'deviceID'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tracked()
    {
        return $this->belongsTo(Tracked::class);
    }
}
