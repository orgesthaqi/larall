@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Files</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Email Provider</th>
                                <th>Full Email Provider</th>
                                <th>Totals</th>
                                <th>Export</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($file_group as $file)
                                <tr>
                                    <td>{{ $file->email_provider }}</td>
                                    <td>{{ $file->full_email_provider }}</td>
                                    <td>{{ $file->total }}</td>
                                    <td>
                                        <a href="{{ route('export', ['group_id' => request()->group_id, 'full_email_provider' => $file->full_email_provider]) }}" class="btn btn-primary">Export</a>
                                    </td>
                                    <td>
                                        <form action="{{ route('delete', ['group_id' => request()->group_id, 'full_email_provider' => $file->full_email_provider]) }}" method="post">
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
