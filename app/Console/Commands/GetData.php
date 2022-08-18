<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use App\Services\StarWarsService;
use App\Models\Character;
use App\Models\Homeworld;

class GetData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:get';
    protected $starWarsService;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get data from swapi api';

    /**
     * Create a new command instance.
     *
     * @return void
     */
     public function __construct(StarWarsService $starWarsService)
     {
       parent::__construct();
       $this->starWarsService = $starWarsService;
     }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
      Redis::del('characters');
      $charactersData = json_decode($this->starWarsService->getCharacters());
      $characters = Character::newCollection($charactersData->results);

      $homeworlds = [];

      foreach ($characters as $character) {
        if (!isset($homeworlds[$character->homeworld])) {
          $url = explode('api/', $character->homeworld);
          $homeworld = json_decode($this->starWarsService->getCharacterHomeworld($url[1]));
          $homeworlds[$character->homeworld] = $homeworld;
        }
        $character->homeworld = Homeworld::make((array)$homeworlds[$character->homeworld]);
      }

      Redis::set('characters', $characters);

    }
}
