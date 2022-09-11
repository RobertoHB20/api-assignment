<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumersModel extends Model
{
    use HasFactory;

    protected $table = 'consumers';

    protected $fillable = [
        'id',
        'secret',
        'status'
    ];
}
