@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation">
              <a class="nav-link active" id="simple-tab-0" data-bs-toggle="tab" href="#random-generator" role="tab" aria-controls="random-generator" aria-selected="true">Random Generator</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="simple-tab-1" data-bs-toggle="tab" href="#upload-name-surname" role="tab" aria-controls="upload-name-surname" aria-selected="false">Upload Name Surname File</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="simple-tab-2" data-bs-toggle="tab" href="#names" role="tab" aria-controls="names" aria-selected="false">Names</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="simple-tab-2" data-bs-toggle="tab" href="#surnames" role="tab" aria-controls="surnames" aria-selected="false">Surnames</a>
              </li>
        </ul>
        <div class="tab-content pt-5" id="tab-content">
            <div class="tab-pane active" id="random-generator" role="tabpanel" aria-labelledby="random-generator">
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
            <div class="tab-pane" id="upload-name-surname" role="tabpanel" aria-labelledby="upload-name-surname">
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
            <div class="tab-pane" id="names" role="tabpanel" aria-labelledby="names">
                <div class="d-flex justify-content-between align-items-center">
                    <span></span>
                    <a href="{{ route('randoms.store.view.name') }}" class="btn btn-primary ms-auto mb-2">Create <i class="bi bi-file-earmark-plus"></i></a>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Gender</th>
                            <th style="text-align: end;">Export</th>
                            <th style="text-align: end;">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($names as $name)
                            <tr>
                                <td>{{ $name->name }}</td>
                                <td>{{ $name->gender == 'm' ? 'Male' : 'Female' }}</td>
                                <td style="text-align: end;">
                                    <a href="{{ route('randoms.export', ['name' => $name->name]) }}" class="btn btn-primary"><i class="bi bi-file-earmark-bar-graph"></i></a>
                                </td>
                                <td style="text-align: end;">
                                    <form action="{{ route('randoms.name.delete', ['id' => $name->id]) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="name" value="{{ $name->name }}">
                                        <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tab-pane" id="surnames" role="tabpanel" aria-labelledby="surnames">
                <div class="d-flex justify-content-between align-items-center">
                    <span></span>
                    <a href="{{ route('randoms.store.surname') }}" class="btn btn-primary ms-auto mb-2">Create <i class="bi bi-file-earmark-plus"></i></a>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th style="text-align: end;">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($surnames as $surname)
                            <tr>
                                <td>{{ $surname->surname }}</td>
                                <td style="text-align: end;">
                                    <form action="{{ route('randoms.surname.delete', ['id' => $surname->id]) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="surname" value="{{ $surname->surname }}">
                                        <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
