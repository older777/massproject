<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * @desc Fillable fields
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'status',
        'message',
        'comment',
    ];
}
