<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Housing extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    // public function getCreatedAtAttribute()
    // {
    //     $lang = app()->getLocale() ? app()->getLocale() : 'en';
    //     return Carbon::createFromTimeStamp(strtotime($this->attributes['created_at']))->locale($lang)->diffForHumans();
    // }

    protected $casts = [
        'street_id' => 'string',
        'category_id' => 'string',
        'price' => 'string',
        'group_travel' => 'string',
        'indivdual_travel' => 'string',
        'hour_work' => 'string',
        'ticket_count' => 'string',
        'hour_price' => 'string',
        'go' => 'string',
        'back' => 'string',
        'count_days' => 'string',
        'passengers' => 'string',
        'license_number' => 'string',
        'from' => 'string',
        'to' => 'string',
        'language_id' => 'string',
        'iban' => 'string',
        'moodle' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function Country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function street()
    {
        return $this->belongsTo(Streets::class, 'street_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
