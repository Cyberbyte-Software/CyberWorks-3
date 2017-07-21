<?php
/**
 * Created by PhpStorm.
 * User: Cameron Chilton
 * Date: 21/07/2017
 * Time: 13:06
 */

namespace CyberWorks\Life\Models;

use Illuminate\Database\Eloquent\Model;

class Gang extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'owner',
        'name',
        'bank',
        'active',
        'maxmembers'
    ];

    public function owner()
    {
        return $this->hasOne('CyberWorks\Life\Models\Player', 'pid', 'owner')->get();
    }
}