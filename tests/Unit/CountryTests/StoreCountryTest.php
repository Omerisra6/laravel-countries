<?php

namespace Tests\Unit\CountryTests;

use App\Models\Country;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreCountryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_country()
    {
        //Arrange
        $user        = User::factory()->create();
        $countryData = [ 'name' => 'Test', 'ISO' => 'TC' ];
        
        //Act
        $response = $this->actingAs( $user )->post(route('countries.store'), $countryData);

        //Assert
        $response->assertRedirect(route('dashboard'));
        $this->assertCount(1, Country::all());
    }

    /** @test */
    public function it_cant_create_country_when_user_is_not_logged()
    {
        //Arrange
        $user        = User::factory()->create();
        $countryData = [ 'name' => 'Test', 'ISO' => 'TC', 'user_id' => $user->id ];
        
        //Act
        $response = $this->post(route('countries.store'), $countryData);

        //Assert
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function it_returns_an_error_when_a_name_is_taken()
    {
        //Arrange
        $user        = User::factory()->create();
        $country     = Country::factory()->create([ 'ISO' => 'IL', 'user_id' => $user->id ]);
        $countryData = [ 'name' => $country->name, 'ISO' => 'TC' ];
        
        //Act
        $this->actingAs( $user )->post(route('countries.store'), $countryData);

        //Assert
        $errors = session('errors')->getBag('StoreCountryForm');
        $this->assertTrue($errors->has('name'));
    }

    /** @test */
    public function it_returns_an_error_when_a_iso_is_taken()
    {
        //Arrange
        $user        = User::factory()->create();
        $country     = Country::factory()->create([ 'name' => 'Israel', 'user_id' => $user->id ]);
        $countryData = [ 'name' => 'Italy', 'ISO' => $country->ISO ];
        
        //Act
        $this->actingAs( $user )->post(route('countries.store'), $countryData);

        //Assert
        $errors = session('errors')->getBag('StoreCountryForm');
        $this->assertTrue($errors->has('ISO'));
    }

    /** @test */
    public function it_returns_an_error_when_the_iso_is_not_the_correct_length()
    {
        //Arrange
        $user        = User::factory()->create();
        $countryData = [ 'name' => 'Italy', 'ISO' => 'ITA' ];
        
        //Act
        $this->actingAs( $user )->post(route('countries.store'), $countryData);

        //Assert
        $errors = session('errors')->getBag('StoreCountryForm');
        $this->assertTrue($errors->has('ISO'));
    }

    /** @test */
    public function it_returns_an_error_when_the_iso_is_not_only_letters()
    {
        //Arrange
        $user        = User::factory()->create();
        $countryData = [ 'name' => 'Italy', 'ISO' => '11' ];
        
        //Act
        $this->actingAs( $user )->post(route('countries.store'), $countryData);

        //Assert
        $errors = session('errors')->getBag('StoreCountryForm');
        $this->assertTrue($errors->has('ISO'));
    }
    
    /** @test */
    public function it_returns_an_error_when_the_name_is_not_only_letters()
    {
        //Arrange
        $user        = User::factory()->create();
        $countryData = [ 'name' => 'Ital11', 'ISO' => 'IT' ];
        
        //Act
        $this->actingAs( $user )->post(route('countries.store'), $countryData);

        //Assert
        $errors = session('errors')->getBag('StoreCountryForm');
        $this->assertTrue($errors->has('name'));
    }
}