@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-5">
                <div class="card-header">Upload Excel File</div>

                <div class="card-body">
                    <form action="{{ route('download.file') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <h5>
                            Please select the Excel fields for download
                        </h5>

                        @foreach ($data as $key => $value)
                        <div class="form-check">
                            <div class="form-check" style="margin-bottom: 5px;">
                                <input class="form-check-input" name="fields[]" type="checkbox" value="{{ $key }}" id="flexCheckSizeLarge_{{ $key }}" style="font-size: 25px;">
                                <label class="form-check-label" for="flexCheckSizeLarge_{{ $key }}" style="font-size: 20px; margin-top: 5px;">
                                    {{ $value }}
                                </label>
                            </div>
                        </div>

                        @endforeach

                        <div class="d-grid gap-2" style="margin-top: 15px;">
                            <button class="btn btn-primary" type="submit">Download</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
