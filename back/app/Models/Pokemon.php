<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    protected $fillable = [
        'external_id','name','height','weight','base_experience',
        'sprites','types','abilities','stats'
    ];

    protected $casts = [
        'sprites'   => 'array',
        'types'     => 'array',
        'abilities' => 'array',
        'stats'     => 'array',
    ];

    public function favorites() {
        return $this->hasMany(Favorite::class);
    }
}
