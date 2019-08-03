@extends('layouts.app')

@section('title', 'Add Employee')

@section('content')

    @include('employees.partials.form', [
        'url'       => route('employees.store'),
        'method'    => 'POST',
        'firstName' => null,
        'lastName'  => null,
        'email'     => null,
        'phone'     => null,
        'companyId' => null,
    ])

@endsection