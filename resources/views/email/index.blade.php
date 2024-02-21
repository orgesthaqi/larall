@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-5">
                <div class="card-header">Upload File</div>

                <div class="card-body">
                    <form action="{{ route('upload') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="group_name">Group Name</label>
                            <input type="text" name="group_name" class="form-control" id="group_name" aria-describedby="emailHelp" placeholder="Enter group name" required>
                        </div>
                        <div class="form-group">
                            <label for="photo_upload">Upload File</label>
                            <input type="file" class="form-control form-control-file" id="file" name="credentials" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary mt-2">Upload</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Files</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Group Name</th>
                                <th>Total Emails</th>
                                <th>Date</th>
                                <th>View</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($files as $file)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $file->group_name }}</td>
                                    <td>{{ $file->total }}</td>
                                    <td>{{ $file->date }}</td>
                                    <td><a href="{{ route('file', ['group_id' => $file->group_id]) }}" class="btn btn-primary">View</a></td>
                                    <td>
                                        <form action="{{ route('delete', ['group_id' => $file->group_id]) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
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
