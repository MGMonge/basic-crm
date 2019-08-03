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
                    <div class="form-group has-feedback @error('name') has-error @enderror">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <input id="name" type="name" class="form-control" name="name" value="{{ old('name', $name) }}" autofocus>
                            @error('name')
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

                    <div class="form-group has-feedback @error('website') has-error @enderror">
                        <label for="website" class="col-sm-2 control-label">Website</label>
                        <div class="col-sm-10">
                            <input id="website" type="website" class="form-control" name="website" value="{{ old('website', $website) }}">
                            @error('website')
                            <span class="help-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <a href="{{ route('companies.index') }}" class="btn btn-default">Cancel</a>
                    <button type="submit" class="btn btn-primary pull-right">Save</button>
                </div>
            </form>
        </div>
    </section>

@endsection