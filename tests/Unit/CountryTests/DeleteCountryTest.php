<?php

namespace Tests\Unit\CountryTests;

use App\Models\Country;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteCountryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_delete_country()
    {
        //Arrange
        $user    = User::factory()->create();
        $country = Country::factory()->create([ 'user_id' => $user->id ]);

        //Act
        $response = $this->actingAs($user)->delete(route('countries.destroy', $country->id));

        //Assert
        $response->assertRedirect(route('dashboard'));
        $this->assertCount(0, Country::all());
    }
    
    /** @test */
    public function it_cant_delete_country_when_user_is_not_logged()
    {
        //Arrange
        $user    = User::factory()->create();
        $country = Country::factory()->create([ 'user_id' => $user->id ]);

        //Act
        $response = $this->delete(route('countries.destroy', $country->id));

        //Assert
        $response->assertRedirect(route('login'));
    }
}