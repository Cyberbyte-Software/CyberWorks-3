<?php


namespace CyberWorks\Life\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $primaryKey = 'uid';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'cash',
        'bankacc',
        'coplevel',
        'mediclevel',
        'civ_licenses',
        'cop_licenses',
        'med_licenses',
        'civ_gear',
        'cop_gear',
        'med_gear',
        'arrested',
        'adminlevel',
        'donorlevel',
        'blacklist'
    ];

    public function vehicles()
    {
        return $this->hasMany('CyberWorks\Life\Models\Vehicle', 'pid', 'pid')->get();
    }

    public function containers()
    {
        return $this->hasMany('CyberWorks\Life\Models\Container', 'pid', 'pid')->get();
    }

    public function homes()
    {
        return $this->hasMany('CyberWorks\Life\Models\Houses', 'pid', 'pid')->get();
    }
}