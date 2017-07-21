<?php
namespace CyberWorks\Core\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'cw_users';

    protected $fillable = [
        'name',
        'email',
        'connect_id',
        'primaryGroup',
        'secondaryGroups',
        'profilePicture',
        'profileUrl'
    ];
}