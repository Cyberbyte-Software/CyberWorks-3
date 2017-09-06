<?php
/**
 * Created by PhpStorm.
 * User: Cameron Chilton
 * Date: 03/08/2017
 * Time: 15:36
 */

namespace CyberWorks\Life\Models;

use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $appends = [
        'owner',
        'owner_id'
    ];

    protected $fillable = [
        'classname',
        'pid',
        'pos',
        'inventory',
        'gear',
        'dir',
        'active',
        'owned'
    ];

    public function getOwnerAttribute(): string
    {
        return $this->containerOwner()->name;
    }

    public function getOwnerIdAttribute(): int
    {
        return $this->containerOwner()->uid;
    }

    private function containerOwner()
    {
        return $this->hasOne('CyberWorks\Life\Models\Player', 'pid', 'pid')->first();
    }
}
