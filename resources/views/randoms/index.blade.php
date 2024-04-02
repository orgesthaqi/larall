@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-5">
                <div class="card-header">Upload File</div>

                <div class="card-body">
                    <form action="{{ route('randoms.store.view.name') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="group_name">Gender</label>
                            <select class="form-select" name="gender" id="gender" required>
                                <option value="m">Male</option>
                                <option value="f">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name_surname">Upload File: Name Surname</label>
                            <input type="file" class="form-control form-control-file" id="name_surname" name="name_surname" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary mt-2">Upload</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mb-5">
                <div class="card-header">Random Generator</div>

                <div class="card-body">
                    <form action="{{ route('randoms.generator') }}" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="group_name">Gender</label>
                            <select class="form-select" name="gender" id="gender" required>
                                <option value="all">All</option>
                                <option value="m">Male</option>
                                <option value="f">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name_surname">Total row</label>
                            <input type="number" class="form-control" id="total_row" name="total_row" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary mt-2">Generate</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mb-5">
                <div class="card-header">Names</div>
                <div class="card-header text-end">
                    <a href="{{ route('randoms.store.view.name') }}" class="btn btn-primary">Add New</a>
                </div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Export</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($names as $name)
                                <tr>
                                    <td>{{ $name->name }}</td>
                                    <td>{{ $name->gender == 'm' ? 'Male' : 'Female' }}</td>
                                    <td>
                                        <a href="{{ route('randoms.export', ['name' => $name->name]) }}" class="btn btn-primary">Export</a>
                                    </td>
                                    <td>
                                        <form action="{{ route('randoms.delete', ['id' => $name->id]) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="name" value="{{ $name->name }}">
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                      </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Surnames</div>
                <div class="card-header text-end">
                    <a href="{{ route('randoms.store.surname') }}" class="btn btn-primary">Add New</a>
                </div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($surnames as $surname)
                                <tr>
                                    <td>{{ $surname->surname }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
