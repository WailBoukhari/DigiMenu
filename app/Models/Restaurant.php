<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Restaurant extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'contact_number',
        'description',
        'owner_id',
        'slug',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($restaurant) {
            $restaurant->slug = Str::slug($restaurant->name);
        });

        static::updating(function ($restaurant) {
            $restaurant->slug = Str::slug($restaurant->name);
        });
    }
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function operators()
    {
        return $this->belongsToMany(User::class, 'operator_restaurant', 'restaurant_id', 'operator_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
