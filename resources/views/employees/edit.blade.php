@extends('layouts.app')

@section('title', 'Edit ' . $employee->fullname)

@section('content')

    @include('employees.partials.form', [
        'url'       => route('employees.update', $employee),
        'method'    => 'PUT',
        'firstName' => $employee->first_name,
        'lastName'  => $employee->last_name,
        'email'     => $employee->email,
        'phone'     => $employee->phone,
        'companyId' => $employee->company_id,
    ])

@endsection