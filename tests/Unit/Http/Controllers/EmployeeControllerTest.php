<?php

namespace Tests\Unit\Http\Controllers;

use App\Company;
use App\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function required_fields_when_creating()
    {
        $this->actingAsAdmin();

        $response = $this->post(route('employees.store'), []);

        $response->assertSessionHasErrors(['first_name', 'last_name']);
        $response->assertSessionMissing(['email', 'phone', 'company']);
    }

    /** @test */
    function the_email_should_be_a_valid_email_address_when_creating()
    {
        $this->actingAsAdmin();

        $response = $this->post(route('employees.store'), [
            'email' => 'foobar',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    function the_company_should_exists_when_creating()
    {
        $this->actingAsAdmin();

        $response = $this->post(route('employees.store'), [
            'company' => 123,
        ]);

        $response->assertSessionHasErrors(['company']);
    }

    /** @test */
    function guests_may_not_create_employees()
    {
        $response = $this->post(route('employees.store'), [
            'first_name' => 'Maximiliano',
            'last_name'  => 'Monge',
        ]);

        $response->assertRedirect(route('login'));
    }

    /** @test */
    function storing_an_employee()
    {
        $company = factory(Company::class)->create();
        $this->actingAsAdmin();

        $response = $this->post(route('employees.store'), [
            'first_name' => 'Maximiliano',
            'last_name'  => 'Monge',
            'email'      => 'maxi@skybase.it',
            'phone'      => '+54123456790',
            'company'    => $company->id,
        ]);

        $response->assertRedirect(route('employees.index'));
        $this->assertDatabaseHas('employees', [
            'first_name' => 'Maximiliano',
            'last_name'  => 'Monge',
            'email'      => 'maxi@skybase.it',
            'phone'      => '+54123456790',
            'company_id' => $company->id,
        ]);
    }

    /** @test */
    function storing_an_employee_with_minimum_information()
    {
        $this->actingAsAdmin();

        $response = $this->post(route('employees.store'), [
            'first_name' => 'Maximiliano',
            'last_name'  => 'Monge',
        ]);

        $response->assertRedirect(route('employees.index'));
        $this->assertDatabaseHas('employees', [
            'first_name' => 'Maximiliano',
            'last_name'  => 'Monge',
            'email'      => null,
            'phone'      => null,
            'company_id' => null,
        ]);
    }

    /** @test */
    function required_fields_when_updating()
    {
        $this->actingAsAdmin();
        $employee = factory(Employee::class)->create();

        $response = $this->put(route('employees.update', $employee), []);

        $response->assertSessionHasErrors(['first_name', 'last_name']);
        $response->assertSessionMissing(['email', 'phone', 'company']);
    }

    /** @test */
    function the_email_should_be_a_valid_email_address_when_updating()
    {
        $this->actingAsAdmin();
        $employee = factory(Employee::class)->create();

        $response = $this->put(route('employees.update', $employee), [
            'email' => 'foobar',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    function the_company_should_exists_when_updating()
    {
        $this->actingAsAdmin();
        $employee = factory(Employee::class)->create();

        $response = $this->put(route('employees.update', $employee), [
            'company' => 123,
        ]);

        $response->assertSessionHasErrors(['company']);
    }

    /** @test */
    function guests_may_not_update_employees()
    {
        $employee = factory(Employee::class)->create();

        $response = $this->put(route('employees.update', $employee), [
            'first_name' => 'Maximiliano',
            'last_name'  => 'Monge',
        ]);

        $response->assertRedirect(route('login'));
    }

    /** @test */
    function updating_an_employee()
    {
        $company  = factory(Company::class)->create();
        $employee = factory(Employee::class)->create();
        $this->actingAsAdmin();

        $response = $this->put(route('employees.update', $employee), [
            'first_name' => 'Maximiliano',
            'last_name'  => 'Monge',
            'email'      => 'maxi@skybase.it',
            'phone'      => '+54123456790',
            'company'    => $company->id,
        ]);

        $response->assertRedirect(route('employees.index'));
        $this->assertDatabaseHas('employees', [
            'first_name' => 'Maximiliano',
            'last_name'  => 'Monge',
            'email'      => 'maxi@skybase.it',
            'phone'      => '+54123456790',
            'company_id' => $company->id,
        ]);
    }

    /** @test */
    function updating_an_employee_with_minimum_information()
    {
        $employee = factory(Employee::class)->create();
        $this->actingAsAdmin();

        $response = $this->put(route('employees.update', $employee), [
            'first_name' => 'Maximiliano',
            'last_name'  => 'Monge',
        ]);

        $response->assertRedirect(route('employees.index'));
        $this->assertDatabaseHas('employees', [
            'first_name' => 'Maximiliano',
            'last_name'  => 'Monge',
            'email'      => null,
            'phone'      => null,
            'company_id' => null,
        ]);
    }
}