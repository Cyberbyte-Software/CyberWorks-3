<?php
namespace CyberWorks\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'cw_logs';
    protected $appends = [
        'name',
        'profileUrl',
        'playerName'
    ];

    protected $fillable = [
        'user_id',
        'message',
        'type',
        'player_id',
        'vehicle_id',
        'forum_id',
        'forum_name'
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

    public function user()
    {
        return $this->hasOne('CyberWorks\Core\Models\User', 'id', 'user_id')->first();
    }

    public function player()
    {
        return $this->hasOne('CyberWorks\Life\Models\Player', 'uid', 'player_id')->first();
    }
}