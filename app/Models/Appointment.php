<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
    'name',
    'phone',
    'email',
    'service',
    'appointment_date',
    'appointment_time',
    'message',
    'salon',
    'status',
];
}
