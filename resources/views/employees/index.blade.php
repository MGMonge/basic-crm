@extends('layouts.app')

@section('title', 'Employees')

@section('content')

    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Employees</h3>
                <div class="box-tools">
                    <a href="{{ route('employees.create') }}" class="btn btn-block btn-primary">Add Employee</a>
                </div>
            </div>
            <div class="box-body">
                @if ($employees->isNotEmpty())
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="lc-employees-table table table-bordered table-hover" role="grid">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Company</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employees as $employee)
                                        <tr class="lc-employee-item">
                                            <td>{{ $employee->id }}</td>
                                            <td>{{ $employee->fullname }}</td>
                                            <td>{{ $employee->email }}</td>
                                            <td>{{ $employee->phone }}</td>
                                            <td>{{ $employee->company->name }}</td>
                                            <td>
                                                <form method="POST" class="text-right" action="{{ route('employees.destroy', $employee) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a title="Edit" href="{{ route('employees.edit', $employee) }}" class="btn btn-primary btn-m">Edit</a>
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
                                {!! $employees->links() !!}
                            </div>
                        </div>
                    </div>
                @else
                    <p class="lc-empty-state">There are not employees. <a href="{{ route('employees.create') }}">Click here to add a new employee</a></p>
                @endif
            </div>
        </div>
    </section>

@endsection