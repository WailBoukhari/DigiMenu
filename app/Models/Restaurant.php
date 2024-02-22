<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class Restaurant extends Model implements HasMedia
{
    use HasFactory ,InteractsWithMedia;
    protected $fillable = [
        'name',
        'address',
        'contact_number',
        'description',
        'image',
        'video',
    ];
    public function operators()
    {
        return $this->belongsToMany(User::class, 'operator_restaurant', 'restaurant_id', 'operator_id');
    }

}
