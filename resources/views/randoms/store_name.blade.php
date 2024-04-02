@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-5">
                <div class="card-header">Store Name</div>

                <div class="card-body">
                    <form action="{{ route('randoms.store.name') }}" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="group_name">Gender</label>
                            <select class="form-select" name="gender" id="gender" required>
                                <option value="m">Male</option>
                                <option value="f">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name_surname">Name</label>
                            <input type="text" class="form-control form-control-file" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary mt-2">Save</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mb-5">
                <div class="card-header">Store name using file</div>

                <div class="card-body">
                    <form action="{{ route('randoms.store.name') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="group_name">Gender</label>
                            <select class="form-select" name="gender" id="gender" required>
                                <option value="m">Male</option>
                                <option value="f">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name_surname">Upload File: Name</label>
                            <input type="file" class="form-control form-control-file" id="file_name" name="file_name" required>
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
