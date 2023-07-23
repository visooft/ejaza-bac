<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'status',
        'type',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'image' => 'array',
        'status' => 'boolean',
        'type' => 'string',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
