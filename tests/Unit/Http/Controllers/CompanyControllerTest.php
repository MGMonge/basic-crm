<?php

namespace Tests\Unit\Http\Controllers;

use App\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
    function the_logo_must_be_a_file_when_creating()
    {
        $this->actingAsUser();

        $response = $this->post(route('companies.store'), [
            'logo' => 'foobar',
        ]);

        $response->assertSessionHasErrors(['logo']);
    }

    /** @test */
    function the_logo_must_be_an_image_when_creating()
    {
        $this->actingAsUser();

        $response = $this->post(route('companies.store'), [
            'logo' => UploadedFile::fake()->create('document.pdf'),
        ]);

        $response->assertSessionHasErrors(['logo']);
    }

    /** @test */
    function minimum_logo_dimensions_when_creating()
    {
        $this->actingAsUser();

        $response = $this->post(route('companies.store'), [
            'logo' => UploadedFile::fake()->image('logo.jpg', 99, 99),
        ]);

        $response->assertSessionHasErrors(['logo']);
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
            'logo'    => UploadedFile::fake()->image('logo.jpg', 100, 100),
        ]);

        $response->assertRedirect(route('companies.index'));
        $company = Company::where([
            'name'    => 'Skybase',
            'email'   => 'support@skybase.it',
            'website' => 'http://skybase.it',
        ])->first();
        $this->assertFileExists(Storage::path($company->logo));
        Storage::deleteDirectory('logo');
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
    function the_logo_must_be_a_file_when_updating()
    {
        $this->actingAsUser();
        $company = factory(Company::class)->create();

        $response = $this->put(route('companies.update', $company), [
            'logo' => 'foobar',
        ]);

        $response->assertSessionHasErrors(['logo']);
    }

    /** @test */
    function the_logo_must_be_an_image_when_updating()
    {
        $this->actingAsUser();
        $company = factory(Company::class)->create();

        $response = $this->put(route('companies.update', $company), [
            'logo' => UploadedFile::fake()->create('document.pdf'),
        ]);

        $response->assertSessionHasErrors(['logo']);
    }

    /** @test */
    function minimum_logo_dimensions_when_updating()
    {
        $this->actingAsUser();
        $company = factory(Company::class)->create();

        $response = $this->put(route('companies.update', $company), [
            'logo' => UploadedFile::fake()->image('logo.jpg', 99, 99),
        ]);

        $response->assertSessionHasErrors(['logo']);
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
            'logo'    => UploadedFile::fake()->image('logo.jpg', 100, 100),
        ]);

        $response->assertRedirect(route('companies.index'));
        $this->assertDatabaseHas('companies', [
            'name'    => 'Skybase',
            'email'   => 'support@skybase.it',
            'website' => 'http://skybase.it',
        ]);
        $this->assertFileExists(Storage::path($company->fresh()->logo));
        Storage::deleteDirectory('logo');
    }

    /** @test */
    function the_system_deletes_old_logos_when_uploading_a_new_logo()
    {
        $oldLogo = UploadedFile::fake()->image('logo.jpg', 100, 100)->store('logo');
        $company = factory(Company::class)->create(['logo' => $oldLogo]);
        $this->assertFileExists(Storage::path($company->logo));
        $this->actingAsUser();

        $response = $this->put(route('companies.update', $company), [
            'name'    => 'Skybase',
            'email'   => 'support@skybase.it',
            'website' => 'http://skybase.it',
            'logo'    => UploadedFile::fake()->image('logo.jpg', 100, 100),
        ]);

        $response->assertRedirect(route('companies.index'));
        $this->assertFileNotExists(Storage::path($oldLogo));
        $this->assertFileExists(Storage::path($company->fresh()->logo));
        Storage::deleteDirectory('logo');
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

    /** @test */
    function deleting_companies_with_old_files()
    {
        $oldLogo = UploadedFile::fake()->image('logo.jpg', 100, 100)->store('logo');
        $company = factory(Company::class)->create(['logo' => $oldLogo]);
        $this->assertFileExists(Storage::path($company->logo));
        $this->actingAsUser();

        $response = $this->delete(route('companies.destroy', $company));

        $response->assertRedirect(route('companies.index'));
        $this->assertFileNotExists(Storage::path($oldLogo));
    }
}