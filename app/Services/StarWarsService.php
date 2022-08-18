<?php

namespace App\Services;

use App\Traits\ConsumesExternalServices;
use Illuminate\Support\Facades\Http;

class StarWarsService
{

  public function getCharacters()
  {
    return $response = Http::swapi()->get('/people');
  }

  public function getCharacterHomeworld($homeworld)
  {
    return $response = Http::swapi()->get($homeworld);
  }
}
