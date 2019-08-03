<?php

namespace Tests\Unit\Http\Controllers;

use App\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function required_fields_when_creating()
    {
        $this->actingAsUser();

        $response = $this->post(route('companies.store'), []);

        $response->assertSessionHasErrors(['name']);
        $response->assertSessionMissing(['email', 'website', 'logo']);
    }

    /** @test */
    function the_email_should_be_a_valid_email_address_when_creating()
    {
        $this->actingAsUser();

        $response = $this->post(route('companies.store'), [
            'email' => 'foobar',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    function the_webiste_should_a_valid_url_when_creating()
    {
        $this->actingAsUser();

        $response = $this->post(route('companies.store'), [
            'website' => 'foobar',
        ]);

        $response->assertSessionHasErrors(['website']);
    }

    /** @test */
    function guests_may_not_create_companies()
    {
        $response = $this->post(route('companies.store'), [
            'name' => 'Skybase',
        ]);

        $response->assertRedirect(route('login'));
    }

    /** @test */
    function storing_a_company()
    {
        $this->actingAsUser();

        $response = $this->post(route('companies.store'), [
            'name'    => 'Skybase',
            'email'   => 'support@skybase.it',
            'website' => 'http://skybase.it',
        ]);

        $response->assertRedirect(route('companies.index'));
        $this->assertDatabaseHas('companies', [
            'name'    => 'Skybase',
            'email'   => 'support@skybase.it',
            'website' => 'http://skybase.it',
        ]);
    }

    /** @test */
    function storing_a_company_with_minimum_information()
    {
        $this->actingAsUser();

        $response = $this->post(route('companies.store'), [
            'name' => 'Skybase',
        ]);

        $response->assertRedirect(route('companies.index'));
        $this->assertDatabaseHas('companies', [
            'name'    => 'Skybase',
            'email'   => null,
            'website' => null,
        ]);
    }

    /** @test */
    function required_fields_when_updating()
    {
        $this->actingAsUser();
        $company = factory(Company::class)->create();

        $response = $this->put(route('companies.update', $company), []);

        $response->assertSessionHasErrors(['name']);
        $response->assertSessionMissing(['email', 'website', 'logo']);
    }

    /** @test */
    function the_email_should_be_a_valid_email_address_when_updating()
    {
        $this->actingAsUser();
        $company = factory(Company::class)->create();

        $response = $this->put(route('companies.update', $company), [
            'email' => 'foobar',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    function the_webiste_should_a_valid_url_when_updating()
    {
        $this->actingAsUser();
        $company = factory(Company::class)->create();

        $response = $this->put(route('companies.update', $company), [
            'website' => 123,
        ]);

        $response->assertSessionHasErrors(['website']);
    }

    /** @test */
    function guests_may_not_update_companies()
    {
        $company = factory(Company::class)->create();

        $response = $this->put(route('companies.update', $company), [
            'name' => 'Skybase',
        ]);

        $response->assertRedirect(route('login'));
    }

    /** @test */
    function updating_a_company()
    {
        $company = factory(Company::class)->create();
        $this->actingAsUser();

        $response = $this->put(route('companies.update', $company), [
            'name'    => 'Skybase',
            'email'   => 'support@skybase.it',
            'website' => 'http://skybase.it',
        ]);

        $response->assertRedirect(route('companies.index'));
        $this->assertDatabaseHas('companies', [
            'name'    => 'Skybase',
            'email'   => 'support@skybase.it',
            'website' => 'http://skybase.it',
        ]);
    }

    /** @test */
    function updating_a_company_with_minimum_information()
    {
        $company = factory(Company::class)->create();
        $this->actingAsUser();

        $response = $this->put(route('companies.update', $company), [
            'name' => 'Skybase',
        ]);

        $response->assertRedirect(route('companies.index'));
        $this->assertDatabaseHas('companies', [
            'name'    => 'Skybase',
            'email'   => null,
            'website' => null,
        ]);
    }
}