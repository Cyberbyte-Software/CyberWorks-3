<?php
namespace CyberWorks\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'cw_logs';
    protected $appends = [
        'name',
        'profileUrl',
        'playerName',
        'gangName'
    ];

    protected $fillable = [
        'user_id',
        'message',
        'type',
        'player_id',
        'vehicle_id',
        'gang_id',
        'container_id',
        'house_id'
    ];

    public function getNameAttribute()
    {
        return $this->user()->name;
    }

    public function getProfileUrlAttribute()
    {
        return $this->user()->profileUrl;
    }

    public function getPlayerNameAttribute()
    {
        return $this->player()->name;
    }

    public function getGangNameAttribute()
    {
        return $this->gang()->name;
    }

    public function user()
    {
        return $this->hasOne('CyberWorks\Core\Models\User', 'id', 'user_id')->first();
    }

    public function player()
    {
        return $this->hasOne('CyberWorks\Life\Models\Player', 'uid', 'player_id')->first();
    }

    public function gang()
    {
        return $this->hasOne('CyberWorks\Life\Models\Gang', 'id', 'gang_id')->first();
    }
}