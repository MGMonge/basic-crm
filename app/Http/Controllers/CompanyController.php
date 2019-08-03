<?php

namespace App\Http\Controllers;

use App\Company;
use App\Exceptions\CannotDeleteCompany;
use App\Http\Requests\SaveCompanyRequest;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::paginate(config('crm.companies.per-page'));

        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store(SaveCompanyRequest $request)
    {
        Company::create([
            'name'    => $request->input('name'),
            'email'   => $request->input('email'),
            'website' => $request->input('website'),
            'logo'    => $request->hasFile('logo') ? $request->file('logo')->store('logo') : null,
        ]);

        return redirect()->route('companies.index')->with('status', 'Company added successfully');
    }

    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    public function update(SaveCompanyRequest $request, Company $company)
    {
        $company->removeLogo();

        $company->update([
            'name'    => $request->input('name'),
            'email'   => $request->input('email'),
            'website' => $request->input('website'),
            'logo'    => $request->hasFile('logo') ? $request->file('logo')->store('logo') : null,
        ]);

        return redirect()->route('companies.index')->with('status', 'Company updated successfully');
    }

    public function destroy(Company $company)
    {
        if ($company->hasEmployees()) {
            throw new CannotDeleteCompany('Only empty companies can be deleted');
        }

        $company->removeLogo();

        $company->delete();

        return redirect()->route('companies.index')->with('status', 'Company deleted successfully');
    }
}
