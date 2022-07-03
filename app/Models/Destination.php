<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $table = 'destinations';
    protected $fillable = [
        'id',
        'longtitude',
        'latitude',
        'name_location',
        'note',
        'category_id',
        'number_contact',
        'location',
        'image_url',
        'is_favourite',
        'is_schedule',
        'is_complete',
        'user_id'
    ];
}
