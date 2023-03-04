<?php

namespace App\Console\Commands;

use App\Models\Fruit;
use App\Mail\FruitAdded;
use App\Models\FruitFamily;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class FetchFruits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fruits:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fetch fruits though api';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Fruit $fruit)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $response = Http::get('https://fruityvice.com/api/fruit/all');

        if ($response->failed()) {
            Log::error('fruits apis failed to get data', [
                'message' => $response->body()
            ]);
            
            return false;
        }

        $fruits = json_decode($response->body());

        foreach ($fruits as $fruit) {
            if (Fruit::find($fruit->id)) {
                continue;
            }

            $fruitFamily = FruitFamily::firstOrCreate([
                'name' => $fruit->name
            ]);

            $addedFruit = Fruit::create([
                'id' => $fruit->id,
                'name' => $fruit->name,
                'genus' => $fruit->genus,
                'order' => $fruit->order,
                'carbohydrates' => $fruit->nutritions->carbohydrates,
                'protein' => $fruit->nutritions->protein,
                'fat' => $fruit->nutritions->fat,
                'calories' => $fruit->nutritions->calories,
                'sugar' => $fruit->nutritions->sugar,
                'fruit_family_id' => $fruitFamily->id
            ]);

            Mail::to(config('mail.admin_email'))->send(new FruitAdded($addedFruit));
        }
    }
}
