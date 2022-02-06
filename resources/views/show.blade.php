@extends('layout.master')
@section('content')

<div class="container-fluid col-md-6">
    <div class="row">
        <h4 class="col-auto me-auto">
            <a href="{{ route('user.userslist') }}"><i class="fas fa-arrow-left" style="color: black; margin-right: 10px"></i></a>
            User Information
        </h4>
        <a href="{{ route('user.edit', $user) }}" class="col-auto">
            <h4><i class="fas fa-edit" style="color: black"></i></h4>
        </a>
    </div>
        <div class="row">
            <div class="col form-group">
                <label for="first_name" class="col-form-label">First Name:</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $user->first_name }}" disabled>
            </div>
            <div class="col form-group">
                <label for="last_name" class="col-form-label">Last Name:</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $user->last_name }}" disabled>
            </div>
        </div>
        <div class="form-group">
            <label for="middle_name" class="col-form-label">Middle Name:</label>
            <input type="text" class="form-control" id="middle_name" name="middle_name" value="{{ $user->middle_name }}" disabled>
        </div>
        <div class="form-group">
            <label for="address" class="col-form-label">Address:</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ $user->address }}" disabled>
        </div>
        <div class="form-group">
            <label for="role" class="col-form-label">Role:</label>
            <input type="text" class="form-control" id="role" name="role" value="{{ $user->role }}" disabled>
        </div>
        <div class="form-group">
            <label for="email" class="col-form-label">Email:</label>
            <input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}" disabled>
        </div><br>
        <h4>Files</h4>
        <div class="row mx-6">
            <table id="myTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>File name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($files as $file)
                        <tr>
                            <td>{{ $file->filename }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <div>
                                        <a href="#">
                                            <button id="viewUser" class="btn btn-primary btn-sm view">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </a>
                                    </div>
                                    <form action="#" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-success btn-sm mx-2">
                                            <i class="fas fa-download"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection