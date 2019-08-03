@extends('layouts.app')

@section('title', 'Add Company')

@section('content')

    @include('companies.partials.form', [
        'url'     => route('companies.store'),
        'method'  => 'POST',
        'name'    => null,
        'email'   => null,
        'website' => null,
    ])

@endsection