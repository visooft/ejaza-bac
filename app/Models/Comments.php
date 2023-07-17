<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    public function getCreatedAtAttribute()
    {
        $lang = app()->getLocale() ? app()->getLocale() : 'en';
        return Carbon::createFromTimeStamp(strtotime($this->attributes['created_at']))->locale($lang)->diffForHumans();
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
