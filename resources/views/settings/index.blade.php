@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">Settings</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('settings.update') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="email_password_separator" class="col-md-4 col-form-label text-md-right">Email Password Separator</label>
                            <div class="col-md-6">
                                <input id="email_password_separator" type="text" class="form-control" name="email_password_separator" value="{{ auth()->user()->email_password_separator }}" required>
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
