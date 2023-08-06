<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseDetials extends Model
{
    use HasFactory;

    protected $table = 'house_detials';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'families' => 'string',
        'individual' => 'string',
        'insurance' => 'string',
        'insurance_value' => 'string',
        'private_house' => 'string',
        'Shared_accommodation' => 'string',
        'animals' => 'string',
        'visits' => 'string',
        'bed_room' => 'string',
        'Bathrooms' => 'string',
        'council' => 'string',
        'kitchen_table' => 'string',
        'smoking' => 'string',
        'camp' => 'string',
        'chalets' => 'string',
        'flight_tickets' => 'string',
        'main_meal' => 'string',
        'housing_included' => 'string',
        'Tour_guide_included' => 'string',
        'breakfast' => 'string',
        'lunch' => 'string',
        'dinner' => 'string',
    ];

    public function getCreatedAtAttribute()
    {
        $lang = app()->getLocale() ? app()->getLocale() : 'en';
        return Carbon::createFromTimeStamp(strtotime($this->attributes['created_at']))->locale($lang)->diffForHumans();
    }
}
