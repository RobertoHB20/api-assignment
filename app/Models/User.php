<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class that represent user entity
 */
class User extends Model
{
    use HasFactory;

    protected $table = 'users';


    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'avatar',
    ];

}
