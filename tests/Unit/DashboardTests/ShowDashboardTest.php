<?php

namespace Tests\Unit\WelcomeTests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowDashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_redirects_to_dashboard_when_a_user_logged()
    {
        //Arrange
        $user    = User::factory()->create();

        //Act
        $response = $this->actingAs($user)->get('/dashboard');

        //Assert
        $response->assertViewIs('dashboard');
    }
    
    /** @test */
    public function it_redirects_to_login_when_a_user_not_logged()
    {
        //Act
        $response = $this->get('/dashboard');

        //Assert
        $response->assertRedirect(route('login'));
    }
}