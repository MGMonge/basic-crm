<?php

namespace Tests\Unit;

use App\Company;
use App\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function removing_logo()
    {
        $logo    = UploadedFile::fake()->image('logo.jpg', 100, 100)->store('logo');
        $company = factory(Company::class)->create(['logo' => $logo]);

        $company->removeLogo();

        $this->assertFileNotExists(Storage::path($logo));
        $this->assertNull($company->fresh()->logo);
    }

    /** @test */
    function removing_logo_with_non_existing_file()
    {
        $company = factory(Company::class)->create(['logo' => 'non_existing.jpeg']);

        $company->removeLogo();

        $this->assertNull($company->fresh()->logo);
    }

    /** @test */
    function it_checks_if_company_has_employees()
    {
        $company = factory(Company::class)->create();
        $this->assertFalse($company->hasEmployees());
        
        factory(Employee::class)->create(['company_id' => $company->id]);

        $this->assertTrue($company->hasEmployees());
    }
}
