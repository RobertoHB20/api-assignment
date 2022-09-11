<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class to save information of every request made to external API,
 * in order to save information of last request and it is use to
 * prepare next request
 */
class UsersRequestLogModel extends Model
{
    use HasFactory;

    protected $table = 'users_request_log';

    protected $fillable = [
        'page',
        'status',
    ];

}
