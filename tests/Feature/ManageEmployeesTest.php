<?php

namespace Tests\Feature;

use App\Company;
use App\Employee;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\FeatureTestCase;

class ManageEmployeesTest extends FeatureTestCase
{
    use RefreshDatabase;

    /** @test */
    public function listing_employees()
    {
        $company   = factory(Company::class)->create(['name' => 'Skybase']);
        $employees = factory(Employee::class, 2)->create(['company_id' => $company->id]);
        $this->actingAsUser();

        $this->visitRoute('employees.index')
             ->assertNumberOfElements(2, '.lc-employee-item')
             ->seeInElement('.lc-employee-item', $employees[0]->id)
             ->seeInElement('.lc-employee-item', $employees[0]->fullname)
             ->seeInElement('.lc-employee-item', $employees[0]->email)
             ->seeInElement('.lc-employee-item', $employees[0]->phone)
             ->seeInElement('.lc-employee-item', 'Skybase');
    }

    /** @test */
    public function paginated_employees()
    {
        config()->set('crm.employees.per-page', 3);
        factory(Employee::class, 7)->create();
        $this->actingAsUser();
        $this->visitRoute('employees.index')
             ->assertNumberOfElements(3, '.lc-employee-item')
             ->seeInElement('.page-item.active', 1)
             ->clickElement('[rel="next"]')
             ->seeRouteIs('employees.index', ['page' => 2])
             ->seeInElement('.page-item.active', 2)
             ->assertNumberOfElements(3, '.lc-employee-item')
             ->clickElement('[rel="next"]')
             ->seeRouteIs('employees.index', ['page' => 3])
             ->seeInElement('.page-item.active', 3)
             ->assertNumberOfElements(1, '.lc-employee-item');

    }

    /** @test */
    function creating_employee()
    {
        Carbon::setTestNow('1992-01-11 11:00:00');
        $company = factory(Company::class)->create();
        $this->actingAsUser();

        $this->visitRoute('employees.create')
             ->type('Maximiliano', 'first_name')
             ->type('Monge', 'last_name')
             ->type('maxi@skybase.it', 'email')
             ->type('+44012345789', 'phone')
             ->select($company->id, 'company')
             ->press('Save')
             ->seeRouteIs('employees.index')
             ->seeElement('.lc-flash-message');

        $this->seeInDatabase('employees', [
            'first_name' => 'Maximiliano',
            'last_name'  => 'Monge',
            'email'      => 'maxi@skybase.it',
            'phone'      => '+44012345789',
            'company_id' => $company->id,
            'created_at' => '1992-01-11 11:00:00',
        ]);
    }

    /** @test */
    function updating_employee()
    {
        Carbon::setTestNow('1992-01-11 11:00:00');
        $company  = factory(Company::class)->create();
        $employee = factory(Employee::class)->create();
        $this->actingAsUser();

        $this->visitRoute('employees.edit', $employee)
             ->seeInField('first_name', $employee->first_name)
             ->seeInField('last_name', $employee->last_name)
             ->seeInField('email', $employee->email)
             ->seeInField('phone', $employee->phone)
             ->seeIsSelected('company', $employee->company_id)
             ->type('Maximiliano', 'first_name')
             ->type('Monge', 'last_name')
             ->type('maxi@skybase.it', 'email')
             ->type('+44012345789', 'phone')
             ->select($company->id, 'company')
             ->press('Save')
             ->seeRouteIs('employees.index')
             ->seeElement('.lc-flash-message');

        $this->seeInDatabase('employees', [
            'id'         => $employee->id,
            'first_name' => 'Maximiliano',
            'last_name'  => 'Monge',
            'email'      => 'maxi@skybase.it',
            'phone'      => '+44012345789',
            'company_id' => $company->id,
            'updated_at' => '1992-01-11 11:00:00',
        ]);
    }

    /** @test */
    function deleting_employee()
    {
        $employee = factory(Employee::class)->create();
        $this->actingAsUser();

        $this->visitRoute('employees.index')
             ->assertNumberOfElements(1, '.lc-employee-item')
             ->press('Delete')
             ->seeRouteIs('employees.index')
             ->assertNumberOfElements(0, '.lc-employee-item')
             ->seeElement('.lc-flash-message');

        $this->dontSeeInDatabase('employees', ['id' => $employee->id]);
    }
}