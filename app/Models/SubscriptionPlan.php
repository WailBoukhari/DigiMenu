<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'price', 'duration_in_days', 'max_qr_scans'];
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
