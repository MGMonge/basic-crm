@extends('layouts.app')

@section('title', 'Companies')

@section('content')

    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Companies</h3>
                <div class="box-tools">
                    <a href="{{ route('companies.create') }}" class="btn btn-block btn-primary">Add Company</a>
                </div>
            </div>
            <div class="box-body">
                @if ($companies->isNotEmpty())
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="lc-companies-table table table-bordered table-hover" role="grid">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Website</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($companies as $company)
                                        <tr class="lc-company-item">
                                            <td>{{ $company->id }}</td>
                                            <td>
                                                @if($company->logo)
                                                    <img width="32" height="32" class="img-circle margin-r-5" src="{{ asset($company->logo) }}" alt="">
                                                @endif
                                                {{ $company->name }}
                                            </td>
                                            <td>{{ $company->email }}</td>
                                            <td>{{ $company->website }}</td>
                                            <td>
                                                <form method="POST" class="text-right" action="{{ route('companies.destroy', $company) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a title="Edit" href="{{ route('companies.edit', $company) }}" class="btn btn-primary btn-m">Edit</a>
                                                    <button title="Delete" class="btn btn-danger btn-m" type="submit">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="paging_simple_numbers">
                                {!! $companies->links() !!}
                            </div>
                        </div>
                    </div>
                @else
                    <p class="lc-empty-state">There are not companies. <a href="{{ route('companies.create') }}">Click here to add a new company</a></p>
                @endif
            </div>
        </div>
    </section>

@endsection