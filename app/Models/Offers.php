<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offers extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    public function ad()
    {
        return $this->belongsTo(Housing::class, 'housings_id');
    }
    public function getCreatedAtAttribute()
    {
        $lang = app()->getLocale() ? app()->getLocale() : 'en';
        return Carbon::createFromTimeStamp(strtotime($this->attributes['created_at']))->locale($lang)->diffForHumans();
    }
}
