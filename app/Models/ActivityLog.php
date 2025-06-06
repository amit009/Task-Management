<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    public $fillable = ['user_id', 'action', 'description'];
    public $timestamps = true;
}
