<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    use HasFactory;
    
    protected $guarded = ['id', 'created_at', 'updated_at'];
    
    public function getCreatedAtAttribute()
    {
        $lang = app()->getLocale() ? app()->getLocale() : 'en';
        return Carbon::createFromTimeStamp(strtotime($this->attributes['created_at']))->locale($lang)->diffForHumans();
    }

    public function trave_type()
    {
        return $this->belongsTo(travelType::class, 'travel_type_id');
    }

    public function travel_country()
    {
        return $this->belongsTo(travelCountry::class, 'travel_country_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function language()
    {
        return $this->belongsTo(travelType::class, 'language_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
