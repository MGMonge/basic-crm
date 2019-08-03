<?php

namespace App\Http\Controllers;

use App\Company;
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
        ]);

        return redirect()->route('companies.index')->with('status', 'Company added successfully');
    }

    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    public function update(SaveCompanyRequest $request, Company $company)
    {
        $company->update([
            'name'    => $request->input('name'),
            'email'   => $request->input('email'),
            'website' => $request->input('website'),
        ]);

        return redirect()->route('companies.index')->with('status', 'Company updated successfully');
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->route('companies.index')->with('status', 'Company deleted successfully');
    }
}
