<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accompanying extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
