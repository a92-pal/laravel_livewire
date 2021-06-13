<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postalcode extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function geozones()
    {
        return $this->belongsToMany(Geozone::class);
    }
}
