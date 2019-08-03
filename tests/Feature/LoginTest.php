<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\FeatureTestCase;

class LoginTest extends FeatureTestCase
{
    use RefreshDatabase;

    /** @test */
    function logging_in()
    {
        $user = factory(User::class)->states('admin')->create();

        $this->visitRoute('login')
             ->type($user->email, 'email')
             ->type('password', 'password')
             ->press('Login')
             ->seeRouteIs('dashboard');
    }

    /** @test */
    function redirecting_to_dashboard_when_trying_to_visit_the_login_page_as_logged_in_user()
    {
        $this->actingAsAdmin();

        $this->visitRoute('login')
             ->seeRouteIs('dashboard');
    }

    /** @test */
    function redirecting_to_intended_url_after_logging_in()
    {
        $user = factory(User::class)->states('admin')->create();

        $this->visitRoute('employees.create')
             ->seeRouteIs('login')
             ->type($user->email, 'email')
             ->type('password', 'password')
             ->press('Login')
             ->seeRouteIs('employees.create');
    }

    /** @test */
    function logging_out()
    {
        $this->actingAsAdmin();

        $this->visitRoute('dashboard')
             ->press('Sign out')
             ->seeRouteIs('login');
    }
}
