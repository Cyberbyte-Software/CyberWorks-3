<?php
namespace CyberWorks\Life\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $table = 'cw_notes';
    protected $appends = [
        'name',
        'profileUrl'
    ];

    protected $fillable = [
        'user_id',
        'message',
        'type',
        'player_id'
    ];

    public function getNameAttribute()
    {
        return $this->user()->name;
    }

    public function getProfileUrlAttribute()
    {
        return $this->user()->profileUrl;
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