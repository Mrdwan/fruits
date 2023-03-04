<?php

namespace Tests\Feature;

use App\Models\Fruit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FavoriteFruitTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function it_renders_favorited_fruits_only()
    {
        $name = 'correct anem';
        $wrongName = 'wrong name';

        Fruit::factory()->create(['name' => $name, 'is_favorited' => true]);
        Fruit::factory()->create(['name' => $wrongName]);

        $this->get('/favorites')
            ->assertStatus(200)
            ->assertSee($name)
            ->assertDontSee($wrongName);
    }

    public function it_renders_no_favorited_fruits_if_empty()
    {
        $name = $this->faker->word();

        Fruit::factory()->create(['name' => $name, 'is_favorited' => false]);

        $this->get('/favorites')
            ->assertStatus(200)
            ->assertDontSee($name)
            ->assertSee('no fruits found');
    }

    /** @test */
    public function it_can_be_favorited()
    {
        $fruits = Fruit::factory(4)->create();

        $this->patch("/favorites/{$fruits->first()->id}")
            ->assertRedirect();

        $this->assertDatabaseHas('fruits', [
            'name' => $fruits->first()->name,
            'is_favorited' => true
        ]);
    }

    /** @test */
    public function it_can_be_unfavorited()
    {
        $fruits = Fruit::factory(10)->create(['is_favorited' => true]);

        $this->patch("/favorites/{$fruits->first()->id}")
            ->assertRedirect();

        $this->assertDatabaseHas('fruits', [
            'name' => $fruits->first()->name,
            'is_favorited' => false
        ]);
    }

    /** @test */
    public function it_can_not_favorite_more_than_10_fruits()
    {
        $favoritedFruits = Fruit::factory(10)->create(['is_favorited' => true]);
        $unfavoritedFruit = Fruit::factory(4)->create();

        $this->patch("/favorites/{$unfavoritedFruit->first()->id}")
            ->assertRedirect()
            ->assertSessionHas('message');

        // assert nothing changed
        $this->assertCount(10, Fruit::favorited()->get());
        $this->assertCount(4, Fruit::unfavorited()->get());
    }
}