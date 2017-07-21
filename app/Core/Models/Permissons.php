<?php
/**
 * Created by PhpStorm.
 * User: Cameron Chilton
 * Date: 02/07/2017
 * Time: 13:07
 */

namespace CyberWorks\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Permissons extends Model
{
    protected $table = 'cw_permissions';

    protected $primaryKey = 'group_id';
}