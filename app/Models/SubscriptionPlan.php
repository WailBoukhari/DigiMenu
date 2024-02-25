<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'create_limit',
        'scan_limit',
        'dish_creation_limit'
    ];    public function users()
    {
        return $this->hasMany(User::class);
    }
}
