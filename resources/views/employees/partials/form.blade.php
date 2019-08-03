@extends('layouts.app')

@section('content')

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">@yield('title')</h3>
            </div>
            <form action="{{ $url }}" method="POST" class="form-horizontal">
                @csrf
                @method($method)
                <div class="box-body">
                    <div class="form-group has-feedback @error('first_name') has-error @enderror">
                        <label for="first_name" class="col-sm-2 control-label">First name</label>
                        <div class="col-sm-10">
                            <input id="first_name" type="first_name" class="form-control" name="first_name" value="{{ old('first_name', $firstName) }}" autofocus>
                            @error('first_name')
                            <span class="help-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group has-feedback @error('last_name') has-error @enderror">
                        <label for="last_name" class="col-sm-2 control-label">Last name</label>
                        <div class="col-sm-10">
                            <input id="last_name" type="last_name" class="form-control" name="last_name" value="{{ old('last_name', $lastName) }}">
                            @error('last_name')
                            <span class="help-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group has-feedback @error('email') has-error @enderror">
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <input id="email" type="text" class="form-control" name="email" value="{{ old('email', $email) }}">
                            @error('email')
                            <span class="help-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group has-feedback @error('phone') has-error @enderror">
                        <label for="phone" class="col-sm-2 control-label">Phone</label>
                        <div class="col-sm-10">
                            <input id="phone" type="phone" class="form-control" name="phone" value="{{ old('phone', $phone) }}">
                            @error('phone')
                            <span class="help-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group has-feedback @error('company') has-error @enderror">
                        <label for="company" class="col-sm-2 control-label">Company</label>
                        <div class="col-sm-10">
                            <select id="company" type="company" class="form-control" name="company">
                                <option value="">Select company</option>
                                @foreach($companies as $company)
                                    <option {{ $company->id == old('company', $companyId) ? 'selected' : '' }} value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                            @error('company')
                            <span class="help-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <a href="{{ route('employees.index') }}" class="btn btn-default">Cancel</a>
                    <button type="submit" class="btn btn-primary pull-right">Save</button>
                </div>
            </form>
        </div>
    </section>

@endsection