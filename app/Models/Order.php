<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * @desc Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'status',
        'message',
        'comment',
    ];

    /**
     * @desc приведение дат к виду Y.m.d H:i:s
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'date:Y.m.d H:i:s',
        'updated_at' => 'date:Y.m.d H:i:s',
    ];
}
