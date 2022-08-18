<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

use Illuminate\Http\Request;

class CharacterController extends Controller
{
  public function characters()
  {
    $characters = Redis::get('characters');

    return view('characters')->with(['characters' => json_decode($characters)]);
  }
}
