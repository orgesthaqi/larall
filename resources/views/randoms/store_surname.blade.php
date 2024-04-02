@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-5">
                <div class="card-header">Store Surname</div>

                <div class="card-body">
                    <form action="{{ route('randoms.store.surname') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name_surname">Surname</label>
                            <input type="text" class="form-control form-control-file" id="surname" name="surname" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary mt-2">Save</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mb-5">
                <div class="card-header">Store surname using file</div>

                <div class="card-body">
                    <form action="{{ route('randoms.store.surname') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name_surname">Upload File: Surname</label>
                            <input type="file" class="form-control form-control-file" id="file_surname" name="file_surname" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary mt-2">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
