@extends('layout.master')
@section('content')

<div class="container-fluid col-md-6">
    <h4>
        Edit Information
    </h4>
    <form action="{{ route('user.update', $user) }}" method="POST">
    @csrf
    @method('PUT')
        <div class="row">
            <div class="col form-group">
                <label for="first_name" class="col-form-label">First Name:</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $user->first_name }}">
            </div>
            <div class="col form-group">
                <label for="last_name" class="col-form-label">Last Name:</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $user->last_name }}">
            </div>
        </div>
        <div class="form-group">
            <label for="middle_name" class="col-form-label">Middle Name:</label>
            <input type="text" class="form-control" id="middle_name" name="middle_name" value="{{ $user->middle_name }}">
        </div>
        <div class="form-group">
            <label for="address" class="col-form-label">Address:</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ $user->address }}">
        </div>
        <div class="form-group">
            <label class="col-form-label">Role:</label>
            <select class="form-select" aria-label="Default select example" id="role" name="role">
                <option value="" selected disabled hidden>{{ $user->role }}</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->role_name }}">{{ $role->role_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="email" class="col-form-label">Email:</label>
            <input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}">
        </div>
        <div class="d-grid gap-2 mt-3">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
            <a href="{{ url()->previous() }}" type="button" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
        </div>
    </form>
</div>

@endsection