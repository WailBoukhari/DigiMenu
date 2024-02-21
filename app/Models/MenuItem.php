<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class MenuItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
