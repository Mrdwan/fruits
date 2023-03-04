<?php

namespace Tests\Feature;

use App\Models\Fruit;
use App\Models\FruitFamily;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function it_can_render_fruits()
    {
        $name = $this->faker->word();

        Fruit::factory()->create(['name' => $name]);
        
        $this->get('/')
            ->assertStatus(200)
            ->assertSeeText($name);
    }

    /** @test */
    public function it_can_filter_by_name()
    {
        $correctName = 'correct name';
        $wrongName = 'wrong name';
        Fruit::factory(5)->create(['name' => $wrongName]);
        Fruit::factory()->create(['name' => $correctName]);
        
        $this->get("/?name={$correctName}")
            ->assertStatus(200)
            ->assertSee($correctName)
            ->assertDontSee($wrongName);
    }

    /** @test */
    public function it_can_filter_by_family()
    {
        $correctFruitName = 'correct fruit name';
        $wrongFruitName = 'wrong fruit name';
        $correctFamilyName = 'correct name';
        $correctFamily = FruitFamily::factory()->create(['name' => $correctFamilyName]);
        
        $wrongFamilyName = 'wrong name';
        $wrongFamily = FruitFamily::factory()->create(['name' => $wrongFamilyName]);

        Fruit::factory(5)->create(['fruit_family_id' => $wrongFamily->id, 'name' => $wrongFruitName]);
        Fruit::factory()->create(['fruit_family_id' => $correctFamily->id, 'name' => $correctFruitName]);
        
        $this->get("/?family={$correctFamily->id}")
            ->assertStatus(200)
            ->assertSee($correctFruitName)
            ->assertDontSee($wrongFruitName);
    }

    /** @test */
    public function it_can_filter_by_name_and_family()
    {
        $correctFamilyName = 'correct family name';
        $correctFamily = FruitFamily::factory()->create(['name' => $correctFamilyName]);
        
        $wrongFamilyName = 'wrong family name';
        $wrongFamily = FruitFamily::factory()->create(['name' => $wrongFamilyName]);

        $correctFruitName = 'correct Fruit name';
        $wrongFruitName = 'wrong Fruit name';
        Fruit::factory(5)->create(['fruit_family_id' => $wrongFamily->id, 'name' => $wrongFruitName]);
        Fruit::factory()->create(['fruit_family_id' => $correctFamily->id, 'name' => $correctFruitName]);
        
        $this->get("/?family={$correctFamily->id}&name={$correctFruitName}")
            ->assertStatus(200)
            ->assertSee($correctFruitName)
            ->assertDontSee($wrongFruitName);
    }

    /** @test */
    public function it_shows_no_record_message_if_filter_not_correct()
    {
        $family = FruitFamily::factory()->create();

        $fruitName = 'wrong Fruit name';
        Fruit::factory(5)->create(['fruit_family_id' => $family->id, 'name' => $fruitName]);
        
        $this->get("/?family=99999&name=not found name")
            ->assertStatus(200)
            ->assertDontSee($fruitName)
            ->assertSee('no Fruits found');
    }
}
