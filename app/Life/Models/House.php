<?php

namespace CyberWorks\Life\Models;

use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    protected $primaryKey = 'id';

    protected $appends = [
        'owner',
        'owner_id'
    ];

    protected $fillable = [
        'pos'
    ];

    public $timestamps = false;

    public function getOwnerAttribute(): string
    {
        return $this->houseOwner()->name;
    }

    public function getOwnerIdAttribute(): int
    {
        return $this->houseOwner()->uid;
    }

    private function houseOwner()
    {
        return $this->hasOne('CyberWorks\Life\Models\Player', 'pid', 'pid')->first();
    }
}