<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homeworld extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'diameter', 'gravity', 'climate', 'population'];

    public function characters() {
      return $this->hasMany(Character::class);
    }
}
