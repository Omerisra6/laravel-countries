<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteCountryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_approve_access_with_israeli_ip()
    {
        //Arrange
        $this->withMiddleware( \App\Http\Middleware\CheckIsraelIP::class );
        $israeliIP              = '102.128.166.0';
        $_SERVER['REMOTE_ADDR'] = $israeliIP;

        //Act
        $response = $this->get('/');

        //Assert
        $response->assertRedirect(route('login'));
    }
    
    /** @test */
    public function it_denies_access_with_not_israeli_ip()
    {
        //Arrange
        $this->withMiddleware( \App\Http\Middleware\CheckIsraelIP::class );
        $notIsraeliIP           = '206.71.50.230';
        $_SERVER['REMOTE_ADDR'] = $notIsraeliIP;

        //Act
        $response = $this->get('/');

        //Assert
        $response->assertStatus(403);
    }
}