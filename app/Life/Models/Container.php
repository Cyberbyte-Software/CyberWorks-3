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
    public $timestamps = false;

    protected $appends = [
        'owner_name',
        'owner_id'
    ];

    protected $fillable = [
        'classname',
        'pos',
        'inventory',
        'gear',
        'dir',
        'active',
        'owned'
    ];

    public function getOwnerNameAttribute(): string
    {
        return $this->owner()->name;
    }

    public function getOwnerIdAttribute(): int
    {
        return $this->owner()->uid;
    }

    public function owner()
    {
        return $this->hasOne('CyberWorks\Life\Models\Player', 'pid', 'pid')->first();
    }
}