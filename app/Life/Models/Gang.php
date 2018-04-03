<?php


namespace CyberWorks\Life\Models;

use Illuminate\Database\Eloquent\Model;

class Gang extends Model
{
    public $timestamps = false;

    protected $appends = [
        'owner_name',
        'owner_id'
    ];

    protected $fillable = [
        'owner',
        'name',
        'bank',
        'active',
        'members',
        'maxmembers'
    ];

    public function getOwnerNameAttribute(): string
    {
        return $this->leader()->name;
    }

    public function getOwnerIdAttribute(): int
    {
        return $this->leader()->uid;
    }

    public function leader()
    {
        return $this->hasOne('CyberWorks\Life\Models\Player', 'pid', 'owner')->first();
    }
}