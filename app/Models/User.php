<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Menu;
use App\Models\Restaurant;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'restaurant_id',
        'subscription_expires_at',

    ];
    protected $dates = ['deleted_at'];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'subscription_expires_at' => 'datetime',
    ];

    public function restaurant()
    {
        return $this->belongsToMany(User::class, 'operator_restaurant', 'restaurant_id', 'operator_id');
    }
    public function restaurants()
    {
        return $this->hasMany(Restaurant::class, 'owner_id');
    }

    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }
    public function subscriptionExpired(): bool
    {
        // Retrieve the user's subscription plan
        $subscriptionPlan = $this->subscriptionPlan;

        if (!$subscriptionPlan) {
            // User has no subscription plan
            return true;
        }

        // Retrieve the expiration date of the subscription
        $expirationDate = $this->subscription_expires_at;

        // Check if the expiration date has passed
        return Carbon::now()->greaterThan($expirationDate);
    }
    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::updating(function ($user) {
    //         if ($user->isDirty('subscription_expires_at')) {
    //             $expirationDate = $user->subscription_expires_at;
    //             if ($expirationDate && $expirationDate->isPast()) {
    //                 $user->delete();
    //             }
    //         }
    //     });
    // }
 

    // Define the relationship with the subscription plan

}
