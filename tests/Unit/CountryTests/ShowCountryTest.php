<?php

namespace Tests\Unit\CountryTests;

use App\Models\Country;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowCountryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_show_country()
    {
        //Arrange
        $user    = User::factory()->create();
        $country = Country::factory()->create([ 'user_id' => $user->id ]);

        //Act
        $response = $this->actingAs( $user )->get(route('countries.show', $country->id));

        //Assert
        $response->assertStatus(200);
        $response->assertJson($country->toArray());
    }
    
    /** @test */
    public function it_cant_show_country_when_user_is_not_logged()
    {
        //Arrange
        $user    = User::factory()->create();
        $country = Country::factory()->create([ 'user_id' => $user->id ]);

        //Act
        $response = $this->get(route('countries.show', $country->id));

        //Assert
        $response->assertRedirect(route('login'));
    }
}