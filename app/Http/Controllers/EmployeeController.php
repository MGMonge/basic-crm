<?php

namespace App\Http\Controllers;

use App\Company;
use App\Employee;
use App\Http\Requests\SaveEmployeeRequest;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::paginate(config('crm.employees.per-page'));

        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $companies = Company::all();

        return view('employees.create', compact('companies'));
    }

    public function store(SaveEmployeeRequest $request)
    {
        Employee::create([
            'first_name' => $request->input('first_name'),
            'last_name'  => $request->input('last_name'),
            'email'      => $request->input('email'),
            'phone'      => $request->input('phone'),
            'company_id' => $request->input('company'),
        ]);

        return redirect()->route('employees.index')->with('status', 'Employee added successfully');
    }

    public function edit(Employee $employee)
    {
        $companies = Company::all();

        return view('employees.edit', compact('employee', 'companies'));
    }

    public function update(SaveEmployeeRequest $request, Employee $employee)
    {
        $employee->update([
            'first_name' => $request->input('first_name'),
            'last_name'  => $request->input('last_name'),
            'email'      => $request->input('email'),
            'phone'      => $request->input('phone'),
            'company_id' => $request->input('company'),
        ]);

        return redirect()->route('employees.index')->with('status', 'Employee updated successfully');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')->with('status', 'Employee deleted successfully');
    }
}
