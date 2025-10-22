<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = ['pokemon_id','user_ref'];

    public function pokemon() {
        return $this->belongsTo(Pokemon::class);
    }
}
