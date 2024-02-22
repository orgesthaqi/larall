@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session('success') || session('error'))
                <div class="alert alert-{{ session('success') ? 'success' : 'danger' }}" role="alert">
                    {{ session('success') ?? session('error') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">Settings</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('settings.update') }}">
                        @csrf

                        <div class="form-group row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ auth()->user()->email }}">
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="email_password_separator" class="col-md-4 col-form-label text-md-right">Email Password Separator</label>
                            <div class="col-md-6">
                                <input id="email_password_separator" type="text" class="form-control" name="email_password_separator" value="{{ auth()->user()->email_password_separator }}">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
