<?php

namespace CyberWorks\Life\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $primaryKey = 'id';

    protected $appends = [
        'owner', 
        'owner_id'
    ];

    protected $fillable = [
        'side',
        'classname',
        'type',
        'pid',
        'alive',
        'active',
        'plate',
        'color',
        'inventory',
        'gear',
        'fuel',
        'damage'
    ];

    public $timestamps = false;

    public function getOwnerAttribute(): string
    {
        return $this->vehicleRegistration()->name;
    }

    public function getOwnerIdAttribute(): int
    {
        return $this->vehicleRegistration()->uid;
    }

    private function vehicleRegistration()
    {
        return $this->hasOne('CyberWorks\Life\Models\Player', 'pid', 'pid')->first();
    }
    
}