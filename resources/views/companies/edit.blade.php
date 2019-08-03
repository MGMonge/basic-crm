@extends('layouts.app')

@section('title', 'Edit ' . $company->fullname)

@section('content')

    @include('companies.partials.form', [
        'url'     => route('companies.update', $company),
        'method'  => 'PUT',
        'name'    => $company->name,
        'email'   => $company->email,
        'logo'    => $company->logo,
        'website' => $company->website,
    ])

@endsection