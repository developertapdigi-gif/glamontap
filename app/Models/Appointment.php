<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
    'user_id',
    'name',
    'phone',
    'email',
    'service',
    'appointment_date',
    'appointment_time',
    'message',
    'salon',
    'status',
    'appointment_type',
];


public function salonUser()
{
    return $this->belongsTo(User::class, 'salon');
}

 public function getStatusBadge()
    {
        $statuses = [
            'pending' => 'warning',
            'confirmed' => 'primary',
            'completed' => 'success',
            'cancelled' => 'danger'
        ];
        
        return $statuses[$this->status] ?? 'secondary';
    }

    // Get status label
    public function getStatusLabel()
    {
        return ucfirst($this->status);
    }

}
