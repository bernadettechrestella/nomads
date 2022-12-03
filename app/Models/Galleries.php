<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Galleries extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'travel_packages_id', 'image',
    ];

    protected $hidden = [];

    public function travel_packages()
    {
        return $this->belongsTo(TravelPackages::class, 'travel_packages_id', 'id');
    }
}
