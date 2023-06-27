<?php

namespace Tests\Unit\CountryTests;

use App\Models\Country;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateCountryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_update_country()
    {
        //Arrange
        $user           = User::factory()->create();
        $country        = Country::factory()->create([ 'name' => 'Israel', 'user_id' => $user->id ]);
        $updatedCountry = [ 'name' => 'Italy', 'ISO' => $country->ISO ];
        
        //Act
        $response = 
        $this->actingAs($user)
        ->put(route('countries.update', $country->id), $updatedCountry);

        //Assert
        $response->assertRedirect(route('dashboard'));
        $this->assertEquals('Italy', $country->fresh()->name);
    }

    /** @test */
    public function it_cant_update_country_when_user_is_not_logged()
    {
        //Arrange
        $user           = User::factory()->create();
        $country        = Country::factory()->create([ 'name' => 'Israel', 'user_id' => $user->id ]);
        $updatedCountry = [ 'name' => 'Italy', 'ISO' => $country->ISO ];
        
        //Act
        $response = 
        $this->put(route('countries.update', $country->id), $updatedCountry);

        //Assert
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function it_cant_update_country_when_name_is_taken()
    {
        //Arrange
        $user            = User::factory()->create();
        $country1        = Country::factory()->create([ 'name' => 'Israel', 'ISO' => 'IL', 'user_id' => $user->id ]);
        $country2        = Country::factory()->create([ 'name' => 'Italy', 'ISO' => 'IT', 'user_id' => $user->id ]);
        $updatedCountry1 = [ 'name' => $country2->name, 'ISO' => $country1->ISO ];
        
        //Act
        $this->actingAs( $user )
        ->put(route('countries.update', $country1->id), $updatedCountry1);

        //Assert
        $errors = session('errors')->getBag('UpdateCountryForm');
        $this->assertTrue($errors->has('name'));
    }

    /** @test */
    public function it_cant_update_country_when_iso_is_taken()
    {
        //Arrange
        $user            = User::factory()->create();
        $country1        = Country::factory()->create([ 'name' => 'Israel', 'ISO' => 'IL', 'user_id' => $user->id ]);
        $country2        = Country::factory()->create([ 'name' => 'Italy', 'ISO' => 'IT', 'user_id' => $user->id ]);
        $updatedCountry1 = [ 'name' => $country1->name, 'ISO' => $country2->ISO ];
        
        //Act
        $this->actingAs( $user )
        ->put(route('countries.update', $country1->id), $updatedCountry1);

        //Assert
        $errors = session('errors')->getBag('UpdateCountryForm');
        $this->assertTrue($errors->has('ISO'));
    }

    /** @test */
    public function it_cant_update_country_when_iso_length_is_wrong()
    {
        //Arrange
        $user           = User::factory()->create();
        $country        = Country::factory()->create([ 'name' => 'Israel', 'ISO' => 'IL', 'user_id' => $user->id ]);
        $updatedCountry = [ 'name' => $country->name, 'ISO' => 'ERR' ];
        
        //Act
        $this->actingAs( $user )
        ->put(route('countries.update', $country->id), $updatedCountry);

        //Assert
        $errors = session('errors')->getBag('UpdateCountryForm');
        $this->assertTrue($errors->has('ISO'));
    }

    /** @test */
    public function it_cant_update_country_when_iso_is_not_only_letters()
    {
        //Arrange
        $user           = User::factory()->create();
        $country        = Country::factory()->create([ 'name' => 'Israel', 'ISO' => 'IL', 'user_id' => $user->id ]);
        $updatedCountry = [ 'name' => $country->name, 'ISO' => '11' ];
        
        //Act
        $this->actingAs( $user )
        ->put(route('countries.update', $country->id), $updatedCountry);

        //Assert
        $errors = session('errors')->getBag('UpdateCountryForm');
        $this->assertTrue($errors->has('ISO'));
    }

    /** @test */
    public function it_cant_update_country_when_name_is_not_only_letters()
    {
        //Arrange
        $user           = User::factory()->create();
        $country        = Country::factory()->create([ 'name' => 'Israel', 'ISO' => 'IL', 'user_id' => $user->id ]);
        $updatedCountry = [ 'name' => 'Israel11', 'ISO' => 'IL' ];
        
        //Act
        $this->actingAs( $user )
        ->put(route('countries.update', $country->id), $updatedCountry);

        //Assert
        $errors = session('errors')->getBag('UpdateCountryForm');
        $this->assertTrue($errors->has('name'));
    }

}