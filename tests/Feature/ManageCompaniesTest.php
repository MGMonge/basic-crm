<?php

namespace Tests\Feature;

use App\Company;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\FeatureTestCase;

class ManageCompaniesTest extends FeatureTestCase
{
    use RefreshDatabase;

    /** @test */
    public function listing_companies()
    {
        $companies = factory(Company::class, 2)->create();
        $this->actingAsAdmin();

        $this->visitRoute('companies.index')
             ->assertNumberOfElements(2, '.lc-company-item')
             ->seeInElement('.lc-company-item', $companies[0]->id)
             ->seeInElement('.lc-company-item', $companies[0]->name)
             ->seeInElement('.lc-company-item', $companies[0]->email)
             ->seeInElement('.lc-company-item', $companies[0]->website);
    }

    /** @test */
    public function paginated_companies()
    {
        config()->set('crm.companies.per-page', 3);
        factory(Company::class, 7)->create();
        $this->actingAsAdmin();
        $this->visitRoute('companies.index')
             ->assertNumberOfElements(3, '.lc-company-item')
             ->seeInElement('.page-item.active', 1)
             ->clickElement('[rel="next"]')
             ->seeRouteIs('companies.index', ['page' => 2])
             ->seeInElement('.page-item.active', 2)
             ->assertNumberOfElements(3, '.lc-company-item')
             ->clickElement('[rel="next"]')
             ->seeRouteIs('companies.index', ['page' => 3])
             ->seeInElement('.page-item.active', 3)
             ->assertNumberOfElements(1, '.lc-company-item');

    }

    /** @test */
    function creating_company()
    {
        Carbon::setTestNow('1992-01-11 11:00:00');
        $this->actingAsAdmin();

        $this->visitRoute('companies.create')
             ->type('Skybase', 'name')
             ->type('support@skybase.it', 'email')
             ->type('http://skybase.it', 'website')
             ->press('Save')
             ->seeRouteIs('companies.index')
             ->seeElement('.lc-flash-message');

        $this->seeInDatabase('companies', [
            'name'       => 'Skybase',
            'email'      => 'support@skybase.it',
            'website'    => 'http://skybase.it',
            'created_at' => '1992-01-11 11:00:00',
        ]);
    }

    /** @test */
    function updating_company()
    {
        Carbon::setTestNow('1992-01-11 11:00:00');
        $company = factory(Company::class)->create();
        $this->actingAsAdmin();

        $this->visitRoute('companies.edit', $company)
             ->seeInField('name', $company->name)
             ->seeInField('email', $company->email)
             ->seeInField('website', $company->website)
             ->type('Skybase', 'name')
             ->type('support@skybase.it', 'email')
             ->type('http://skybase.it', 'website')
             ->press('Save')
             ->seeRouteIs('companies.index')
             ->seeElement('.lc-flash-message');

        $this->seeInDatabase('companies', [
            'id'         => $company->id,
            'name'       => 'Skybase',
            'email'      => 'support@skybase.it',
            'website'    => 'http://skybase.it',
            'updated_at' => '1992-01-11 11:00:00',
        ]);
    }

    /** @test */
    function deleting_company()
    {
        $company = factory(Company::class)->create();
        $this->actingAsAdmin();

        $this->visitRoute('companies.index')
             ->assertNumberOfElements(1, '.lc-company-item')
             ->press('Delete')
             ->seeRouteIs('companies.index')
             ->assertNumberOfElements(0, '.lc-company-item')
             ->seeElement('.lc-flash-message');

        $this->dontSeeInDatabase('companies', ['id' => $company->id]);
    }
}